@extends('layouts.app')
@section('title')
    Ustozlar
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Ustozlar</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">Ustozlar</a></li>
                            <li class="breadcrumb-item active">Barcha ustozlar</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="student-group-form">
                <div class="row">
                    <div class="col-lg-5 col-md-6">
                        <div class="form-group">
                            <form action="{{ route('teachers.search') }}" method="GET" class="d-flex ">
                                <input type="text" value="{{ Request::get('query') }}" class="form-control "
                                    name="query" placeholder="Search by name">
                                <button type="submit" class="btn btn-primary mx-2">Qidirish</button>
                                <a href="{{ route('teachers.index') }}" class="btn btn-success"
                                    style="padding-top: 10px">Qaytarish</a>
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
                                        <h3 class="page-title">Ustozlar</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="{{ route('teacher.export') }}" class="btn btn-outline-primary me-2"><i
                                                class="fas fa-download"></i> Excel</a>
                                        <a href="{{ route('teachers.create') }}" class="btn btn-primary"><i
                                                class="fas fa-plus"></i></a>
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
                                    class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </th>
                                            <th>ID</th>
                                            <th>Rasm</th>
                                            <th>Ism</th>
                                            <th>Telefon raqam</th>
                                            <th>Login</th>
                                            <th>Fan</th>
                                            <th>Xona</th>
                                            <th>Guruhlar soni</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($teachers as $teacher)
                                            <tr>
                                                <td>
                                                    <div class="form-check check-tables">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="{{ $teacher->id }}">
                                                    </div>
                                                </td>
                                                <td>{{ $teacher->id }}</td>


                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="{{ route('teachers.show', $teacher->id) }}"
                                                            class="avatar avatar-sm me-2">
                                                            <img class="avatar-img rounded"
                                                                src="{{ $teacher->image ? asset('storage/' . $teacher->image) : asset('/assets/img/profiles/avatar-02.png') }}"
                                                                alt="User Image">
                                                        </a>
                                                    </h2>
                                                </td>





                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a
                                                            href="{{ route('teachers.show', $teacher->id) }}"><b>{{ $teacher->name }}</b></a>
                                                    </h2>
                                                </td>
                                                <td>{{ $teacher->number }}</td>
                                                <td>{{ $teacher->email }}</td>
                                                <td>
                                                    @if ($teacher->subject)
                                                        <ul class="list-group">
                                                            <li class="list-group-item">{{ $teacher->subject->name }}</li>
                                                        </ul>
                                                    @else
                                                        No subject assigned
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($teacher->room)
                                                        <ul class="list-group">
                                                            <li class="list-group-item">{{ $teacher->room->name }}</li>
                                                        </ul>
                                                    @else
                                                    <ul class="list-group">
                                                        <li class="list-group-item">N/A</li>
                                                    </ul>
                                                        
                                                    @endif
                                                </td>

                                                <td>{{ $teacher->groups()->where('status', 1)->count() }} ta</td>
                                                </td>

                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('teachers.show', $teacher->id) }}"
                                                            class="btn btn-sm btn-success rounded-pill px-3 text-white">
                                                            <i class="feather-eye"></i> Batafsil
                                                        </a>
                                                        <a href="{{ route('teachers.edit', $teacher->id) }}"
                                                            class="btn btn-sm btn-warning rounded-pill px-3 mx-2 text-white">
                                                            <i class="feather-edit"></i> Yangilash
                                                        </a>
                                                        <form action="{{ route('teachers.delete', $teacher->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
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
