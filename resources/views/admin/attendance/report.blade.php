@extends('layouts.app')
@section('title')
    Davomat hisoboti
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Davomat hisoboti</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('attendance.index') }}">Davomat</a></li>
                            <li class="breadcrumb-item active">Davomat hisoboti</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="student-group-form">
                <div class="row">
                    <div class="col-lg-10 col-md-6">
                        <div class="form-group">
                            <form action="{{ route('attendance.report') }}" method="GET" class="d-flex">
                                @csrf

                               <select class="form-control select mx-2" name="group_id" id="groups" required
                                    style="margin-right: 8px">
                                    <option id="gruh" value="">Guruh tanlang</option>
                                    @foreach ($groups as $group)
                                        @if ($group->user)
                                            <!-- Check if the user (teacher) exists -->
                                            <option {{ Request::get('group_id') == $group->id ? 'selected' : '' }}
                                                value="{{ $group->id }}">
                                                {{ $group->name }} ({{ $group->user->name }})
                                            </option>
                                        @else
                                            <option value="{{ $group->id }}">
                                                {{ $group->name }} (no teacher)
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <select class="form-control select" name="year" id="year" required>
                                    <option value="">Yilni tanlang</option>
                                    @for ($i = now()->year; $i >= 2022; $i--)
                                        <option value="{{ $i }}"
                                            {{ (Request::get('year') ?? now()->year) == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>

                                <select class="form-control select mx-2" name="month" id="month" required>
                                    <option value="">Oyni tanlang</option>
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}"
                                            {{ (Request::get('month') ?? now()->month) == $m ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                        </option>
                                    @endfor
                                </select>




                                <button type="submit" class="btn btn-primary mx-2">Qidirish</button>
                                <a href="{{ route('attendance.report') }}" class="btn btn-success pt-2">Qaytish</a>
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
                                        <h6 class="page-title" style="color: rgb(68, 67, 67)"
                                            style="font-size: 5px !important">
                                            @if ($selectedGroup)
                                                <small>Guruh: <b>{{ $selectedGroup->name }}</b></small> <br>
                                                <small>
                                                    {{ $selectedMonth['year'] }}-yil <b>{{ $selectedMonthName }} </b> oy
                                                    uchun
                                                    davomat
                                                </small>
                                            @endif

                                        </h6>
                                        
                                          <a href="{{ route('attendance.downloadPdf', ['group_id' => $selectedGroupId, 'year' => $selectedMonth['year'], 'month' => $selectedMonth['month']]) }}" class="btn btn-primary mx-5">
                                             PDF yuklash
                                        </a>
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
                                    class="table border-0 star-student table-hover table-center mb-0 table-striped table table-bordered table-md">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>№</th>
                                            <th>Talaba Ism familiyasi</th>
                                            <th>To'lov holati</th>
                                            @foreach ($distinctDates as $date)
                                                <th>{{ date('d', strtotime($date)) }}</th>
                                            @endforeach
                                            <th>Foiz</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        @if (auth()->user()->hasRole('Supper admin'))
                                                            <a href="{{ route('payments.show', $student->id) }}">
                                                                <b>{{ $student->name }}</b>
                                                            </a>
                                                        @else
                                                            <b>{{ $student->name }}</b>
                                                        @endif
                                                    </h2>
                                                    <div>
                                                        @if ($student->number)
                                                            <span>Talaba raqami: {{ $student->number }}</span><br>
                                                        @else
                                                            <span>Talaba raqami: No phone number available</span><br>
                                                        @endif
                                    
                                                        @if ($student->parent_number)
                                                            <span>Ota-ona raqami: {{ $student->parent_number }}</span>
                                                        @else
                                                            <span>Ota-ona raqami: No parent number available</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    @php
                                                        $formattedMonth = sprintf('%02d', $selectedMonth['month']); // Format month with leading zero if needed
                                                        $paymentMonth = "{$selectedMonth['year']}-{$formattedMonth}"; // Construct formatted year-month (e.g., '2024-02')
                                                        $studentPayments = $student->payments
                                                            ->where('group_id', $selectedGroupId)
                                                            ->where('payment_month', $paymentMonth);

                                                        $totalPaidAmount = $studentPayments->sum('paid_amount');

                                                        $groupPrice = $selectedGroup->price;
                                                    @endphp

                                                    @if ($totalPaidAmount >= $groupPrice)
                                                        <b class="text-success">
                                                            {{ number_format($totalPaidAmount) }} so'm</b>
                                                    @else
                                                        <b class="text-danger">
                                                            {{ number_format($totalPaidAmount) }} so'm</b>
                                                    @endif
                                                </td>




                                                @foreach ($distinctDates as $date)
                                                    <td>
                                                        @php
                                                            // Retrieve the attendance record for the student on the current date
                                                            $attendance = $student
                                                                ->attendances()
                                                                ->where('group_id', $selectedGroupId)
                                                                ->whereDate('attendance_date', $date)
                                                                ->first();
                                                            // Determine the attendance status
                                                            $attendanceStatus = $attendance
                                                                ? ($attendance->status
                                                                    ? 'Present'
                                                                    : 'Absent')
                                                                : 'Not signed';
                                                        @endphp

                                                        @if ($attendanceStatus === 'Present')
                                                            <b class="text-success">Kelgan</b>
                                                        @elseif ($attendanceStatus === 'Absent')
                                                            <b class="text-danger">Kelmagan</b>
                                                        @else
                                                            <b style="color: rgb(255, 166, 0)">Belgilanmagan</b>
                                                        @endif
                                                    </td>
                                                @endforeach

                                                <td>{{ $student->attendancePercentage($selectedGroup, $selectedMonth) }}%
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
