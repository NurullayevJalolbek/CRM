@extends('layouts.app')
@section('title')
    Fanlar
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Barcha Fanlar</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Fanlar</a></li>
                            <li class="breadcrumb-item active">Barcha fanlar</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="student-group-form">
                <div class="row">
                    <div class="col-lg-5 col-md-6">
                        <div class="form-group">
                            <form action="{{ route('subjects.search') }}" method="GET" class="d-flex ">
                                <input type="text" value="{{ Request::get('query') }}" class="form-control " name="query"
                                    placeholder="Nomi orqali qidirish">
                                <button type="submit" class="btn btn-primary mx-2">Qidirish</button>
                                <a href="{{ route('subjects.index') }}" class="btn btn-success"
                                    style="padding-top: 10px">Qaytatish</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">

                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Barcha Fanlar</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="{{ route('subjects.create') }}" class="btn btn-primary"><i
                                                class="fas fa-plus"></i>
                                            Yaratish</a>
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
                                            <th>ID</th>
                                            <th>Nomi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subjects as $subject)
                                            <tr>
                                                <td>{{ $subject->id }}</td>
                                                <td>
                                                    <h2>
                                                        <a
                                                            href="{{ route('subjects.showHtml', $subject->id) }}"><b>{{ $subject->name }}</b></a>
                                                    </h2>
                                                </td>

                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('subjects.showHtml', $subject->id) }}"
                                                            class="btn btn-sm btn-success rounded-pill px-3 text-white">
                                                            <i class="feather-eye"></i> Batafsil
                                                        </a>
                                                        <a href="{{ route('subjects.edit', $subject->id) }}"
                                                            class="btn btn-sm btn-warning rounded-pill px-3 mx-2 text-white">
                                                            <i class="feather-edit"></i> Tahrirlash
                                                        </a>
                                                        <form action="{{ route('subjects.delete', $subject->id) }}"
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
