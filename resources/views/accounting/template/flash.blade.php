@include('accounting.template.head')
@if ($pesan = Session::get('sukses'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $pesan }}</strong>
    </div>
@endif

@if ($pesan = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $pesan }}</strong>
    </div>
@endif

@if ($pesan = Session::get('warning'))
    <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $pesan }}</strong>
    </div>
@endif
