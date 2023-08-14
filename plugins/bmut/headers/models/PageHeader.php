<?php namespace Bmut\Headers\Models;

use Model;
use Cms\Classes\Theme;
use Cms\Classes\Page;

/**
 * Model
 */
class PageHeader extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    public $jsonable = [
        'buttons',
        'items'
    ];
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bmut_headers_page_headers';

    public $translatable = [
        'title',
        'subtitle',
        'description',
        'section_title',
        'section_subtitle',
        'section_description',
        'buttons',
        'items'
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $attachOne = [
        'image' => ['System\Models\File', 'delete' => true]
    ];

    public function getPageOptions($keyValue = null)
    {
        $theme = Theme::getActiveTheme();
        $withHeader = self::lists('page');

        $pages = $theme->listPages()
            ->filter(function ($page, $key) use ($withHeader) {
                return ! in_array(strtolower($page->baseFileName), $withHeader);
            })
            ->pluck('title', 'baseFileName')
            ->toArray();

        if (!is_null($keyValue)) {
            $headerPage = $this->where('page', $keyValue)
                ->first();
            $pages[(string)$headerPage->page] = $headerPage->page;
        }
        return $pages;
    }
}
