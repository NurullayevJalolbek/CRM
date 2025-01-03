@extends('layouts.app')
@section('title')
    Guruhlar
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Barcha guruhlar</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('groups.index') }}">Guruhlar</a></li>
                            <li class="breadcrumb-item active">barcha guruhlar</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="student-group-form">
                <div class="row">
                    <div class="col-lg-5 col-md-6">
                        <div class="form-group">
                            <form action="{{ route('groups.search') }}" method="GET" class="d-flex ">
                                <input type="text" value="{{ Request::get('query') }}" class="form-control "
                                    name="query" placeholder="Guruh nomi orqali qidirish">
                                <button type="submit" class="btn btn-primary mx-2">Qidirish</button>
                                <a href="{{ route('groups.index') }}" class="btn btn-success"
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
                                        <h3 class="page-title">Barcha guruhlar</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="{{ route('groups.export') }}" class="btn btn-outline-primary me-2"><i
                                                class="fas fa-download"></i> Excel</a>
                                        <a href="{{ route('groups.create') }}" class="btn btn-primary"><i
                                                class="fas fa-plus"></i>
                                            Guruh yaratish</a>
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
                                            <th>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </th>
                                            <th>ID</th>
                                            <th>Nomi</th>
                                            <th>Narxi</th>
                                            <th>Ustozi</th>
                                            <th>Fani</th>
                                            <th>Talabalar soni</th>
                                            <th>Boshlangan vaqti</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($groups as $group)
                                            <tr>
                                                <td>
                                                    <div class="form-check check-tables">
                                                        <input class="form-check-input" type="checkbox" value="something">
                                                    </div>
                                                </td>
                                                <td>{{ $group->id }}</td>
                                                <td>
                                                    <h2>
                                                        <a
                                                            href="{{ route('groups.show', $group->id) }}"><b>{{ ucfirst($group->name) }}</b></a>
                                                    </h2>
                                                </td>
                                                <td>{{ number_format($group->price, 0, ',', ' ') }} so'm</td>
                                                <td>{{ $group->user->name ?? 'N/A' }}</td>
                                                <td>{{ $group->subject->name ?? 'N/A' }}</td>
                                                <td>{{ $group->numberOfStudents ?? 'N/A' }} azo</td>
                                                <td>{{ $group->started_date }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('groups.show', $group->id) }}"
                                                            class="btn btn-sm btn-success rounded-pill px-3  text-white">
                                                            <i class="feather-eye"></i> Batafsil
                                                        </a>
                                                        <a href="{{ route('groups.edit', $group->id) }}"
                                                            class="btn btn-sm btn-warning rounded-pill px-3 mx-2 text-white">
                                                            <i class="feather-edit"></i> Tahrirlash
                                                        </a>
                                                        <form action="{{ route('groups.delete', $group->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button
                                                                onclick="return confirm('Haqiqatan ham o\'chirib tashlamoqchimisiz ?')"
                                                                class="btn btn-danger btn btn-sm rounded-pill px-3 text-white"><i
                                                                    class="feather-trash"></i> O'chirish</button>
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
