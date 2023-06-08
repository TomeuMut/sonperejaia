<?php namespace Bmut\Headers;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    
    public function registerComponents()
    {
        return [
            '\Bmut\Headers\Components\BreadcrumbDetails' => 'breadcrumbDetails',
            '\Bmut\Headers\Components\PageHeaderDetails' => 'pageHeaderDetails',
            '\Bmut\Headers\Components\PageSlider' => 'pageSlider'
        ];
    }

}
