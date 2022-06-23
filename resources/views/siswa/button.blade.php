<form action="{{ route('siswa.destroy', $students->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <div class="d-flex gap-3">
        <a href="{{ route('siswa.show', $students->id) }}" class="text-info"><i class="mdi mdi-eye font-size-18"></i></a>
        <a href="{{ route('siswa.edit', $students->id) }}" class="text-success" data-toggle="tooltip" data-placement="top"
            title="edit"><i class="mdi mdi-pencil font-size-18"></i></a>
        <a href="#" class="text-danger delete-confirm" data-toggle="tooltip" data-placement="top"
            title="hapus"><i class="mdi mdi-delete font-size-18"></i></a>
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
