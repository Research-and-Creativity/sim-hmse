<?php

namespace app\Exports;

use App\Models\FinanceInternal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FinanceExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return FinanceInternal::all(); 
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Keterangan',
            'Tipe',
            'Nominal',
            'Metode',
            'Deskripsi',
            'Link Bukti',
        ];
    }
    
    public function map($transaction): array
    {
        return [
            $transaction->transaction_date,
            $transaction->title,
            $transaction->type == 'income' ? 'Pemasukan' : 'Pengeluaran',
            $transaction->amount,
            $transaction->method,
            $transaction->description,
            $transaction->attachment ? url('storage/' . $transaction->attachment) : '-',
        ];
    }
}