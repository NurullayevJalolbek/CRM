@extends('layouts.app')

@section('title')
    Mijoz qo'shish
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Mijoz Qo'shish</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('passive-students.index') }}">Mijozlar</a></li>
                            <li class="breadcrumb-item active">Mijoz qo'shish</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('passive-students.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <h5 class="form-title"><span>Mijoz malumotlari</span></h5>
                                        <a href="{{ route('passive-students.index') }}" class="btn btn-primary"
                                            style="height: 40px;">Orqaga</a>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label>Mijoz ism familiyasi <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Name"
                                                name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label>Mijoz telefon raqami <span class="login-danger">*</span></label>
                                            <input type="tel" class="form-control" value="+998 "
                                                placeholder="Enter Phone number" name="number" required>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label>Mijoz oqimi <span class="login-danger">*</span></label>
                                            <select class="form-control" name="social_id">
                                                <option value="">Mijoz oqimini tanlang</option>

                                                @foreach ($socialLinks as $socialLink)
                                                    <option id="fan" value="{{ $socialLink->id }}">
                                                        {{ $socialLink->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label>Fan <span class="login-danger">*</span></label>
                                            <select class="form-control" name="subject_id">
                                                <option value="">Fan tanlang</option>

                                                @foreach ($subjects as $subject)
                                                    <option id="fan" value="{{ $subject->id }}">
                                                        {{ $subject->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label>Izoh <span class="login-danger">*</span></label>
                                            <textarea class="form-control" id="notes" name="notes" rows="5" placeholder="Enter your notes"></textarea>
                                        </div>
                                    </div>

                                </div>

                       
                                <div class="col-12">
                                    <div class="student-submit">
                                        <button type="submit" class="btn btn-primary">Saqlash</button>
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
