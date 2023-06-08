<?php


namespace Bmut\Utils\Behaviors;


use App;
use Event;
use October\Rain\Extension\ExtensionBase;
use Bmut\Utils\Classes\ActivatableScope;
use Bmut\Utils\Models\DynamicSeo;

class ActivatableController extends ExtensionBase
{
    protected $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;

        $this->controller->listConfig = $this->controller->mergeConfig(
            '$/bmut/utils/behaviors/activatablecontroller/config_filter.yaml',
            $this->controller->listConfig
        );

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
                'is_active' => [
                    'label' => 'bmut.utils::lang.fields.is_active',
                    'type' => 'switch',
                    'conditions' => [
                        $modelClass->getActiveColumn() . '<> ' . $modelClass->getActiveValue(),
                        $modelClass->getActiveColumn() . '= ' . $modelClass->getActiveValue()
                    ],
                ],
            ]);
        });
    }

}
