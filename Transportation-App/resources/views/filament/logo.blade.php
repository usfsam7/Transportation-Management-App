{{-- resources/views/filament/topbar-logo.blade.php --}}
@php
    // Ensure file exists: public/images/logo.png
    $logo = asset('images/logo3.png');
@endphp

<div class="filament-global-logo" aria-hidden="true">
    <img src="{{ $logo }}" alt="TMS" class="filament-global-logo__img" />
</div>

<style>
.filament-global-logo {
    display: inline-flex;
    align-items: center;
    height: 48px;
    margin-left: 0.76rem;

}
.filament-global-logo__img {
    height: 90px;
    width: auto;
    display: inline-block;
    vertical-align: middle;
    object-fit: contain;
    pointer-events: none;
}
</style>
