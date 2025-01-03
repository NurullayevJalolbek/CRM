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
                    <th>ID</th>
                    <th>Rasm</th>
                    <th>Ism familiya</th>
                    <th>Telefon raqam</th>
                    <th>Email</th>
                    <th>Guruhlar soni</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subject->users as $teacher)
                    <tr>
                        <td>
                            <div class="form-check check-tables">
                                <input class="form-check-input" type="checkbox" value="{{ $teacher->id }}">
                            </div>
                        </td>
                        <td>{{ $teacher->id }}</td>


                        <td>
                            <h2 class="table-avatar">
                                <a href="{{ route('teachers.show', $teacher->id) }}" class="avatar avatar-sm me-2">
                                    <img class="avatar-img rounded"
                                        src="{{ $teacher->image ? asset('storage/' . $teacher->image) : asset('/assets/img/profiles/avatar-02.png') }}"
                                        alt="User Image">
                                </a>
                            </h2>
                        </td>





                        <td>
                            <h2 class="table-avatar">
                                <a href="{{ route('teachers.show', $teacher->id) }}"><b>{{ $teacher->name }}</b></a>
                            </h2>
                        </td>
                        <td>{{ $teacher->number }}</td>
                        <td>{{ $teacher->email }}</td>
                        <td>
                            {{ $teacher->groups->count() }}
                        </td>

                        <td>
                            <div class="btn-group">
                                <a href="{{ route('teachers.show', $teacher->id) }}"
                                    class="btn btn-sm btn-success rounded-pill px-3 text-white">
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
