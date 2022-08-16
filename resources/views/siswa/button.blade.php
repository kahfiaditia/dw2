<?php $session_menu = explode(',', Auth::user()->akses_submenu); ?>
<form action="{{ route('siswa.destroy', $students->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <div class="d-flex gap-3">
        @if (in_array('19', $session_menu))
            <a href="{{ route('siswa.show', \Crypt::encryptString($students->id)) }}" class="text-info"><i
                    class="mdi mdi-eye font-size-18"></i></a>
        @endif
        @if (in_array('21', $session_menu))
            <a href="{{ route('siswa.edit', \Crypt::encryptString($students->id)) }}" class="text-success"
                data-toggle="tooltip" data-placement="top" title="edit"><i class="mdi mdi-pencil font-size-18"></i></a>
        @endif
        @if (in_array('22', $session_menu))
            <a href="#" class="text-danger delete-confirm" data-toggle="tooltip" data-placement="top"
                title="hapus"><i class="mdi mdi-delete font-size-18"></i></a>
        @endif
        @if (in_array('56', $session_menu))
            <a href="{{ route('siswa.edit_pembayaran', \Crypt::encryptString($students->id)) }}" class="text-success"
                data-toggle="tooltip" data-placement="top" title="edit Pembayaran"><i
                    class="mdi mdi-credit-card-check-outline font-size-18"></i></a>
        @endif
    </div>
</form>

<script>
    $('.delete-confirm').on('click', function(event) {
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
