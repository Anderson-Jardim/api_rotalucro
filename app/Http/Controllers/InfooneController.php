<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Infoone;
use Illuminate\Support\Facades\Auth;

class InfooneController extends Controller
{
    public function createInfoone(Request $request)
    {
        try {
            $infoone = $request->validate([
                'valor_gasolina' => 'required|numeric|min:0',
                'dias_trab' => 'required|numeric|min:0',
                'qtd_corridas' => 'required|numeric|min:0',
                'km_litro' => 'required|numeric|min:0',
            ]);

            $createinfoone = Infoone::create([
                'user_id' => Auth::id(),
                'valor_gasolina' => $infoone['valor_gasolina'],
                'dias_trab' => $infoone['dias_trab'],
                'qtd_corridas' => $infoone['qtd_corridas'],
                'km_litro' => $infoone['km_litro'],
            ]);

            return response()->json(['message' => 'Infoone added successfully']);
        } catch (\Exception $e) {
            // Log do erro
            \Log::error('Failed to add Infoone: ' . $e->getMessage());

            // Retornar uma resposta de erro
            return response()->json(['message' => 'Failed to add Infoone. Please try again later.'], 500);
        }
    }

    public function getInfoone(Request $request)
{
    $infoone = Infoone::where('user_id', Auth::id())->get();
    return response()->json($infoone);
}

public function checkInfoone(Request $request) {
    $user = auth()->user();
    $infoone = Infoone::where('user_id', $user->id)->get();

    if ($infoone->isEmpty()) {
        return response()->json([]);
    } else {
        return response()->json($infoone);
    }
}


    // Função para atualizar um registro existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'valor_gasolina' => 'required|numeric|min:0',
            'dias_trab' => 'required|numeric|min:0',
            'qtd_corridas' => 'required|numeric|min:0',
            'km_litro' => 'required|numeric|min:0',
        ]);

        $infoone = Infoone::find($id);

        if ($infoone) {
            $infoone->update($request->all());
            return response()->json(['message' => 'Infoone updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Infoone not found'], 404);
        }
    }
}
