@extends('layouts.dashboard.app')

@section('title', __('site.categories'))

@php
    
$path = [
    ['title' => __('site.home') , 'link' => route('dashboard.index')],
    ['title' => __('site.categories')]
]

@endphp

@section('content')

<x-breadcrumb title="{{ __('site.categories') }}" :path="$path"></x-breadcrumb>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">@lang('site.categories')</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div class="listjs-table" id="customerList">
                    <div class="row g-4 mb-3">
                        @if (auth()->user()->hasPermission('create-category'))
                            <div class="col-sm-auto">
                                <div>
                                    <a href="{{ route('dashboard.categories.create') }}" type="button" class="btn btn-success" id="create-btn"><i class="ri-add-line align-bottom me-1"></i> @lang('site.add')</a>
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
                        @if ($categories->count() == 0)
                            <x-no-result-found></x-no-result-found>
                        @else
                            <table class="table align-middle table-nowrap" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="sort">#</th>
                                        <th class="sort">@lang('site.name')</th>
                                        <th class="sort">@lang('site.products.count')</th>
                                        <th class="sort">@lang('site.products')</th>
                                        @if (auth()->user()->hasPermission(['edit-category', 'remove-category']))
                                            <th class="sort">@lang('site.action')</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td><a href="javascript:void(0);" class="fw-medium link-primary">#{{ $category->id }}</a></td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->products->count() }}</td>
                                            <td><a href="{{ route('dashboard.products.index' , ['category_search' => $category->id]) }}" class="btn btn-primary">@lang('site.show-products')</a></td>
                                            @if (auth()->user()->hasPermission(['edit-category', 'remove-category']))
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        @if (auth()->user()->hasPermission('edit-category'))
                                                            <a href="{{ route('dashboard.categories.edit', $category) }}">
                                                                <button class="btn btn-sm btn-success edit-item-btn">@lang('site.edit')</button>
                                                            </a>
                                                        @endif
                                                        @if (auth()->user()->hasPermission('remove-category'))
                                                            <form action="{{ route('dashboard.categories.destroy', $category) }}" method="post">
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
                        {{ $categories->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end col -->
</div>

@endsection