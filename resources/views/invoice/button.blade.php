<?php $session_menu = explode(',', Auth::user()->akses_submenu); ?>
<?php $id = Crypt::encryptString($model->id); ?>
<form class="delete-form" action="{{ route('invoice.destroy', $id) }}" method="POST">
    @csrf
    @method('DELETE')
    <div class="d-flex gap-3">
        @if (in_array('35', $session_menu))
            <a href="{{ route('invoice.show', $id) }}" class="text-info"><i class="mdi mdi-eye font-size-18"></i></a>
        @endif
        @if (in_array('38', $session_menu))
            <a href class="text-danger delete_confirm"><i class="mdi mdi-delete font-size-18"></i></a>
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
