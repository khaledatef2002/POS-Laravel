@extends('layouts.dashboard.app')

@section('title', __('site.products'))

@php
    
$path = [
    ['title' => __('site.home') , 'link' => route('dashboard.index')],
    ['title' => __('site.products')]
]

@endphp

@section('content')

<x-breadcrumb title="{{ __('site.products') }}" :path="$path"></x-breadcrumb>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">@lang('site.products')</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div class="listjs-table" id="customerList">
                    <div class="row g-4 mb-3">
                        @if (auth()->user()->hasPermission('create-product'))
                            <div class="col-sm-auto">
                                <div>
                                    <a href="{{ route('dashboard.products.create') }}" type="button" class="btn btn-success" id="create-btn"><i class="ri-add-line align-bottom me-1"></i> @lang('site.add')</a>
                                </div>
                            </div>
                        @endif
                        <div class="col-sm">
                            <div class="d-flex justify-content-sm-end">
                                <form action="" class="d-flex">
                                    <div class="search-box me-2">
                                        <input name="search" value="{{ request()->search }}" type="text" class="form-control search" placeholder="@lang('site.search')...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                    <div class="me-2">
                                        <select name="category_search" class="form-select">
                                            <option value="">الجميع</option>
                                            @foreach ($categories as $category)
                                                <option {{ request()->category_search == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button class="btn btn-info" type="submit">@lang('site.search')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @session('success')
                        <x-success-alert :msg="$value"></x-success-alert>
                    @endsession
                    <div class="table-responsive table-card mt-3 mb-1">
                        @if ($products->count() == 0)
                            <x-no-result-found></x-no-result-found>
                        @else
                            <table class="table align-middle table-nowrap" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="sort">#</th>
                                        <th class="sort">@lang('site.image')</th>
                                        <th class="sort">@lang('site.name')</th>
                                        <th class="sort">@lang('site.description')</th>
                                        <th class="sort">@lang('site.purchase_price')</th>
                                        <th class="sort">@lang('site.sell_price')</th>
                                        <th class="sort">@lang('site.profit_percent')</th>
                                        <th class="sort">@lang('site.stock')</th>
                                        @if (auth()->user()->hasPermission(['edit-product', 'remove-product']))
                                            <th class="sort">@lang('site.action')</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($products as $product)
                                        <tr>
                                            <td><a href="javascript:void(0);" class="fw-medium link-primary">#{{ $product->id }}</a></td>
                                            <td><img src="{{ asset($product->image) }}" width="50" class="thumbnail"></td>
                                            <td>{{ $product->title }}</td>
                                            <td>{{ $product->description }}</td>
                                            <td>{{ $product->purchase_price }}</td>
                                            <td>{{ $product->sell_price }}</td>
                                            <td>{{ $product->profit_percent }}</td>
                                            <td>{{ $product->stock }}</td>
                                            @if (auth()->user()->hasPermission(['edit-product', 'remove-product']))
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        @if (auth()->user()->hasPermission('edit-product'))
                                                            <a href="{{ route('dashboard.products.edit', $product) }}">
                                                                <button class="btn btn-sm btn-success edit-item-btn">@lang('site.edit')</button>
                                                            </a>
                                                        @endif
                                                        @if (auth()->user()->hasPermission('remove-product'))
                                                            <form action="{{ route('dashboard.products.destroy', $product) }}" method="post">
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
                        @endif
                    </div>

                    <div class="d-flex justify-content-end">
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end col -->
</div>

@endsection