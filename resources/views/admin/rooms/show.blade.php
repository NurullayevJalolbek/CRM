@extends('layouts.app')
@section('title')
    Xona malumotlari
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Xona malumotlari</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}">Xonalar</a></li>
                                <li class="breadcrumb-item active">Xona malumotlari</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="about-info">
                                <h4>{{ $room->name }} - ustozlar ro'yxati<span><a href="{{ route('rooms.index') }}">
                                            <i class="fa fa-angle-double-left"></i>
                                        </a></span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($room->users as $user)
                        <div class="col-lg-3">
                            <div class="room-personals-grp">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center mb-4 d-flex justify-content-between">
                                            <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('/assets/img/profiles/avatar-02.png') }}"
                                                class="img-fluid rounded" width="100" alt="Room Image">
                                            <div class="">
                                                <a href="{{ route('teachers.show', $user->id) }}"
                                                    class="btn img-fluid rounded btn-smrounded-pill px-3 mx-2 text-dark">
                                                    <i class="feather-eye"> Batafsil</i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="personal-activity border-bottom pb-2">
                                            <div class="personal-icons">
                                                <i class="feather-user"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Ism familiya</h4>
                                                <h5>{{ $user->name }}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity border-bottom pb-2">
                                            <div class="personal-icons">
                                                <i class="feather-book"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Ustozning fani </h4>
                                                <h5>{{ $user->subject->name }}</h5>
                                            </div>
                                        </div>
                                        
                                        <div class="personal-activity border-bottom pb-2">
                                            <div class="personal-icons">
                                                <i class="feather-phone-call"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Telefon raqam</h4>
                                                <h5>{{ $user->number }}</h5>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        @endforeach
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
