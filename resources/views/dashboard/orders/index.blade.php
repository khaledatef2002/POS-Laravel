@extends('layouts.dashboard.app')

@section('title', __('site.orders'))

@php
    
$path = [
    ['title' => __('site.home') , 'link' => route('dashboard.index')],
    ['title' => __('site.orders')]
]

@endphp

@section('content')

<x-breadcrumb title="{{ __('site.orders') }}" :path="$path"></x-breadcrumb>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">@lang('site.orders')</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div class="listjs-table" id="customerList">
                    <div class="row g-4 mb-3">
                        <div class="col-sm">
                            <div class="d-flex justify-content-sm-end">
                                <form action="" class="d-flex">
                                    <div class="search-box me-2">
                                        <input name="search" value="{{ request()->search }}" type="text" class="form-control search" placeholder="@lang('site.search')...">
                                        <i class="ri-search-line search-icon"></i>
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
                        @if ($orders->count() == 0)
                            <x-no-result-found></x-no-result-found>
                        @else
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
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td><a href="javascript:void(0);" class="fw-medium link-primary">#{{ $order->id }}</a></td>
                                            <td>{{ $order->client->name }} </td>
                                            <td>{{ $order->total_price }}</td>
                                            <td><bdi>{{ $order->created_at->format('Y-m-d h:i:s a') }}</bdi></td>
                                            @if (auth()->user()->hasPermission(['read-order', 'edit-order', 'remove-order']))
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        @if (auth()->user()->hasPermission('read-order'))
                                                            <button class="btn btn-sm btn-primary" onclick="show_order({{ $order->id }})">@lang('site.show')</button>
                                                        @endif
                                                        @if (auth()->user()->hasPermission('edit-order'))
                                                            <a href="{{ route('dashboard.orders.edit', $order) }}">
                                                                <button class="btn btn-sm btn-success edit-item-btn">@lang('site.edit')</button>
                                                            </a>
                                                        @endif
                                                        @if (auth()->user()->hasPermission('remove-order'))
                                                            <form action="{{ route('dashboard.orders.destroy', $order) }}" method="post">
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
                        {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end col -->
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="order_info" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
      <h3 class="offcanvas-title fw-bold" id="offcanvasExampleLabel">@lang('site.order.details')</h3>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <hr class="m-0">
    <div class="offcanvas-body">
      
    </div>
    <div class="offcanvas-footer">
        <button class="btn btn-primary border-none w-100" data-bs-dismiss="offcanvas">@lang('site.close')</button>
    </div>
  </div>

@endsection