@extends('layouts.app')
@section('title')
    Payment methods
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Payment methods</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">Settings</a></li>
                            <li class="breadcrumb-item active">Payment methods</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="settings-menu-links">
                    <ul class="nav nav-tabs menu-tabs">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ route('user.edit') }}">General Settings</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ route('changePassword') }}">Password change</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ route('socialLinks.index') }}">Social Links</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('paymentMethods.index') }}">Payment Methods</a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('paymentMethods.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <h5 class="form-title"><span>Payment method create</span></h5>
                                        <a href="{{ route('paymentMethods.index') }}" class="btn btn-primary"
                                            style="height: 40px; !important">
                                            Orqaga</a>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary">Saqlash</button>
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
