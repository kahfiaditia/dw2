<?php $id = Crypt::encryptString($model->id); ?>
<form class="delete-form" action="{{ route('kodepos.destroy', ['id' => $id]) }}" method="POST">
    @csrf
    @method('DELETE')
    <div class="d-flex gap-3">
        <a href class="text-danger delete_confirm"><i class="mdi mdi-delete font-size-18"></i></a>
        <a href="{{ route('kodepos.edit',['id' => $id]) }}" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
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
