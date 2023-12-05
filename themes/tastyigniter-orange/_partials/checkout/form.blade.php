{!! form_open([
    'id' => 'checkout-form',
    'role' => 'form',
    'method' => 'POST',
    'data-handler' => $confirmCheckoutEventHandler,
]) !!}

@partial('@customer_fields')


@if ($order->isDeliveryType())
    @partial('@address_fields')
@endif

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="ebee_comapny_name">Company Name (Optional)</label>
            <input
                type="text"
                class="form-control"
                id="ebee_comapny_name"
                name="ebee_company_name"
                value="{{ set_value('ebee_company_name', $order->ebee_company_name) }}"/>
            {!! form_error('ebee_company_name', '<span class="text-danger">', '</span>') !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="ebee_vat_id">Vat ID (Optional)</label>
            <input
                type="text"
                name="ebee_vat_id"
                id="ebee_vat_id"
                class="form-control"
                value="{{ set_value('ebee_vat_id', $order->ebee_vat_id) }}"/>
            {!! form_error('ebee_vat_id', '<span class="text-danger">', '</span>') !!}
        </div>
    </div>
</div>

<div data-partial="checkoutPayments">
    @partial('@payments')
</div>

@if ($showCommentField)
<div class="form-group">
    <label for="comment">@lang('igniter.cart::default.checkout.label_comment')</label>
    <textarea
        name="comment"
        id="comment"
        rows="3"
        class="form-control"
    >{!! set_value('comment', $order->comment) !!}</textarea>
</div>
@endif

@if ($showDeliveryCommentField)
<div class="form-group">
    <label for="delivery_comment">@lang('igniter.cart::default.checkout.label_delivery_comment')</label>
    <textarea
        name="delivery_comment"
        id="delivery_comment"
        rows="3"
        class="form-control"
    >{!! set_value('delivery_comment', $order->delivery_comment) !!}</textarea>
</div>
@endif

@if ($agreeTermsSlug)
    <div class="form-group">
        <div class="form-check">
            <input
                id="terms-condition"
                type="checkbox"
                name="terms_condition"
                value="1"
                class="form-check-input" {!! set_checkbox('terms_condition', '1') !!}
            >
            <label class="form-check-label ms-2" for="terms-condition">
                {!! sprintf(lang('igniter.cart::default.checkout.label_terms'), url($agreeTermsSlug)) !!}
            </label>
        </div>
        {!! form_error('terms_condition', '<span class="text-danger col-xs-12">', '</span>') !!}
    </div>
@endif

{!! form_close() !!}
