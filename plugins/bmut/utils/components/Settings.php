<?php

namespace Bmut\Utils\Components;

use Cms\Classes\ComponentBase;
use Bmut\Utils\Models\Settings as UtilsSettings;

class Settings extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Settings',
            'description' => 'Settings form.'
        ];
    }

    public function onRun()
    {
        $this->page['utilsSettings'] = $settings = UtilsSettings::instance();
    }
}
