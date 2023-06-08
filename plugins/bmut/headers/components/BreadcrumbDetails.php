<?php namespace Bmut\Headers\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Cms\Classes\Theme;
use Bmut\Headers\Models\Breadcrumb;
use RainLab\Translate\Classes\Translator;
use RainLab\Translate\Models\Locale;
use October\Rain\Router\Router as RainRouter;
use Url;
use RefineriaWeb\RealEstate\Models\SeoLink;

class BreadcrumbDetails extends ComponentBase
{
    const ESTATE_RESULTS_PAGES = ['buy', 'rent', 'new-build', 'luxury-properties'];

    public $breadCrumbs;
    public $richSnippet;
    private $activeTheme;

    /**
     * @return mixed
     */
    public function getRichSnippet()
    {
        return $this->richSnippet;
    }

    /**
     * @param mixed $richSnippet
     */
    public function setRichSnippet($richSnippet)
    {
        $this->richSnippet = $richSnippet;
    }

    public function componentDetails()
    {
        return [
            'name' => 'BreadcrumbDetails Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        try {
            $this->activeTheme = Theme::getActiveTheme()->getDirName();
            $page = $this->getBreadCrumbModel($this->getPage()->baseFileName);

            $page->pageUrl = $page->generatePageUrl($this);

            $page->pageName = $page->generatePageName($this);

            $breadCrumbs = $this->generateBreadcrumbs($page);

            if ($page->seoLink) {
                $breadCrumbs->pageUrl = $breadCrumbs->seoLink->pageUrl;
                $breadCrumbs->pageName = $breadCrumbs->seoLink->name;
            }

            $this->breadCrumbs = $this->page['breadCrumbs'] = $breadCrumbs;
            $this->addJs('/plugins/bmut/headers/assets/frontend/js/bmut.breadcrumbs.js');
        } catch (\Exception $exception) {
            // \Log::error($exception->getMessage());
        }
    }

    private function getBreadCrumbModel($filename)
    {
        return Breadcrumb::with(['parentPage'])
            ->where('page', $filename)->firstOrFail();
    }

    private function generateBreadcrumbs($page, $ids = null)
    {
        $ids = $ids ?? collect();

        if (!$this->getRichSnippet()) {
            $this->setRichSnippet(collect());
        }

        $this->setRichSnippet($this->getRichSnippet()->prepend($page));
        $ids->push($page->id);
        if ($page->parentPage) {

            if (!$page->seoLink && $this->param('types') && $this->param('localities')) {
                $page->seoLink = SeoLink::findBySlug($page->page, $this->param('types'), $this->param('localities'));
            }

            if (in_array($page->page, self::ESTATE_RESULTS_PAGES) && ($page->seoLink && $page->seoLink->parent)) {

                $parent = $this->getBreadCrumbModel($page->page);

                $parent->seoLink = $page->seoLink->parent;

                $parent->pageUrl = $parent->seoLink->pageUrl;
                $parent->pageName = $parent->seoLink->name;

                $parent = $this->generateBreadcrumbs($parent, $ids);
            } else {
                $parent = $this->generateBreadcrumbs($page->parentPage->load('parentPage'), $ids);

                $parent->pageUrl = $parent->generatePageUrl($this);
                $parent->pageName = $parent->generatePageName($this);
            }

            $page->parent = $parent;
        }

        return $page;
    }

    private function generateRichSnippet()
    {
        if (!$pages = $this->getRichSnippet()) {
            return;
        }

        $items = null;
        $cont = 1;
        $lang = app()->getLocale();

        foreach ($pages as $page) {
            $url = \Event::fire(
                    'bmut.breadcrumbs.resolveUrl',
                    [$page, $this->activeTheme, $this],
                    true
                ) ?? $this->getLocalizedUrl($page, $lang);

            $name = \Event::fire(
                    'bmut.breadcrumbs.resolveName',
                    [$page, $this->activeTheme, $this],
                    true
                ) ?? $page->breadcrumb;


            $items[] = (object) [
                "@type" => "ListItem",
                "position" => $cont++,
                "item" => $url,
                "name" => $name
            ];
        }
        $ldJson = (object) [
            "@context" => "http://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => $items
        ];

        return json_encode($ldJson);
    }

    private function getLocalizedUrl($item, $lang)
    {
        $page = Page::load($this->activeTheme, $item->page . '.htm');

        $page->rewriteTranslatablePageUrl($lang);
        $router = new RainRouter;
        $localeUrl = $router->urlFromPattern($page->url);

        $translator = Translator::instance();

        return Url::to("/") . '/' . $translator->getPathInLocale($localeUrl, $lang);
    }

    public function onGetRichSnippet()
    {
        $res = $this->generateRichSnippet();

        return $res;
    }

    public function init()
    {
        $this->onRun();
    }
}
