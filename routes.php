<?php
use RainLab\User\Models\User as UserModel;
use Shohabbos\Matcher\Models\Profile as ProfileModel;
use Shohabbos\Matcher\Controllers\Api;

Route::group(['prefix' => 'api', 'middleware' => ['\Tymon\JWTAuth\Middleware\GetUserFromToken']], function() {

	// public profiles
	Route::get('/properties', 'Shohabbos\Matcher\Controllers\Api@getProperties');
	Route::get('/profiles', 'Shohabbos\Matcher\Controllers\Api@getProfiles');
	Route::get('/profile/{id}', 'Shohabbos\Matcher\Controllers\Api@getProfile');

	
	// user account
	Route::get('/user', 'Shohabbos\Matcher\Controllers\Api@getUserProfile');

	
	// user profile manage
	Route::get('/user/profiles', 'Shohabbos\Matcher\Controllers\Api@getUserProfiles');
	Route::get('/user/profile/{id}/wishlist', 'Shohabbos\Matcher\Controllers\Api@getWishlist');
	Route::post('/user/profile/{id}/wishlist', 'Shohabbos\Matcher\Controllers\Api@createWishlist');
	Route::post('/user/profile', 'Shohabbos\Matcher\Controllers\Api@createProfile');
	Route::delete('/user/profile/{id}', 'Shohabbos\Matcher\Controllers\Api@deleteProfile');
	Route::put('/user/profile/{id}', 'Shohabbos\Matcher\Controllers\Api@updateProfile');

	

});