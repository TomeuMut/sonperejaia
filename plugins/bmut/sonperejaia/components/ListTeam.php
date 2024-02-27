<?php namespace Bmut\Sonperejaia\Components;

use Bmut\SonPereJaia\Models\Team;
use Cms\Classes\ComponentBase;

/**
 * ListTeam Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class ListTeam extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'ListTeam Component',
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
        $teams = Team::get();        
        $this->page['teams'] = $teams;
    }
}
