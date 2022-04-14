<?php $id = Crypt::encryptString($model->id); ?>
@if ($model->email_verified_at)
    <form class="delete-form" action="{{ route('akun.destroy', $id) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="d-flex gap-3">
            @if (isset($model->aktif))
                <a href="{{ route('akun.edit', $id) }}" class="text-success"><i
                        class="mdi mdi-pencil font-size-18"></i></a>
            @elseif ($model->aktif === null)
                <a href="{{ route('akun.confirmasi', $id) }}" class="text-info"><i
                        class="mdi mdi-account-check font-size-18"></i></a>
            @endif
            <a href class="text-danger delete_confirm"><i class="mdi mdi-delete font-size-18"></i></a>
        </div>
    </form>
@else
    <form class="delete-form" action="{{ route('akun.destroy', $id) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="d-flex gap-3">
            <a href class="text-danger delete_confirm"><i class="mdi mdi-delete font-size-18"></i></a>
        </div>
    </form>
@endif
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
