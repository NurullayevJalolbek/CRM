@extends('layouts.app')

@section('title')
    sms jo'natish
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Xabar jo'natish</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="teachers.html">SMS Jo'natmalar</a></li>
                            <li class="breadcrumb-item active">Xabar yuborish</li>
                        </ul>
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
                    <div class="alert-body text-white" style="color: rgb(255, 255, 255); font-weight: bold;">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('send.sms.student') }}" method="POST">
                                @csrf
                                <div class="row">



                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label>To'lov uchun eslatma <span class="login-danger">*</span></label>
                                            <select class="form-control js-select2 select" name="group_id" id="subject"
                                                required>
                                                <option value="">Guruh tanlang</option>

                                                @foreach ($groups as $group)
                                                    <option id="fan" value="{{ $group->id }}">{{ $group->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                </div>

                                <div class="row">

                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary">Yuborish</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <p class="mx-4 my-2 message-text">
                            <b>Guruhni tanlang va yuborish tugmasini bosing va SMS xabarnoma guruhdagi to'lov qilmagan
                                talabalar uchun avtomatik tarzda yuboriladi.
                                <br> <br>
                                SMS Namuna
                                <br> <i>Assalomu aleykum $studentName ning ota-onasi, Iltimos $subjectName kursiga joriy oy
                                    uchun 15-sanagacha to\'lov qilishni unutmang. Xurmat bilan MAGISTR o'quv markazi ! </i>
                            </b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
