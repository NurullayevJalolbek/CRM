@extends('layouts.app')
@section('title')
    Davomat
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Davomat</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('attendance.index') }}">Davomat</a></li>
                            <li class="breadcrumb-item active">Davomat qilish</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="student-group-form">
                <div class="row">
                    <div class="col-lg-10 col-md-6">
                        <div class="form-group">
                            <form action="{{ route('attendance.index') }}" method="GET" class="d-flex">
                                @csrf

                                <select class="form-control select mx-2" name="group_id" id="groups" required>
                                    <option value="">Guruh tanlang</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}" {{ $groupId == $group->id ? 'selected' : '' }}>
                                            {{ $group->name }} ({{ $group->user->name }})
                                        </option>
                                    @endforeach
                                </select>

                                <input type="date"
                                    value="{{ Request::get('attendance_date', \Carbon\Carbon::now()->toDateString()) }}"
                                    class="form-control" name="attendance_date" placeholder="Search by date" required>

                                <button type="submit" class="btn btn-primary mx-2" style="width: 500px">Saqlash</button>
                                <a href="{{ route('attendance.index') }}" class="btn btn-success pt-2">Qaytish</a>
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
                                        <h3 class="page-title">Talabalar</h3>
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
                                <form action="{{ route('attendance.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                                    <input type="hidden" name="group_id" value="{{ $groupId }}">
                                    <input type="hidden" name="attendance_date" value="{{ $attendanceDate }}">
                                    <table
                                        class="table border-0 star-student table-hover table-center mb-0 table-striped table table-bordered table-md">
                                        <thead class="student-thread">
                                            <tr>
                                                <th>№</th>
                                                <th>Ism familiya</th>
                                                <th>To'lov holati</th>
                                                <th>Yo'qlama</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($students as $student)
                                                <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a
                                                                href="{{ route('students.show', $student->id) }}"><b>{{ $student->name }}</b></a>
                                                        </h2>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $studentPayments = $student->payments
                                                                ->where('group_id', $groupId)
                                                                ->where('payment_month', $paymentMonth);

                                                            $totalPaidAmount = $studentPayments->sum('paid_amount');

                                                        @endphp

                                                        @if ($totalPaidAmount >= $groupPrice)
                                                            <b class="text-success">
                                                                {{ number_format($totalPaidAmount) }} so'm
                                                            </b>
                                                        @else
                                                            <b class="text-danger">
                                                                {{ number_format($totalPaidAmount) }} so'm</b>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <label class="text-success">
                                                            <input type="radio" value="1"
                                                                id="attendance_{{ $student->id }}_{{ $attendanceDate }}_1"
                                                                name="attendance[{{ $student->id }}][{{ $attendanceDate }}]"
                                                                {{ isset($attendance[$student->id][$attendanceDate]) && $attendance[$student->id][$attendanceDate] == 1 ? 'checked' : '' }}>
                                                            <b>Keldi</b>
                                                        </label>
                                                        <label class="text-danger mx-2">
                                                            <input type="radio" value="0"
                                                                id="attendance_{{ $student->id }}_{{ $attendanceDate }}_0"
                                                                name="attendance[{{ $student->id }}][{{ $attendanceDate }}]"
                                                                {{ isset($attendance[$student->id][$attendanceDate]) && $attendance[$student->id][$attendanceDate] == 0 ? 'checked' : '' }}>
                                                            <b>Kelmadi</b>
                                                        </label>
                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-primary mt-4">Yo'qlamani saqlash</button>
                                </form>
                            </div>
                            <p class="mx-0 mt-4 message-text">
                                <b class="text-danger"> Davomotni saqlash tugmasini bosishni unutmang !
                                   
                                </b>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
