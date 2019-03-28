<?php
use RainLab\User\Models\User as UserModel;
use Shohabbos\Matcher\Models\Profile as ProfileModel;
use Shohabbos\Matcher\Controllers\Api;

Route::group(['prefix' => 'api', 'middleware' => ['\Tymon\JWTAuth\Middleware\GetUserFromToken']], function() {

	// public profiles
	Route::get('/test', 'Shohabbos\Matcher\Controllers\Api@test');
	Route::get('/properties', 'Shohabbos\Matcher\Controllers\Api@getProperties');
	Route::get('/profiles', 'Shohabbos\Matcher\Controllers\Api@getProfiles');
	Route::get('/profile/{id}', 'Shohabbos\Matcher\Controllers\Api@getProfile');
	Route::post('/profile/{id}/wishlist', 'Shohabbos\Matcher\Controllers\Api@addToWishlist');
	Route::post('/profile/{id}/public', 'Shohabbos\Matcher\Controllers\Api@addToPublic');



	

	// user account
	Route::get('/user', 'Shohabbos\Matcher\Controllers\Api@getUserProfile');
	Route::get('/user/wishlist', 'Shohabbos\Matcher\Controllers\Api@getUserWishlist');
	Route::get('/user/public', 'Shohabbos\Matcher\Controllers\Api@getUserPublic');
	Route::get('/user/requests', 'Shohabbos\Matcher\Controllers\Api@getUserRequests');
	Route::get('/user/register-notify/{key}', 'Shohabbos\Matcher\Controllers\Api@setUserNotifyPush');



	
	// user profile manage
	Route::get('/user/profiles', 'Shohabbos\Matcher\Controllers\Api@getUserProfiles');
	Route::post('/user/profile', 'Shohabbos\Matcher\Controllers\Api@createProfile');
	Route::post('/user/profile/{id}', 'Shohabbos\Matcher\Controllers\Api@updateProfile');
	Route::delete('/user/profile/{id}', 'Shohabbos\Matcher\Controllers\Api@deleteProfile');
	

});