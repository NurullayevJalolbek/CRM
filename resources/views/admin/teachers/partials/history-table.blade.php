<!-- transactions-table.blade.php -->
<div class="card-body">

    <div class="table-responsive">
        <table class="table table-bordered table-md">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User Ismi</th>
                    <th>Mahsulot Nomi</th>
                    <th>Miqdori</th>
                    <th>Qo'shilgan vaqt</th>
                    <th>Xolat</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($transactions as $index => $transaction) --}}
                <tr>
                    <td>1</td>
                    <td>Murod</td>
                    <td>Uzum</td>
                    <td>111 KG</td>
                    <td>kecha</td>
                    <td class="d-flex">
                        <a href="#" class="btn text-success border mr-2">View</a>
                    </td>
                </tr>
                {{-- @endforeach --}}
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer text-right">
    {{-- Pagination links or other footer content --}}
</div>
