<?php
use RainLab\User\Models\User as UserModel;
use Shohabbos\Matcher\Models\Profile as ProfileModel;
use Shohabbos\Matcher\Controllers\Api;

Route::group(['prefix' => 'api', 'middleware' => ['\Tymon\JWTAuth\Middleware\GetUserFromToken']], function() {


	// manage account
	Route::get('/user', 'Shohabbos\Matcher\Controllers\Api@getUser');
	Route::post('/user/update', 'Shohabbos\Matcher\Controllers\Api@updateUser');
	

	Route::get('/user/public', 'Shohabbos\Matcher\Controllers\Api@getUserPublic');
	Route::get('/user/requests', 'Shohabbos\Matcher\Controllers\Api@getUserRequests');
	Route::post('/user/{id}/public', 'Shohabbos\Matcher\Controllers\Api@addToPublic');


	Route::get('/user/wishlist', 'Shohabbos\Matcher\Controllers\Api@getUserWishlist');
	Route::post('/user/{id}/wishlist', 'Shohabbos\Matcher\Controllers\Api@addToWishlist');



	Route::get('/users', 'Shohabbos\Matcher\Controllers\Api@getUsers');
	Route::get('/user/{id}', 'Shohabbos\Matcher\Controllers\Api@getUserById');
	




	// stuff methods
	Route::get('/test', 'Shohabbos\Matcher\Controllers\Api@test');
	Route::get('/properties', 'Shohabbos\Matcher\Controllers\Api@getProperties');

	Route::get('/user/register-notify/{key}', 'Shohabbos\Matcher\Controllers\Api@setUserNotifyPush');
});