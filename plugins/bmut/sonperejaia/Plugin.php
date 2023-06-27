<?php namespace Bmut\SonPereJaia;

use Bmut\Sonperejaia\Components\FormContact;
use Bmut\Sonperejaia\Components\ListWines;
use Bmut\Sonperejaia\Components\ListGallery;
use Bmut\Sonperejaia\Components\ListTags;
use Bmut\Sonperejaia\Components\InnerWine;
use System\Classes\PluginBase;

/**
 * Plugin class
 */
class Plugin extends PluginBase
{
    /**
     * register method, called when the plugin is first registered.
     */
    public function register()  
    {

      
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return [
            FormContact::class => 'FormContact',            
            InnerWine::class => 'InnerWine',         
            ListWines::class => 'ListWines',         
            ListTags::class => 'ListTags',         
            ListGallery::class => 'ListGallery',         
        ];
    }

    /**
     * registerSettings used by the backend.
     */
    public function registerSettings()
    {
    }
}
