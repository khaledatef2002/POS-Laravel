@extends('layouts.dashboard.app')

@section('title', __('site.roles.edit'))

@php

    $path = [
        ['title' => __('site.home')  , 'link' => route('dashboard.index')],
        ['title' => __('site.roles') , 'link' => route('dashboard.roles.index')],
        ['title' => __('site.roles.edit')]
    ]

@endphp

@section('content')

<x-breadcrumb title="{{ __('site.roles.edit') }}" :path="$path"></x-breadcrumb>

<div class="col-12">
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">@lang('site.roles.edit')</h4>
        </div><!-- end card header -->

        <div class="card-body">
            @session('success')
                <x-success-alert msg="{{ $value }}"></x-success-alert>
            @endsession
            <x-error-alert></x-error-alert>
            <div class="live-preview">
                <form action="{{ route('dashboard.roles.update', $role) }}" method="post" class="row g-3">
                    @csrf
                    @method('put')
                    <div class="col-md-12">
                        <label for="name" class="form-label">@lang('site.role-name'):</label>
                        <input name="name" type="text" class="form-control" id="name" placeholder="@lang('site.role-name')" value="{{ $role->name }}">
                    </div>
                    <div class="col-md-12">
                        <label for="display_name" class="form-label">@lang('site.display-name'):</label>
                        <input name="display_name" type="text" class="form-control" id="display_name" placeholder="@lang('site.display-name')" value="{{ $role->display_name }}">
                    </div>
                    <div class="col-md-12">
                        <label for="description" class="form-label">@lang('site.description'):</label>
                        <textarea name="description" class="form-control" id="description" placeholder="@lang('site.description')">{{ $role->description }}</textarea>
                    </div>
                    <p class="fw-bold mb-0 fs-5">@lang('site.permissions'):</p>
                    <div class="col-md-12 mt-1">
                        <ul class="nav nav-pills nav-justified mb-3" role="tablist" style="border-top: 2px solid #405189">
                            <li class="nav-item waves-effect waves-light" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#users" role="tab" aria-selected="true">
                                    @lang('site.users')
                                </a>
                            </li>
                            <li class="nav-item waves-effect waves-light" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#roles" role="tab" aria-selected="false" tabindex="-1">
                                    @lang('site.roles')
                                </a>
                            </li>
                            <li class="nav-item waves-effect waves-light" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#categories" role="tab" aria-selected="false" tabindex="-1">
                                    @lang('site.categories')
                                </a>
                            </li>
                            <li class="nav-item waves-effect waves-light" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#products" role="tab" aria-selected="false" tabindex="-1">
                                    @lang('site.products')
                                </a>
                            </li>
                            <li class="nav-item waves-effect waves-light" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#clients" role="tab" aria-selected="false" tabindex="-1">
                                    @lang('site.clients')
                                </a>
                            </li>
                            <li class="nav-item waves-effect waves-light" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#orders" role="tab" aria-selected="false" tabindex="-1">
                                    @lang('site.orders')
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content text-muted">
                            <div class="tab-pane active show" id="users" role="tabpanel">
                                <div class="d-flex gap-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="create-user" value="create-user" name="permissions[]" {{ $role->hasPermission('create-user') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="create-user">
                                            @lang('site.add')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="read-user" value="read-user" name="permissions[]" {{ $role->hasPermission('read-user') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="read-user">
                                            @lang('site.read')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="edit-user" value="edit-user" name="permissions[]" {{ $role->hasPermission('edit-user') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edit-user">
                                            @lang('site.edit')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remove-user" value="remove-user" name="permissions[]" {{ $role->hasPermission('remove-user') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remove-user">
                                            @lang('site.remove')
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="roles" role="tabpanel">
                                <div class="d-flex gap-5">
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="create-role" value="create-role" name="permissions[]" {{ $role->hasPermission('create-role') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="create-role">
                                            @lang('site.add')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="read-role" value="read-role" name="permissions[]" {{ $role->hasPermission('read-role') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="read-role">
                                            @lang('site.read')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="edit-role" value="edit-role" name="permissions[]" {{ $role->hasPermission('edit-role') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edit-role">
                                            @lang('site.edit')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remove-role" value="remove-role" name="permissions[]" {{ $role->hasPermission('remove-role') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remove-role">
                                            @lang('site.remove')
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane" id="categories" role="tabpanel">
                                <div class="d-flex gap-5">
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="create-category" value="create-category" name="permissions[]" {{ $role->hasPermission('create-category') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="create-category">
                                            @lang('site.add')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="read-category" value="read-category" name="permissions[]" {{ $role->hasPermission('read-category') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="read-category">
                                            @lang('site.read')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="edit-category" value="edit-category" name="permissions[]" {{ $role->hasPermission('edit-category') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edit-category">
                                            @lang('site.edit')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remove-category" value="remove-category" name="permissions[]" {{ $role->hasPermission('remove-category') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remove-category">
                                            @lang('site.remove')
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane" id="products" role="tabpanel">
                                <div class="d-flex gap-5">
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="create-product" value="create-product" name="permissions[]" {{ $role->hasPermission('create-product') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="create-product">
                                            @lang('site.add')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="read-product" value="read-product" name="permissions[]" {{ $role->hasPermission('read-product') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="read-product">
                                            @lang('site.read')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="edit-product" value="edit-product" name="permissions[]" {{ $role->hasPermission('edit-product') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edit-product">
                                            @lang('site.edit')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remove-product" value="remove-product" name="permissions[]" {{ $role->hasPermission('remove-product') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remove-product">
                                            @lang('site.remove')
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane" id="clients" role="tabpanel">
                                <div class="d-flex gap-5">
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="create-client" value="create-client" name="permissions[]" {{ $role->hasPermission('create-client') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="create-client">
                                            @lang('site.add')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="read-client" value="read-client" name="permissions[]" {{ $role->hasPermission('read-client') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="read-client">
                                            @lang('site.read')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="edit-client" value="edit-client" name="permissions[]" {{ $role->hasPermission('edit-client') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edit-client">
                                            @lang('site.edit')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remove-client" value="remove-client" name="permissions[]" {{ $role->hasPermission('remove-client') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remove-client">
                                            @lang('site.remove')
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane" id="orders" role="tabpanel">
                                <div class="d-flex gap-5">
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="create-order" value="create-order" name="permissions[]" {{ $role->hasPermission('create-order') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="create-order">
                                            @lang('site.add')
                                        </label>
                                    </div>
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="read-order" value="read-order" name="permissions[]" {{ $role->hasPermission('read-order') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="read-order">
                                            @lang('site.read')
                                        </label>
                                    </div>
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="edit-order" value="edit-order" name="permissions[]" {{ $role->hasPermission('edit-order') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edit-order">
                                            @lang('site.edit')
                                        </label>
                                    </div>
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remove-order" value="remove-order" name="permissions[]" {{ $role->hasPermission('remove-order') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remove-order">
                                            @lang('site.remove')
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
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