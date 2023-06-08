<?php


namespace Bmut\Utils\Behaviors;


use October\Rain\Extension\ExtensionBase;
use Bmut\Utils\Models\DynamicSeo;

class SeoExtendableModel extends ExtensionBase
{
    protected $model;

    public function __construct($model)
    {
//        parent::__construct($model);

        $this->model = $model;
        $this->model->morphOne['bmutSeo'] = [
            DynamicSeo::class,
            'name' => 'seoable'
        ];

    }

}
