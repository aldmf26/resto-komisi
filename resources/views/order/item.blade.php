<div class="modal-content">
    <?php if (file_exists("./assets/tb_menu/$menu->image")) : ?>
    <img width="100%" height="100%" src="{{ asset('assets') }}/tb_menu/{{ $menu->image }}" alt="">
    <?php else : ?>
    <img width=" 100%" height="100%" src="{{ asset('assets') }}/tb_menu/notfound.png" alt="">
    <?php endif ?>
    <div style="background-color: rgba(0, 0, 0, 0.5); padding:5px 0 5px;">
        <h5 style="font-weight: bold; color:#fff;" class="text-center">Rp. <?= number_format($menu->harga) ?></h5>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">

            </div>
            <div class="col-sm-12 col-md-12">
                <h6 style="font-weight: bold; text-align: center;" class="mt-2">{{ $menu->nm_menu }}</h6>
                <input type="hidden" id="id_harga2" value="{{ $menu->id_harga }}">
                <br>
                <input type="hidden" id="id_dis" value="{{ $menu->id_harga }}">
                <input type="hidden" id="id_menu" value="{{ $menu->id_menu }}">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="number" min="1" id="qty" class="form-control" value="1" required="">
                            <br>
                            <textarea id="req" class="form-control" placeholder="Request (Opsional)"></textarea>
                            <input type="hidden" id="dis" class="form-control" value="{{ $id_dis }}"
                                required="">
                            <input type="hidden" id="id_harga" value="{{ $menu->id_harga }}">
                            <input type="hidden" id="price" value="{{ $menu->harga }}">
                            <input type="hidden" id="name" value="{{ $menu->nm_menu }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn float-right btn-block  btn-costume btn_to_cart"> Masukkan Keranjang</button>
    </div>
</div>
