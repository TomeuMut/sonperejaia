<?php namespace Bmut\Sonperejaia\Components;

use Cms\Classes\ComponentBase;
use Bmut\SonPereJaia\Models\Tag;


/**
 * ListTags Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class ListTags extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'ListTags Component',
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
        $tags = Tag::get();
        
        $this->page['tags'] = $tags;
    }
}
