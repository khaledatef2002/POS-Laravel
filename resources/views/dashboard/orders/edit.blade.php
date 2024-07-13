@extends('layouts.dashboard.app')

@section('title', __('site.orders.edit'))

@php

    $path = [
        ['title' => __('site.home')  , 'link' => route('dashboard.index')],
        ['title' => __('site.clients') , 'link' => route('dashboard.clients.index')],
        ['title' => __('site.orders.edit')]
    ]


@endphp

@section('content')

<x-breadcrumb title="{{ __('site.orders.edit') }}" :path="$path"></x-breadcrumb>

<div class="row">
    <div class="col-12">
        <div class="card">
            <table class="table align-middle table-nowrap mb-0" id="customerTable">
                <thead class="table-light">
                    <tr>
                        <th class="sort">#</th>
                        <th class="sort">@lang('site.client.name')</th>
                        <th class="sort">@lang('site.phone')</th>
                        <th class="sort">@lang('site.address')</th>
                        <th class="sort">@lang('site.order.date')</th>
                    </tr>
                </thead>
                <tbody class="list form-check-all">
                    <tr>
                        <td><a href="javascript:void(0);" class="fw-medium link-primary">#{{ $order->id }}</a></td>
                        <td>{{ $order->client->name }} </td>
                        <td>{{ $order->client->phone }}</td>
                        <td>{{ $order->client->address }}</td>
                        <td><bdi>{{ $order->created_at->format('Y-m-d h:i:s a') }}</bdi></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">@lang('site.orders.edit')</h4>
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
                                <li data-category="{{$category->id}}" data-id="{{ $product->id }}" data-title="{{ $product->title }}" data-price="{{ $product->sell_price }}" data-stock="{{ $order->products->pluck('product_id')->contains($product->id) ? $product->stock + $order->products->firstWhere('product_id', $product->id)->quantity : $product->stock }}">
                                    <div class="row">
                                        <div class="d-flex align-items-center col-6">
                                            <img class="rounded" src="{{ asset($product->image) }}" width="40">
                                            <p class="fw-bold mb-0 ms-2">{{ $product->title }}</p>
                                        </div>
                                        <div class="col-3 d-flex align-items-center text-center">
                                            (@lang('site.stock'): {{ $product->stock }}) {{ $order->products->pluck('product_id')->contains($product->id) ? "+ [" . $order->products->firstWhere('product_id', $product->id)->quantity . "]" : '' }}
                                        </div>
                                        <div class="col-3 d-flex justify-content-end align-items-center">
                                            [{{ $product->sell_price }} @lang('site.currency')]
                                            <button class="btn btn-success fw-bold add-item-to-cart" {{ $product->stock == 0 || $order->products->pluck('product_id')->contains($product->id) ? 'disabled' : '' }}>+</button>
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
                <form action="{{ route('dashboard.orders.update', $order) }}" method="post">
                    @csrf
                    @method('PUT')
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
                            @foreach ($order->products as $product)
                                <tr data-price="{{ $product->item->sell_price }}">
                                    <td>{{ $product->item->title }}</td>
                                    <input type="hidden" name="products[]" value="{{ $product->item->id }}">
                                    <td><input name="quantities[]" value="{{ $product->quantity }}" min="1" max="{{ $product->quantity + $product->item->stock }}" onchange="check_max(this)" type="number" class="form-control" oninput="change_quantity(this)"></td>
                                    <td>{{ $product->quantity * $product->item->sell_price }}</td>
                                    <td><button class="btn btn-danger" onclick="remove_from_cart(this, {{ $product->item->id }})"><i class="ri-delete-bin-line"></i></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p>@lang('site.total_price') <span class="total-price">{{ $order->total_price }}</span> @lang('site.currency')</p>
                    <button class="btn btn-primary w-100 add-order" type="submit" {{ $order->products->count() ? '' : 'disabled' }}>@lang('site.save-order')</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>@lang('site.client.order.history')</h4>
            </div>
            <div class="card-body">
                <table class="table align-middle table-nowrap" id="customerTable">
                    <thead class="table-light">
                        <tr>
                            <th class="sort">#</th>
                            <th class="sort">@lang('site.client.name')</th>
                            <th class="sort">@lang('site.total_price')</th>
                            <th class="sort">@lang('site.order.date')</th>
                            @if (auth()->user()->hasPermission(['edit-order', 'remove-order']))
                                <th class="sort">@lang('site.action')</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="list form-check-all">
                        @foreach ($order->client->orders as $orderHistory)
                            <tr>
                                <td><a href="javascript:void(0);" class="fw-medium link-primary">#{{ $orderHistory->id }}</a></td>
                                <td>{{ $orderHistory->client->name }} </td>
                                <td>{{ $orderHistory->total_price }}</td>
                                <td><bdi>{{ $orderHistory->created_at->format('Y-m-d h:i:s a') }}</bdi></td>
                                @if (auth()->user()->hasPermission(['read-order', 'edit-order', 'remove-order']))
                                    <td>
                                        <div class="d-flex gap-2">
                                            @if (auth()->user()->hasPermission('read-order'))
                                                <button class="btn btn-sm btn-primary" onclick="show_order({{ $orderHistory->id }})">@lang('site.show')</button>
                                            @endif
                                            @if (auth()->user()->hasPermission('edit-order'))
                                                <a href="{{ route('dashboard.orders.edit', $orderHistory) }}">
                                                    <button class="btn btn-sm btn-success edit-item-btn">@lang('site.edit')</button>
                                                </a>
                                            @endif
                                            @if (auth()->user()->hasPermission('remove-order'))
                                                <form action="{{ route('dashboard.orders.destroy', $orderHistory) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-sm btn-danger remove-item-btn" type="submit">@lang('site.remove')</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection