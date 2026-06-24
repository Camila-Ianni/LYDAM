@extends('layouts.app')

@section('content')
<div class="mb-8">
    <p class="text-sm font-black uppercase tracking-wide text-stitch-hibiscus">{{ __('messages.admin_panel') }}</p>
    <h1 class="mt-2 text-4xl font-black text-stitch-navy">{{ __('messages.create_product') }}</h1>
</div>

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="rounded-3xl border border-sky-100 bg-white p-6 shadow-sm sm:p-8">
    @include('admin.products._form', [
        'product' => $product,
        'buttonText' => __('messages.save_product'),
    ])
</form>
@endsection
