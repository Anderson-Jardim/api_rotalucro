<?php

namespace App\Http\Controllers;

use App\Models\valorKM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValorKMController extends Controller
{
     // Função para pegar os valores de valor_km (ruim e bom)
     public function getValorKM(Request $request)
     {
        $valorKM = valorKM::where('user_id', Auth::id())->get();
        return response()->json($valorKM);
     }



      // Função para atualizar os valores de valor_km (ruim e bom)
    public function updateValorKM(Request $request)
    {
        // Validar os valores que o usuário deseja atualizar
        $request->validate([
            'ruim' => 'required|numeric',  // Validação para o valor "ruim"
            'bom' => 'required|numeric',   // Validação para o valor "bom"
        ]);

        // Buscar o valorKM do usuário autenticado
        $user_id = Auth::id();  // ID do usuário autenticado
        $valorKM = valorKM::where('user_id', $user_id)->first();

        if (!$valorKM) {
            return response()->json([
                'message' => 'Registro de valor_km não encontrado para este usuário.'
            ], 404);
        }

        // Atualizar os valores
        $valorKM->update([
            'ruim' => $request->ruim,
            'bom' => $request->bom,
        ]);

        return response()->json([
            'message' => 'Valores de valor_km atualizados com sucesso!',
            'valor_km' => $valorKM,
        ], 200);
    }
}
