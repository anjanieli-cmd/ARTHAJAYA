<?php

namespace Database\Seeders;

use App\Models\Receivable;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReceivableSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $receivables = [
            // Data Piutang Usaha - Sudah Jatuh Tempo
            [
                'client' => 'Bumi Retail Group',
                'invoice' => 'INV-2026-0001',
                'date' => '2026-07-16',
                'due' => '2026-07-15', // Sudah lewat
                'status' => 'jatuh_tempo',
                'amount' => 100000,
                'items' => json_encode([
                    'Jasa Retail' => 100000
                ]),
                'notes' => 'Sudah jatuh tempo 4 hari'
            ],
            [
                'client' => 'Nusantara Logistik',
                'invoice' => 'INV-2026-0002',
                'date' => '2026-07-17',
                'due' => '2026-07-14', // Sudah lewat
                'status' => 'jatuh_tempo',
                'amount' => 100000000,
                'items' => json_encode([
                    'Jasa Logistik' => 100000000
                ]),
                'notes' => 'Sudah jatuh tempo 5 hari'
            ],
            // Data Lancar (belum jatuh tempo)
            [
                'client' => 'PT Andalas Maju Bersama',
                'invoice' => 'INV-2026-0003',
                'date' => '2026-07-10',
                'due' => '2026-08-10',
                'status' => 'lancar',
                'amount' => 5750000,
                'items' => json_encode([
                    'Jasa Konsultasi' => 5750000
                ]),
                'notes' => 'Masih dalam masa tenggang'
            ],
            [
                'client' => 'Ruang Kriya Studio',
                'invoice' => 'INV-2026-0004',
                'date' => '2026-07-18',
                'due' => '2026-08-01',
                'status' => 'lancar',
                'amount' => 6200000,
                'items' => json_encode([
                    'Desain Grafis' => 6200000
                ]),
                'notes' => 'Baru dibuat'
            ],
            // Data Lunas
            [
                'client' => 'Kopi Kenangan Senja',
                'invoice' => 'INV-2026-0005',
                'date' => '2026-07-01',
                'due' => '2026-07-15',
                'status' => 'lunas',
                'amount' => 2800000,
                'items' => json_encode([
                    'Supply Kopi' => 2800000
                ]),
                'notes' => 'Sudah dibayar lunas'
            ],
            [
                'client' => 'Warung Sinar Abadi',
                'invoice' => 'INV-2026-0006',
                'date' => '2026-06-20',
                'due' => '2026-07-04',
                'status' => 'lunas',
                'amount' => 4100000,
                'items' => json_encode([
                    'Bahan Baku' => 4100000
                ]),
                'notes' => 'Lunas tepat waktu'
            ],
        ];

        foreach ($receivables as $receivable) {
            Receivable::create($receivable);
        }
    }
}