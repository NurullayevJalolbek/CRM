@extends('layouts.app')

@section('title')
    Ustoz qo'shish
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Ustoz Qo'shish</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">Ustozlar</a></li>
                            <li class="breadcrumb-item active">Ustoz qo'shish</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <h5 class="form-title"><span>Ustoz malumotlari</span></h5>
                                        <a href="{{ route('teachers.index') }}" class="btn btn-primary"
                                            style="height: 40px; !important">
                                            Orqaga</a>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>To'lliq ism familiya<span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Ism va familia kiriting"
                                                name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Telefon raqam<span class="login-danger">*</span></label>
                                            <input type="tel" value="+998 " class="form-control"
                                                placeholder="Telefon raqam kiriting" name="number" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Login <span class="login-danger">*</span></label>
                                            <input class="form-control" type="text" placeholder="Login kiriting"
                                                name="email" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Fan <span class="login-danger">*</span></label>
                                            <select class="form-control select" name="subject_id" required>
                                                <option value="">Fan tanlang</option>
                                                @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-sm-4  local-forms">
                                        <label for="password" class="form-label">Parol <span
                                                class="login-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="form-group col-12 col-sm-4  local-forms">
                                        <label for="password_confirmation" class="form-label">Parolni qayta tasdiqlash <span
                                                class="login-danger">*</span></label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" required>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Rasm (majburiy emas) <span class="login-danger">*</span></label>
                                            <input class="form-control" type="file" name="image">
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
