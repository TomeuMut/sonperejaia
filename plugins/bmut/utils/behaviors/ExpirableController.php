<?php


namespace Bmut\Utils\Behaviors;


use Carbon\Carbon;
use Event;
use October\Rain\Extension\ExtensionBase;

class ExpirableController extends ExtensionBase
{
    public $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;

        $this->controller->listConfig = $this->controller->mergeConfig(
            '$/bmut/utils/behaviors/expirablecontroller/config_filter.yaml',
            $this->controller->listConfig
        );
        Event::listen('system.extendConfigFile', function ($path, $config) {
            if (!isset($config['filter'])) {
                $config['filter'] = [];
            }

            return $config;
        });
        Event::listen('system.extendConfigFile', function ($path, $config) {
            if (!isset($config['filter'])) {
                $config['filter'] = [];
            }

            return $config;
        });

        Event::listen('backend.filter.extendScopes', function ($widget) {
            $widgetController = $widget->getController();
            $modelClass = new $widgetController->listConfig->modelClass;

            $widget->addScopes([
                'is_expired' => [
                    'label' => 'bmut.utils::lang.fields.is_expired',
                    'type' => 'switch',
                    'conditions' => [
                        $modelClass->getExpirableColumn() . '>=' . "'" . Carbon::now() . "'",
                        $modelClass->getExpirableColumn() . '<=' . "'" . Carbon::now() . "'"
                    ],
                ],
            ]);
        });
    }

}
