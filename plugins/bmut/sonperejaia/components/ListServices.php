<?php namespace Bmut\Sonperejaia\Components;

use Bmut\SonPereJaia\Models\Service;
use Cms\Classes\ComponentBase;

/**
 * ListServices Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class ListServices extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'ListServices Component',
            'description' => 'No description provided yet...'
        ];
    }

    /**
     * @link https://docs.octobercms.com/3.x/element/inspector-types.html
     */
    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $services = Service::get();
        
        $this->page['services'] = $services;
    }
}
