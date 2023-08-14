<?php namespace Bmut\Sonperejaia\Components;

use Cms\Classes\ComponentBase;
use Bmut\SonPereJaia\Models\LegalTerm;

/**
 * PolicyCookies Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class PolicyCookies extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'PolicyCookies Component',
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
        $policycookies = LegalTerm::first();
                        
        $this->page['policycookies'] = $policycookies;
    }
}
