@extends('layouts.app')

@section('title')
    To'lov qilmaganlar
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">To'lov qilmaganlar</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">To'lovlar</a></li>
                            <li class="breadcrumb-item active">To'lov qilmaganlar</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Payment Search Form -->
            <div class="payment-search-form">
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="form-group">
                            <form action="{{ route('payments.unpaid') }}" method="GET" class="d-flex">
                                <select class="form-control mx-2" name="group_id">
                                    <option value="">Barcha guruhlar</option>
                                    @foreach ($groups as $group)
                                        <option {{ Request::get('group_id') == $group->id ? 'selected' : '' }}
                                            value="{{ $group->id }}">
                                            {{ $group->name }} ({{ $group->user->name ?? 'no teacher' }})
                                        </option>
                                    @endforeach
                                </select>

                                <input type="month" id="payment_month" name="payment_month" class="form-control mx-2"
                                    value="{{ Request::get('payment_month', date('Y-m')) }}">

                                <button type="submit" class="btn btn-primary">Qidirish</button>
                                <a href="{{ route('payments.unpaid') }}" class="btn btn-success pt-2 mx-2">Qaytarish</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table displaying unpaid students -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
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
                                <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>№</th>
                                            <th>Talaba</th>
                                            <th>Guruh</th>
                                            <th>To'lov holati</th>
                                            <th>To'lov oy</th>
                                            <th>Amallar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = 1; @endphp <!-- Initialize a counter -->
                                        @forelse($students as $student)
                                            @php
                                                // Calculate total paid for this student and the group's price
                                                $totalPaid = $student->payments->sum('paid_amount');
                                                $groupPrice = $student->groups->first()->price ?? 0; // Assuming group has a 'price' field
                                            @endphp

                                            @if ($totalPaid < $groupPrice)
                                                <!-- Check if the student is unpaid -->
                                                <tr>
                                                    <td>{{ $counter++ }}</td> <!-- Increment the counter only for unpaid students -->
                                                    <td>{{ $student->name ?? 'Talaba mavjud emas' }}</td>
                                                    <td>{{ $student->groups->pluck('name')->implode(', ') ?? 'Guruh mavjud emas' }}</td>
                                                    <td>
                                                        <span class="badge badge-danger">To'lanmagan (To'langan: {{ $totalPaid }} / {{ $groupPrice }})</span>
                                                    </td>
                                                    <td>{{ $paymentMonth }}</td>
                                                    <td>
                                                        <a href="{{ route('payments.show', $student->id) }}"
                                                            class="btn btn-sm btn-success rounded px-3 text-white">
                                                            <i class="feather-dollar"></i> To'lov qilish
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">To'lov qilmagan talabalar topilmadi</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="row mt-3">
                                <div class="col-sm-12 col-md-5">
                                  
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <ul class="pagination justify-content-end">
                                        @if ($students->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $students->previousPageUrl() }}"
                                                    tabindex="-1">Previous</a>
                                            </li>
                                        @endif

                                        @foreach ($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                                            @if ($page == $students->currentPage())
                                                <li class="page-item active"><span
                                                        class="page-link">{{ $page }}</span></li>
                                            @else
                                                <li class="page-item"><a class="page-link"
                                                        href="{{ $url }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach

                                        @if ($students->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $students->nextPageUrl() }}">Next</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Next</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
