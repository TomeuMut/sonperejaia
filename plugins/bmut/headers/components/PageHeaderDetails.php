<?php namespace Bmut\Headers\Components;

use Cms\Classes\ComponentBase;
use Rw\Evm\Models\Inverter;
use Bmut\Headers\Models\PageHeader;

class PageHeaderDetails extends ComponentBase
{
    public $header;

    public function componentDetails()
    {
        return [
            'name'        => 'PageHeaderDetails Component',
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
            $page = $this->page->baseFileName;
            $header = PageHeader::with('image')
                    ->where('page', $page)
                    ->firstOrFail();
            $this->header = $this->page['header'] = $header;
        } catch (\Exception $exception) {
            // \Log::error($exception->getMessage());
        }
    }
}
