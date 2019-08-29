<?php namespace Filipac\Comingsoon;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function register()
    {
        \Event::listen('cms.route', function() {
            \Route::group([], function() {
                \Route::any('{slug}', 'Filipac\Comingsoon\Classes\BaseController@run')->where('slug', '(.*)?')->middleware('web');
            });
        });
    }

    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }
}
