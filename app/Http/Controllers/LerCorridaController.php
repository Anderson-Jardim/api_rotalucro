<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LerCorrida;
use Illuminate\Support\Facades\Auth;


class LerCorridaController extends Controller
{
    public function store(Request $request)
    {
        try{
        $lercorrida = $request->validate([
            'total_distance' => 'required|numeric',
            'valor'  => 'required|numeric',
            'valor_por_km'    => 'required|numeric',
           'tipo_corrida'   => 'required|string',  
        ]);

        $createlercorrida = LerCorrida::create([
            'user_id' => Auth::id(),
            'total_distance' =>  $lercorrida['total_distance'],
            'valor' =>  $lercorrida['valor'],
            'valor_por_km' =>  $lercorrida['valor_por_km'],
             'tipo_corrida' =>  $lercorrida['tipo_corrida'],  
        ]);

        /* CapturedData::create($validatedData); */

        return response()->json(['message' => 'Data stored successfully'], 201);
    } catch (\Exception $e) {
        // Log do erro
        \Log::error('Failed to add Ler Corrida: ' . $e->getMessage());

        // Retornar uma resposta de erro
        return response()->json(['message' => 'Failed to add Ler Corrida. Please try again later.'], 500);
    }
    }

}
