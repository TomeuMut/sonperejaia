<?php namespace Bmut\Utils;

use Illuminate\Support\Facades\Schema;
use Backend\Facades\Backend;
use Backend\Classes\Controller;
use Carbon\Carbon;
use RainLab\Blog\Models\Post;
use Bmut\Utils\Components\DynamicSeo;
use Bmut\Utils\Components\LanguageDetector;
use Bmut\Utils\Components\Scripts;
use Bmut\Utils\Components\SeoPage;
use Bmut\Utils\Classes\Middlewares\HttpsRedirect;
use Bmut\Utils\Models\Settings;
use System\Classes\PluginBase;
use Lang;
use Event;
use Bmut\Utils\Classes\BehaviorsRegistry;
use Bmut\Utils\Components\Settings as ComponentsSettings;

class Plugin extends PluginBase
{
    public $require = ['RainLab.Translate'];

    public function registerComponents()
    {
        return [
            SeoPage::class => 'seoPage',
            DynamicSeo::class => 'dynamicSeo',
            Scripts::class => 'scripts',
            LanguageDetector::class => 'LanguageDetector',
            ComponentsSettings::class => 'utilsSettings',
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label' => 'Web details',
                'description' => 'Manage webpage details',
                'category' => 'Web',
                'icon' => 'icon-cog',
                'class' => 'Bmut\Utils\Models\Settings',
                'url' => Backend::url('bmut/utils/settings/update'),
                'order' => 500,
                'keywords' => 'security location',
                'permissions' => ['manage_config']
            ]
        ];
    }

    public function boot()
    {
        Schema::defaultStringLength(191);

        Event::listen('pages.builder.registerControllerBehaviors', function ($behaviorLibrary) {
            new BehaviorsRegistry($behaviorLibrary);
        }, -1);

        $this->bootWysiwygEditor();

        $this->bootMiddlewares();

    }

    private function bootWysiwygEditor()
    {
        Event::listen('backend.form.extendFields', function ($form) {
            if ($form->model instanceof Post && Settings::instance()->blog_richeditor) {
                $form->getField('content')->config['type'] = $form->getField('content')->config['widget'] = 'mlricheditor';
            }
        });
    }

    private function bootMiddlewares()
    {
        $this->app['Illuminate\Contracts\Http\Kernel']
            ->prependMiddleware(HttpsRedirect::class);
    }
}
