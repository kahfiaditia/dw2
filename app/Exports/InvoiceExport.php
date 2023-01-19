<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class InvoiceExport implements WithColumnFormatting, FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    use Exportable;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function query()
    {
        $invoice = DB::table('invoice_header')
            ->select(
                'invoice_header.id',
                'no_invoice',
                'date_header',
                'nis',
                'nama_lengkap as siswa',
                'uang_formulir',
                'uang_pangkal',
                'uang_spp',
                'uang_kegiatan',
                'diskon_pembayaran',
                'diskon_prestasi',
                'grand_total',
            )
            ->leftJoin('siswa', 'siswa.id', 'invoice_header.siswa_id')
            ->whereNull('invoice_header.deleted_at')
            ->groupBy('invoice_header.no_invoice')
            ->orderBy('invoice_header.no_invoice', 'asc');

        $search = $this->data['search_manual'];
        if ($search != null) {
            $invoice->where(function ($where) use ($search) {
                $where
                    ->orWhere('no_invoice', 'like', '%' . $search . '%')
                    ->orWhere('nis', 'like', '%' . $search . '%')
                    ->orWhere('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('diskon_pembayaran', 'like', '%' . $search . '%')
                    ->orWhere('diskon_prestasi', 'like', '%' . $search . '%')
                    ->orWhere('grand_total', 'like', '%' . $search . '%');
            });
        } else {
            $kode = $this->data['kode'];
            $tgl_start = $this->data['tgl_start'];
            $tgl_end = $this->data['tgl_end'];
            $nis = $this->data['nis'];
            $siswa = $this->data['siswa'];
            $biaya_start = $this->data['biaya_start'];
            $biaya_end = $this->data['biaya_end'];
            $disc_start = $this->data['disc_start'];
            $disc_end = $this->data['disc_end'];
            $prestasi_start = $this->data['prestasi_start'];
            $prestasi_end = $this->data['prestasi_end'];
            $total_start = $this->data['total_start'];
            $total_end = $this->data['total_end'];

            if ($kode != null) {
                $invoice->where('no_invoice', '=', $kode);
            }
            if ($tgl_end != null) {
                $start = $tgl_start . ' 00:00:01';
                $end = $tgl_end . ' 23:59:59';
                $invoice->where('date_header', '>=', $start);
                $invoice->where('date_header', '<=', $end);
            }
            if ($nis != null) {
                $invoice->where('nis', '=', $nis);
            }
            if ($siswa != null) {
                $invoice->Where('nama_lengkap', 'like', '%' . $siswa . '%');
            }
            if ($biaya_end != null) {
                $invoice->havingRaw("SUM(uang_formulir+uang_pangkal+uang_spp+uang_kegiatan) >= '$biaya_start' and SUM(uang_formulir+uang_pangkal+uang_spp+uang_kegiatan) <= '$biaya_end'");
            }
            if ($disc_end != null) {
                $invoice->where('diskon_pembayaran', '>=', $disc_start);
                $invoice->where('diskon_pembayaran', '<=', $disc_end);
            }
            if ($prestasi_end != null) {
                $invoice->where('diskon_prestasi', '>=', $prestasi_start);
                $invoice->where('diskon_prestasi', '<=', $prestasi_end);
            }
            if ($total_end != null) {
                $invoice->where('grand_total', '>=', $total_start);
                $invoice->where('grand_total', '<=', $total_end);
            }
        }
        return $invoice;
    }

    public function headings(): array
    {
        return [
            'No Pembayaran',
            'Tanggal',
            'NIS',
            'Siswa',
            'Biaya',
            'Diskon Pembayaran',
            'Diskon Prestasi',
            'Total',
        ];
    }

    public function map($invoice): array
    {
        return [
            $invoice->no_invoice,
            date('Y-m-d', strtotime($invoice->date_header)),
            $invoice->nis,
            $invoice->siswa,
            ($invoice->uang_formulir + $invoice->uang_pangkal + $invoice->uang_spp + $invoice->uang_kegiatan),
            $invoice->diskon_pembayaran,
            $invoice->diskon_prestasi,
            $invoice->grand_total,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function registerEvents(): array
    {
        $cellHeader      = 'A1:H1';
        return [
            AfterSheet::class    => function (AfterSheet $event) use ($cellHeader) {
                $event->sheet->getDelegate()->getStyle($cellHeader)
                    ->getFont()
                    ->setBold(true);
            },
        ];
    }
}
