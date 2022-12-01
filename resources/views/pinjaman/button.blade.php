<?php $session_menu = explode(',', Auth::user()->akses_submenu); ?>
<?php $id = Crypt::encryptString($model->kode_transaksi); ?>
<form class="delete-form" action="{{ route('pinjaman.destroy', $id) }}" method="POST">
    @csrf
    @method('DELETE')
    <div class="d-flex gap-3">
        @if (in_array('74', $session_menu))
            <a href="{{ route('pinjaman.show', $id) }}" class="text-info"><i class="mdi mdi-eye font-size-18"></i></a>
        @endif
        @if ($model->all_date_return == null)
            @if (in_array('76', $session_menu))
                <a href="{{ route('pinjaman.edit', $id) }}" class="text-success"><i
                        class="mdi mdi-pencil font-size-18"></i></a>
            @endif
            @if (in_array('77', $session_menu))
                <a href class="text-danger delete_confirm"><i class="mdi mdi-delete font-size-18"></i></a>
            @endif
            @if (in_array('78', $session_menu))
                <a href="{{ route('pinjaman.approve', $id) }}" class="text-success" data-toggle="tooltip"
                    data-placement="top" title="Approve"><i class="mdi mdi-check-all font-size-18"></i></a>
            @endif
        @endif
    </div>
</form>
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
</script>
