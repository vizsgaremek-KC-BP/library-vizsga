<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = 'public\students.csv';

        if (!Storage::exists($csvFile)) {
            echo "CSV fájl nem található: " . Storage::path($csvFile) . "\n";
            return;
        }

        $csvPath = Storage::path($csvFile);

        $csv = Reader::createFromPath($csvPath, 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {

            $existingStudent = Student::where('edu_id', $record['edu_id'])->first();

            if (!$existingStudent) {
                Student::create([
                    'name' => $record['name'],
                    'status' => 'active',
                    'edu_id' => $record['edu_id']
                ]);
            }
        }
    }
}
