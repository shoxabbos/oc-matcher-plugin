<?php namespace Shohabbos\Matcher\Controllers;

use Input;
use JWTAuth;
use RainLab\User\Models\User;
use Backend\Classes\Controller;
use Shohabbos\Matcher\Models\Profile;
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
        $data = Input::only([
            'nationality', 'laguage', 'gender', 'relationship_status', 'age', 'children', 'height', 'weight',
            'education', 'job', 'profession', 'contact', 'language', 'name', 'surname', 'middlename',
        ], []);

        return Profile::listApi($data);
    }






    //  methods for manage with account
    public function getUserProfile() {
        return $this->getUser();
    }







    // methods for manage profiles
    public function getUserProfiles() {
        return $this->getUser()->profiles;   
    }

    public function createProfile() {
    	$user = $this->getUser();

    	$data = Input::only([
    		'nationality', 'laguage', 'gender', 'relationship_status', 'age', 'children', 'height', 'weight',
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
    		'nationality', 'laguage', 'gender', 'relationship_status', 'age', 'children', 'height', 'weight',
    		'education', 'job', 'profession', 'contact', 'photo', 'photos', 'name', 'surname', 'middlename',
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
