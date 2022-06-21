<ul class="nav nav-pills mb-3 custom-scrollbar-css" id="pills-tab" role="tablist">
    <?php foreach ($distribusi as $d) : ?>
    <li class="nav-item">
        <?php if ($id == $d->id_distribusi) : ?>
        <?php if (empty($d->jumlah)) : ?>
        <a href="{{ route('meja', ['id' => $d->id_distribusi]) }}" class="nav-link active badge-notif"><strong>{{
                $d->nm_distribusi }}</strong></a>
        <?php else : ?>
        <a href="{{ route('meja', ['id' => $d->id_distribusi]) }}" data-badge="{{ $d->jumlah }}"
            class="nav-link active badge-notif"><strong>{{ $d->nm_distribusi
                }}</strong></a>
        <?php endif ?>

        <?php else : ?>
        <?php if (empty($d->jumlah)) : ?>
        <a href="{{ route('meja', ['id' => $d->id_distribusi]) }}" class="nav-link badge-notif"><strong>{{
                $d->nm_distribusi }}</strong></a>
        <?php else : ?>
        <a href="{{ route('meja', ['id' => $d->id_distribusi]) }}" data-badge="{{ $d->jumlah }}"
            class="nav-link badge-notif"><strong>{{ $d->nm_distribusi
                }}</strong></a>
        <?php endif ?>

        <?php endif ?>
    </li>
    <?php endforeach ?>
    @foreach ($orderan as $o)
    <input type="hidden" id="jumlah1" value="{{ $o->jml_order }}">
    @endforeach

</ul>