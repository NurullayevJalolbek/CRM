@extends('layouts.app')
@section('title')
    Talaba malumotlari
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Talaba malumotlari</h3>
                            @if (auth()->user()->hasRole(['Supper admin', 'Admin']))
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Talabalar</a></li>
                                    <li class="breadcrumb-item active">Talaba malumotlari</li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="about-info">
                                <h4>Profile <span>
                                        @if (auth()->user()->hasRole(['Supper admin', 'Admin']))
                                            <a href="{{ route('students.index') }}">
                                                <i class="fa fa-angle-double-left"></i>
                                            </a>
                                        @endif
                                    </span>
                                </h4>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="student-personals-grp">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="heading-detail">
                                            <h4>Shaxsiy malumotlari :</h4>
                                        </div>
                                        <div class="text-center mb-4 d-flex justify-content-between">
                                            <img src="/assets/img/profiles/avatar-02.png" class="img-fluid rounded"
                                                width="100" alt="Profile Image">
                                            <div class="">
                                                <a href="{{ route('students.edit', $student->id) }}"
                                                    class="btn img-fluid rounded btn-smrounded-pill px-3 mx-2 text-dark">
                                                    <i class="feather-edit"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="personal-activity border-bottom pb-2">
                                            <div class="personal-icons">
                                                <i class="feather-user"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Ism familiya</h4>
                                                <h5>{{ $student->name }}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity border-bottom pb-2">
                                            <div class="personal-icons">
                                                <i class="feather-phone-call"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Telefon raqam</h4>
                                                <h5>{{ $student->number }}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity border-bottom pb-2">
                                            <div class="personal-icons">
                                                <i class="feather-users"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Ota-ona ismi</h4>
                                                <h5>{{ $student->parent_name }}</h5>
                                            </div>
                                        </div>

                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-phone-call"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Ota-ona raqami</h4>
                                                <h5>{{ $student->parent_number }}</h5>
                                            </div>
                                        </div>




                                        <div class="personal-activity border-bottom pb-2">
                                            <div class="personal-icons">
                                                <i class="feather-calendar"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Boshlagan vaqti</h4>
                                                <h5>{{ $student->started_date }}</h5>
                                            </div>
                                        </div>

                                        <div class="personal-activity border-bottom pb-2">
                                            <div class="personal-icons">
                                                <i class="feather-gift"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Talaba tug'ulgan kuni</h4>
                                                <h5>{{ $student->started_date }}</h5>
                                            </div>
                                        </div>


                                        @if ($student->archived_at)
                                            <div class="personal-activity">
                                                <div class="personal-icons">
                                                    <i class="feather-calendar"></i>
                                                </div>
                                                <div class="views-personal">
                                                    <h4>Tugatgan vaqti</h4>
                                                    <h5> {{ \Carbon\Carbon::parse($student->archived_at)->format('Y.m.d') }}
                                                    </h5>
                                                </div>
                                            </div>
                                        @endif


                                    </div>
                                </div>
                            </div>
                            <div class="student-personals-grp">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="heading-detail">
                                            <h4>Izohlar</h4>
                                        </div>
                                        <div class="skill-blk">
                                            <p><i>{{ $student->notes }}</i></p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="">
                                <div class="card">
                                    <ul class="nav nav-tabs" id="myTabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="everything-tab" data-toggle="tab"
                                                href="#groups">Guruhlar</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="monthly-tab" data-toggle="tab" href="#history">To'lov
                                                tarixi</a>
                                        </li>


                                    </ul>

                                    <div class="tab-content mt-2">
                                        <div class="tab-pane fade show active" id="groups">
                                            @include('admin.students.partials.groups-table')
                                        </div>
                                        <div class="tab-pane fade " id="today">

                                        </div>
                                        <div class="tab-pane fade" id="weekly">
                                            {{-- @include('admin.teachers.partials.groups-table') --}}
                                        </div>
                                        <div class="tab-pane fade" id="history">
                                            @include('admin.students.partials.history-table')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
