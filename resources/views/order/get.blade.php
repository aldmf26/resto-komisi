<div class="row">
    @foreach ($menu2 as $t)
        <div class="col-md-3">
            <a href="" class="input_cart2" data-toggle="modal" data-target="#myModal" id_harga="{{ $t->id_harga }}"
                id_dis="{{ $id_dis }}">
                <div class="card">
                    <div style="background-color: rgba(0, 0, 0, 0.5); padding:5px 0 5px;">
                        <h6 style="font-weight: bold; color:#fff;" class="text-center">
                            {{ ucwords(Str::lower($t->nm_menu)) }}

                        </h6>
                    </div>
                    <div class="card-body" style="padding:0.2rem;">
                        <p class="mt-2 text-center demoname" style="font-size:15px; color: #787878;"><strong>Rp.
                                {{ number_format($t->harga) }}</strong></p>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
<div class="col-lg-12">
    <center>

        {{ $menu2->links() }}
    </center>
</div>
