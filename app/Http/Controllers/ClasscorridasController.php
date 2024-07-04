<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classcorridas;
use Illuminate\Support\Facades\Auth;

class ClasscorridasController extends Controller
{
    public function createClasscorridas(Request $request)
    {
        try {
            $classcorridas = $request->validate([
                'corrida_bronze' => 'required|numeric|min:0',
                'corrida_ouro' => 'required|numeric|min:0',
                'corrida_diamante' => 'required|numeric|min:0',
            ]);

            $createclasscorridas = Classcorridas::create([
                'user_id' => Auth::id(),
                'corrida_bronze' => $classcorridas['corrida_bronze'],
                'corrida_ouro' => $classcorridas['corrida_ouro'],
                'corrida_diamante' => $classcorridas['corrida_diamante'],
            ]);

            return response()->json(['message' => 'classcorridas added successfully']);
        } catch (\Exception $e) {
            // Log do erro
            \Log::error('Failed to add classcorridas: ' . $e->getMessage());

            // Retornar uma resposta de erro
            return response()->json(['message' => 'Failed to add classcorridas. Please try again later.'], 500);
        }
    }


    public function getClasscorridas()
    {
        $classcorridas = Classcorridas::where('user_id', Auth::id())->get();
        return response()->json($classcorridas);
    }



    // Função para atualizar um registro existente
    public function updateClasscorridas(Request $request, $id)
    {
        $request->validate([
            'corrida_bronze' => 'required|numeric|min:0',
            'corrida_ouro' => 'required|numeric|min:0',
            'corrida_diamante' => 'required|numeric|min:0',
        ]);

        $classcorridas = Classcorridas::find($id);

        if ($classcorridas) {
            $classcorridas->update($request->all());
            return response()->json(['message' => 'classcorridas updated successfully'], 200);
        } else {
            return response()->json(['message' => 'classcorridas not found'], 404);
        }
    }
}
