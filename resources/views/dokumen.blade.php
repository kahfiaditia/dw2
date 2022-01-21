<?php
    if ($type === 'nik'){
        $path = 'karyawan/nik/'.$file;
    }elseif($type === 'npwp'){
        $path = 'karyawan/npwp/'.$file;
    }elseif($type === 'kk'){
        $path = 'karyawan/kk/'.$file;
    }elseif($type === 'sk'){
        $path = 'sk/'.$file;
    }else{
        $path = '';
    }
?>
@if ($eks === 'pdf')
    <object data="<?php echo $path?>#view=Fit" type="application/pdf" width="100%" height='850px'></object>
@else
    <?php $path = Storage::url($path); ?>
    <img src="{{ $path }}" style="width: 100%">
@endif
