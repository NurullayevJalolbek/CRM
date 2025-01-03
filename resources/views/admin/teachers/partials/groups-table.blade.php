<div class="card-body">
    <div class="row">
        @foreach ($teacher->groups->where('status', 1) as $group)
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="card border-0 shadow-sm group-card">
                    <div class="card-header d-flex justify-content-between ">
                        <div class="mt-2" style="margin-left: 9px">
                            <h6><a href="{{ route('groups.show', $group->id) }}"
                                    class="text-dark">{{ ucfirst($group->name) }}</a></h6>
                            <strong>Fan:</strong> {{ $group->subject->name ?? 'N/A' }}
                        </div>


                    </div>
                    <div class="card-body d-flex justify-content-between ">
                        <ul class="list-styled group-details">
                            <li><strong>id:</strong> {{ $group->id }}</li>
                            <li><strong>Narxi:</strong> {{ number_format($group->price, 0, ',', ' ') }} so'm</li>
                            <li><strong>Talabalar soni:</strong> {{ $group->students->count() ?? 'N/A' }} ta azo</li>
                            <li><strong>Boshlangan vaqti: </strong> {{ $group->started_date }}</li>
                        </ul>
                        <div class="text-center pt-2 mt-5">
                            <a href="{{ route('groups.show', $group->id) }}"
                                class="btn btn-outline-success btn-sm">View</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="card-footer text-right">
    {{-- Pagination links or other footer content --}}
</div>
