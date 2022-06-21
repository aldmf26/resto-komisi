<div class="card-body">
    <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">

        <div class="row">
            <div class="col-sm-12">
                <table class="table dataTable no-footer" id="table" role="grid"
                    aria-describedby="table_info">
                    <thead>
                        <tr role="row">
                            <th>No</th>
                            <th>Nama Koki</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($koki as $ko)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $ko->nama }}</td>
                                <td>
                                    <a href="javascript:void(0)" id_koki="{{ $ko->id_koki }}"
                                        class="hapusKoki btn btn-sm btn-primary">non-aktifkan
                                        koki</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>