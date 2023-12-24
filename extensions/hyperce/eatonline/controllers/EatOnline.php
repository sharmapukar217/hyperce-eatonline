<?php

namespace Hyperce\EatOnline\Controllers;

use Admin\Facades\AdminMenu;

class EatOnline extends \Admin\Classes\AdminController
{
    public $implement = [
        \Admin\Actions\ListController::class,
        \Admin\Actions\FormController::class,
        \Admin\Actions\LocationAwareController::class,
    ];

     public $formConfig = [
        'name' => 'hyperce.eatonline::default.text_form_name',
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'igniter/coupons/coupons',
        ],
        'configFile' => 'coupons_model',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
