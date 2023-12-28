<div id="{{ $this->getId('toolbar') }}">
    <div class="btn-toolbar justify-content-between" data-control="toolbar" role="toolbar">

        @if($recordCount < $addLimit)
        <div class="toolbar-item">
            <div class="btn-group">
                <button type="button" class="btn btn-default" data-control="load-record">
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;
                    {{ $prompt ? lang($prompt) : '' }}
                </button>
            </div>
        </div>
        @endif
    </div>
</div>