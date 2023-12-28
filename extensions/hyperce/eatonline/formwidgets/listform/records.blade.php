@if ($records)
<div id="{{ $this->getId('records') }}" class="records" aria-multiselectable="true" data-control="records">
    @foreach ($records as $index => $record)
    {!! $this->makePartial('record', ['index' => $index, 'record' => $record]) !!}
    @endforeach
</div>
@else
<div class="card shadow-sm bg-light border-warning text-warning">
    <div class="card-body">
        <b>@lang('hyperce.eatonline::default.alert_no_record')</b>
    </div>
</div>
@endif 