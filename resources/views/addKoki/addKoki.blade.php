@extends('template.master')
@section('content')

    <div class="content-wrapper" style="min-height: 511px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2 justify-content-center">
                    <div class="col-sm-12">

                        <h4 style="color: rgb(120, 120, 120); font-weight: bold; --darkreader-inline-color:#837e75;"
                            data-darkreader-inline-color="">Add Koki</h4>


                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-6">
                        <div class="card">
                            <form action="{{ route('absenKoki') }}" method="post">
                                @csrf
                                <div class="card-header">
                                    <label for="">Add Koki</label>
                                    <div class="form-group" data-select2-id="93">
                                        <select name="id_karyawan[]" class="select2 select2-hidden-accessible" multiple=""
                                            data-placeholder="Add Koki" style="width: 100%;" data-select2-id="7"
                                            tabindex="-1" aria-hidden="true">
                                            @foreach ($karyawan as $d)
                                                <option value="{{ $d->id_karyawan }}">{{ $d->nama }}</option>
                                            @endforeach
                                        </select>

                                    </div><br>
                                    <button type="submit"
                                        class="btn btn-sm btn-block btn-primary float-right mt-2">Simpan</button>
                                </div>
                            </form>
                            <div id="tabelKoki">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $('.select2').select2()
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            var count_addKoki = 1;

        })
    </script>
    <script>
        $(document).ready(function(){
            // load halaman view
            var url = "{{ route('tabelKoki') }}"
            getUrl(url)
            function getUrl(url) {
                $("#tabelKoki").load(url, "data", function(response, status, request) {
                    this;
                });
            }
            // -------------------------
            $(document).on('click', '.hapusKoki', function(){
                var id_koki = $(this).attr('id_koki')
                var url = "{{ route('tabelKoki') }}"
                $.ajax({
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    url: "{{ route('delAbsKoki') }}?id_koki=" + id_koki,
                    success: function(response) {
                        getUrl(url)
                    }
                });
            })
        })
    </script>
@endsection
