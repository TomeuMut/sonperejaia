<?php namespace Bmut\Utils\Components;

use Event;
use Bmut\Utils\Classes\Helpers\LocaleParser;
use Bmut\Utils\Models\Settings;
use Session;
use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Request;
use RainLab\Translate\Models\Locale;
use RainLab\Translate\Classes\Translator;
use Illuminate\Support\Facades\Route;

class LanguageDetector extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'LanguageDetector Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    /*ToDo: Middleware */
    public function onRun()
    {
        if (\App::runningInBackend()) {
            return;
        }

        $settings = Settings::instance();

        $translator = Translator::instance();

        $segment = Request::segment(1);

        $localeSession = Session::get($translator::SESSION_LOCALE);

        $locale = $segment;

        if (post('locale') && $locale != post('locale')) {
            $translator->setLocale(post('locale'));
            $locale = post('locale');
        }

        if (!$locale && !$localeSession && ($settings->detect_browser_language && isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))) {
            $accepted = LocaleParser::parseLanguageList($_SERVER['HTTP_ACCEPT_LANGUAGE']);
            $available = Locale::listEnabled();

            $matches = LocaleParser::findMatches($accepted, $available);

            if (!empty($matches)) {
                $locale = array_keys($matches)[0];
                $translator->setLocale($locale);

                return $this->forceRedirect($locale, $translator);
            }
        }

        $locale = $translator->getLocale();

        if (!Locale::isValid($locale)) {
            $translator->setLocale($translator->getDefaultLocale());
        }

        if ($segment == $translator->getDefaultLocale()) {
            if ($translator->getLocale() == $translator->getDefaultLocale()) {
                return;
            }

            return redirect($translator->getPathInLocale('/', $locale, env('PREFIX_DEFAULT_LOCALE')), 301);
        }

        return;
    }

    /**
     * @param $locale
     * @param Translator $translator
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function forceRedirect($locale, Translator $translator)
    {
        Route::group(['prefix' => $locale, 'middleware' => 'web'], function () {
            Route::any('{slug}', 'Cms\Classes\CmsController@run')->where('slug', '(.*)?');
        });

        Route::any($locale, 'Cms\Classes\CmsController@run')->middleware('web');

        Event::listen('cms.route', function () use ($locale) {
            Route::group(['prefix' => $locale, 'middleware' => 'web'], function () {
                Route::any('{slug}', 'Cms\Classes\CmsController@run')->where('slug', '(.*)?');
            });
        });

        return redirect($translator->getPathInLocale('/', $locale, env('PREFIX_DEFAULT_LOCALE')));
    }

}
