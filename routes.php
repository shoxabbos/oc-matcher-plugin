<?php
use RainLab\User\Models\User as UserModel;
use Shohabbos\Matcher\Models\Profile as ProfileModel;
use Shohabbos\Matcher\Controllers\Api;

Route::group(['prefix' => 'api', 'middleware' => ['\Tymon\JWTAuth\Middleware\GetUserFromToken']], function() {

	Route::post('/profile', 'Shohabbos\Matcher\Controllers\Api@createProfile');
	Route::put('/profile/{id}', 'Shohabbos\Matcher\Controllers\Api@updateProfile');
	Route::get('/profile/{id}', 'Shohabbos\Matcher\Controllers\Api@getProfile');
	Route::delete('/profile/{id}', 'Shohabbos\Matcher\Controllers\Api@deleteProfile');

});