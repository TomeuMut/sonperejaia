<?php namespace Bmut\Sonperejaia\Components;

use Bmut\SonPereJaia\Models\Service;
use Cms\Classes\ComponentBase;

/**
 * InnerService Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class InnerService extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'InnerService Component',
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
        $service = Service::transWhere('slug', $this->param('slug'))->first();
                
        $this->page->title = $service->title;

        $this->page['service'] = $service;
    }
}
