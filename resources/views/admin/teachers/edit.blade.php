@extends('layouts.app')

@section('title')
    Ustozni yangilash
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Ustoz yangilash</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">Ustozlar</a></li>
                            <li class="breadcrumb-item active">Ustoz yangilash</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('teachers.update', $teacher->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <h5 class="form-title"><span>Ustoz malumotlari</span></h5>
                                        <a href="{{ route('teachers.index') }}" class="btn btn-primary"
                                            style="height: 40px; !important">
                                            Orqaga</a>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>To'lliq ism familiya <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Name"
                                                name="name" required value="{{ $teacher->name }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Telefon raqam<span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Phone number"
                                                name="number" required value="{{ $teacher->number }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Login <span class="login-danger">*</span></label>
                                            <input class="form-control" type="text" placeholder="Enter email"
                                                name="email" required value="{{ $teacher->email }}">
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Fan <span class="login-danger">*</span></label>
                                            <select class="form-control" name="subject_id" required>
                                                <option value="" style="padding: 10px; font-size: 16px;">Fan tanlang
                                                </option>
                                                @foreach ($subjects as $subject)
                                                    <option style="padding: 10px; font-size: 16px;"
                                                        value="{{ $subject->id }}"
                                                        {{ $teacher->subject_id == $subject->id ? 'selected' : '' }}>
                                                        {{ $subject->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Rasm (majburiy emas) <span class="login-danger">*</span></label>
                                            <div class="d-flex align-items-center">
                                                @if ($teacher->image)
                                                    <img src="{{ asset('storage/' . $teacher->image) }}"
                                                        class="avatar avatar-lg rounded me-3" alt="Old Image">
                                                @else
                                                    <img src="/assets/img/profiles/avatar-02.png"
                                                        class="avatar avatar-lg rounded me-3" alt="Old Image">
                                                @endif
                                                <div>
                                                    <label class="form-label" for="image">Rasm (majburiy emas)</label>
                                                    <input type="file" class="form-control-file" id="image"
                                                        name="image" value="{{ $teacher->image }}">
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
