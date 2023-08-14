<?php namespace Bmut\Sonperejaia\Components;

use Bmut\SonPereJaia\Models\Wine;
use Cms\Classes\ComponentBase;
/**
 * InnerWine Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class InnerWine extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'InnerWine Component',
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
        $wine = Wine::transWhere('slug', $this->param('slug'))->first();
                
        $this->page->title = $wine->title;

        $this->page['wine'] = $wine;
    }
}
