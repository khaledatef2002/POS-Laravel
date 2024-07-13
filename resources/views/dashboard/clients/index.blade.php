@extends('layouts.dashboard.app')

@section('title', __('site.clients'))

@php
    
$path = [
    ['title' => __('site.home') , 'link' => route('dashboard.index')],
    ['title' => __('site.clients')]
]

@endphp

@section('content')

<x-breadcrumb title="{{ __('site.clients') }}" :path="$path"></x-breadcrumb>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">@lang('site.clients')</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div class="listjs-table" id="customerList">
                    <div class="row g-4 mb-3">
                        @if (auth()->user()->hasPermission('create-client'))
                            <div class="col-sm-auto">
                                <div>
                                    <a href="{{ route('dashboard.clients.create') }}" type="button" class="btn btn-success" id="create-btn"><i class="ri-add-line align-bottom me-1"></i> @lang('site.add')</a>
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
                                    <button class="btn btn-info" type="submit">@lang('site.search')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @session('success')
                        <x-success-alert :msg="$value"></x-success-alert>
                    @endsession
                    <div class="table-responsive table-card mt-3 mb-1">
                        @if ($clients->count() == 0)
                            <x-no-result-found></x-no-result-found>
                        @else
                            <table class="table align-middle table-nowrap" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="sort">#</th>
                                        <th class="sort">@lang('site.name')</th>
                                        <th class="sort">@lang('site.phone')</th>
                                        <th class="sort">@lang('site.address')</th>
                                        @if (auth()->user()->hasPermission('create-order'))
                                            <th class="sort">@lang('site.add-order')</th>
                                        @endif
                                        @if (auth()->user()->hasPermission(['edit-client', 'remove-client']))
                                            <th class="sort">@lang('site.action')</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($clients as $client)
                                        <tr>
                                            <td><a href="javascript:void(0);" class="fw-medium link-primary">#{{ $client->id }}</a></td>
                                            <td>{{ $client->name }}</td>
                                            <td>{{ $client->phone }}</td>
                                            <td>{{ $client->address }}</td>
                                            @if (auth()->user()->hasPermission('create-order'))
                                                <td><a href="{{ route('dashboard.clients.orders.create', $client) }}" class="btn btn-success btn-sm">أضف طلب</a></td>
                                            @endif    
                                            @if (auth()->user()->hasPermission(['edit-client', 'remove-client']))
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        @if (auth()->user()->hasPermission('edit-client'))
                                                            <a href="{{ route('dashboard.clients.edit', $client) }}">
                                                                <button class="btn btn-sm btn-success edit-item-btn">@lang('site.edit')</button>
                                                            </a>
                                                        @endif
                                                        @if (auth()->user()->hasPermission('remove-client'))
                                                            <form action="{{ route('dashboard.clients.destroy', $client) }}" method="post">
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
                        {{ $clients->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end col -->
</div>

@endsection