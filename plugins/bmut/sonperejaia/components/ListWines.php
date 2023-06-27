<?php namespace Bmut\Sonperejaia\Components;

use Bmut\SonPereJaia\Models\Wine;
use Cms\Classes\ComponentBase;
/**
 * ListWines Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class ListWines extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'ListWines Component',
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
        $wines = Wine::get();
        
        $this->page['wines'] = $wines;
    }
}
