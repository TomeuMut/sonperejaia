<?php namespace Bmut\Headers\Models;

use Event;
use Model;
use Cms\Classes\Theme;
use Cms\Classes\Page;
use October\Rain\Router\Router as RainRouter;
use RainLab\Translate\Classes\Translator;
use Url;

/**
 * Model
 */
class Breadcrumb extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \Bmut\Utils\Classes\Traits\Activatable;

    protected $dates = ['deleted_at'];
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bmut_headers_breadcrumbs';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $translatable = [
        'breadcrumb',
    ];

    public $belongsTo = [
        'parentPage' => [ 'Bmut\Headers\Models\Breadcrumb',
            'key' => 'page_id',
            'otherKey' => 'id'
        ]
    ];

    public $hasMany = [
        'childPage' => [ 'Bmut\Headers\Models\Breadcrumb',
            'key' => 'page_id',
            'otherKey' => 'id'
        ]
    ];

    public function getPageOptions($keyValue = null)
    {
        $theme = Theme::getActiveTheme();
        $withBreadCrumb = self::lists('page');

        $pages = $theme->listPages()
            ->filter(function ($page) use ($withBreadCrumb) {
                return ! in_array(strtolower($page->baseFileName), $withBreadCrumb);
            })
            ->pluck('title', 'baseFileName')
            ->toArray();

        if (!is_null($keyValue)) {
            $breadCrumbPage = $this->where('page', $keyValue)
                ->first();
            $pages[(string)$breadCrumbPage->page] = $breadCrumbPage->page;
        }
        return $pages;
    }

    public function getTypeOptions()
    {
        $res = ['cms' => 'Cms'];
        $types = Event::fire('bmut.breadcrumbs.types');

        if (is_array($types) && count($types) > 0) {
            $res = array_merge($res, $types[0]);
        }

        return $res;
    }

    public function generatePageUrl($component)
    {
        $activeTheme = Theme::getActiveTheme()->getDirName();

        $lang = app()->getLocale();

        return \Event::fire(
            'bmut.breadcrumbs.resolveUrl',
            [$this, $activeTheme, $component],
            true
        ) ?? $this->getLocalizedUrl();
    }

    public function getLocalizedUrl()
    {
        $activeTheme = Theme::getActiveTheme()->getDirName();

        $lang = app()->getLocale();

        $page = Page::load($activeTheme, $this->page . '.htm');

        $page->rewriteTranslatablePageUrl($lang);
        $router = new RainRouter;
        $localeUrl = $router->urlFromPattern($page->url);

        $translator = Translator::instance();

        return Url::to("/") . '/' . $translator->getPathInLocale($localeUrl, $lang);
    }

    public function generatePageName($component)
    {
        $activeTheme = Theme::getActiveTheme()->getDirName();

        return \Event::fire(
            'bmut.breadcrumbs.resolveName',
            [$this, $activeTheme, $component],
            true
        ) ?? $this->breadcrumb;
    }
}
