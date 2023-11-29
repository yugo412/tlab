<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitTableSeeder extends Seeder
{
    private array $units = [
        'gr' => 'gram',
        'siung' => 'siung',
        'sdm' => 'sendok makan',
        'sdt' => 'sendok teh',

        // etc
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->units as $short => $name) {
            $unit = Unit::firstOrNew(['short_name' => $short]);
            $unit->fill(['name' => $name]);
            $unit->save();
        }
    }
}
