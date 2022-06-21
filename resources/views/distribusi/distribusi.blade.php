@extends('template.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2 justify-content-center">
                    <div class="col-sm-12">




                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card" style="margin-left: 100px">
                            <div class="card-header">
                                <h5 class="float-left">Data Distribusi</h5>
                                <a href="" data-toggle="modal" data-target="#tambah"
                                    class="btn btn-info btn-sm float-right"><i class="fas fa-plus"></i> Tambah
                                    distribusi</a>
                            </div>
                            <div id="tabelDistribusi">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tambah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content ">
                <div class="modal-header btn-costume">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Tambah distribusi</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Nama Distribusi</label>
                            <input class="form-control" type="text" name="nm_distribusi">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-costume" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var url = "{{ route('tabelDistribusi') }}"
            getUrl(url)

            function getUrl(url) {
                $("#tabelDistribusi").load(url, "data", function(response, status,
                    request) {
                    this; // dom element

                });
            }

            $(document).on('click', '.btnDelete', function() {
                var id_distribusi = $(this).attr('id_distribusi')
                var status = $(this).attr('status')
                var value = $(this).attr('value')
                var url = "{{ route('tabelDistribusi') }}"
                $.ajax({
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    url: "{{ route('updateDistribusi') }}?id_distribusi=" + id_distribusi +
                        "&status=" + status + "&v=" + value,
                    success: function(response) {
                        getUrl(url)
                    }
                });
            })

            $(document).on('click', '.btnInput', function() {
                var id_distribusi = $(this).attr('id_distribusi')
                var status = $(this).attr('status')
                var value = $(this).attr('value')
                var url = "{{ route('tabelDistribusi') }}"

                $.ajax({
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    url: "{{ route('inputDistribusi') }}?id_distribusi=" + id_distribusi +
                        "&status=" + status + "&v=" + value,
                    success: function(response) {
                        getUrl(url)
                    }
                });
            })
        })
    </script>
@endsection
