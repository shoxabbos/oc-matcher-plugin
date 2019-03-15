<?php namespace Shohabbos\Matcher\Controllers;

use Input;
use JWTAuth;
use RainLab\User\Models\User;
use Backend\Classes\Controller;
use Shohabbos\Matcher\Models\Profile;
use Shohabbos\Matcher\Models\ListItem;
use Shohabbos\Matcher\Models\Property;

class Api extends Controller
{


    // public methods for all

    public function getProperties() {
        $data = [];
        $models = Property::with(['children'])->get();

        foreach ($models as $key => $value) {
            if (isset($value->children) && count($value->children)) {
                $data[$value->key] = $value;
            }
        }

        return $data;
    }

    public function getProfile($id) {
        $model = Profile::with(['photo', 'photos'])->find($id);

        if (!$model) {
            return response()->json(['error' => 'not_found'], 404);
        }

        return $model;
    }

    public function getProfiles() {
        $data = Input::all();

        return Profile::listApi($data);
    }






    //  methods for manage with account
    public function getUserProfile() {
        return $this->getUser();
    }






    // manage wishlist
    public function getWishlist($id) {
        $model = $this->findProfileModel($id);

        if (!$model) {
            return response()->json(['error' => 'not_found'], 404);
        }

        return $model->wishlist()->with(['profile'])->get();
    }


    public function createWishlist($id) {
        $model = $this->findProfileModel($id);
        $user = $this->getUser();

        if (!$model) {
            return response()->json(['error' => 'not_found'], 404);
        }

        $list = $model->wishlist()->where('user_id', $user->id)->first();

        if ($list) {
            $list->delete();
            return 'deleted';
        }

        $list = new ListItem([
            'user_id' => $user->id,
            'profile_id' => $model->id,
            'type' => 'wishlist'
        ]);

        $list->save();

        return $list;
    }






    // methods for manage profiles
    public function getUserProfiles() {
        return $this->getUser()->profiles()->with(['photo', 'photos'])->get();
    }

    public function createProfile() {
    	$user = $this->getUser();
    	$data = Input::all();

    	$profile = new Profile($data);
    	$user->profiles()->add($profile);

    	return $profile;
    }

    public function updateProfile($id) {
    	$model = $this->findProfileModel($id);

        if (!$model) {
            return response()->json(['error' => 'not_found'], 404);
        }

    	$data = Input::all();

    	$model->fill($data);
    	$model->save();

        return $model;
    }

    public function deleteProfile($id) {
     	$model = $this->findProfileModel($id);

        if (!$model) {
            return response()->json(['error' => 'not_found'], 404);
        }

        if (!$model->delete()) {
            return response()->json(['error' => 'something_went_wrong'], 500);
        }

        return 'ok';
    }







    // private methods

    private function findProfileModel($id) {
    	return $this->getUser()->profiles()->where('id', $id)->first();
    }

    private function getUser() {
		return JWTAuth::parseToken()->authenticate();
	}

}
