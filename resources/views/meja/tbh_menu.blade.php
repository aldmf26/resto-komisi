<input type="hidden" id="kd_order" name="kd_order" value="{{ $order->no_order }}">
<input type="hidden" id="id_dis" name="id_dis" value="{{ $order->id_distribusi }}">
<input type="hidden" id="orang" name="orang" value="{{ $order->orang }}  ">
<input type="hidden" id="meja" name="meja" value="{{ $order->id_meja }}  ">
<div class="row">
    <div class="col-lg-4">
        <label for="">Admin</label>
        <select class="form-control select2bs4" name="admin" id="">
            @php
                $user = DB::table('users')->get();
            @endphp
            @foreach ($user as $u)              
            <option value="{{ $u->nama }}">{{ $u->nama }}</option>
            @endforeach
        </select>
        
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <label for="">Menu</label>
        <select name="id_harga[]" class="form-control id_harga id_harga1 select2bs4" detail="1" required>
            <option value="">-Pilih Menu-</option>
            <?php foreach ($menu as $m) : ?>
            <option value="{{ $m->id_harga }}">
                {{ $m->nm_menu }}
            </option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="col-lg-2">
        <label for="">Qty</label>
        <input type="number" name="qty[]" value="1" min="1" class="form-control">
    </div>
    <div class="col-lg-2">
        <label for="">Harga</label>
        <input type="text" name="harga[]" class="form-control harga harga1" detail="1" readonly>
    </div>
    <div class="col-lg-3">
        <label for="">Request</label>
        <input type="text" name="req[]" class="form-control">
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on("change", ".id_harga", function() {

            var id_harga = $(this).val();
            var detail = $(this).attr('detail')
            $.ajax({
                url: "{{ route('get_harga') }}?id_harga=" + id_harga,
                method: "GET",
                dataType: "json",
                success: function(data) {
                    $(".harga" + detail).val(data);

                }
            });

        });


        // disini 


    });
</script>
