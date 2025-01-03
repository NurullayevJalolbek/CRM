@extends('layouts.app')
@section('title')
    Xonalar
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Xonalar</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}">Xonalar</a></li>
                            <li class="breadcrumb-item active">Barcha xonalar</li>
                        </ul>
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
                                        <h3 class="page-title">Xonalar</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        
                                        <a href="{{ route('rooms.create') }}" class="btn btn-primary"><i
                                                class="fas fa-plus"> Yaratish</i></a>
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
                                <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                           
                                            <th>ID</th>
                                            <th>Ism</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rooms as $room)
                                            <tr>
                                               
                                                <td>{{ $room->id }}</td>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="{{ route('rooms.show', $room->id) }}"><b>{{ $room->name }}</b></a>
                                                    </h2>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('rooms.show', $room->id) }}"
                                                            class="btn btn-sm btn-success rounded-pill px-3 text-white">
                                                            <i class="feather-eye"></i> Batafsil
                                                        </a>
                                                        <a href="{{ route('rooms.edit', $room->id) }}"
                                                            class="btn btn-sm btn-warning rounded-pill px-3 mx-2 text-white">
                                                            <i class="feather-edit"></i> Yangilash
                                                        </a>
                                                        <form action="{{ route('rooms.delete', $room->id) }}"
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
