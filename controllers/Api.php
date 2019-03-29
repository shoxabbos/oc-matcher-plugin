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

    public function test() {
        $interestDetails = ['1', "ExponentPushToken[Ly1nncFCSjUEVaiWW6qWs4]"];

        // You can quickly bootup an expo instance
        $expo = \ExponentPhpSDK\Expo::normalSetup();

        // Subscribe the recipient to the server
        $expo->subscribe($interestDetails[0], $interestDetails[1]);

        // Build the notification data
        $notification = [
            'body' => 'Hello World!'
        ];

        // Notify an interest with a notification
        $expo->notify($interestDetails[0], $notification);
    }


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




    // user
    public function getUser() {
        return $this->auth();
    }

    public function getUserById($id) {
        return User::with(['profile', 'profile.photo', 'profile.photos'])->find($id);
    }

    public function updateUser() {
        $user = $this->auth();

        $data = Input::only([
            'nationality', 'language', 'is_public', 'gender', 'relationship_status', 'age', 'children', 'height', 'weight',
            'education', 'job', 'profession', 'contact', 'photo', 'photos', 'name', 'surname', 'middlename', 'properties',
        ]);

        $user->profile;
        $user->profile->fill($data);
        $user->profile->saveOrFail();

        return $user;
    }

    public function getUsers() {
        $data = Input::all();

        return Profile::with(['photo', 'photos'])->listApi($data);
    }


    public function setUserNotifyPush($key) {
        $model = $this->auth();

        if ($model) {
            $model->notify_key = $key;
            $model->save();

            return 'ok';
        }

        return 'fail';
    }


    public function addToPublic($id) {
        $user = $this->getUser();

        $list = $user->list()
            ->where('type', 'access')
            ->where('profile_id', $id)
            ->first();

        if ($list) {
            $list->delete();
            return 'deleted';
        }

        $list = new ListItem([
            'user_id' => $user->id,
            'profile_id' => $id,
            'type' => 'access'
        ]);


        if ($list->save()) {
            $interestDetails = [md5($list->profile->id), $list->profile->notify_key];

            // You can quickly bootup an expo instance
            $expo = \ExponentPhpSDK\Expo::normalSetup();

            // Subscribe the recipient to the server
            $expo->subscribe($interestDetails[0], $interestDetails[1]);

            // Build the notification data
            $notification = ['body' => 'Запрос на просмотр личных данных.'];

            // Notify an interest with a notification
            $expo->notify($interestDetails[0], $notification);
        }


        return $list;
    }

    public function getUserPublic() {
        $model = $this->auth();
        $items = $model->list()->where('type', 'access')->lists('profile_id');

        return Profile::with(['photo', 'photos'])->whereIn('user_id', $items)->get();
    }


    public function getUserRequests() {
        $user = $this->auth();

        $items = $user->list()
            ->where('type', 'access')
            ->lists('profile_id');

        return Profile::with(['photo', 'photos'])->whereIn('user_id', $items)->get();
    }


    public function addToWishlist($id) {
        $user = $this->getUser();

        $list = $user->list()
            ->where('type', 'wishlist')
            ->where('profile_id', $id)
            ->first();

        if ($list) {
            $list->delete();
            return 'deleted';
        }

        $list = new ListItem([
            'user_id' => $user->id,
            'profile_id' => $id,
            'type' => 'wishlist'
        ]);

        $list->save();

        return $list;
    }


    public function getUserWishlist() {
        $user = $this->auth();
        $items = $user->list()->where('type', 'wishlist')->lists('profile_id');

        return Profile::with(['photo', 'photos'])->whereIn('user_id', $items)->get();
    }









    // private methods

    private function auth() {
		return JWTAuth::parseToken()->authenticate();
	}

}
