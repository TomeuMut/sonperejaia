<?php namespace Bmut\SonPereJaia;

use Bmut\Sonperejaia\Components\FormContact;
use Bmut\Sonperejaia\Components\HomeBlocks;
use Bmut\Sonperejaia\Components\ListWines;
use Bmut\Sonperejaia\Components\ListGallery;
use Bmut\Sonperejaia\Components\ListTags;
use Bmut\Sonperejaia\Components\InnerWine;
use Bmut\Sonperejaia\Components\LegalTerms;
use Bmut\Sonperejaia\Components\PolicyCookies;
use Bmut\Sonperejaia\Components\PolicyPrivacity;
use Bmut\Sonperejaia\Components\ListServices;
use Bmut\Sonperejaia\Components\InnerService;
use Bmut\Sonperejaia\Components\ListTeam;

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
            HomeBlocks::class => 'HomeBlocks',    
            LegalTerms::class => 'LegalTerms',    
            PolicyCookies::class => 'PolicyCookies',    
            PolicyPrivacity::class => 'PolicyPrivacity',    
            ListServices::class => 'ListServices',
            InnerService::class => 'InnerService',
            ListTeam::class => 'ListTeam',
        ];
    }

    /**
     * registerSettings used by the backend.
     */
    public function registerSettings()
    {
    }
}

