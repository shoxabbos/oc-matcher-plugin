<?php namespace Shohabbos\Matcher\Controllers;

use Input;
use JWTAuth;
use RainLab\User\Models\User;
use Backend\Classes\Controller;
use Shohabbos\Matcher\Models\Profile;

class Api extends Controller
{

	public $user;
	public $token;

	public function __construct() {
		$this->token = JWTAuth::parseToken()->getToken();
		$this->user = JWTAuth::authenticate($this->token);
	}

    public function createProfile() {
    	
    }

    public function updateProfile() {
        
    }

    public function getProfile($id) {
        
    }

    public function deleteProfile($id) {
        
    }

}
