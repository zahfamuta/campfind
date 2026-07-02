<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    $categories = [
        ['category_name' => 'Elektronik & Gadget'],
        ['category_name' => 'Dokumen & Kartu Penting'],
        ['category_name' => 'Dompet & Uang'],
        ['category_name' => 'Barang & Aksesoris'],
        ['category_name' => 'Pakaian & Tas'],
    ];

    foreach ($categories ?? [] as $category) {
        \App\Models\Category::create($category);
    }
}
}
