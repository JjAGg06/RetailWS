<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\JsonResponse;

class ApiMockController extends Controller
{
    /**
     * Devuelve datos de ventas (para dashboard)
     */
    public function sales(): JsonResponse
    {
        $path = base_path('resources/data/sales.json');

        if (!File::exists($path)) {
            return response()->json([
                ['2025-11-07', 'Producto demo', 'Sucursal demo', 'Cliente demo', 'Guatemala', 999.99]
            ]);
        }

        $data = json_decode(File::get($path), true);
        return response()->json($data ?? []);
    }

    /**
     * Devuelve datos de logs ETL (para tablas de logs o ETL)
     */
    public function logs(): JsonResponse
    {
        $path = base_path('resources/data/logs.json');

        if (!File::exists($path)) {
            // si no existe, devolvemos logs simulados
            $demo = [
                ["2025-11-07 10:15","DIM_PRODUCTO","OK","Insertadas 1,234 filas (merge)."],
                ["2025-11-07 10:16","DIM_CLIENTE","OK","Actualizadas 543; nuevas 87."],
                ["2025-11-07 10:18","FACT_VENTAS","OK","Creadas 12,345 filas; duplicados evitados."],
                ["2025-11-07 10:20","REPROCESO_HECHOS","ERROR","ORA-00001: restricción única violada."],
                ["2025-11-07 10:25","DIM_SUCURSAL","OK","Sin cambios detectados."]
            ];
            return response()->json($demo);
        }

        $data = json_decode(File::get($path), true);
        return response()->json($data ?? []);
    }
}
