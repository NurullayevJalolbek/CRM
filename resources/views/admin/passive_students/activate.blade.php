@extends('layouts.app')

@section('title')
    Mijozni aktivlash
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Mijozni aktivlash</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('passive-students.index') }}">Mijozlar</a></li>
                            <li class="breadcrumb-item active">Mijozni aktivlash</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('passive-students.activate', $passiveStudent->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <h5 class="form-title"><span>Mijoz malumotlari</span></h5>
                                        <a href="{{ route('passive-students.index') }}" class="btn btn-primary"
                                            style="height: 40px; !important">
                                            Orqaga</a>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Ism familiya <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Name"
                                                name="name" required value="{{ $passiveStudent->name }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Telefon raqam<span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Phone number"
                                                name="number" required value="{{ $passiveStudent->number }}">
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Ota-ona ism familiyasi <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" name="parent_name" required
                                                value="{{ $passiveStudent->parent_name }}">
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Ota-ona raqami<span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" name="parent_number" required
                                                value="{{ $passiveStudent->parent_number }}">
                                        </div>
                                    </div>


                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Guruhlar <span class="login-danger">*</span></label>
                                            <select class="form-control js-select2 select" multiple="multiple"
                                                name="group_id[]" id="subject" required>
                                                @php
                                                    // Filter groups that have a teacher and sort them by teacher's name
                                                    $filteredAndSortedGroups = $groups
                                                        ->filter(function ($group) {
                                                            return $group->user; // Only include groups with a teacher
                                                        })
                                                        ->sortBy(function ($group) {
                                                            return $group->user->name; // Sort by teacher's name
                                                                                                            });
                                                @endphp

                                                @foreach ($filteredAndSortedGroups as $group)
                                                    <option {{ Request::get('group_id') == $group->id ? 'selected' : '' }}
                                                        value="{{ $group->id }}">
                                                        {{ $group->name }} ({{ $group->user->name }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Talaba boshlagan vaqti <span class="login-danger">*</span></label>
                                            <input class="form-control datetimepicker" type="date" id="started_date"
                                                name="started_date" required value="{{ $passiveStudent->started_date }}">
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Izoh<span class="login-danger">*</span></label>
                                            <textarea class="form-control" id="notes" name="notes" rows="5" placeholder="Enter your notes"
                                                value="">{{ $passiveStudent->notes }}</textarea>
                                        </div>
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
