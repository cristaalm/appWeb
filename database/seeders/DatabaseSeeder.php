<?php

namespace Database\Seeders;

use App\Models\Historial;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $fecha = Carbon::createFromDate(date('Y'), 5, 10);
            $hora = $fecha->addHours(rand(1, 22))->addMinutes(rand(0, 59))->addSeconds(rand(0, 59));
            Historial::factory()->create([
                'id_empresa' => 1,
                'id_dispositivo' => 1,
                'valor' => rand(1000, 9999),
                'fecha_ingreso' => $hora->format('Y-m-d H:i:s.u'),
            ]);
        }
        for ($i = 0; $i < 20; $i++) {
            $fecha = Carbon::createFromDate(date('Y'), 5, 10);
            $hora = $fecha->addHours(rand(1, 22))->addMinutes(rand(0, 59))->addSeconds(rand(0, 59));
            Historial::factory()->create([
                'id_empresa' => 1,
                'id_dispositivo' => 2,
                'valor' => rand(0, 14),
                'fecha_ingreso' => $hora->format('Y-m-d H:i:s.u'),
            ]);
        }
        for ($i = 0; $i < 20; $i++) {
            $fecha = Carbon::createFromDate(date('Y'), 5, 10);
            $hora = $fecha->addHours(rand(1, 22))->addMinutes(rand(0, 59))->addSeconds(rand(0, 59));
            Historial::factory()->create([
                'id_empresa' => 1,
                'id_dispositivo' => 3,
                'valor' => rand(0, 100),
                'fecha_ingreso' => $hora->format('Y-m-d H:i:s.u'),
            ]);
        }
        for ($i = 0; $i < 20; $i++) {
            $fecha = Carbon::createFromDate(date('Y'), 5, 10);
            $hora = $fecha->addHours(rand(1, 22))->addMinutes(rand(0, 59))->addSeconds(rand(0, 59));
            Historial::factory()->create([
                'id_empresa' => 1,
                'id_dispositivo' => 4,
                'valor' => rand(0, 100),
                'fecha_ingreso' => $hora->format('Y-m-d H:i:s.u'),
            ]);
        }
        for ($i = 0; $i < 20; $i++) {
            $fecha = Carbon::createFromDate(date('Y'), 5, 10);
            $hora = $fecha->addHours(rand(1, 22))->addMinutes(rand(0, 59))->addSeconds(rand(0, 59));
            Historial::factory()->create([
                'id_empresa' => 1,
                'id_dispositivo' => 6,
                'valor' => rand(0, 100),
                'fecha_ingreso' => $hora->format('Y-m-d H:i:s.u'),
            ]);
        }
    }
}
