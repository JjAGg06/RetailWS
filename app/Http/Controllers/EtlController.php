<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EtlController extends Controller
{
    /**
     * Muestra la pantalla de Gestión de ETL.
     * La vista usa app.js (initETL) para cargar logs y simular ejecuciones.
     */
    public function index(Request $request)
    {
        // Si quieres pasar datos a la vista, agrega al array:
        // return view('etl', ['titulo' => 'Gestión de ETL']);
        return view('etl');
    }
}
