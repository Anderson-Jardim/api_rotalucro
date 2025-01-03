<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LerCorridaCard;
use Illuminate\Support\Facades\Auth;


class LerCorridaCardController extends Controller
{

    public function index()
    
        {
            $lercorr = LerCorridaCard::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($lercorr) {
                return [
                    'id' => $lercorr->id,
                    'total_distance' => $lercorr->total_distance,
                    'valor' => $lercorr->valor,
                    'lucro' => $lercorr->lucro,
                    'total_custo' => $lercorr->total_custo,
                    'valor_por_km' => $lercorr->valor_por_km,
                    'tipo_corrida' => $lercorr->tipo_corrida,
                    'created_at' => $lercorr->created_at->format('d/m/Y'), // Formata a data
                ];
            });
            return response()->json($lercorr);
        }







    
    
    public function store(Request $request)
    {
        try{
        $lercorrida = $request->validate([
            'total_distance' => 'required|numeric',
            'valor'  => 'required|numeric',
            'lucro'  => 'required|numeric',
            'total_custo'  => 'required|numeric',
            'valor_por_km'    => 'required|numeric',
           'tipo_corrida'   => 'required|string',  
        ]);

        $createlercorrida = LerCorridaCard::create([
            'user_id' => Auth::id(),
            'total_distance' =>  $lercorrida['total_distance'],
            'valor' =>  $lercorrida['valor'],
            'lucro' =>  $lercorrida['lucro'],
            'total_custo' =>  $lercorrida['total_custo'],
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
