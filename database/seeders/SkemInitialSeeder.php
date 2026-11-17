<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\StudyProgram;
use App\Models\Student;
use Illuminate\Database\Seeder;

class SkemInitialSeeder extends Seeder
{
    public function run(): void
    {
        // [nama prodi, jenjang, departemen]
        $daftar = [
            ['D3 Teknik Elektronika', 'D3', 'Departemen Teknik Elektro'],
            ['S.Tr. Teknik Elektronika', 'D4', 'Departemen Teknik Elektro'],
            ['D3 Teknik Telekomunikasi', 'D3', 'Departemen Teknik Elektro'],
            ['S.Tr. Teknik Telekomunikasi', 'D4', 'Departemen Teknik Elektro'],
            ['D3 Teknik Elektro Industri', 'D3', 'Departemen Teknik Elektro'],
            ['S.Tr. Teknik Elektro Industri', 'D4', 'Departemen Teknik Elektro'],
            ['S.Tr. Teknologi Rekayasa Internet', 'D4', 'Departemen Teknik Elektro'],
            ['S.Tr. Teknologi Rekayasa Keselamatan (TRK) K3', 'D4', 'Departemen Teknik Elektro'],

            ['D3 Teknik Informatika', 'D3', 'Departemen Teknik Informatika dan Komputer'],
            ['S.Tr. Teknik Informatika', 'D4', 'Departemen Teknik Informatika dan Komputer'],
            ['S.Tr. Teknik Komputer', 'D4', 'Departemen Teknik Informatika dan Komputer'],
            ['S.Tr. Sains Data Terapan', 'D4', 'Departemen Teknik Informatika dan Komputer'],
            ['S.Tr. Teknologi Rekayasa Perangkat Lunak', 'D4', 'Departemen Teknik Informatika dan Komputer'],

            ['S.Tr. Teknik Mekatronika', 'D4', 'Departemen Teknik Mekanika dan Energi'],
            ['S.Tr. Sistem Pembangkit Energi', 'D4', 'Departemen Teknik Mekanika dan Energi'],
            ['S.Tr. Teknologi Rekayasa Perancangan Manufaktur (TRPM)', 'D4', 'Departemen Teknik Mekanika dan Energi'],

            ['D3 Teknologi Multimedia Broadcasting', 'D3', 'Departemen Teknologi Multimedia Kreatif'],
            ['S.Tr. Teknologi Game', 'D4', 'Departemen Teknologi Multimedia Kreatif'],
            ['S.Tr. Teknologi Rekayasa Multimedia', 'D4', 'Departemen Teknologi Multimedia Kreatif'],
            ['S.Tr. Bisnis Digital', 'D4', 'Departemen Teknologi Multimedia Kreatif'],
        ];

        $prodi = [];

        foreach ($daftar as [$nama, $degree, $namaDept]) {
            $dept = Department::updateOrCreate(['name' => $namaDept]);

            $prodi[$nama] = StudyProgram::updateOrCreate(
                ['name' => $nama],
                ['department_id' => $dept->id, 'degree' => $degree]
            );
        }

        Student::updateOrCreate(['nrp' => '3125600001'], [
            'study_program_id' => $prodi['S.Tr. Teknik Informatika']->id,
            'name' => 'Rizky Pratama',
            'accumulated_points' => 1.50,
        ]);

        Student::updateOrCreate(['nrp' => '3125600002'], [
            'study_program_id' => $prodi['D3 Teknik Informatika']->id,
            'name' => 'Siti Nurhaliza',
            'accumulated_points' => 0.00,
        ]);
    }
}