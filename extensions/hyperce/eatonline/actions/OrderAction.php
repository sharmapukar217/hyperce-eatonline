<?php

namespace Hyperce\EatOnline\Actions;

use System\Actions\ModelAction;

class OrderAction extends ModelAction
{
    public function __construct($model)
    {
        parent::__construct($model);
        $this->model->mergeFillable(["ebee_vat_id", "ebee_company_name"]);
        dd($this->model);
        // $this->model->fillable(['customer_id', 'address_id', 'first_name', 'last_name', 'email', 'telephone', 'comment', 'payment', 'ebee_vat_id', 'ebee_company_name']);
    }
}
