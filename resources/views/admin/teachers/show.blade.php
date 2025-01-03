@extends('layouts.app')
@section('title')
    Ustoz malumotlari
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Ustoz malumotlari</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">Ustozlar</a></li>
                                <li class="breadcrumb-item active">Ustoz malumotlari</li>
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
                                <h4>{{ $teacher->name }} <span><a href="{{ route('teachers.index') }}">
                                            <i class="fa fa-angle-double-left"></i>
                                        </a></span>
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
                                            <h4>Shaxsiy ma'lumotlari:</h4>
                                        </div>
                                        <div class="text-center mb-4 d-flex justify-content-between">
                                            <img src="{{ $teacher->image ? asset('storage/' . $teacher->image) : asset('/assets/img/profiles/avatar-02.png') }}"
                                                class="img-fluid rounded" width="100" alt="Profile Image">
                                            <div class="">
                                                <a href="{{ route('teachers.edit', $teacher->id) }}"
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
                                                <h5>{{ $teacher->name }}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity border-bottom pb-2">
                                            <div class="personal-icons">
                                                <i class="feather-book"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Ustozning fani </h4>
                                                <h5>{{ $teacher->subject->name }}</h5>
                                            </div>
                                        </div>
                                       
                                        <div class="personal-activity border-bottom pb-2">
                                            <div class="personal-icons">
                                                <i class="feather-phone-call"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Telefon raqam</h4>
                                                <h5>{{ $teacher->number }}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity ">
                                            <div class="personal-icons">
                                                <i class="feather-mail"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>CRM Login</h4>
                                                <h5>{{ $teacher->email }}</h5>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="student-personals-grp pb-3">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="heading-detail">
                                            <h4>Raqamlarda:</h4>
                                        </div>
                                        <div class="skill-blk">
                                            <div class="skill-statistics border-bottom">
                                                <div class="skills-head">
                                                    <h5>Faol guruhlar</h5>
                                                    <p class="highlight"><i>{{ $totalGroupsCount }} ta guruh</i></p>
                                                </div>
                                            </div>
                                            <div class="skill-statistics border-bottom">
                                                <div class="skills-head">
                                                    <h5>Tugatilgan guruhlar</h5>
                                                    <p class="highlight"><i>{{ $softDeletedGroupsCount }} ta guruh</i></p>
                                                </div>
                                            </div>
                                            <div class="skill-statistics border-bottom">
                                                <div class="skills-head">
                                                    <h5>Faol talabalar</h5>
                                                    <p class="highlight"><i>{{ $totalActiveStudents }} ta azo</i></p>
                                                </div>
                                            </div>
                                            <div class="skill-statistics mb-0">
                                                <div class="skills-head">
                                                    <h5>Bitirgan talabalar</h5>
                                                    <p class="highlight"><i>{{ $totalArchivedStudents }} ta azo </i></p>
                                                </div>
                                            </div>
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


                                    </ul>

                                    <div class="tab-content mt-2">
                                        <div class="tab-pane fade show active" id="groups">
                                            @include('admin.teachers.partials.groups-table')
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
