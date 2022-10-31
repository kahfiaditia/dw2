<?php $session_menu = explode(',', Auth::user()->akses_submenu); ?>
<?php $id = Crypt::encryptString($model->id); ?>
<form class="delete-form" action="{{ route('buku.destroy', $id) }}" method="POST">
    @csrf
    @method('DELETE')
    <div class="d-flex gap-3">
        @if (in_array('70', $session_menu))
            <a href="{{ route('buku.show', $id) }}" class="text-info"><i class="mdi mdi-eye font-size-18"></i></a>
        @endif
        @if (in_array('72', $session_menu))
            <a href="{{ route('buku.edit', $id) }}" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
        @endif
        @if (in_array('73', $session_menu))
            <a href class="text-danger delete_confirm"><i class="mdi mdi-delete font-size-18"></i></a>
        @endif

        <a href="javascript:void(0)" data-id="{{ $id }}" class="text-dark" id="get_data_edit"
            data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg-edit">
            <i class="mdi mdi-printer font-size-18"></i>
        </a>
    </div>
</form>
<!-- modal -->
<div class="modal fade bs-example-modal-lg-edit" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Print Barcode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="dynamic-content-edit"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '#get_data_edit', function(e) {
        e.preventDefault();
        var id = $(this).data('id'); // it will get id of clicked row
        $('#dynamic-content-edit').html(''); // leave it blank before ajax call
        $('#modal-loader').show(); // load ajax loader
        var url = "{{ route('buku.print') }}"
        $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id
                }
            })
            .done(function(url) {
                $('#dynamic-content-edit').html(url); // load response
                $('#modal-loader').hide(); // hide ajax loader
            })
            .fail(function(err) {
                $('#dynamic-content').html(
                    '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                );
                $('#modal-loader').hide();
            });
    });

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
