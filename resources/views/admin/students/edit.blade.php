@extends('layouts.app')

@section('title')
    Talabani yangilash
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Talabani yangilash</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Talabalar</a></li>
                            <li class="breadcrumb-item active">Talaba yangilash</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('students.update', $student->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <h5 class="form-title"><span>Talaba malumotlari</span></h5>
                                        <a href="{{ route('students.index') }}" class="btn btn-primary"
                                            style="height: 40px; !important">
                                            Orqaga</a>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Ism familiya <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Name"
                                                name="name" required value="{{ $student->name }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Telefon raqam<span class="login-danger">*</span></label>
                                            <input type="tel" class="form-control" placeholder="Enter Phone number"
                                                name="number" required value="{{ $student->number }}">
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Ota-ona ism familiyasi <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Name"
                                                name="parent_name" required value="{{ $student->parent_name }}">
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Ota-ona raqami<span class="login-danger">*</span></label>
                                            <input type="tel" class="form-control" placeholder="Enter Phone number"
                                                name="parent_number" required value="{{ $student->parent_number }}">
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Guruhlar <span class="login-danger">*</span></label>
                                            <select class="form-control js-select2 select" multiple="multiple"
                                                name="group_id[]" id="subject" required>
                                                @php
                                                    // Filter groups with a teacher and sort them by teacher's name
$filteredAndSortedGroups = $groups
    ->filter(function ($group) {
        return $group->user; // Only include groups that have a teacher
    })
    ->sortBy(function ($group) {
        return $group->user->name; // Sort by teacher's name
                                                        });
                                                @endphp

                                                @foreach ($filteredAndSortedGroups as $group)
                                                    <option id="fan" value="{{ $group->id }}"
                                                        {{ in_array($group->id, $student->groups->pluck('id')->toArray()) ? 'selected' : '' }}>
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
                                                name="started_date" required value="{{ $student->started_date }}">
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Izohlar<span class="login-danger">*</span></label>
                                            <textarea class="form-control" id="notes" name="notes" rows="5" placeholder="Enter your notes"
                                                value="">{{ $student->notes }}</textarea>
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
