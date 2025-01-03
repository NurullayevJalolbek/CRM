@extends('layouts.app')

@section('title')
    Fan tahrirlash
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Fanni yangilash</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Fanlar</a></li>
                            <li class="breadcrumb-item active">Tahrirlash</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <h5 class="form-title"><span>Fan malumotlari</span></h5>
                                        <a href="{{ route('subjects.index') }}" class="btn btn-primary"
                                            style="height: 40px; !important">
                                            Orqaga</a>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Fan nomi <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" required
                                                value="{{ $subject->name }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary">Submit</button>
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
