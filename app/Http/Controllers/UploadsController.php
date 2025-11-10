<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadsController extends Controller
{
    // GET /uploads
    public function index()
    {
        // Muestra la vista de cargas (uploads.blade.php)
        return view('uploads');
    }

    // POST /uploads  (opcional si usas formulario con POST)
    public function upload(Request $request)
    {
        if (!$request->hasFile('file')) {
            return back()->with('error', 'Debe seleccionar un archivo.');
        }

        $file = $request->file('file');
        $ext  = strtolower($file->getClientOriginalExtension());

        if (!in_array($ext, ['csv','json','xlsx'])) {
            return back()->with('error', 'Formato no permitido. Use CSV, JSON o XLSX.');
        }

        return back()->with('success', "Archivo '{$file->getClientOriginalName()}' cargado correctamente (demo).");
    }
}
