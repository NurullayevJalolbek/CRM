@extends('layouts.app')

@section('title')
    To'lov qilish
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">To'lovlarni yig'ish</h3>
                    </div>
                </div>
            </div>

            <div class="student-group-form">
                <div class="row">
                    <div class="col-lg-10 col-md-6">
                        <div class="form-group">
                            <form action="{{ route('payments.history') }}" method="GET" class="d-flex">
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
                                            {{ Request::get('year') == $i || (Request::get('year') == null && $i == now()->year) ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>

                                <select class="form-control select mx-2" name="month" id="month" required>
                                    <option value="">Oyni tanlang</option>
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}"
                                            {{ Request::get('month') == $m || (Request::get('month') == null && $m == now()->month) ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                        </option>
                                    @endfor
                                </select>




                                <button type="submit" class="btn btn-primary mx-2">Qidirish</button>
                                <a href="{{ route('payments.history') }}" class="btn btn-success pt-2">Qaytish</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border-0 star-student table-hover table-center mb-0 table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>№</th>
                                            <th>Talaba ismi</th>
                                            <th>To'langan summa</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!$year || !$month)
                                            <tr>
                                                <td colspan="4">No required query parameters. Please select a group,
                                                    year, and month to view payment history.</td>
                                            </tr>
                                        @else
                                            @php
                                                $totalPayments = 0; // Initialize total payments variable
                                            @endphp
                                            @foreach ($students as $student)
                                                @php
                                                    $totalPaidAmount = 0; // Initialize total paid amount for this student
                                                    $groupPrice = 0; // Initialize group price for this student
                                                @endphp
                                                @foreach ($student->groups as $group)
                                                    @if ($group->id == $groupId)
                                                        @php
                                                            $totalPaidAmount += $student->payments
                                                                ->where('group_id', $groupId)
                                                                ->sum('paid_amount');
                                                            $groupPrice = $group->price; // Assuming the group's price is stored in the 'price' column
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @php
                                                    $totalPayments += $totalPaidAmount; // Increment total payments
                                                @endphp
                                                <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                    <td><a
                                                            href="{{ route('payments.show', $student->id) }}"><b>{{ $student->name }}</b></a>
                                                    </td>
                                                    <td>{{ number_format($totalPaidAmount) }} so'm</td>
                                                   
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('payments.show', $student->id) }}"
                                                                class="btn btn-sm btn-success rounded px-3 text-white ">
                                                                <i class="feather-doller"></i> To'lov qilish
                                                            </a>
                                                           
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <p><b>Umumiy tushum: {{ number_format($totalPayments) }} so'm</b></p>
                                        @endif
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
