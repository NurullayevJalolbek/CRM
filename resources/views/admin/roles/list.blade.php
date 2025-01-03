@extends('layouts.app')

@section('title')
    Xodimlar ro'yxati
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Xodimlar</h3>

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
                                        <h3 class="page-title">Xodimlar profili</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="{{ route('user.create') }}" class="btn btn-primary"><i
                                                class="fas fa-plus"></i>
                                            Yaratish</a>
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
                                    class="table border-0 star-student table-hover table-center mb-0 datatable table-striped table table-bordered table-md">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </th>
                                            <th>ID</th>
                                            <th>Rasm</th>
                                            <th>Ism familiya</th>
                                            <th>Telefon Raqam</th>
                                            <th>Login</th>
                                            <th>Fan</th>
                                            <th>Rol</th>
                                            <th>Qo'shilgan vaqt</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>
                                                    <div class="form-check check-tables">
                                                        <input class="form-check-input" type="checkbox" value="something">
                                                    </div>
                                                </td>
                                                <td>{{ $user->id }}</td>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="" class="avatar avatar-sm me-2">
                                                            <img class="avatar-img rounded"
                                                                src="{{ $user->image ? asset('storage/' . $user->image) : asset('/assets/img/profiles/avatar-02.png') }}">
                                                        </a>
                                                    </h2>
                                                </td>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="#!">{{ $user->name }}</a>
                                                    </h2>
                                                </td>
                                                <td>{{ $user->number ?? 'Mavjud emas' }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->subject ? $user->subject->name : 'Mavjud emas' }}</td>
                                                @if ($user->roles->isNotEmpty())
                                                    @foreach ($user->roles as $role)
                                                        <td><b>{{ $role->name }}</b></td>
                                                    @endforeach
                                                @else
                                                    <td>Mavjud emas</td>
                                                @endif
                                                <td>{{ $user->created_at->format('Y.m.d') }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('roles.edit', $user->id) }}"
                                                            class="btn btn-sm btn-warning rounded-pill px-3 mx-2 text-white">
                                                            <i class="feather-edit"></i> Yangilash
                                                        </a>
                                                        <form action="{{ route('roles.delete', $user->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button
                                                                onclick="return confirm('Are you sure you want to delete this?')"
                                                                class="btn btn-danger btn btn-sm rounded-pill px-3 text-white"><i
                                                                    class="feather-trash"></i> O'chirish</button>
                                                        </form>
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
