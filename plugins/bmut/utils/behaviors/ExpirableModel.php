<?php


namespace Bmut\Utils\Behaviors;


use App;
use October\Rain\Extension\ExtensionBase;
use Bmut\Utils\Classes\ActivatableScope;
use Bmut\Utils\Classes\ExpirableScope;
use Bmut\Utils\Models\DynamicSeo;

class ExpirableModel extends ExtensionBase
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;

//        $this->model->dates[] = 'expires_at';
//        dump($this->model);
        $this->model->addDynamicProperty('dates', 'expires_at');
//        dd($this->model);

        $this->model->addDynamicMethod('getExpirableColumn', function () use ($model) {
            return $this->expiresColumn ?? 'expires_at';
        });

        if (!App::runningInBackend()) {
            $this->model->addGlobalScope(new ExpirableScope());
        }
    }

}
