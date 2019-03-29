<?php namespace Shohabbos\Matcher;

use Yaml;
use File;
use RainLab\User\Models\User;
use RainLab\User\Controllers\Users;
use System\Classes\PluginBase;
use Shohabbos\Matcher\Models\Profile;
use Shohabbos\Matcher\Models\ListItem;

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
            $model->hasOne['profile'] = Profile::class;
            $model->hasOne['list'] = ListItem::class;

            $model->addFillable(['profile', 'avatar']);
        });


        Users::extendFormFields(function($form, $model, $context) {
            if (!$model instanceof User)
                return;
            
            if (!$model->exists)
                return;

            Profile::getFromUser($model);
        });

    }

    
}
