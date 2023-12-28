<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/cartapi', function (Request $request){
    return ["response" => $request->headers_list()];
});

// required form fields: menuId, rowId(optional), menu_options, quantity
Route::post('/api/update-cart', [\Igniter\Demo\Classes\CartApi::class, 'updateCart']);

//form fields: action, rowId, quantity
Route::post('/api/update-quantity', [\Igniter\Demo\Classes\CartApi::class, 'updateQuantity']);

//form fields: code
Route::post('/api/coupon', [\Igniter\Demo\Classes\CartApi::class, 'applyCoupon']);

// form fields: amount_type, amount
Route::post('/api/applytip', [\Igniter\Demo\Classes\CartApi::class, 'applyTip']);

//form fields: conditionId
Route::post('/api/remove-condition', [\Igniter\Demo\Classes\CartApi::class, 'removeCondition']);

