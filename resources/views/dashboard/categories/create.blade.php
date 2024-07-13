@extends('layouts.dashboard.app')

@section('title', __('site.categories.add'))

@php

    $path = [
        ['title' => __('site.home')  , 'link' => route('dashboard.index')],
        ['title' => __('site.categories') , 'link' => route('dashboard.categories.index')],
        ['title' => __('site.categories.add')]
    ]

@endphp

@section('content')

<x-breadcrumb title="{{ __('site.categories.add') }}" :path="$path"></x-breadcrumb>

<div class="col-12">
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">@lang('site.categories.add')</h4>
        </div><!-- end card header -->

        <div class="card-body">
            <x-error-alert></x-error-alert>
            <div class="live-preview">
                <form action="{{ route('dashboard.categories.store') }}" method="post" class="row g-3">
                    @csrf
                    @foreach (config('translatable.locales') as $locale)
                        <div class="col-md-12">
                            <label for="{{ $locale }}.name" class="form-label">@lang('site.' . $locale .'.name'):</label>
                            <input name="{{ $locale }}[name]" type="text" class="form-control" id="{{ $locale }}.name" placeholder="@lang('site.' . $locale .'.name')" value="{{ old($locale . '.name') }}">
                        </div>
                    @endforeach
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