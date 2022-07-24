@extends('layouts.main')
@section('container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ $label }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">{{ ucwords($menu) }}</li>
                                <li class="breadcrumb-item">{{ ucwords($submenu) }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <form class="needs-validation" action="{{ route('primession.update', Crypt::encryptString($user->id)) }}"
                method="POST" novalidate>
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered border-success mb-0">
                                            <thead>
                                                <tr>
                                                    <th valign="middle" class="text-center">#</th>
                                                    <th valign="middle">Menu Akses <input type="checkbox"
                                                            onchange="checkAll(this)" name="chk[]"></th>
                                                    <th class="text-center">View <br>
                                                        <input type="checkbox" onchange="viewAll(this)" name="chk[]">
                                                    </th>
                                                    <th class="text-center">Insert <br>
                                                        <input type="checkbox" onchange="insertAll(this)" name="chk[]">
                                                    </th>
                                                    <th class="text-center">Edit <br>
                                                        <input type="checkbox" onchange="editAll(this)" name="chk[]">
                                                    </th>
                                                    <th class="text-center">Delete <br>
                                                        <input type="checkbox" onchange="deleteAll(this)" name="chk[]">
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1; foreach ($primession as $item){?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-left"><?php echo $item->submenu; ?></td>
                                                    <td class="text-center">
                                                        <?php if(isset($item->views)){ ?>
                                                        <input type="checkbox" name="akses_id[]" class="view"
                                                            value="<?php echo $item->views; ?>" <?php $c = explode(',', $user->akses_submenu); ?>
                                                            <?php if (in_array($item->views, $c)) {
                                                                echo 'checked';
                                                            } ?>>
                                                        <?php }else{ ?>
                                                        <input type="checkbox" disabled>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if(isset($item->inserts)){ ?>
                                                        <input type="checkbox" name="akses_id[]" class="insert"
                                                            value="<?php echo $item->inserts; ?>" <?php $c = explode(',', $user->akses_submenu); ?>
                                                            <?php if (in_array($item->inserts, $c)) {
                                                                echo 'checked';
                                                            } ?>>
                                                        <?php }else{ ?>
                                                        <input type="checkbox" disabled>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if(isset($item->edits)){ ?>
                                                        <input type="checkbox" name="akses_id[]" class="edit"
                                                            value="<?php echo $item->edits; ?>" <?php $c = explode(',', $user->akses_submenu); ?>
                                                            <?php if (in_array($item->edits, $c)) {
                                                                echo 'checked';
                                                            } ?>>
                                                        <?php }else{ ?>
                                                        <input type="checkbox" disabled>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if(isset($item->deletes)){ ?>
                                                        <input type="checkbox" name="akses_id[]" class="delete"
                                                            value="<?php echo $item->deletes; ?>" <?php $c = explode(',', $user->akses_submenu); ?>
                                                            <?php if (in_array($item->deletes, $c)) {
                                                                echo 'checked';
                                                            } ?>>
                                                        <?php }else{ ?>
                                                        <input type="checkbox" disabled>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('primession.index') }}"
                                            class="btn btn-secondary waves-effect">Batal</a>
                                        <button class="btn btn-primary" type="submit" style="float: right"
                                            id="submit">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        function checkAll(ele) {
            var checkboxes = document.getElementsByTagName('input');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox' && !(checkboxes[i].disabled)) {
                        checkboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
            }
        }

        function viewAll(ele) {
            var checkboxes = document.getElementsByClassName('view');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
            }
        }

        function insertAll(ele) {
            var checkboxes = document.getElementsByClassName('insert');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
            }
        }

        function editAll(ele) {
            var checkboxes = document.getElementsByClassName('edit');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
            }
        }

        function deleteAll(ele) {
            var checkboxes = document.getElementsByClassName('delete');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
            }
        }
    </script>
@endsection
