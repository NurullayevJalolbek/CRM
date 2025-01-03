<!-- transactions-table.blade.php -->
<div class="card-body">

    <div class="table-responsive">
        <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
            <thead class="student-thread">
                <tr>
                    <th>
                        <div class="form-check check-tables">
                            <input class="form-check-input" type="checkbox" value="something">
                        </div>
                    </th>
                    <th>id</th>
                    <th>Ism familiya</th>
                    <th>Telefon raqam</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($group->students->where('status', 'active') as $student)
                    <tr>
                        <td>
                            <div class="form-check check-tables">
                                <input class="form-check-input" type="checkbox" value="">
                            </div>
                        </td>
                        <td>{{ $student->id }}</td>
                        <td>
                            <h2 class="table-avatar">
                                <a href="{{ route('students.show', $student->id) }}"><b>{{ $student->name }}</b></a>
                            </h2>
                        </td>
                        <td>{{ $student->number }}</td>

                        <td>
                            <div class="btn-group">
                                <a href="{{ route('students.show', $student->id) }}"
                                    class="btn btn-sm btn-outline-success rounded px-3 text-success">
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
<div class="card-footer text-right">
    {{-- Pagination links or other footer content --}}
</div>
