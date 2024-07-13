@extends('layouts.dashboard.app')

@section('title', __('site.users.edit'))

@php

    $path = [
        ['title' => __('site.home')  , 'link' => route('dashboard.index')],
        ['title' => __('site.users') , 'link' => route('dashboard.users.index')],
        ['title' => __('site.users.edit')]
    ]

@endphp

@section('content')

<x-breadcrumb title="{{ __('site.users.edit') }}" :path="$path"></x-breadcrumb>

<div class="col-12">
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">@lang('site.users.edit')</h4>
        </div><!-- end card header -->

        <div class="card-body">
            @session('success')
                <x-success-alert msg="{{ $value }}"></x-success-alert>
            @endsession
            <x-error-alert></x-error-alert>
            <div class="live-preview">
                <form action="{{ route('dashboard.users.update', $user) }}" method="post" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    @method('put')
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
                                        <img src="{{ asset($user->image) }}" id="customer-img" class="avatar-md rounded-circle object-fit-cover">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="firstname" class="form-label">@lang('site.first-name'):</label>
                        <input name="first_name" type="text" class="form-control" id="firstname" placeholder="@lang('site.first-name')" value="{{ $user->first_name }}">
                    </div>
                    <div class="col-md-6">
                        <label for="lastname" class="form-label">@lang('site.last-name'):</label>
                        <input name="last_name" type="text" class="form-control" id="lastname" placeholder="@lang('site.last-name')" value="{{ $user->last_name }}">
                    </div>
                    <div class="col-md-12">
                        <label for="email" class="form-label">@lang('site.email'):</label>
                        <input name="email" type="email" class="form-control" id="email" placeholder="@lang('site.email')" value="{{ $user->email }}">
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">@lang('site.password'):</label>
                        <input name="password" type="password" class="form-control" id="password" placeholder="@lang('site.password')">
                    </div>
                    <div class="col-md-6">
                        <label for="re-password" class="form-label">@lang('site.re-password'):</label>
                        <input name="password_confirmation" type="password" class="form-control" id="re-password" placeholder="@lang('site.re-password')">
                    </div>
                    <div class="col-md-12">
                        <label for="role" class="form-label">@lang('site.role'):</label>
                        <select name="role" class="form-select" id="role" placeholder="@lang('site.role')">
                            <option value="" disabled {{ $user->roles->count() == 0 ? 'selected' : '' }}>@lang('site.no-role')</option>
                            @foreach ($roles as $role)
                                <option {{ $user->roles->count() > 0 && $user->roles->pluck('id')[0] == $role->id ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
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