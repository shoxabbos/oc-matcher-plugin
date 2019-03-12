<?php namespace Shohabbos\Matcher;

use RainLab\User\Models\User;
use RainLab\User\Controllers\Users;
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




        Users::extend(function($controller) {

            // Implement the relation controller if it doesn't exist already
            if (!$controller->isClassExtendedWith('Backend.Behaviors.RelationController')) {
                $controller->implement[] = 'Backend.Behaviors.RelationController';
            }

            // Define property if not already defined
            if (!isset($controller->relationConfig)) {
                $controller->addDynamicProperty('relationConfig');
            }

            // Implement the relationConfig property with our custom config if it doesn't exist already
            $myConfigPath = '$/shohabbos/matcher/controllers/users/config_relation.yaml';

            $controller->relationConfig = $controller->mergeConfig(
                $controller->relationConfig,
                $myConfigPath
            );

        });


         // now your actual code for extending fields
        \RainLab\User\Controllers\Users::extendFormFields(function($form, $model, $context){
            
            if (!$model instanceof \RainLab\User\Models\User)
                return;

            if (!$model->exists)
                return;

            $form->addTabFields([
                'profiles' => [
                    'tab' => 'Profiles',
                    'label' => 'Profiles',
                    'type'  => 'partial',
                    'path' => '$/shohabbos/matcher/controllers/users/_profiles.htm',
                    'context' => ['preview', 'update']
                ]
            ]);
        });


    }

    
}
