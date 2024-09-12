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
            'value' => 'required|numeric',
            
        ]);

        $createlercorrida = LerCorrida::create([
            'user_id' => Auth::id(),
            'value' =>  $lercorrida['value'],
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
