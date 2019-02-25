<?php namespace Shohabbos\Matcher;

use RainLab\User\Models\User;
use System\Classes\PluginBase;
use Shohabbos\Matcher\Models\Profile;

class Plugin extends PluginBase
{

	public $require = [
		'RainLab.User',
		'Vdomah.JWTAuth',
	];

    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }


    public function boot()
    {
        // Local event hook that affects all users
        User::extend(function($model) {
            $model->hasMany['profiles'] = Profile::class;
        });
    }

    
}
