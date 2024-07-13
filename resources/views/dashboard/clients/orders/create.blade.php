@extends('layouts.dashboard.app')

@section('title', __('site.orders.add'))

@php

    $path = [
        ['title' => __('site.home')  , 'link' => route('dashboard.index')],
        ['title' => __('site.clients') , 'link' => route('dashboard.clients.index')],
        ['title' => __('site.orders.add')]
    ]

@endphp

@section('content')

<x-breadcrumb title="{{ __('site.orders.add') }}" :path="$path"></x-breadcrumb>

<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">@lang('site.orders.add')</h4>
            </div><!-- end card header -->
    
            <div class="card-body">
                <ul class="nav nav-pills nav-justified mb-3" role="tablist" style="border-top: 2px solid #405189">
                    <li class="nav-item waves-effect waves-light productCategoryShowAll" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#users" role="tab" aria-selected="true">
                            @lang('site.all')
                        </a>
                    </li>
                    @foreach ($categories as $category)
                        <li class="nav-item waves-effect waves-light productCategoryChanger" data-target="{{ $category->id }}" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="true">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="items">
                    <ul class="d-flex flex-column gap-3 orderProductsList" style="list-style:none">
                        @foreach ($categories as $category)
                            @foreach ($category->products as $product)
                                <li data-category="{{$category->id}}" data-id="{{ $product->id }}" data-title="{{ $product->title }}" data-price="{{ $product->sell_price }}" data-stock="{{ $product->stock }}">
                                    <div class="row">
                                        <div class="d-flex align-items-center col-7">
                                            <img class="rounded" src="{{ asset($product->image) }}" width="40">
                                            <p class="fw-bold mb-0 ms-2">{{ $product->title }}</p>
                                        </div>
                                        <div class="col-2 d-flex align-items-center text-center">
                                            (@lang('site.stock'): {{ $product->stock }})
                                        </div>
                                        <div class="col-3 d-flex justify-content-end align-items-center">
                                            [{{ $product->sell_price }} @lang('site.currency')]
                                            <button class="btn btn-success fw-bold add-item-to-cart" {{ $product->stock == 0 ? 'disabled' : '' }}>+</button>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">@lang('site.orders')</h4>
            </div><!-- end card header -->
    
            <div class="card-body">
                <form action="{{ route('dashboard.clients.orders.store', $client) }}" method="post">
                    @csrf
                    <table class="table cart-table">
                        <thead>
                            <tr>
                                <th>@lang('site.products')</th>
                                <th>@lang('site.quantity')</th>
                                <th>@lang('site.price')</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
    
                        </tbody>
                    </table>
                    <p>@lang('site.total_price') <span class="total-price">0</span> @lang('site.currency')</p>
                    <button class="btn btn-primary w-100 add-order" type="submit" disabled>@lang('site.add-order')</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection