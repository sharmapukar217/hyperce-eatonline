<?php

namespace Hyperce\EatOnline\Classes;

use Exception;
use Igniter\Cart\Components\CartBox;
use Illuminate\Support\Facades\Session;

class CartApi extends CartBox
{
    public function updateCart()
    {

        try {
            $this->initialize();
            $postData = post();

            // WARN: THIS IS NULL !!!! (no cartManager on this class)
            $this->cartManager->addOrUpdateCartItem($postData);

            return Session::get('cart');

        } catch (Exception $ex) {
            return json_encode($ex->getMessage());
        }
    }

    public function getCart()
    {
        return Session::all('cart');
    }
}
