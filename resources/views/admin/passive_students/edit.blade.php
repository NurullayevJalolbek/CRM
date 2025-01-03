@extends('layouts.app')

@section('title')
    Mijozni yangilash
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Mijozni yangilash</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="teachers.html">Mijozlar</a></li>
                            <li class="breadcrumb-item active">Mijozni yangilash</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('passive-students.update', $passiveStudent->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <h5 class="form-title"><span>Mijoz malumotlari</span></h5>
                                        <a href="{{ route('passive-students.index') }}" class="btn btn-primary"
                                            style="height: 40px; !important">
                                            Orqaga</a>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Ism familiya <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Name"
                                                name="name" required value="{{ $passiveStudent->name }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Telefon raqam<span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Phone number"
                                                name="number" required value="{{ $passiveStudent->number }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Mijoz oqimi<span class="login-danger">*</span></label>
                                            <select class="form-control" name="social_id">
                                                <option value="">Mijoz oqimini tanlang</option>
                                                @foreach ($socialLinks as $socialLink)
                                                    <option value="{{ $socialLink->id }}"
                                                        {{ $passiveStudent->social_id == $socialLink->id ? 'selected' : '' }}>
                                                        {{ $socialLink->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group  local-forms">
                                            <label>Fan<span class="login-danger">*</span></label>
                                            <select class="form-control" name="subject_id">
                                                <option value="">Fan tanlang</option>

                                                @foreach ($subjects as $subject)
                                                    <option id="fan" value="{{ $subject->id }}" {{ $passiveStudent->subject_id == $subject->id ? 'selected' : '' }}>
                                                        {{ $subject->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                    </div>

                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Izoh<span class="login-danger">*</span></label>
                                                <textarea class="form-control" id="notes" name="notes" rows="5" placeholder="Enter your notes">{{ $passiveStudent->notes }}</textarea>
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
    </div>
@endsection
