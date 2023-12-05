@if(isset($href))
	<a
	@class([$class])
	@if(isset($id)) id="{{ $id }}" @endif
	@if(isset($target)) target="{{ $target }}" @endif>
		<i @class(["fa-solid fa-globe", $iconClass])></i>
	</a>
@endif