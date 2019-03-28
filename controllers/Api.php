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
    public function getUserRequests() {
        $model = $this->getUser();
        $profile = $model->profiles()->first('id');

        if (!$profile) {
            return [];
        }

        $data = ListItem::where('profile_id', $profile)
            ->where('type', 'access')
            ->get();

        return $data;
    }

    public function setUserNotifyPush($key) {
        $model = $this->getUser();

        if ($model) {
            $model->notify_key = $key;
            $model->save();

            return 'ok';
        }

        return 'fail';
    }


    public function getUserProfile() {
        return $this->getUser();
    }

    public function getUserWishlist() {
        $model = $this->getUser();

        $data = [];

        $items = $model->list()
            ->with(['profile', 'profile.photo', 'profile.photos'])
            ->where('type', 'wishlist')->get();

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

        $items = $model->list()
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

        $list = $model->list()
            ->where('user_id', $user->id)
            ->where('type', 'access')
            ->first();

        if ($list) {
            $list->delete();
            return 'deleted';
        }

        $list = new ListItem([
            'user_id' => $user->id,
            'profile_id' => $model->id,
            'type' => 'access'
        ]);


        if ($list->save()) {
            $interestDetails = [md5($list->profile->user_id), $list->profile->user->notify_key];

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

    public function addToWishlist($id) {
        $model = Profile::find($id);
        $user = $this->getUser();

        if (!$model) {
            return response()->json(['error' => 'not_found'], 404);
        }

        $list = $model->list()
            ->where('user_id', $user->id)
            ->where('type', 'wishlist')
            ->first();

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
