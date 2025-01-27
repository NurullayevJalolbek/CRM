@extends('layouts.app')

@section('title')
    Add group
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Guruh yaratish</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('groups.index') }}">Guruhlar</a></li>
                            <li class="breadcrumb-item active">guruh yaratish</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('groups.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <h5 class="form-title"><span>Guruh malumotlari</span></h5>
                                        <a href="{{ route('groups.index') }}" class="btn btn-primary"
                                            style="height: 40px; !important">
                                            Orqaga</a>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Guruh nomi <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Guruh narxi <span class="login-danger">*</span></label>
                                            <input type="number" class="form-control" name="price" id="priceInput"
                                                required value="" data-type="currency">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Fan <span class="login-danger">*</span></label>
                                            <select class="form-control" name="subject_id" required>
                                                <option value="" style="padding: 10px; font-size: 16px;">Fan tanlash
                                                </option>
                                                @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->id }}"
                                                        style="padding: 10px; font-size: 16px;">{{ $subject->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Ustoz <span class="login-danger">*</span></label>
                                            <select class="form-control" name="user_id" required>
                                                <option value="" style="padding: 10px; font-size: 16px;">
                                                    Ustoz tanlash
                                                </option>
                                            @foreach ($teachers as $teacher)
                                                    <option value="{{ $teacher->id }}"
                                                        style="padding: 10px; font-size: 16px;">{{ $teacher->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Guruh boshlanish vaqti <span class="login-danger">*</span></label>
                                            <input class="form-control datetimepicker" type="date" id="started_date"
                                                name="started_date" required>
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
