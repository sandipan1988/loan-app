@if ($errors->has($field))
    <span class="" role="alert" style="display: block;{{-- This fixes a bootstrap known-issue --}}">
        <strong>{{ $errors->first($field) }}</strong>
    </span>
@endif
