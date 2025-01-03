@extends('layouts.app')

@section('title')
    Guruhni yangilash
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Guruhni yangilash</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('groups.index') }}">Guruhlar</a></li>
                            <li class="breadcrumb-item active">Yangilash</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('groups.update', $group->id) }}" method="POST">
                                @csrf
                                @method('PUT')
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
                                            <input type="text" class="form-control" name="name" required
                                                value="{{ $group->name }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Guruh narxi <span class="login-danger">*</span></label>
                                            <input type="number" class="form-control" name="price" id="priceInput"
                                                required data-type="currency" value="{{ $group->price }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Fan <span class="login-danger">*</span></label>
                                            <select class="form-control" name="subject_id" required>
                                                <option value="" style="padding: 10px; font-size: 16px;">
                                                    Fan tanlash</option>
                                                @foreach ($subjects as $subject)
                                                    <option style="padding: 10px; font-size: 16px;"
                                                        value="{{ $subject->id }}"
                                                        {{ $group->subject_id == $subject->id ? 'selected' : '' }}>
                                                        {{ $subject->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Ustoz <span class="login-danger">*</span></label>
                                            <select class="form-control" name="user_id" required>
                                                <option value="" style="padding: 10px; font-size: 16px;">Ustoz tanlash</option>
                                                @foreach ($teachers as $teacher)
                                                    <option style="padding: 10px; font-size: 16px;"
                                                        value="{{ $teacher->id }}"
                                                        {{ $group->user_id == $teacher->id ? 'selected' : '' }}>
                                                        {{ $teacher->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Guruh boshlanish vaqti <span class="login-danger">*</span></label>
                                            <input class="form-control datetimepicker" type="date" id="started_date"
                                                name="started_date" required value="{{ $group->started_date }}">
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
