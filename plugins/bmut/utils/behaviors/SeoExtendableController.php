<?php


namespace Bmut\Utils\Behaviors;


use Backend\Widgets\Form;
use Event;
use Exception;
use Log;
use October\Rain\Extension\ExtensionBase;
use RainLab\Blog\Models\Post;
use Bmut\Utils\Models\DynamicSeo;

class SeoExtendableController extends ExtensionBase
{
    protected $parent;

    public function __construct($parent)
    {
        $this->parent = $parent;

        if (!isset($this->parent->relationConfig)) {
            $this->parent->addDynamicProperty('relationConfig');
        }

        $bmutSeoRelation = '$/bmut/utils/behaviors/seoextendablecontroller/config_relation.yaml';

        $this->parent->relationConfig = $this->parent->mergeConfig(
            $this->parent->relationConfig,
            $bmutSeoRelation
        );

        $this->eventListeners();
    }

    private function eventListeners()
    {
        Event::listen('backend.page.beforeDisplay', function ($controller) {
            if (!$controller->isClassExtendedWith('Backend.Behaviors.RelationController')) {
                $controller->implement[] = 'Backend.Behaviors.RelationController';
                $controller->extendClassWith('Backend.Behaviors.RelationController');
            }
        });

        Event::listen('backend.form.extendFields', function (Form $formWidget) {
            if ($formWidget->model instanceof DynamicSeo) {
                return;
            }

            $isRelation = request('_relation_field');
            if (!is_null($isRelation) && ($isRelation != 'bmutSeo')) {
                return;
            }

            // Si el modelo no tiene el behaviour SeoExtendableModel no funciona
            if (!$formWidget->model->isClassExtendedWith(SeoExtendableModel::class)) {
                return;
            }

            try {
                if (!$formWidget->model instanceof Post) {
                    $formWidget->addTabFields([
                        'bmutSeo' => [
                            'type' => 'partial',
                            'path' => '$/bmut/utils/partials/_bmutSeo.htm',
                            'span' => 'full',
                            'context' => ['update', 'preview'],
                            'tab' => 'Seo'
                        ]
                    ]);
                } else {
                    $formWidget->addSecondaryTabFields([
                        'bmutSeo' => [
                            'type' => 'partial',
                            'path' => '$/bmut/utils/partials/_bmutSeo.htm',
                            'span' => 'full',
                            'context' => ['update', 'preview'],
                            'tab' => 'Seo'
                        ]
                    ]);
                }


            } catch (Exception $e) {
                Log::error($e->getMessage());
            }

            return true;
        });
    }

}
