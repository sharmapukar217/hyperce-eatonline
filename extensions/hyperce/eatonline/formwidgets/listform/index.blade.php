<div id="{{ $this->getId() }}" data-control="records-container" data-alias="{{ $this->alias }}"
    data-remove-handler="{{ $this->getEventHandler('onDeleteRecord') }}"
    data-sortable-container="#{{ $this->getId('records') }}"
    data-sortable-handle=".{{ $this->getId('records') }}-handle">
    <div class="records-count">
        {!! $this->makePartial('listform/counts') !!}
    </div>

    <div class="record-container my-3" id="{{ $this->getId('items') }}">
        {!! $this->makePartial('listform/records') !!}
    </div>

    <div id="{{ $this->getId('toolbar') }}" class="record-toolbar">
        {!! $this->makePartial('listform/toolbar') !!}
    </div>
</div>