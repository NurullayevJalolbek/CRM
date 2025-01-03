@extends('layouts.app')
@section('title')
    Talabalar
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Talabalar</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Talabalar</a></li>
                            <li class="breadcrumb-item active">Barcha talabalar</li>
                        </ul>
                    </div>
                </div>
            </div>

           <div class="student-group-form">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="form-group">
                <form action="{{ route('students.search') }}" method="GET">
                    <div class="row gx-3 gy-2">
                        <!-- Name Input -->
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

                        <!-- Created Date Input -->
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <input type="month" class="form-control" name="createdDate" placeholder="Created Date"
                                   value="{{ Request::get('createdDate', now()->format('Y-m')) }}">
                        </div>

                        <!-- Buttons -->
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 d-flex">
                            <button type="submit" class="btn btn-primary w-100">Qidirish</button>
                            <a href="{{ route('students.index') }}" class="btn btn-success w-100 ms-2">Qaytarish</a>
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
                                        <h3 class="page-title">Talabalar</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        
                                        <a href="{{ route('studentExport.export') }}"
                                            class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Excel</a>
                                        <a href="{{ route('students.create') }}" class="btn btn-primary"><i
                                                class="fas fa-plus"></i></a>
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
                                            <th>Guruh</th>
                                            <th>Boshlagan vaqti</th>
                                            <th>Izoh</th>
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
                                                        @php
                                                            $activeGroups = $student->groups->where('status', 1); // Filter active groups
                                                        @endphp

                                                        @if ($activeGroups->isNotEmpty())
                                                            @foreach ($activeGroups as $group)
                                                                <li class="list-group-item">{{ $group->name }}</li>
                                                            @endforeach
                                                        @else
                                                            <li class="list-group-item">Not Available</li>
                                                        @endif
                                                    </ul>

                                                </td>

                                                <td>{{ $student->started_date ?? 'Not Available' }}</td>

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
                                                                class="tolliqModel" title="{{ $student->notes }}">
                                                                <small>To'lliq</small>
                                                            </a>
                                                        @endif
                                                    @else
                                                        Mavjud emas
                                                    @endif
                                                </td>


                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('students.show', $student->id) }}"
                                                            class="btn btn-sm btn-success rounded px-3 text-white">
                                                            <i class="feather-eye"></i> Batafsil
                                                        </a>
                                                        <a href="{{ route('students.edit', $student->id) }}"
                                                            class="btn btn-sm btn-warning rounded px-3 mx-2 text-white">
                                                            <i class="feather-edit"></i> Yangilash
                                                        </a>
                                                        <a href="{{ route('payments.show', $student->id) }}"
                                                            class="btn btn-sm btn-primary rounded px-3 mx-2 text-white">
                                                            <i class="feather-dollar-sign"></i> To'lov qilish
                                                        </a>
                                                                            @if (auth()->user()->hasRole('Supper admin'))

                                                        <form action="{{ route('students.delete', $student->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                onclick="return confirm('Haqiqatan ham o\'chirib tashlamoqchimisiz ?')"
                                                                class="btn btn-danger btn btn-sm rounded px-3 text-white">
                                                                <i class="feather-trash"></i> O'chirish
                                                            </button>
                                                        </form>
                                                         @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="DataTables_Table_0_info" role="status"
                                        aria-live="polite">
                                        Umumiy <b>{{ $students->total() }}</b> ta talaba
                                    </div>
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
