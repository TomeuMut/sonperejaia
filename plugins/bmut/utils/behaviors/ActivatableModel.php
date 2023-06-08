<?php


namespace Bmut\Utils\Behaviors;


use App;
use October\Rain\Extension\ExtensionBase;
use Bmut\Utils\Classes\ActivatableScope;
use Bmut\Utils\Models\DynamicSeo;

class ActivatableModel extends ExtensionBase
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;

        $this->model->addDynamicMethod('getActiveColumn', function () use ($model) {
            return $model->activeColumn ?? 'is_active';
        });

        $this->model->addDynamicMethod('getActiveValue', function () use ($model) {
            return $model->activeValue ?? "1";
        });

        $this->model->addDynamicMethod('scopeActive', function ($query) {
            return $query->where($this->model->getActiveColumn(), $this->model->getActiveValue());
        });

        $this->model->addDynamicMethod('scopeInactive', function ($query) {
            return $query->where($this->model->getActiveColumn(), '!=', $this->model->getActiveValue());
        });

        if (!App::runningInBackend()) {
            $this->model->addGlobalScope(new ActivatableScope);
        }
    }

}
