<form action="{{ route('siswa.destroy', $students->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <a href="{{ route('siswa.show', \Crypt::encryptString($students->id)) }}" class="text-info"><i
            class="mdi mdi-eye font-size-18"></i></a>
    <a href="{{ route('siswa.edit', \Crypt::encryptString($students->id)) }}" class="text-success" data-toggle="tooltip"
        data-placement="top" title="edit"><i class="mdi mdi-pencil font-size-18"></i></a>
    @if (Auth::user()->roles == 'Admin')
        <a href="#" class="text-danger delete-confirm" data-toggle="tooltip" data-placement="top"
            title="hapus"><i class="mdi mdi-delete font-size-18"></i></a>
    @endif
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
