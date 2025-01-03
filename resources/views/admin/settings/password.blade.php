@extends('layouts.app')

@section('title')
    Password
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Settings</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="settings.html">Settings</a></li>
                            <li class="breadcrumb-item active">Password change</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                    <div class="settings-menu-links">
                        <ul class="nav nav-tabs menu-tabs">
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('user.edit') }}">General Settings</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ route('changePassword') }}">Password change</a>
                            </li>
                            @if (auth()->user()->hasRole(['Supper admin', 'Admin']))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('socialLinks.index') }}">Social Links</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('paymentMethods.index') }}">Payment Methods</a>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible show fade">
                                        <div class="alert-body text-white">
                                            <button class="close" data-dismiss="alert">
                                                <span>×</span>
                                            </button>
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible show fade">
                                        <div class="alert-body text-white"
                                            style="color: red; font-weight: bold; !important">
                                            <button class="close" data-dismiss="alert">
                                                <span>×</span>
                                            </button>
                                            {{ session('error') }}
                                        </div>
                                    </div>
                                @endif
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Password changing</h5>
                                    <div class="status-toggle d-flex justify-content-between align-items-center">
                                        <input type="checkbox" id="status_1" class="check">
                                        <label for="status_1" class="checktoggle">checkbox</label>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <form class="form" action="{{ route('postChangePassword') }}" method="post">
                                        @csrf
                                        <div class="settings-form">
                                            <div class="form-group form-placeholder">
                                                <label for="current_password" class="form-label">Current Password</label>
                                                <input type="password" class="form-control" id="current_password"
                                                    name="current_password" required>
                                            </div>
                                            <div class="form-group form-placeholder">
                                                <label for="new_password" class="form-label">New Password</label>
                                                <input type="password" class="form-control" id="new_password"
                                                    name="new_password" required>
                                            </div>
                                            <div class="form-group form-placeholder">
                                                <label for="new_password_confirmation" class="form-label">Confirm New
                                                    Password</label>
                                                <input type="password" class="form-control" id="new_password_confirmation"
                                                    name="new_password_confirmation" required>
                                            </div>
                                            <div class="form-group mb-0">
                                                <div class="settings-btns">
                                                    <button type="submit" class="btn btn-orange">Submit</button>
                                                    <button type="submit" class="btn btn-grey">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
