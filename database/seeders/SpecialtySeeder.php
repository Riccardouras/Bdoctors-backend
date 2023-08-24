<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialties = [
            'Allergologia',
            'Anatomia Patologica',
            'Andrologia',
            'Angiologia Medica',
            'Cardiochirurgia',
            'Cardiologia',
            'Cardiologia pediatrica',
            'Chirurgia Generale',
            'Chirurgia Maxillo-facciale',
            'Chirurgia Pediatrica',
            'Chirurgia Plastica',
            'Chirurgia Proctologica e Proctologia',
            'Chirurgia Toracica',
            'Chirurgia Vascolare',
            'Dermatologia e Venereologia',
            'Diabetologia',
            'Dietologia',
            'Ecografia e Doppler',
            'Ematologia',
            'Endocrinologia',
            'Fisiatria',
            'Gastroenterologia',
            'Genetica Medica',
            'Geriatria e Gerontologia',
            'Ginecologia e Ostetricia',
            'Immunologia',
            'Infettivologia e Malattie Infettive',
            'Medicina del Dolore',
            'Medicina dello Sport',
            'Medicina Estetica',
            'Medicina Interna',
            'Medicina Legale',
            'Medicina Nucleare',
            'Nefrologia',
            'Neurochirurgia',
            'Neurofisiopatologia',
            'Neurologia',
            'Neuropsichiatria Infantile',
            'Oculistica',
            'Odontoiatria',
            'Omeopatia e Agopuntura',
            'Oncologia',
            'Ortopedia e Traumatologia',
            'Otorinolaringoiatria',
            'Pediatria',
            'Pneumologia e Malattie Respiratorie',
            'Psichiatria',
            'Radiologia Interventistica',
            'Radiologia TAC e Risonanza',
            'Reumatologia',
            'Senologia',
            'Urologia',
        ];

        foreach ($specialties as $specialty) {
            DB::table('specialties')->insert([
                'name' => $specialty,
            ]);
        }
    }
}
