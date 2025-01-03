@extends('layouts.app')
@section('title')
    Passiv mijozlar
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Mijozlar</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('passive-students.index') }}">Mijozlar</a></li>
                            <li class="breadcrumb-item active">Barcha mijozlar</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="student-group-form">
                <div class="row">
                    <div class="col-lg-5 col-md-6">
                        <div class="form-group">
                            <form action="{{ route('passive-students.search') }}" method="GET" class="d-flex">
                                <input type="text" class="form-control" value="{{ Request::get('name_query') }}"
                                    name="name_query" placeholder="Ism orqali qidirish">
                                <!-- Display old search query value -->
                                <button type="submit" class="btn btn-primary mx-2">Qidirish</button>
                                <a href="{{ route('passive-students.index') }}" class="btn btn-success pt-2">Qaytarish</a>
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
                                        <h3 class="page-title">Mijozlar</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        
                                        <a href="{{ route('passiveStudentExport.export') }}"
                                            class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Excel</a>
                                        <a href="{{ route('passive-students.create') }}" class="btn btn-primary"><i
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
                                            <th>Ism familiya</th>
                                            <th>Telefon raqam</th>
                                            <th>Mijoz oqimi</th>
                                            <th>Qo'shilgan vaqt</th>
                                            <th>Fan</th>
                                            <th>Izon</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($passiveStudents as $passiveStudent)
                                            <tr>
                                                <td>
                                                    <div class="form-check check-tables">
                                                        <input class="form-check-input" type="checkbox" value="">
                                                    </div>
                                                </td>
                                                <td>{{ $passiveStudent->id }}</td>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a
                                                            href="{{ route('students.show', $passiveStudent->id) }}"><b>{{ $passiveStudent->name }}</b></a>
                                                    </h2>
                                                </td>
                                                <td>{{ $passiveStudent->number }}</td>
                                                <td>{{ $passiveStudent->social_links ? $passiveStudent->social_links->name : 'mavjud emas' }}
                                                </td>
                                                </td>
                                                </td>

                                                <td>{{ $passiveStudent->created_at->format('Y-m-d, H:i') }}</td>
                                                <td>{{ $passiveStudent->subject ? $passiveStudent->subject->name : 'mavjud emas' }}</td>
                                                <td>
                                                    @if ($passiveStudent->notes)
                                                        @php
                                                            $words = explode(' ', $passiveStudent->notes);
                                                            $shortNotes = implode(' ', array_slice($words, 0, 3));
                                                            $ellipsis = count($words) > 3 ? '...' : '';
                                                        @endphp
                                                        {{ $shortNotes . $ellipsis }}
                                                        @if (count($words) > 3)
                                                            <a href="{{ route('passive-students.show', $passiveStudent->id) }}"
                                                                data-toggle="tooltip" data-placement="left"
                                                                title="{{ $passiveStudent->notes }}">
                                                                <small>To'lliq</small>
                                                            </a>
                                                        @endif
                                                    @else
                                                        Not Available
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('passive-students.edit', $passiveStudent->id) }}"
                                                            class="btn btn-sm btn-warning rounded px-3 mx-2 text-white">
                                                            <i class="feather-edit"></i> Yangilash
                                                        </a>
                                                        <a href="{{ route('passive-students.activation', $passiveStudent->id) }}"
                                                            class="btn btn-sm btn-success rounded px-3 mx-2 text-white">
                                                            <i class="feather-edit"></i> Aktivlash
                                                        </a>
                                                        <form action="{{ route('passive-students.destroy', $passiveStudent->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                onclick="return confirm('Haqiqatan ham o\'chirib tashlamoqchimisiz ?')"
                                                                class="btn btn-danger btn btn-sm rounded px-3 text-white">
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
