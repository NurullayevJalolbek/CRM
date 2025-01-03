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
                            <a class="nav-link" href="payment-settings.html">Payment Methods</a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <div class="card card-table">
                        <div class="card-body">

                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Payment Methods</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="{{ route('paymentMethods.create') }}" class="btn btn-primary"><i
                                                class="fas fa-plus"></i>
                                            Qo'shish</a>
                                    </div>
                                </div>
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

                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-student table-hover table-center mb-0 datatable table-striped table table-bordered table-md">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($paymentMethods as $paymentMethod)
                                            <tr>
                                                <td>
                                                    <h2>
                                                        <b>{{ $paymentMethod->name }}</b>
                                                    </h2>
                                                </td>

                                                <td>
                                                    <div class="btn-group">
                                                        <form
                                                            action="{{ route('paymentMethods.delete', ['id' => $paymentMethod->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button
                                                                onclick="return confirm('Haqiqatan ham o\'chirib tashlamoqchimisiz ?')"
                                                                class="btn btn-danger btn btn-sm rounded-pill px-3 text-white">
                                                                <i class="feather-trash"></i> O'chirish
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
