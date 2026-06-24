@extends('layouts.app')

@section('content')
<div class="mb-8 border-b border-surface-container-highest pb-4">
    <span class="font-label-caps text-label-caps text-blood-red uppercase tracking-widest">{{ __('messages.admin_panel') }}</span>
    <h1 class="font-headline-lg text-headline-lg text-raw-white uppercase mt-2">{{ __('messages.edit_product') }}</h1>
</div>

<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="bg-surface-container-low border border-surface-container-highest p-8">
    @method('PUT')
    @include('admin.products._form', [
        'product' => $product,
        'buttonText' => __('messages.update_product'),
    ])
</form>
@endsection
