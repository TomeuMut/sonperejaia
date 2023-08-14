<?php namespace Bmut\Sonperejaia\Components;

use Cms\Classes\ComponentBase;
use Bmut\SonPereJaia\Models\LegalTerm;

/**
 * PolicyPrivacity Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class PolicyPrivacity extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'PolicyPrivacity Component',
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
        $policyprivacity = LegalTerm::first();
                        
        $this->page['policyprivacity'] = $policyprivacity;
    }
}
