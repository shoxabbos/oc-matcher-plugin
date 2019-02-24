<?php namespace Shohabbos\Matcher\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Profiles extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'manage_profiles' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Shohabbos.Matcher', 'matcher-profiles', 'matcher-profiles');
    }
}
