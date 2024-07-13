@extends('layouts.dashboard.app')

@section('title', __('site.products.add'))

@php

    $path = [
        ['title' => __('site.home')  , 'link' => route('dashboard.index')],
        ['title' => __('site.products') , 'link' => route('dashboard.products.index')],
        ['title' => __('site.products.add')]
    ]

@endphp

@section('content')

<x-breadcrumb title="{{ __('site.products.add') }}" :path="$path"></x-breadcrumb>

<div class="col-12">
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">@lang('site.products.add')</h4>
        </div><!-- end card header -->

        <div class="card-body">
            <x-error-alert></x-error-alert>
            <div class="live-preview">
                <form action="{{ route('dashboard.products.store') }}" method="post" class="row g-3" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12">
                        <div class="text-center">
                            <div class="position-relative d-inline-block">
                                <div class="position-absolute  bottom-0 end-0">
                                    <label for="customer-image-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="@lang('site.select-image')" data-bs-original-title="@lang('site.select-image')">
                                        <div class="avatar-xs cursor-pointer">
                                            <div class="avatar-title bg-light border rounded-circle text-muted">
                                                <i class="ri-image-fill"></i>
                                            </div>
                                        </div>
                                    </label>
                                    <input name="image" class="form-control d-none" id="customer-image-input" type="file" accept="image/png, image/gif, image/jpeg">
                                </div>
                                <div class="avatar-lg p-1">
                                    <div class="avatar-title bg-light rounded-circle">
                                        <img src="{{ asset('assets/dashboard/images/foods/default.avif') }}" id="customer-img" class="avatar-md rounded-circle object-fit-cover">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="category" class="form-label">@lang('site.category'):</label>
                        <select name="category_id" class="form-select" id="category" placeholder="@lang('site.category')">
                            @foreach ($categories as $category)
                                <option {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr>
                    @foreach (config('translatable.locales') as $locale)
                    <div class="col-md-12">
                        <label for="title" class="form-label">@lang('site.' . $locale . '.name'):</label>
                        <input name="{{$locale}}[title]" type="text" class="form-control" id="title" placeholder="@lang('site.' . $locale . '.name')" value="{{ old($locale . '.title') }}">
                    </div>
                    @endforeach
                    <hr>
                    @foreach (config('translatable.locales') as $locale)
                        <div class="col-md-12">
                            <label for="description" class="form-label">@lang('site.' . $locale . '.description'):</label>
                            <textarea name="{{$locale}}[description]" class="form-control" id="description" placeholder="@lang('site.' . $locale .'.description')">{{ old($locale . '.description') }}</textarea>
                        </div>
                    @endforeach
                    <hr>
                    <div class="col-md-12">
                        <label for="purchase_price" class="form-label">@lang('site.purchase_price'):</label>
                        <input name="purchase_price" type="number" step="0.01" class="form-control" id="purchase_price" placeholder="@lang('site.purchase_price')" value="{{ old('purchase_price') }}">
                    </div>
                    <div class="col-md-12">
                        <label for="sell_price" class="form-label">@lang('site.sell_price'):</label>
                        <input name="sell_price" type="number" step="0.01" class="form-control" id="sell_price" placeholder="@lang('site.sell_price')" value="{{ old('sell_price') }}">
                    </div>
                    <div class="col-md-12">
                        <label for="stock" class="form-label">@lang('site.stock'):</label>
                        <input name="stock" type="number" class="form-control" id="stock" placeholder="@lang('site.stock')" value="{{ old('stock') }}">
                    </div>
                    <div class="col-12">
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">@lang('site.create')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection