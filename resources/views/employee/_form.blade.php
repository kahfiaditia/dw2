<form action="{{ route('employee.destroy', \Crypt::encryptString($employee->id)) }}" method="POST">
    @csrf
    @method('DELETE')
    <div class="row">
        <div class="col-md-3">
            <a href="{{ route('employee.edit', \Crypt::encryptString($employee->id)) }}"
                class="btn btn-sm btn-info rounded">Edit</a>
        </div>
        <div class="col-md-3">
            <button class="delete-employee btn btn-danger btn-sm rounded">
                Hapus
            </button>
        </div>
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
