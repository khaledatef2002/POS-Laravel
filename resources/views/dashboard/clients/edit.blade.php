@extends('layouts.dashboard.app')

@section('title', __('site.clients.edit'))

@php

    $path = [
        ['title' => __('site.home')  , 'link' => route('dashboard.index')],
        ['title' => __('site.clients') , 'link' => route('dashboard.clients.index')],
        ['title' => __('site.clients.edit')]
    ]

@endphp

@section('content')

<x-breadcrumb title="{{ __('site.clients.edit') }}" :path="$path"></x-breadcrumb>

<div class="col-12">
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">@lang('site.clients.edit')</h4>
        </div><!-- end card header -->

        <div class="card-body">
            @session('success')
                <x-success-alert msg="{{ $value }}"></x-success-alert>
            @endsession
            <x-error-alert></x-error-alert>
            <div class="live-preview">
                <form action="{{ route('dashboard.clients.update', $client) }}" method="post" class="row g-3">
                    @csrf
                    @method('put')
                    <div class="col-md-12">
                        <label for="name" class="form-label">@lang('site.name'):</label>
                        <input name="name" type="text" class="form-control" id="name" placeholder="@lang('site.name')" value="{{ $client->name }}">
                    </div>
                    <div class="col-md-12">
                        <label for="phone" class="form-label">@lang('site.phone'):</label>
                        <input name="phone" type="text" class="form-control" id="phone" placeholder="@lang('site.phone')" value="{{ $client->phone }}">
                    </div>
                    <div class="col-md-12">
                        <label for="address" class="form-label">@lang('site.address'):</label>
                        <textarea name="address" class="form-control" id="address" placeholder="@lang('site.address')">{{ $client->address }}</textarea>
                    </div>
                    <div class="col-12">
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">@lang('site.save')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection