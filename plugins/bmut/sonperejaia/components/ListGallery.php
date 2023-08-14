<?php namespace Bmut\Sonperejaia\Components;

use Bmut\SonPereJaia\Models\Gallery;
use Bmut\SonPereJaia\Models\Tag;
use Cms\Classes\ComponentBase;

/**
 * ListGallery Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class ListGallery extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'ListGallery Component',
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
        $galleries = Gallery::has('tags')->with('tags')->get();
        $this->page['galleries'] = $galleries;        
    }
}
