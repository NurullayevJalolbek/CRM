@extends('layouts.app')

@section('title', 'Xodim o\'zgartirish')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="page-title">{{ $user->name }} - malumotlarini o'zgartirish</h5>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('roles.update', $user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
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
                                            required value="{{ $user->name }}">
                                    </div>
                                    <div class="form-group col-12 col-sm-4">
                                        <label for="number">Telefon raqam</label>
                                        <input id="number" type="tel" class="form-control" name="number" required
                                             value="{{ $user->number }}">
                                    </div>

                                    <div class="form-group col-12 col-sm-4">
                                        <label for="email">Login</label>
                                        <input id="email" type="text" class="form-control" name="email" required
                                            value="{{ $user->email }}">
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group ">
                                            <label>Fan (majburiy emas) </label>
                                            <select class="form-control" name="subject_id">
                                                <option value="" style="padding: 10px; font-size: 16px;">Select
                                                    Subject</option>
                                                @foreach ($subjects as $subject)
                                                    <option style="padding: 10px; font-size: 16px;"
                                                        value="{{ $subject->id }}"
                                                        {{ $user->subject_id == $subject->id ? 'selected' : '' }}>
                                                        {{ $subject->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group col-12 col-sm-4">
                                        <label for="roles">Rol </label>
                                        <select class="form-control" id="roles" name="role">
                                            <option value="" {{ !$user->hasAnyRole() ? 'selected' : '' }} disabled>
                                                Select Role</option>
                                            <option value="Supper admin"
                                                {{ $user->hasRole('Supper admin') ? 'selected' : '' }}>Super Admin</option>
                                            <option value="admin" {{ $user->hasRole('Admin') ? 'selected' : '' }}>Admin
                                            </option>
                                            <option value="teacher" {{ $user->hasRole('Teacher') ? 'selected' : '' }}>
                                                Teacher</option>
                                        </select>
                                    </div>





                                    <div class="col-12 col-sm-4 pt-3">
                                        <div class="form-group ">
                                            <div class="d-flex align-items-center">
                                                @if ($user->image)
                                                    <img src="{{ asset('storage/' . $user->image) }}"
                                                        class="avatar avatar-lg rounded me-3" alt="Old Image">
                                                @else
                                                    <img src="/assets/img/profiles/avatar-02.png"
                                                        class="avatar avatar-lg rounded me-3" alt="Old Image">
                                                @endif
                                                <div>
                                                    <label class="form-label" for="image">Rasm qo'yish (majburiy
                                                        emas)</label>
                                                    <input type="file" class="form-control-file" id="image"
                                                        name="image" value="{{ $user->image }}">
                                                </div>
                                            </div>
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
