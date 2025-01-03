@extends('layouts.app')

@section('title', 'Xodim yaratish')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Xodim qo'shish</h3>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <h5 class="form-title"><span>Xodim malumotlari</span></h5>
                                        <a href="{{ route('user.index') }}" class="btn btn-primary"
                                            style="height: 40px; !important">
                                            Orqaga</a>
                                    </div>
                                    <div class="form-group col-12 col-sm-4">
                                        <label for="name">Ism familiya</label>
                                        <input id="name" type="text" class="form-control" name="name" autofocus
                                            required {{ old('name') }}>
                                    </div>
                                    <div class="form-group col-12 col-sm-4">
                                        <label for="number">Telefon raqam</label>
                                        <input id="number" type="tel" value="+998 " class="form-control"
                                            name="number" required {{ old('number') }}>
                                    </div>
                                    <div class="form-group col-12 col-sm-4">
                                        <label for="email">Login</label>
                                        <input id="email" type="text" class="form-control" name="email" required
                                            {{ old('email') }}>
                                    </div>
                                    <div class="form-group col-12 col-sm-4">
                                        <label for="roles">Rol</label>
                                        <select class="form-control" id="roles" name="roles">
                                            <option value="" selected disabled>Rol tanlang</option>
                                            <option value="Supper admin">Super Admin</option>
                                            <option value="admin">Admin</option>
                                            <option value="teacher">Teacher</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group ">
                                            <label>Fan (majburiy emas) </label>
                                            <select class="form-control select" name="subject_id">
                                                <option value="">Select Subject</option>
                                                @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-sm-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="form-group col-12 col-sm-4">
                                        <label for="password_confirmation" class="form-label">Confirm
                                            Password</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" required>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group ">
                                            <label>Rasm</label>
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
