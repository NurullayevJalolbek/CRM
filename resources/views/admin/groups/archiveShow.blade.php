@extends('layouts.app')
@section('title')
    Guruh malumotlari
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Arxiv Guruh malumotlari</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('groups.index') }}">Guruhlar</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('groups.archive') }}">Arxiv guruhlar</a></li>
                                <li class="breadcrumb-item active">Arxiv guruh malumotlari</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="about-info d-flex justify-content-between">
                                <h4>Barcha malumotlar</h4>
                                <div class="icons text-end">
                                    <a href="{{ route('groups.edit', $group->id) }}"
                                        class="btn img-fluid rounded btn-smrounded-pill  text-success">
                                        <i class="feather-edit"></i>
                                    </a>
                                    <a href="{{ route('groups.index') }}"
                                        class="btn img-fluid rounded btn-smrounded-pill text-dark">
                                        <i class="fa fa-angle-double-left"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="student-personals-grp">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="heading-detail text-center mb-2">
                                            <i class="feather-users fa-2x"></i>
                                            <h4>{{ ucfirst($group->name) }}</h4>
                                        </div>

                                        <div class="personal-activity border-bottom pb-2">
                                            <div class="personal-icons">
                                                {{-- <i class="feather-book"></i> --}}
                                            </div>
                                            <div class="views-personal">
                                                <h4>Guruhning fani</h4>
                                                <h5>{{ $group->subject->name }}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity border-bottom pb-2">
                                            <div class="personal-icons">
                                                {{-- <i class="feather-phone-call"></i> --}}
                                            </div>
                                            <div class="views-personal">
                                                <h4>Guruh narxi</h4>
                                                <h5>{{ number_format($group->price, 0, ',', ' ') }} so'm</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity border-bottom pb-2">
                                            <div class="personal-icons">
                                                {{-- <i class="feather-mail"></i> --}}
                                            </div>
                                            <div class="views-personal">
                                                <h4>Guruh ustozi</h4>
                                                <h5>{{ $group->user->name ?? 'N/A' }}</h5>
                                            </div>
                                        </div>

                                        <div class="personal-activity border-bottom pb-2">
                                            <div class="personal-icons">
                                                {{-- <i class="feather-mail"></i> --}}
                                            </div>
                                            <div class="views-personal">
                                                <h4>Talabalar soni</h4>
                                                <h5>{{ $group->students->count() ?? 'N/A' }} member</h5>
                                            </div>
                                        </div>

                                        <div class="personal-activity border-bottom pb-2">
                                            <div class="personal-icons">
                                                {{-- <i class="feather-mail"></i> --}}
                                            </div>
                                            <div class="views-personal">
                                                <h4>Yaratgan admin</h4>
                                                <h5>{{ $group->creator->name ?? 'Unknown' }}</h5>
                                            </div>
                                        </div>

                                        <div class="personal-activity ">
                                            <div class="personal-icons">
                                                {{-- <i class="feather-mail"></i> --}}
                                            </div>
                                            <div class="views-personal">
                                                <h4>Boshlangan vaqt</h4>
                                                <h5>{{ $group->started_date }}</h5>
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
                                                href="#students">Eski guruh talabalari </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="weekly-tab" data-toggle="tab" href="#report">Davomat
                                                tarixi</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="monthly-tab" data-toggle="tab" href="#history">Tolov
                                                tarixi</a>
                                        </li>

                                    </ul>

                                    <div class="tab-content mt-2">
                                        <div class="tab-pane fade show active" id="students">
                                            @include('admin.groups.partials.students-table')
                                        </div>
                                        <div class="tab-pane fade" id="report">
                                            @include('admin.groups.partials.reports-table')
                                        </div>
                                        <div class="tab-pane fade" id="history">
                                            @include('admin.groups.partials.history-table')
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
