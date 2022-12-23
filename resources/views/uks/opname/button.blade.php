<?php $session_menu = explode(',', Auth::user()->akses_submenu); ?>
<?php $id = Crypt::encryptString($model->kode_transaksi); ?>
<div class="d-flex gap-3">
    @if (in_array('104', $session_menu))
        <a href="{{ route('opname_obat.show', $id) }}" class="text-info"><i class="mdi mdi-eye font-size-18"></i></a>
    @endif
    @if ($model->status == 'C')
        @if (in_array('106', $session_menu))
            <a href="{{ route('opname_obat.edit', $id) }}" class="text-success"><i
                    class="mdi mdi-pencil font-size-18"></i></a>
        @endif
        @if (in_array('107', $session_menu))
            <form class="delete-form" action="{{ route('opname_obat.destroy', $id) }}" method="POST">
                @csrf
                @method('DELETE')
                <a href class="text-danger delete_confirm"><i class="mdi mdi-delete font-size-18"></i></a>
            </form>
        @endif
        @if (in_array('106', $session_menu))
            <form class="delete-form"
                action="{{ route('opname_obat.approve_opname', ['kode' => $model->kode_transaksi, 'type' => 'A']) }}"
                method="POST">
                @csrf
                @method('DELETE')
                <a href class="text-success approve_confirm"><i class="mdi mdi-check-all font-size-18"></i></a>
            </form>
        @endif
    @endif
    @if ($model->status == 'A')
        @if (in_array('106', $session_menu))
            <form class="delete-form"
                action="{{ route('opname_obat.approve_opname', ['kode' => $model->kode_transaksi, 'type' => 'C']) }}"
                method="POST">
                @csrf
                @method('DELETE')
                <a href class="text-danger approve_confirm"><i class="mdi mdi-close font-size-18"></i></a>
            </form>
        @endif
    @endif
</div>
<script>
    $('.delete_confirm').on('click', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Data',
            text: 'Ingin menghapus data?',
            icon: 'question',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: "Batal",
            focusConfirm: false,
        }).then((value) => {
            if (value.isConfirmed) {
                $(this).closest("form").submit()
            }
        });
    });

    $('.approve_confirm').on('click', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Approve Data',
            text: 'Ingin approve opname?',
            icon: 'question',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: "Batal",
            focusConfirm: false,
        }).then((value) => {
            if (value.isConfirmed) {
                $(this).closest("form").submit()
            }
        });
    });
</script>
