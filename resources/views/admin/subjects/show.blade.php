@extends('layouts.app')
@section('title')
    Fan malumotlari
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Fan malumotlari</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Fanlar</a></li>
                                <li class="breadcrumb-item active">Fan malumotlari</li>
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
                                <h4>{{ $subject->name }} <span><a href="{{ route('subjects.index') }}">
                                            <i class="fa fa-angle-double-left"></i>
                                        </a></span>
                                </h4>
                            </div>

                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="">
                                <div class="card">
                                    <ul class="nav nav-tabs" id="myTabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="everything-tab" data-toggle="tab"
                                                href="#groups">Guruhlar</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="weekly-tab" data-toggle="tab" href="#history">
                                                Ustozlar</a>
                                        </li>

                                    </ul>

                                    <div class="tab-content mt-2">
                                        <div class="tab-pane fade show active" id="groups">
                                            @include('admin.subjects.partials.groups-table')
                                        </div>

                                        <div class="tab-pane fade" id="history">
                                            @include('admin.subjects.partials.history-table')
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
