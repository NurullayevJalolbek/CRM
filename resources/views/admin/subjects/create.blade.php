@extends('layouts.app')

@section('title')
    Fan qo'shish
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Yangi fan qo'shish</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Fanlar</a></li>
                            <li class="breadcrumb-item active">Fan qo'shish</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('subjects.store') }}" method="POST">
                                @csrf
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
                                            <input type="text" class="form-control" name="name" required>
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
