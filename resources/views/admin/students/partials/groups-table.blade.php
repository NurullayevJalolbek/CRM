<div class="card-body">
    <div class="row">
        @foreach ($student->groups as $group)
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="card border-0 shadow-sm group-card">
                    <div class="card-header d-flex justify-content-between ">
                        <div class="mt-2" style="margin-left: 9px">
                            <h6>{{ ucfirst($group->name) }}</h6>
                            <strong>Fan:</strong> {{ $group->subject->name ?? 'N/A' }}
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('groups.show', $group->id) }}"
                                class="btn btn-outline-success btn-sm">Batafsil</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled group-details">
                            <li><strong>id:</strong> {{ $group->id }}</li>
                            <li><strong>Narx:</strong> {{ number_format($group->price, 0, ',', ' ') }} so'm</li>
                            <li><strong>Talabalar soni:</strong>
                                {{ $group->students->where('status', 'active')->count() ?? 'N/A' }}ta azo</li>
                            <li><strong>Boshlangan vaqt:</strong> {{ $group->started_date }}</li>
                        </ul>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="card-footer text-right">
    {{-- Pagination links or other footer content --}}
</div>
