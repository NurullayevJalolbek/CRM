@extends('layouts.app')

@section('title')
To'lov tarixi
@endsection

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">To'lov tarixi</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">To'lovlar</a></li>
                        <li class="breadcrumb-item active">To'lov tarixi</li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="payment-search-form">
            <div class="row">
                <div class="col-lg-8 col-md-6">
                    <div class="form-group">
                        <form action="{{ route('payments.search') }}" method="GET" class="d-flex">

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
                            <input type="month" id="payment_month" name="payment_month" class="form-control mx-2"
                                value="{{ Request::get('payment_month', now()->format('Y-m')) }}">


                            <button type="submit" class="btn btn-primary">Qidirish</button>
                            <a href="{{ route('payments.index') }}" class="btn btn-success pt-2 mx-2">Qaytarish</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
                            <table
                                class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                <thead class="student-thread">
                                    <tr>
                                        <th>№</th>
                                        <th>To'lov summa</th>
                                        <th>Talaba</th>
                                        <th>Guruh</th>
                                        <th>To'lov oy</th>
                                        <th>To'lov turi</th>
                                        <th>Admin</th>
                                        <th>To'lov qilingan vaqt</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @php
                                $previousDate = null; // To track the previous payment date
                                @endphp

                                <tbody>
                                    @foreach ($payments as $payment)
                                    @php
                                    // Format the current payment's date
                                    $currentDate = $payment->created_at->format('Y-m-d');
                                    @endphp

                                    @if ($previousDate !== $currentDate)
                                    @if ($previousDate !== null)
                                    <tr>
                                        <td colspan="11">
                                            <hr>
                                        </td> <!-- Divider line -->
                                    </tr>
                                    @endif
                                    <tr>
                                        <td colspan="11"><strong>{{ $currentDate }}</strong></td> <!-- Display the date -->
                                    </tr>
                                    @php
                                    $previousDate = $currentDate;
                                    $counter = 1; // Reset the counter for the new date
                                    @endphp
                                    @endif

                                    <tr>
                                        <td>{{ $counter++ }}</td> <!-- Increment counter for each payment -->
                                        <td>{{ number_format($payment->paid_amount) }} so'm</td>
                                        <td><a href="{{ route('payments.show', $payment->student->id) }}"><b>{{ $payment->student->name }}</b></a></td>
                                        <td>{{ $payment->group->name }}</td>
                                        <td>{{ $payment->payment_month }}</td>
                                        <td>{{ $payment->payment_methods ? $payment->payment_methods->name : 'N/A' }}</td>
                                        <td>{{ $payment->createdBy->name ?? 'Admin' }}</td>
                                        <td>{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                                       
                                        <td>
                                            @if ($payment->payment_status == 1)
                                            <b class="text-success">Berilgan</b>
                                            @else
                                            <b class="text-danger">Kutilmoqda</b>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-warning rounded px-3 mx-2 text-white" data-bs-toggle="modal" data-bs-target="#ustozModal" data-payment-id="{{ $payment->id }}">
                                                    <i class="feather-dollar"></i> Ustozga berish
                                                </button>
                                                <form action="{{ route('payments.delete', $payment->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Haqiqatan ham o\'chirib tashlamoqchimisiz ?')" class="btn btn-danger btn btn-sm rounded px-3 text-white">
                                                        <i class="feather-trash"></i> O'chirish
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>


                            </table>
                        </div>

                        <!-- Pagination Info and Links -->
                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="DataTables_Table_0_info" role="status"
                                    aria-live="polite">
                                    Umumiy <b>{{ $payments->total() }}</b> ta to'lovlar
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <ul class="pagination justify-content-end">
                                    @if ($payments->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                    @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $payments->previousPageUrl() }}"
                                            tabindex="-1">Previous</a>
                                    </li>
                                    @endif

                                    @foreach ($payments->getUrlRange(1, $payments->lastPage()) as $page => $url)
                                    @if ($page == $payments->currentPage())
                                    <li class="page-item active"><span
                                            class="page-link">{{ $page }}</span></li>
                                    @else
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                    @endforeach

                                    @if ($payments->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $payments->nextPageUrl() }}">Next</a>
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

                <!-- Modal -->
                <div class="modal fade" id="ustozModal" tabindex="-1" aria-labelledby="ustozModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ustozModalLabel">Ustozga Berish</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="ustozForm" action="{{ route('update.payment.status') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="payment_id" id="paymentIdInput">

                                    <!-- Replace the checkbox with the select dropdown -->
                                    <div class="mb-3 form-check">
                                        <label for="payment_status">Payment Status</label>
                                        <select class="form-control" id="payment_status" name="payment_status">
                                            <option value="">Status tanlang</option>
                                            <option value="0">Kutilmoqda</option>
                                            <option value="1">Berilgan</option>
                                        </select>
                                    </div>

                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">Saqlash</button>
                                </form>


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