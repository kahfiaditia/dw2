<form action="{{ route('employee.destroy', \Crypt::encrypt($employee->id)) }}" method="POST">
    @csrf
    @method('DELETE')
    <div class="d-flex gap-3">
        <a href class="text-danger delete-employee"><i class="mdi mdi-delete font-size-18"></i></a>
        <a href="{{ route('employee.edit', \Crypt::encrypt($employee->id)) }}" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
    </div>
</form>
<script>
    $('.delete-employee').on('click', function(event) {
        event.preventDefault();
        let id = $(this).data('id')
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
