@extends('layouts.app')

@section('title')
    To'lov yig'ish
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">To'lov yig'ish ({{ $student->name }})</h3>
                        <ul class="breadcrumb">
                            <div class="btn-group">
                                <a href="" class="btn btn-sm btn-success rounded px-3 py-2 text-white"
                                    data-toggle="modal" data-target="#exampleModal">
                                    <i class="feather-doller"></i> To'lov qilish
                                </a>
                                <a href="{{ route('payments.index') }}"
                                    class="btn btn-sm btn-dark rounded px-3 py-2 text-white mx-2">
                                    <i class="feather-doller"></i> Orqaga
                                </a>
                            </div>
                        </ul>
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
                                <table class="table border-0 star-student table-hover table-center mb-0 table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>id</th>
                                            <th>Guruh nomi</th>
                                            <th>Tolov oy</th>
                                            <th>To'lov miqdori</th>
                                            <th>To'lov turi</th>
                                            <th>Xodim</th>
                                            <th>To'lov sanasi</th>
                                            <th>Izoh</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($payments->isNotEmpty())
                                            @foreach ($payments as $payment)
                                                <tr>
                                                    <td>{{ $payment->id }}</td>
                                                    <td>{{ $payment->group->name }}</td>
                                                    <td>{{ $payment->payment_month_text }}</td>
                                                    <td>{{ number_format($payment->paid_amount) }} so'm</td>
                                                    <td>{{ $payment->payment_method_id ? $payment->payment_methods->name : 'mavjud emas' }}
                                                    </td>

                                                    <td>{{ $payment->createdBy->name ?? "Admin" }}</td>
                                                    <td>{{ $payment->created_at->format('Y-m-d (H:i)') }}</td>
                                                    <td>
                                                        @if ($payment->remark)
                                                        @php
                                                        $words = explode(' ', $payment->remark);
                                                        $shortNotes = implode(' ', array_slice($words, 0, 3));
                                                        $ellipsis = count($words) > 3 ? '...' : '';
                                                        @endphp
                                                        {{ $shortNotes . $ellipsis }}
                                                        @if (count($words) > 3)
                                                        <a href="#" data-toggle="tooltip" data-placement="left" class="tolliqModel" title="{{ $payment->notes }}">
                                                            <small>To'lliq</small>
                                                        </a>
                                                        @endif
                                                        @else
                                                        Izoh yo'q
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button"
                                                                class="btn btn-sm btn-primary rounded px-3 text-white preview-btn mx-2"
                                                                data-receipt-id="{{ $payment->id }}">
                                                                <i class="feather-eye"></i> Kvitansiya
                                                            </button>
                                                              <form action="{{ route('payments.delete', $payment->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    onclick="return confirm('Haqiqatan ham o\'chirib tashlamoqchimisiz ?')"
                                                                    class="btn btn-danger btn btn-sm rounded px-3 text-white">
                                                                    <i class="feather-trash"></i> O'chirish
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @else
                                            <p>No payments available.</p>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="DataTables_Table_0_info" role="status"
                                        aria-live="polite">
                                        Umumiy <b>{{ $payments->total() }}</b> ta to'lovlardan
                                        <b>{{ $payments->lastItem() ?? 0 }}</b> tasi
                                        <b>{{ $payments->firstItem() ?? 0 }}</b>-sahifada ko'rsatilmoqda
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
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">({{ $student->name }}) uchun to'lov yigish</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('payments.create', ['id' => $student->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Talabaling guruhi <span class="login-danger">*</span></label>
                            <select class="form-control " name="group_id" id="subject" required>
                                @foreach ($student->groups as $group)
                                    <option id="fan" value="{{ $group->id }}">{{ $group->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="month-year">To'lov Oy va Yil:</label>
                            <div class="input-group">
                                <input type="month" id="month-year" name="payment_month" class="form-control" placeholder="MM/YYYY" required
                                       value="<?php echo date('Y-m'); ?>">
                            </div>
                        </div>
                        


                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Tolov summasi (sum):</label>
                            <input type="number" class="form-control" id="paid_amount" name="paid_amount">
                        </div>
                        <div class="form-group">
                            <label>To'lov turi <span class="login-danger">*</span></label>
                            <select class="form-control" name="payment_method_id">

                                @foreach ($paymentMethods as $paymentMethod)
                                    <option id="fan" value="{{ $paymentMethod->id }}">
                                        {{ $paymentMethod->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Izoh:</label>
                            <textarea class="form-control" id="message-text" name="remark"></textarea>
                        </div>
                        <div class="">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tasdiqlash</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="previewCheck" tabindex="-1" role="dialog" aria-labelledby="previewCheckLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $student->name }} - uchun kvitansiya</h5>
                    <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div id="receiptToPrint">
                        <div class="chekModal" id="invoice-POS">

                            <div id="top" style="margin-top: -5px">
                                <div class=""></div>
                                <div class="info text-center">
                                    
                                    <h3 class="camelot_title text-center" style="font-size: 13px"><b>MAGISTR </br> O'QUV MARKAZI</b>
                                    </h3>
                                </div>
                            </div>

                            <div id="bot">

                                <div id="table">
                                    <table>
                                        <tr class="service">
                                            <td class="tableitem">
                                                <p class="itemtext"><b>ID:</b></p>
                                            </td>
                                            <td class="tableitem">
                                                <p class="itemtext id"></p>
                                            </td>
                                        </tr>


                                        <tr class="service">
                                            <td class="tableitem">
                                                <p class="itemtext"><b>To'lov turi</b></p>
                                            </td>
                                            <td class="tableitem">
                                                <p class="itemtext payment_method"></p>
                                            </td>
                                        </tr>

                                        <tr class="service">
                                            <td class="tableitem">
                                                <p class="itemtext"><b>Talaba:</b></p>
                                            </td>
                                            <td class="tableitem">
                                                <p class="itemtext student-name"></p>
                                            </td>
                                        </tr>

                                        <tr class="service">
                                            <td class="tableitem">
                                                <p class="itemtext"><b>Guruh: </b></p>
                                            </td>
                                            <td class="tableitem">
                                                <p class="itemtext group-name"></p>
                                            </td>
                                        </tr>

                                        <tr class="service">
                                            <td class="tableitem">
                                                <p class="itemtext"><b>Kurs narxi: </b></p>
                                            </td>
                                            <td class="tableitem">
                                                <p class="itemtext group-price"></p>
                                            </td>
                                        </tr>

                                        <tr class="service">
                                            <td class="tableitem">
                                                <p class="itemtext"><b>Ustoz:</b> </p>
                                            </td>
                                            <td class="tableitem">
                                                <p class="itemtext group-teacher"></p>
                                            </td>
                                        </tr>

                                        <tr class="service">
                                            <td class="tableitem">
                                                <p class="itemtext"><b>Summa:</b> </p>
                                            </td>
                                            <td class="tableitem">
                                                <p class="itemtext paid-amount"></p>
                                            </td>
                                        </tr>

                                        <tr class="service">
                                            <td class="tableitem">
                                                <p class="itemtext"><b>Sana:</b> </p>
                                            </td>
                                            <td class="tableitem">
                                                <p class="itemtext created-at"></p>
                                            </td>
                                        </tr>
                                        
                                         <tr class="service">
                                            <td class="text-center">
                                               <img src="/assets/img/qr.png" alt="Logo" width="150px">
                                            </td>
                                           
                                        </tr>
                                        
                                        


                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary close text-white" aria-label="Close"><small
                            style="font-weight: 100; font-size: 18px;">Yopish</small></button>
                    <a href="#" class="btn btn-primary text-white" id="printReceiptBtn">Chop etish</a>

                </div>
            </div>
        </div>
    </div>


@endsection
