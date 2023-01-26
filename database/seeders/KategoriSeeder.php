<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Olahraga',
                'slug' => 'olahraga'
            ],
            [
                'name' => 'Teknologi Komputer',
                'slug' => 'teknologi-komputer'
            ],
            [
                'name' => 'Lomba',
                'slug' => 'lomba'
            ]
        ];

        foreach ($data as $row) {
            Kategori::create([
                'name' => $row['name'],
                'slug' => $row['slug']
            ]);
        }
    }
}
