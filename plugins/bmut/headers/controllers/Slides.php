<?php namespace Bmut\Headers\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Slides extends Controller
{

    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController'
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'bmut-headers-sliders'
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('bmut.headers', 'main-headers', 'main-headers.slider');
    }
}
