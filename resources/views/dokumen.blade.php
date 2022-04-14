<?php
if ($type === 'nik') {
    $path = 'karyawan/nik/' . $file;
} elseif ($type === 'npwp') {
    $path = 'karyawan/npwp/' . $file;
} elseif ($type === 'kk') {
    $path = 'karyawan/kk/' . $file;
} elseif ($type === 'foto') {
    $path = 'karyawan/foto/' . $file;
} elseif ($type === 'sk') {
    $path = 'sk/' . $file;
} elseif ($type === 'ijazah') {
    $path = 'ijazah/' . $file;
} else {
    $path = '';
}
$path = Storage::url($path);
?>
@if ($eks === 'pdf')
    <object data="<?php echo $path; ?>#view=Fit" type="application/pdf" width="100%" height='850px'></object>
@else
    <img src="{{ $path }}" style="width: 100%">
@endif
