<?php namespace Bmut\Utils\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Sitemaps extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController'
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'manage_seo'
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('bmut.utils', 'main-seo', 'inner-sitemap');
    }
}
