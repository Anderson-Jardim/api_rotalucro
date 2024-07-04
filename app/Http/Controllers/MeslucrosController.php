<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meslucros;
use Illuminate\Support\Facades\Auth;

class MeslucrosController extends Controller
{
    public function createMeslucros(Request $request)
    {
        try {
            $meslucros = $request->validate([
                'qtd_mes_lucros' => 'required|numeric|min:0',
                
            ]);

            $createmeslucros = Meslucros::create([
                'user_id' => Auth::id(),
                'qtd_mes_lucros' => $meslucros['qtd_mes_lucros'],
                
            ]);

            return response()->json(['message' => 'Meslucros added successfully']);
        } catch (\Exception $e) {
            // Log do erro
            \Log::error('Failed to add Meslucros: ' . $e->getMessage());

            // Retornar uma resposta de erro
            return response()->json(['message' => 'Failed to add Meslucros. Please try again later.'], 500);
        }
    }


    public function getMeslucros()
    {
        $meslucros = Meslucros::where('user_id', Auth::id())->get();
        return response()->json($meslucros);
    }


    public function updateMeslucros(Request $request, $id)
    {
        $request->validate([
            'qtd_mes_lucros' => 'required|numeric|min:0',
        ]);

        $meslucros = Meslucros::find($id);

        if ($meslucros) {
            $meslucros->update($request->all());
            return response()->json(['message' => 'meslucros updated successfully'], 200);
        } else {
            return response()->json(['message' => 'meslucros not found'], 404);
        }
    }

}
