<?php namespace Bmut\Headers\Components;

use Carbon\Carbon;
use Cms\Classes\ComponentBase;
use Bmut\Headers\Models\Slider as SliderModel;

class PageSlider extends ComponentBase
{
    public $pageSlider;

    public function componentDetails()
    {
        return [
            'name'        => 'PageSlider Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $page = $this->page->baseFileName;
        $pageSlider = SliderModel::query()
            ->where('page', $page)
            ->first();

        if ($pageSlider) {
            $pageSlider->load([
                'slides' => function($query) {
                    $query->where('is_active', 1)->orderBy('relation_sort_order');
                }
            ]);
        }

        $this->pageSlider = $this->page['pageSlider'] = $pageSlider;
    }
}
