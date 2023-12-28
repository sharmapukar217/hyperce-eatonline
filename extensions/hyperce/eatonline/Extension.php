<?php

namespace Hyperce\EatOnline;

use Admin\Widgets\Form;
use Admin\Classes\Widgets;
use Hyperce\EatOnline\Models\Location_offers_model;
use Hyperce\EatOnline\Models\Location_headers_model;

/**
 * ti-hyperce Extension Information File
 */
class Extension extends \System\Classes\BaseExtension
{

    /**
     * Register method, called when the extension is first registered.
     *
     * @return void
     */
    public function register()
    {
        // dd($this);
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Register custom widgets
         */

        Widgets::instance()->registerFormWidgets(function (Widgets $manager) {
            $manager->registerFormWidget('Hyperce\EatOnline\FormWidgets\ListForm', [
                'code' => 'listform',
            ]);
        });



        /** Extend the models */
        \Admin\Models\Orders_model::extend(function ($model) {
            $model->mergeFillable(['ebee_vat_id', 'ebee_company_name']);
        });


        \Admin\Models\Locations_model::extend(function ($model) {
            $model->addPurgeable(["headers", "offers"]);
            $model->relation["hasMany"]["headers"] = [
                'Hyperce\EatOnline\Models\Location_headers_model',
                'delete' => true
            ];

            $model->relation["hasMany"]["offers"] = [
                'Hyperce\EatOnline\Models\Location_offers_model',
                'delete' => true
            ];
        });

        /**
         * Extend fields
         */
        \Admin\Controllers\Locations::extendFormFields(function (Form $form) {
            if (!$form->model instanceof \Admin\Models\Locations_model)
                return;
            $form->addTabFields([
                'ebee_website' => [
                    'type' => 'text',
                    'name' => 'ebee_website',
                    'label' => 'hyperce.eatonline::default.locations.label_ebee_website',
                    'tab' => 'hyperce.eatonline::default.locations.text_tab_ebee_website'
                ]
            ]);

            $form->addTabFields([
                'headers' => [
                    'addLimit' => 5,
                    'type' => 'listform',
                    'context' => ['edit'],
                    'modelClass' => Location_headers_model::class,
                    'form' => 'models/config/location_headers_model',
                    'tab' => 'hyperce.eatonline::default.headers.text_tab',
                    'label' => 'hyperce.eatonline::default.headers.text_label',
                ]
            ]);

            $form->addTabFields([
                'offers' => [
                    'addLimit' => 6,
                    'type' => 'listform',
                    'context' => ['edit'],
                    'modelClass' => Location_offers_model::class,
                    'form' => 'models/config/location_offers_model',
                    'tab' => 'hyperce.eatonline::default.offers.text_tab',
                    'label' => 'hyperce.eatonline::default.offers.text_label',
                ]
            ]);

        });

        \Admin\Controllers\Orders::extendFormFields(function (Form $form) {
            $form->addTabFields([
                'ebee_company_name' => [
                    'type' => 'text',
                    'disabled' => 'disabled',
                    'name' => 'ebee_company_name',
                    'label' => 'hyperce.eatonline::default.orders.label_company_name',
                    'tab' => 'hyperce.eatonline::default.orders.text_tab_company',
                ],
                'ebee_vat_id' => [
                    'type' => 'text',
                    'name' => 'ebee_vat_id',
                    'disabled' => 'disabled',
                    'label' => 'hyperce.eatonline::default.orders.label_vat_id',
                    'tab' => 'hyperce.eatonline::default.orders.text_tab_company',
                ]
            ]);
        });
    }

    /**
     * Registers any front-end components implemented in this extension.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            \Hyperce\EatOnline\Components\LocalBox::class => [
                'code' => 'localBox',
                'name' => 'lang:hyperce.eatonline::default.localbox.component_title',
                'description' => 'lang:hyperce.eatonline::default.localbox.component_desc',
            ],
            \Hyperce\EatOnline\Components\Link::class => [
                'code' => 'link',
                'name' => 'lang:hyperce.eatonline::default.link.component_title',
                'description' => 'lang:hyperce.eatonline::default.link.component_desc',
            ],
        ];
    }

    /**
     * Registers back-end navigation menu items for this extension.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [

        ];
    }

    /**
     * Registers any admin permissions used by this extension.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [];
    }
}
