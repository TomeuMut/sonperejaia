<?php namespace Bmut\Sonperejaia\Components;

use Cms\Classes\ComponentBase;
use Bmut\SonPereJaia\Models\LegalTerm;

/**
 * LegalTerms Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class LegalTerms extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'LegalTerms Component',
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
        $legalterm = LegalTerm::first();
                        
        $this->page['legalterm'] = $legalterm;
    }
}
