@extends('layouts.app')
@section('title')
    Birtirganlar
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Birtirgan Talabalar</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Talabalar</a></li>
                            <li class="breadcrumb-item active">Birtirgan talabalar</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="student-group-form">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="form-group">
                <form action="{{ route('archive-students.search') }}" method="GET">
                    <div class="row gx-3 gy-2">
                        <!-- Name Query Input -->
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <input type="text" class="form-control" name="name_query"
                                   placeholder="Ism orqali qidirish"
                                   value="{{ old('name_query', request('name_query')) }}">
                        </div>

                        <!-- Subject Dropdown -->
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <select class="form-control" name="subject_id">
                                <option value="">Fan orqali qidirish</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}"
                                        {{ old('subject_id', request('subject_id')) == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Archived Date Input -->
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <input type="month" class="form-control" name="archived_date" placeholder="Archived Date"
                                   value="{{ Request::get('archived_date', now()->format('Y-m')) }}">
                        </div>

                        <!-- Buttons -->
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 d-flex">
                            <button type="submit" class="btn btn-primary w-100">Qidirish</button>
                            <a href="{{ route('archive-students.index') }}" class="btn btn-success w-100 ms-2">Qaytarish</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

            
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">

                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Birtirgan talabalar</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="{{ route('archiveStudentExport.export') }}"
                                            class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Excel</a>
                                    </div>
                                </div>
                            </div>

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>×</span>
                                        </button>
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible show fade">
                                    <div class="alert-body text-white" style="color: red; font-weight: bold;">
                                        <button class="close" data-dismiss="alert">
                                            <span>×</span>
                                        </button>
                                        {{ session('error') }}
                                    </div>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </th>
                                            <th>ID</th>
                                            <th>Ism familiya</th>
                                            <th>Telefon raqam</th>
                                            <th>Guruhlar</th>
                                            <th>Ustoz</th>
                                            <th>Boshlagan vaqti</th>
                                            <th>Bitirgan vaqti</th>
                                            <th>Izohlar</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            <tr>
                                                <td>
                                                    <div class="form-check check-tables">
                                                        <input class="form-check-input" type="checkbox" value="">
                                                    </div>
                                                </td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a
                                                            href="{{ route('students.show', $student->id) }}"><b>{{ $student->name }}</b></a>
                                                    </h2>
                                                </td>
                                                <td>{{ $student->number }}</td>
                                              <td>
    <ul class="list-group">
        @if ($student->groups->isNotEmpty())
            @foreach ($student->groups as $group)
                <li class="list-group-item">{{ $group->name }}</li>
            @endforeach
        @else
            <li class="list-group-item">Not Available</li>
        @endif
    </ul>
</td>

<td>
    <ul class="list-group">
        @foreach ($student->groups as $group)
            <li class="list-group-item">
                {{ $group->user ? $group->user->name : 'N/A' }}
            </li>
        @endforeach
        @if ($student->groups->isEmpty())
            <li class="list-group-item">N/A</li>
        @endif
    </ul>
</td>


                                                <td>{{ $student->started_date ?? 'Not Available' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($student->archived_at)->format('Y-m-d') }}
                                                </td>
                                                <td>
                                                    @if ($student->notes)
                                                        @php
                                                            $words = explode(' ', $student->notes);
                                                            $shortNotes = implode(' ', array_slice($words, 0, 3));
                                                            $ellipsis = count($words) > 3 ? '...' : '';
                                                        @endphp
                                                        {{ $shortNotes . $ellipsis }}
                                                        @if (count($words) > 3)
                                                            <a href="{{ route('students.show', $student->id) }}"
                                                                data-toggle="tooltip" data-placement="left"
                                                                title="{{ $student->notes }}"> <small>To'lliq</small>
                                                            </a>
                                                        @endif
                                                    @else
                                                        Mavjud emas
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('students.show', $student->id) }}"
                                                            class="btn btn-sm btn-success rounded-pill px-3 text-white">
                                                            <i class="feather-eye"></i> Batafsil
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
