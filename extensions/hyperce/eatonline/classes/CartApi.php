<?php

namespace Hyperce\EatOnline\Classes;

use Exception;
use Igniter\Cart\Components\CartBox;
use Igniter\Flame\Exception\ApplicationException;
use Illuminate\Support\Facades\Session;

class CartApi extends CartBox
{
    public function updateCart()
    {
        try {
            $this->initialize();
            $postData = post();

            $this->cartManager->addOrUpdateCartItem($postData);
            return Session::get('cart');
        } catch (Exception $ex) {
            return json_encode($ex->getMessage());
            // if (Request::ajax()) throw $ex;
            // else flash()->alert($ex->getMessage());
        }
    }


    public function updateQuantity()
    {
        try {
            $action = (string)post('action');
            $rowId = (string)post('rowId');
            $quantity = (int)post('quantity');
            $this->initialize();
            $this->cartManager->updateCartItemQty($rowId, $action ?: $quantity);
            return Session::get('cart');

            // $this->controller->pageCycle();

            // return $this->fetchPartials();
        } catch (Exception $ex) {
            return json_encode($ex->getMessage());
        }
    }

    public function onRemoveItem()
    {
        return $this->onUpdateItemQuantity();
    }

    public function applyCoupon()
    {
        try {
            $this->initialize();
            $this->cartManager->applyCouponCondition(post('code'));
            return Session::get('cart');
        } catch (Exception $ex) {
            return json_encode($ex->getMessage());
        }
    }

    public function applyTip()
    {
        try {
            $this->initialize();
            $amountType = post('amount_type');
            if (!in_array($amountType, ['none', 'amount', 'custom']))
                throw new ApplicationException(lang('igniter.cart::default.alert_tip_not_applied'));

            $amount = post('amount');
            if (preg_match('/^\d+([\.\d]{2})?([%])?$/', $amount) === false)
                throw new ApplicationException(lang('igniter.cart::default.alert_tip_not_applied'));

            $this->cartManager->applyCondition('tip', [
                'amountType' => $amountType,
                'amount' => $amount,
            ]);

            return Session::get('cart');
        } catch (Exception $ex) {
            return json_encode($ex->getMessage());
        }
    }

    public function removeCondition()
    {
        try {
            if (!strlen($conditionId = post('conditionId')))
                return;

            $this->initialize();
            $this->cartManager->removeCondition($conditionId);
            return Session::get('cart');
        } catch (Exception $ex) {
            return json_encode($ex->getMessage());
        }
    }
}