<?php

namespace Hyperce\EatOnline;

use Hyperce\EatOnline\Classes\CartApi;
use Igniter\Cart\Components\CartBox;
use Illuminate\Support\Facades\Route;

// TODO: FIX HERE
Route::prefix('api')->middleware(['api'])->group(function () {
    Route::get('/get-cart', [CartApi::class, 'getCart']);

    // required form fields: menuId, rowId(optional), menu_options, quantity
    Route::post('/update-cart', [CartApi::class, 'updateCart']);

    //form fields: action, rowId, quantity
    Route::post('/update-quantity', [CartBox::class, 'onUpdateItemQuantity']);

    //form fields: code
    Route::post('/coupon', [CartBox::class, 'onApplyCoupon']);

    // form fields: amount_type, amount
    Route::post('/apply-tip', [CartBox::class, 'onApplyTip']);
});
