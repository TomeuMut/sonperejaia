<?php namespace Bmut\Sonperejaia\Components;

use Bmut\SonPereJaia\Models\Home;
use Cms\Classes\ComponentBase;

/**
 * HomeBlocks Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class HomeBlocks extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'HomeBlocks Component',
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
        $home = Home::first();
                    
        $this->page['home'] = $home;
    }
}
