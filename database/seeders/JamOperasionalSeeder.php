<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JamOperasionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jam_operasional')->insert([
            [
                'jo_id' => 3,
                'jo_hari' => 'Senin',
                'jo_jam_buka' => '08:00:00',
                'jo_jam_tutup' => '23:00:00',
                'jo_is_hari_libur' => 0,
                'created_at' => '2025-11-28 12:02:09',
                'updated_at' => '2025-12-16 07:33:24',
            ],
            [
                'jo_id' => 4,
                'jo_hari' => 'Selasa',
                'jo_jam_buka' => '08:00:00',
                'jo_jam_tutup' => '09:00:00',
                'jo_is_hari_libur' => 0,
                'created_at' => '2025-11-28 12:03:35',
                'updated_at' => '2025-12-16 08:14:18',
            ],
            [
                'jo_id' => 5,
                'jo_hari' => 'Rabu',
                'jo_jam_buka' => '00:00:00',
                'jo_jam_tutup' => '23:00:00',
                'jo_is_hari_libur' => 0,
                'created_at' => '2025-11-28 12:03:35',
                'updated_at' => '2025-12-15 09:15:02',
            ],
            [
                'jo_id' => 6,
                'jo_hari' => 'Kamis',
                'jo_jam_buka' => '00:00:00',
                'jo_jam_tutup' => '00:00:00',
                'jo_is_hari_libur' => 0,
                'created_at' => '2025-11-28 12:03:35',
                'updated_at' => '2025-12-10 15:50:34',
            ],
            [
                'jo_id' => 7,
                'jo_hari' => 'Jumat',
                'jo_jam_buka' => '08:00:00',
                'jo_jam_tutup' => '13:00:00',
                'jo_is_hari_libur' => 0,
                'created_at' => '2025-11-28 12:03:35',
                'updated_at' => '2025-12-19 07:13:27',
            ],
            [
                'jo_id' => 8,
                'jo_hari' => 'Sabtu',
                'jo_jam_buka' => '00:00:00',
                'jo_jam_tutup' => '00:00:00',
                'jo_is_hari_libur' => 1,
                'created_at' => '2025-11-28 12:03:35',
                'updated_at' => '2025-12-19 07:14:16',
            ],
            [
                'jo_id' => 9,
                'jo_hari' => 'Minggu',
                'jo_jam_buka' => '08:00:00',
                'jo_jam_tutup' => '22:00:00',
                'jo_is_hari_libur' => 1,
                'created_at' => '2025-11-28 12:03:35',
                'updated_at' => '2025-12-16 06:23:37',
            ],
        ]);
    }
}
