<?php

namespace App\Helper;

use RealRashid\SweetAlert\Facades\Alert;

class AlertHelper
{

    public static function addAlert($info)
    {
        if ($info) {
            return Alert::success('Berhasil', "Berhasil disimpan");
        } else {
            return Alert::error('Gagal', "Gagal disimpan");
        }
    }

    public static function updateAlert($info)
    {
        if ($info) {
            Alert::success('Berhasil', "Berhasil diubah");
        } else {
            Alert::error('Gagal', 'Gagal diubah');
        }
    }

    public static function deleteAlert($info)
    {
        if ($info) {
            Alert::success('Berhasil', "Berhasil dihapus");
        } else {
            Alert::error('Gagal', 'Gagal dihapus');
        }
    }

    public static function addPayment($info)
    {
        if ($info) {
            Alert::success('Berhasil', 'Berhasil dibayar');
        } else {
            Alert::error('Gagal', 'Gagal dibayar');
        }
    }

    public static function addDuplicate($info)
    {
        if ($info) {
        } else {
            Alert::error('Gagal', 'Gagal disimpan, data sudah ada');
        }
    }

    public static function import($info)
    {
        if ($info) {
            Alert::success('Berhasil', 'Berhasil import file');
        } else {
            Alert::error('Gagal', 'Gagal import file');
        }
    }
}
