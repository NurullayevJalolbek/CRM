@extends('layouts.app')
@section('title')
    Arxiv guruhlar
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Arxiv guruhlar</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('groups.archive') }}">Guruhlar</a></li>
                            <li class="breadcrumb-item active">Arxiv guruhlar</li>
                        </ul>
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
                                        <h3 class="page-title">Arxiv guruhlar</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="{{ route('archiveGroups.export') }}"
                                            class="btn btn-outline-primary me-2"><i class="fas fa-download"></i>
                                            Excel</a>
                                    </div>
                                </div>
                            </div>
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
                                            <th>Nomi</th>
                                            <th>Narxi</th>
                                            <th>Ustozi</th>
                                            <th>Fani</th>
                                            <th>Boshlangan vaqt</th>
                                            <th>Tugatilgan vaqt</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($groups as $group)
                                            <tr>
                                                <td>
                                                    <div class="form-check check-tables">
                                                        <input class="form-check-input" type="checkbox" value="something">
                                                    </div>
                                                </td>
                                                <td>{{ $group->id }}</td>
                                                <td>
                                                    <h2>
                                                        <a
                                                            href="{{ route('groups.archiveShow', $group->id) }}"><b>{{ ucfirst($group->name) }}</b></a>
                                                    </h2>
                                                </td>
                                                <td>{{ number_format($group->price, 0, ',', ' ') }} so'm</td>
                                                <td>{{ $group->user->name ?? 'N/A' }}</td>
                                                <td>{{ $group->subject->name ?? 'N/A' }}</td>
                                                <td>{{ $group->started_date }}</td>
                                                <td>
                                                    @if ($group->archived_at)
                                                        {{ \Carbon\Carbon::parse($group->archived_at)->format('Y-m-d') }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('groups.archiveShow', $group->id) }}"
                                                            class="btn btn-sm btn-success rounded-pill px-3  text-white">
                                                            <i class="feather-eye"></i> Batafsil
                                                        </a>

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
