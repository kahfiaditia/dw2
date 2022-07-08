<?php $session_menu = explode(',', Auth::user()->akses_submenu); ?>
<?php $id = Crypt::encryptString($model->id); ?>
@if ($model->email_verified_at)
    <form class="delete-form" action="{{ route('akun.destroy', $id) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="d-flex gap-3">
            @if (in_array('9', $session_menu))
                @if (isset($model->aktif))
                    @if (Auth::user()->roles == 'Administrator')
                        <a href="{{ route('akun.edit', $id) }}" class="text-success"><i
                                class="mdi mdi-pencil font-size-18"></i></a>
                    @else
                        @if ($model->roles != 'Administrator')
                            <a href="{{ route('akun.edit', $id) }}" class="text-success"><i
                                    class="mdi mdi-pencil font-size-18"></i></a>
                        @endif
                    @endif
                @elseif ($model->aktif === null)
                    <a href="{{ route('akun.confirmasi', $id) }}" class="text-info"><i
                            class="mdi mdi-account-check font-size-18"></i></a>
                @endif
            @endif
            @if (in_array('10', $session_menu))
                @if (Auth::user()->roles == 'Administrator')
                    <a href class="text-danger delete_confirm"><i class="mdi mdi-delete font-size-18"></i></a>
                @else
                    @if ($model->roles != 'Administrator')
                        <a href class="text-danger delete_confirm"><i class="mdi mdi-delete font-size-18"></i></a>
                    @endif
                @endif
            @endif
        </div>
    </form>
@else
    @if (in_array('10', $session_menu))
        <form class="delete-form" action="{{ route('akun.destroy', $id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="d-flex gap-3">
                <a href class="text-danger delete_confirm"><i class="mdi mdi-delete font-size-18"></i></a>
            </div>
        </form>
    @endif
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
