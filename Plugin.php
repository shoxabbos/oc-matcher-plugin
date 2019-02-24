<?php namespace Shohabbos\Matcher;

use System\Classes\PluginBase;

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
    
}
