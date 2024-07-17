<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoriesImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        return new Category([
            'name' => $row['name'],
            'image' => $row['image'],
        ]);
    }
}
