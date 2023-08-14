<?php namespace Bmut\Headers\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Breadcrumbs extends Controller
{
 
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController'
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'bmut-headers-breadcrumbs'
    ];

    public $hasActive = true;

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('bmut.headers', 'main-headers', 'inner-breadcrumbs');
    }
}
