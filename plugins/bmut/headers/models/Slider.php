<?php namespace Bmut\Headers\Models;

use Model;
use Cms\Classes\Theme;

/**
 * Model
 */
class Slider extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    use \Bmut\Utils\Classes\Traits\TranslatableRelation;


    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = ['title'];

    protected $dates = ['deleted_at'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bmut_headers_sliders';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsToMany = [
        'slides' => [
            'Bmut\Headers\Models\Slide',
            'table' => 'bmut_headers_slide_slider',
            'key' => 'slider_id',
            'otherKey' => 'slide_id',
            'pivot' => ['relation_sort_order']
        ]
    ];

    public function getPageOptions($keyValue = null)
    {
        $theme = Theme::getActiveTheme();
        $pages = $theme->listPages()->pluck('title', 'baseFileName');
        $pagesUsed = $this->pluck('page')->flip();

        // Al actualizar no restar la pagina del registro actual
        if (!is_null($keyValue)) {
            $pagesUsed->forget($keyValue);
        }
        $pages = $pages->diffKeys($pagesUsed)->toArray();

        return $pages;
    }
}
