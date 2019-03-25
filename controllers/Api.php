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

        return Profile::with(['photo', 'photos'])->listApi($data);
    }






    //  methods for manage with account
    public function getUserProfile() {
        return $this->getUser();
    }

    public function getUserWishlist() {
        $model = $this->getUser();

        $data = [];

        $items = $model->wishlist()
            ->with(['profile', 'profile.photo', 'profile.photos'])
            ->where('type', 'access')->get();

        foreach ($items as $key => $value) {
            if (isset($value['profile']) && !empty($value['profile'])) {
                $data[] = $value['profile'];
            }
        }

        return $data;
    }

    public function getUserPublic() {
        $model = $this->getUser();

        $data = [];

        $items = $model->wishlist()
            ->with(['profile', 'profile.photo', 'profile.photos'])
            ->where('type', 'access')->get();

        foreach ($items as $key => $value) {
            if (isset($value['profile']) && !empty($value['profile'])) {
                $data[] = $value['profile'];
            }
        }

        return $data;
    }



    // manage wishlist
    
    public function addToPublic($id) {
        $model = Profile::find($id);
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
            'type' => 'access'
        ]);

        $list->save();

        return $list;
    }

    public function addToWishlist($id) {
        $model = Profile::find($id);
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
    	$data = Input::only([
            'nationality', 'language', 'is_public', 'gender', 'relationship_status', 'age', 'children', 'height', 'weight',
            'education', 'job', 'profession', 'contact', 'photo', 'photos', 'name', 'surname', 'middlename', 'properties'
        ]);

    	$profile = new Profile($data);
    	$user->profiles()->add($profile);

    	return $profile;
    }

    public function updateProfile($id) {
    	$model = $this->findProfileModel($id);

        if (!$model) {
            return response()->json(['error' => 'not_found'], 404);
        }

    	$data = Input::only([
            'nationality', 'language', 'is_public', 'gender', 'relationship_status', 'age', 'children', 'height', 'weight',
            'education', 'job', 'profession', 'contact', 'photo', 'photos', 'name', 'surname', 'middlename', 'properties'
        ]);


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
