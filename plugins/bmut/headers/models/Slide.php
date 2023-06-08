<?php namespace Bmut\Headers\Models;

use Model;

/**
 * Model
 */
class Slide extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    use \Bmut\Utils\Classes\Traits\TranslatableRelation;

    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = ['title', 'description', 'buttons', 'subtitle'];
    protected $guarded = [];

    protected $dates = ['deleted_at'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bmut_headers_slides';

    public $jsonable = ['buttons'];

    /**
     * @var array Validation rules
     */
    public $rules = [];

    public $attachOne = [
        'image' => ['System\Models\File', 'delete' => true],
    ];

    public $belongsToMany = [
        'slider' => [
            'Bmut\Headers\Models\Slider',
            'table' => 'bmut_headers_slide_slider',
            'key' => 'slide_id',
            'otherKey' => 'slider_id',
            'pivot' => ['relation_sort_order'],
        ],
    ];
}
