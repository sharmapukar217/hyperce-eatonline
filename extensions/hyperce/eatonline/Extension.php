<?php

namespace Hyperce\EatOnline;

use Admin\Widgets\Form;

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

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return void
     */
    public function boot()
    {
        \Admin\Models\Orders_model::extend(function ($model) {
            $model->mergeFillable(['ebee_vat_id', 'ebee_company_name']);
        });

        \Admin\Controllers\Locations::extendFormFields(function (Form $form) {
            if (!$form->model instanceof \Admin\Models\Locations_model) return;
            $form->addTabFields([
                'ebee_website' => [
                    'type' => 'text',
                    'name' => 'ebee_website',
                    'label' => 'hyperce.eatonline::default.locations.label_ebee_website',
                    'tab' => 'hyperce.eatonline::default.locations.text_tab_ebee_website'
                ],
                'header' => [
                    'type' => 'connector',
                    'tab' => 'Header',
                    // 'partial' => 'form/layouts',
                    'nameFrom' => 'label',
                    // 'context' => ['edit', 'preview'],
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
            'restaurant' => [
                'child' => [
                    'headers' => [
                        'priority' => 10,
                        'class' => 'Header',
                        'href' => admin_url('igniter/headers'),
                        'title' => lang('hyperce.eatonline::default.headers.side_menu'),
                    ],
                ],
            ],
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
