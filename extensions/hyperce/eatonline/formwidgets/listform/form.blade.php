<div class="modal-dialog modal-lg">
    {!! form_open(
    [
    'role' => 'form',
    'class' => 'w-100',
    'id' => 'record-editor-form',
    'data-request' => $this->alias.'::onSaveRecord',
    'method' => $formWidget->context == 'create' ? 'POST' : 'PATCH',
    ]
    ) !!}
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">@lang($formTitle)</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="form-fields p-0">
                @foreach ($formWidget->getFields() as $field)
                {!! $formWidget->renderField($field) !!}
                @endforeach
            </div>
        </div>
        <div class="modal-footer text-right">
            <button type="button" class="btn btn-link"
                data-bs-dismiss="modal">@lang('admin::lang.button_close')</button>
            <button type="submit" class="btn btn-primary">@lang('admin::lang.button_save')</button>
        </div>
    </div>
    {!! form_close() !!}
</div>