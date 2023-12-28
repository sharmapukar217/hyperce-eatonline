<div id="{{ $this->getId('record-'.$record->id) }}" class="record card bg-light shadow-sm mb-2" data-control="record"
    data-record-id="{{ $record->id }}" data-item-index="{{ $index }}">
    <div class="card-body" role="tab" id="{{ $this->getId('record-header-'.$record->id) }}">
        <div class="d-flex w-100 justify-content-between">
            @if (!$this->previewMode && $sortable)
            <input type="hidden" name="{{ $sortableInputName }}[]" value="{{ $record->id }}">
            <div class="align-self-center">
                <a class="btn handle {{ $this->getId('records') }}-handle mt-1" role="button">
                    <i class="fa fa-arrows-alt-v text-black-50"></i>
                </a>
            </div>
            @endif
            <div class="flex-fill align-self-center mt-1" data-control="load-record"
                data-handler="{{ $this->getEventHandler('onLoadRecord') }}" role="button"><b>{{ $record->title }}</b>
            </div>
            <div class="align-self-center ml-auto">
                <a class="close text-danger" aria-label="Remove" role="button" @unless ($this->previewMode)
                    data-control="remove-record"
                    data-confirm-message="@lang('admin::lang.alert_warning_confirm')"
                    @endunless>
                    <i class="fa fa-trash-alt"></i>
                </a>
            </div>
        </div>
    </div>
</div>