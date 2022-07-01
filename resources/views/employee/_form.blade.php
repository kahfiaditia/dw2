<?php $session_menu = explode(',', Auth::user()->akses_submenu); ?>
<form action="{{ route('employee.destroy', \Crypt::encryptString($employee->id)) }}" method="POST">
    @csrf
    @method('DELETE')
    <div class="d-flex gap-3">
        @if (in_array('3', $session_menu))
            <a href="{{ route('employee.show', \Crypt::encryptString($employee->id)) }}" class="text-info"><i
                    class="mdi mdi-eye font-size-18"></i></a>
        @endif
        @if (in_array('4', $session_menu))
            <a href="{{ route('employee.edit', \Crypt::encryptString($employee->id)) }}" class="text-success"><i
                    class="mdi mdi-pencil font-size-18"></i></a>
        @endif
        @if (in_array('5', $session_menu))
            <a href class="text-danger delete-employee"><i class="mdi mdi-delete font-size-18"></i></a>
        @endif
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
