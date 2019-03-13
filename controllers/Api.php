<?php namespace Shohabbos\Matcher\Controllers;

use Input;
use JWTAuth;
use RainLab\User\Models\User;
use Backend\Classes\Controller;
use Shohabbos\Matcher\Models\Profile;

class Api extends Controller
{

    public function getProfiles() {
        $data = Input::only([
            'nationality', 'laguage', 'gender', 'relationship_status', 'age', 'children', 'height', 'weight',
            'education', 'job', 'profession', 'contact', 'language'
        ], []);

        return Profile::listApi($data);
    }

    public function getUserProfile() {
        return $this->getUser();
    }

    public function getUserProfiles() {
        return $this->getUser()->profiles;   
    }

    public function createProfile() {
    	$user = $this->getUser();

    	$data = Input::only([
    		'nationality', 'laguage', 'gender', 'relationship_status', 'age', 'children', 'height', 'weight',
    		'education', 'job', 'profession', 'contact'
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
    		'education', 'job', 'profession', 'contact'
    	]);

    	$model->fill($data);
    	$model->save();

        return $model;
    }

    public function getProfile($id) {
     	$model = Profile::with(['photo', 'photos'])->find($id);

        if (!$model) {
            return response()->json(['error' => 'not_found'], 404);
        }

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

    private function findProfileModel($id) {
    	return $this->getUser()->profiles()->where('id', $id)->first();
    }

    private function getUser() {
		return JWTAuth::parseToken()->authenticate();
	}

}
