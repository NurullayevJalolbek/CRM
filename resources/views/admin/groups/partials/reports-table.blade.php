<div class="card-body">
    <div class="row">

        <div class="content container-fluid">


            <div class="student-group-form">
                <div class="row">
                    <div class="col-lg-10 col-md-6">
                        <div class="form-group">
                            <form action="{{ route('groups.show', $group->id) }}" method="GET" class="d-flex">
                                @csrf
                                <select class="form-control select mx-2" name="year" id="year" required>
                                    <option value="">Yilni tanlang</option>
                                    @for ($i = now()->year; $i >= 2020; $i--)
                                        <option {{ Request::get('year') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                <select class="form-control select mx-2" name="month" id="month" required>
                                    <option value="">Oyni tanlang </option>
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}"
                                            {{ Request::get('month') == $m ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                        </option>
                                    @endfor
                                </select>

                                <button type="submit" class="btn btn-primary mx-2">Search</button>
                                <a href="{{ route('groups.show', $group->id) }}" class="btn btn-success pt-2">Reset</a>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">

                            @if ($selectedMonth['month'])
                                <div class="page-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 style="color: rgb(68, 67, 67)">
                                                <small>
                                                    {{ $selectedMonth['year'] }}-yil <b>{{ $monthName }}</b> oy uchun
                                                    davomat
                                                </small>
                                            </h5>

                                        </div>
                                        <div class="col-auto text-end float-end ms-auto download-grp">

                                            <a href="" class="btn btn-outline-primary me-2">
                                                <i class="fas fa-download"></i> Excel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif


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
                                    class="table border-0 star-student table-hover table-center mb-0 table-striped table-bordered table-md">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>ID</th>
                                            <th>Talaba ismi</th>
                                            @foreach ($distinctDates as $date)
                                                <th>{{ date('d', strtotime($date)) }}</th>
                                            @endforeach
                                            <th>Foiz</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            <tr>
                                                <td>{{ $student->id }}</td>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a
                                                            href="{{ route('students.show', $student->id) }}"><b>{{ $student->name }}</b></a>
                                                    </h2>
                                                </td>
                                                @foreach ($distinctDates as $date)
                                                    <td>
                                                        @php
                                                            // Retrieve the attendance record for the student on the current date
                                                            $attendance = $student
                                                                ->attendances()
                                                                ->whereDate('attendance_date', $date)
                                                                ->first();
                                                            // Determine the attendance status
                                                            $attendanceStatus = $attendance
                                                                ? ($attendance->status
                                                                    ? 'Kelgan'
                                                                    : 'Kelmagan')
                                                                : 'Belgilanmagan';
                                                        @endphp

                                                        @if ($attendanceStatus === 'Kelgan')
                                                            <b class="text-success">Kelgan</b>
                                                        @elseif ($attendanceStatus === 'Kelmagan')
                                                            <b class="text-danger">Kelmagan</b>
                                                        @else
                                                            <b style="color: rgb(255, 166, 0)">Belgilanmagan</b>
                                                        @endif
                                                    </td>
                                                @endforeach
                                                <td>
                                                    {{ $student->attendancePercentage($group, $selectedMonth) }}%
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
</div>
