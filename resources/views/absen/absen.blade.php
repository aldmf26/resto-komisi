@extends('template.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-center ml-3">
                    <div class="col-sm-12 ml-5">
                        @php
                            $bulan_2 = ['bulan', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            $bulan1 = (int) date('m');
                        @endphp
                        <h1 class="ml-5">Absen : <span id="ketbul">{{ $bulan_2[$bulan1] }}</span> - <span
                                id="ketah">{{ date('Y') }}</span></h1><br>
                        <div class="row ml-5">
                            <div class="col-md-3">
                                <select id="bulan" class="form-control mb-3 " name="bulan">
                                    <option value="">--Pilih Bulan--</option>
                                    <option value="1" {{ (int) date('m') == 1 ? 'selected' : '' }}>Januari</option>
                                    <option value="2" {{ (int) date('m') == 2 ? 'selected' : '' }}>Februari</option>
                                    <option value="3" {{ (int) date('m') == 3 ? 'selected' : '' }}>Maret</option>
                                    <option value="4" {{ (int) date('m') == 4 ? 'selected' : '' }}>April</option>
                                    <option value="5" {{ (int) date('m') == 5 ? 'selected' : '' }}>Mei</option>
                                    <option value="6" {{ (int) date('m') == 6 ? 'selected' : '' }}>Juni</option>
                                    <option value="7" {{ (int) date('m') == 7 ? 'selected' : '' }}>Juli</option>
                                    <option value="8" {{ (int) date('m') == 8 ? 'selected' : '' }}>Agustus</option>
                                    <option value="9" {{ (int) date('m') == 9 ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ (int) date('m') == 10 ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ (int) date('m') == 11 ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ (int) date('m') == 12 ? 'selected' : '' }}>Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="row ml-5">
                            <div class="col-md-3">
                                @php
                                    $years = range(2020, strftime('%Y', time()));
                                @endphp
                                <select id="tahun" class="form-control mb-3 " name="tahun">
                                    <option value="">--Pilih Tahun--</option>
                                    <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
                                    @for ($i = date('Y'); $i <= date('Y') + 8; $i++)
                                        <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 ml-2">

                                <button id="btntes" class="ml-5 btn btn-primary btn-block">SIMPAN</button><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">

                        <div id="badan">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            function getUrl(url) {
                $("#badan").load(url, "data", function(response, status, request) {
                    this;
                });
            }

            page = 1
            load_menu(1);
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                load_menu(page)
                $("#nopage").val(page)
                // alert(page)
            });

            function load_menu(page) {
                var dis = $("#dis").val();
                var dis2 = $("#dis2").val();
                // console.log(dis);
                // alert(page);
                console.log(page);
                var pageA = page
                $.ajax({
                    method: "GET",

                    url: "{{ route('tabel') }}?page=" + page,
                    dataType: "html",
                    success: function(hasil) {
                        $('#badan').html(hasil);
                    }
                });
            }

            var url = "{{ route('tabel') }}?page=" + page + "&bulan=" + {{ date('m') }} + "&tahun=" +
                {{ date('Y') }}

            getUrl(url)

            $("#bulan").change(function(e) {
                var bulan = $("#bulan").val();
                var ketbul = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                    'September', 'Oktober', 'November', 'Desember'
                ]
                $("#ketbul").text(ketbul[bulan]);

            });
            $("#tahun").change(function(e) {
                var tahun = $("#tahun").val();
                var bulan = $("#bulan").val();
                $("#ketah").text(tahun);

            });

            $("#btntes").click(function(e) {
                var bulan = $("#bulan").val();
                var tahun = $("#tahun").val();
                var url = "{{ route('tabel') }}?page=" + page + "&bulan=" + bulan + "&tahun=" +
                    tahun
                getUrl(url)
            });

            $(document).on('click', '.btnInput', function() {
                if(!confirm('Apakah anda yakin ?')) {
                    event.preventDefault();
                } else {
                    var nopage = $("#nopage").val(page)
                    var id_karyawan = $(this).attr('id_karyawan')
                    var bulan = $(this).attr('bulan')
                    var tahun = $(this).attr('tahun')
                    var tanggal = $(this).attr('tanggal')
                    var status = $(this).attr('status')
                    var url = "{{ route('tabel') }}?page=" + page + "&bulan=" + bulan + "&tahun=" +
                        tahun
                    $.ajax({
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        url: "{{ route('addAbsen') }}?page=4&id_departemen=3&id_karyawan=" +
                            id_karyawan +
                            "&status=" + status + "&tanggal=" + tanggal,
                        success: function(response) {
                            getUrl(url)
                        }
                    });
                }
            })


            $(document).on('click', '.m', function() {
                $('.tutup').hide()
                $(this).find('ul').show()


            })

            $(document).on('click', '.btnUpdate', function() {
                var id_absen = $(this).attr('id_absen')
                var bulan = $(this).attr('bulan')
                var tahun = $(this).attr('tahun')
                var status = $(this).attr('status')
                var url = "{{ route('tabel') }}?page=" + page + "&bulan=" + bulan + "&tahun=" +
                    tahun

                $.ajax({
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    url: "{{ route('updateAbsen') }}?id_departemen=3&id_absen=" + id_absen +
                        "&status=" + status,
                    success: function(response) {
                        getUrl(url)
                    }
                });
            })

            $(document).on('click', '.btnDelete', function() {
                var id_absen = $(this).attr('id_absen')
                var bulan = $(this).attr('bulan')
                var tahun = $(this).attr('tahun')
                var status = $(this).attr('status')
                var url = "{{ route('tabel') }}?page=" + page + "&bulan=" + bulan + "&tahun=" +
                    tahun

                $.ajax({
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    url: "{{ route('deleteAbsen') }}?status=OFF&id_absen=" + id_absen,
                    success: function(response) {
                        getUrl(url)
                    }
                });
            })
        })
    </script>
@endsection
