<?php namespace Bmut\Utils\Models;

use Model;
use October\Rain\Database\Traits\Validation;
use Bmut\Utils\Classes\Traits\TranslatableRelation;
use System\Models\File;

/**
 * Model
 */
class DynamicSeo extends Model
{
    use Validation;
    use TranslatableRelation;

    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bmut_utils_dynamic_seo';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'title' => 'required',
        'description' => 'required',
    ];

    public $translatable = [
        'title',
        'description',
        'keywords',
        'og_title',
        'og_description',
        'bmutSeo[title]',
        'structured_data'
    ];

    public $attachOne = [
        'seoImage' => [File::class, 'delete' => true]
    ];

    public $morphTo = [
        'seoable' => []
    ];
}
