<ul class="nav nav-pills mb-3 custom-scrollbar-css" id="pills-tab" role="tablist">
    <?php 
    $total = 0;
    foreach ($distribusi as $d) : 
    $total += $d->jumlah;
    ?>
    <li class="nav-item">
        <?php if ($id == $d->id_distribusi) : ?>
        <?php if (empty($d->jumlah)) : ?>
        <a href="<?= route('head', ['id' => $d->id_distribusi]) ?>" class="nav-link active badge-notif"><strong>
                <?= $d->nm_distribusi ?>
            </strong></a>
        <?php else : ?>
        <a href="<?= route('head', ['id' => $d->id_distribusi]) ?>" data-badge="<?= $d->jumlah ?>"
            class="nav-link active badge-notif"><strong>
                <?= $d->nm_distribusi ?>
            </strong></a>
        <?php endif ?>
        <?php else : ?>
        <?php if (empty($d->jumlah)) : ?>
        <a href="<?= route('head', ['id' => $d->id_distribusi]) ?>" class="nav-link badge-notif"><strong>
                <?= $d->nm_distribusi ?>
            </strong></a>
        <?php else : ?>
        <a href="<?= route('head', ['id' => $d->id_distribusi]) ?>" data-badge="<?= $d->jumlah ?>"
            class="nav-link badge-notif"><strong>
                <?= $d->nm_distribusi ?>
            </strong></a>
        <?php endif ?>
        <?php endif ?>
    </li>
    <?php endforeach ?>


    <?php if ($id == '4') : ?>
    <?php if(empty($distribusi_food->qty)): ?>
    <li class="nav-item">
        <a href="<?= route('head', ['id' => '4']) ?>" class="nav-link badge-notif active"><strong>Food
            </strong></a>
    </li>
    <?php else: ?>
    <li class="nav-item">
        <a href="<?= route('head', ['id' => '4']) ?>" data-badge="{{$distribusi_food->qty}}"
            class="nav-link badge-notif active"><strong>Food
            </strong></a>
    </li>
    <?php endif ?>

    <?php else : ?>
    <?php if(empty($distribusi_food->qty)): ?>
    {{-- <li class="nav-item">
        <a href="<?= route('head', ['id' => '4']) ?>" class="nav-link badge-notif"><strong>Food
            </strong></a>
    </li>
    <?php else: ?>
    <li class="nav-item">
        <a href="<?= route('head', ['id' => '4']) ?>" class="nav-link badge-notif "
            data-badge="{{$distribusi_food->qty}}"><strong>Food
            </strong></a>
    </li> --}}
    <?php endif ?>


    <?php endif ?>

    <?php if ($id == '5') : ?>
    <?php if(empty($distribusi_drink->qty)): ?>
    {{-- <li class="nav-item">
        <a href="<?= route('head', ['id' => '5']) ?>" class="nav-link badge-notif active"><strong>Drink
            </strong></a>
    </li>
    <?php else: ?>
    <li class="nav-item">
        <a href="<?= route('head', ['id' => '5']) ?>" class="nav-link badge-notif active"
            data-badge="{{$distribusi_drink->qty}}"><strong>Drink
            </strong></a>
    </li> --}}
    <?php endif ?>

    <?php else : ?>
    <?php if(empty($distribusi_drink->qty)): ?>
    {{-- <li class="nav-item">
        <a href="<?= route('head', ['id' => '5']) ?>" class="nav-link badge-notif "><strong>Drink
            </strong></a>
    </li> --}}
    <?php else: ?>
    {{-- <li class="nav-item">
        <a href="<?= route('head', ['id' => '5']) ?>" class="nav-link badge-notif "
            data-badge="{{$distribusi_drink->qty}}"><strong>Drink
            </strong></a>
    </li> --}}
    <?php endif ?>
    <?php endif ?>

    <input type="hidden" id="jumlah1" value="<?= $orderan[0]->jml_order ?>">
</ul>