<?php $session_menu = explode(',', Auth::user()->akses_submenu); ?>
<div class="d-flex gap-3">
    @if (in_array('104', $session_menu))
        <?php $id = Crypt::encryptString($model->kode_komparasi); ?>
        <div class="d-flex gap-3">
            <a href="{{ route('komparasi.show', $id) }}" class="text-info"><i class="mdi mdi-eye font-size-18"></i></a>
        </div>
    @endif
</div>
