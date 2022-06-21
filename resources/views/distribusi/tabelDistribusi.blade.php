<div class="card-body">
    <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
        <div class="row">
            <div class="col-sm-12">
                <table class="table dataTable no-footer" id="table" role="grid" aria-describedby="table_info">
                    <thead>
                        <tr role="row">
                            <th>No
                            </th>
                            <th>Nama Distribusi</th>
                            <th>
                                Service</th>
                            <th>
                                Ongkir</th>
                            <th>Tax
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($distribusi as $d)

                            <tr>
                                <td class="sorting_1">{{ $no++ }}</td>
                                <td>{{ $d->nm_distribusi }}</td>
                                <td>
                                    @if ($d->service == 'Y')
                                        <a href="#" value="T" status="service" id_distribusi="{{ $d->id_distribusi }}"
                                            class="btnDelete btn btn-primary">
                                            ON
                                        </a>
                                    @else
                                        <a href="#" value="Y" status="service" id_distribusi="{{ $d->id_distribusi }}"
                                            class="btnInput btn btn-dark">
                                            OFF
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($d->ongkir == 'Y')
                                        <a href="#" value="T" status="ongkir" id_distribusi="{{ $d->id_distribusi }}"
                                            class="btnDelete btn btn-primary">
                                            ON
                                        </a>
                                    @else
                                        <a href="#" value="Y" status="ongkir" id_distribusi="{{ $d->id_distribusi }}"
                                            class="btnInput btn btn-dark">
                                            OFF
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($d->tax == 'Y')
                                        <a href="#" value="T" status="tax" id_distribusi="{{ $d->id_distribusi }}"
                                            class="btnDelete btn btn-primary">
                                            ON
                                        </a>
                                    @else
                                        <a href="#" value="Y" status="tax" id_distribusi="{{ $d->id_distribusi }}"
                                            class="btnInput btn btn-dark">
                                            OFF
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>
