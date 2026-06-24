@extends('layouts.app')

@section('content')
<div class="mb-8">
    <p class="text-sm font-black uppercase tracking-wide text-stitch-hibiscus">{{ __('messages.admin_panel') }}</p>
    <h1 class="mt-2 text-4xl font-black text-stitch-navy">{{ __('messages.edit_product') }}</h1>
</div>

<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="rounded-3xl border border-sky-100 bg-white p-6 shadow-sm sm:p-8">
    @method('PUT')
    @include('admin.products._form', [
        'product' => $product,
        'buttonText' => __('messages.update_product'),
    ])
</form>
@endsection
