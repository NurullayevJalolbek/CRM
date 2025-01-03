@extends('layouts.app')

@section('title')
    Sozlamalar
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Sozlamalar</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Settings</a></li>
                            <li class="breadcrumb-item active">General Settings</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="settings-menu-links">
                <ul class="nav nav-tabs menu-tabs">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('user.edit') }}">General Settings</a>
                    </li>
                    <li class="nav-item">
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
                        <div class="card-header">
                            <h5 class="card-title">User settings</h5>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert">
                                        <span>×</span>
                                    </button>
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible show fade">
                                <div class="alert-body text-white" style="color: red; font-weight: bold;">
                                    <button class="close" data-dismiss="alert">
                                        <span>×</span>
                                    </button>
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif
                        <div class="card-body pt-0">
                            <form action="{{ route('user.update', $user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="settings-form">
                                    <div class="form-group col-12">
                                        <label for="name">User Name</label>
                                        <input id="name" type="text" class="form-control" name="name" autofocus
                                            value="{{ $user->name }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="number">Number</label>
                                        <input id="number" type="text" class="form-control" name="number"
                                            value="{{ $user->number }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Login</label>
                                        <input id="email" type="text" class="form-control" name="email"
                                            value="{{ $user->email }}" required>
                                    </div>

                                    <div class="col-12 col-sm-4 pt-4">
                                        <div class="form-group local-forms">
                                            <label>Rasm (majburiy emas) <span class="login-danger">*</span></label>
                                            <div class="d-flex align-items-center">
                                                @if ($user->image)
                                                    <img src="{{ asset('storage/' . $user->image) }}"
                                                        class="avatar avatar-lg rounded me-3" alt="Old Image">
                                                @else
                                                    <img src="/assets/img/profiles/avatar-02.png"
                                                        class="avatar avatar-lg rounded me-3" alt="Old Image">
                                                @endif
                                                <div>
                                                    <label class="form-label" for="image">Rasm (majburiy emas)</label>
                                                    <input type="file" class="form-control-file" id="image"
                                                        name="image" value="{{ $user->image }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group mb-0">
                                        <div class="settings-btns">
                                            <button type="submit" class="btn btn-orange">Update</button>
                                            <button type="reset" class="btn btn-grey">Cancel</button>
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
@endsection
