@extends('layouts.app')

@section('title')
    Talaba qo'shish
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Talaba Qo'shish</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Talabalar</a></li>
                            <li class="breadcrumb-item active">Talaba qo'shish</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('students.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <h5 class="form-title"><span>Talaba malumotlari</span></h5>
                                        <a href="{{ route('students.index') }}" class="btn btn-primary"
                                            style="height: 40px;">Orqaga</a>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label>Ism familiya <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Talaba ism familiyasini kiriting" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label>Telefon raqam <span class="login-danger">*</span></label>
                                            <input type="tel" id="number" class="form-control"
                                                placeholder="Talaba raqamini kitiring" name="number" value="+998 "
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label>Ota-ona ism familiyasi <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Ota-ona ism familiyasini kiriting" name="parent_name" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label>Ota-ona raqami <span class="login-danger">*</span></label>
                                            <input type="tel" class="form-control" value="+998 "
                                                placeholder="Ota-ona raqamini kiriting" name="parent_number" required>
                                        </div>
                                    </div>


                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
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
                                        <div class="form-group">
                                            <label>Talaba boshlagan vaqt <span class="login-danger">*</span></label>
                                            <input class="form-control datetimepicker" type="date" id="started_date"
                                                name="started_date" required>
                                        </div>
                                    </div>



                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label>Izoh <span class="login-danger">*</span></label>
                                            <textarea class="form-control" id="notes" name="notes" rows="5" placeholder="Izoh kiriting (majburiy emas)"></textarea>
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
