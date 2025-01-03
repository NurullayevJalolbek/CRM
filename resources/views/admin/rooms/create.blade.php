@extends('layouts.app')

@section('title')
    Xona qo'shish
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Xona Qo'shish</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}">Xonalar</a></li>
                            <li class="breadcrumb-item active">Xona qo'shish</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <h5 class="form-title"><span>Xona malumotlari</span></h5>
                                        <a href="{{ route('rooms.index') }}" class="btn btn-primary" style="height: 40px; !important">
                                            Orqaga</a>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Xona nomi<span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Xona nomini kiriting"
                                                name="name" required>
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
