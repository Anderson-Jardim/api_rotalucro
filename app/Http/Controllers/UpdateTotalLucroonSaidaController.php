<?php

namespace App\Http\Controllers;

use App\Models\UpdateTotalLucroonSaida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateTotalLucroonSaidaController extends Controller
{



    public function getUserSaidas()
{
    $saidas = UpdateTotalLucroonSaida::where('user_id', Auth::id())
    ->orderBy('created_at', 'desc')
    ->get()
    ->map(function($saida) {
        return [
            'id' => $saida->id,
            'nome_saida' => $saida->nome_saida,
            'saida_lucro' => $saida->saida_lucro,
            'tipo' => $saida->tipo,
            'created_at' => $saida->created_at->format('d/m/Y'), // Formata a data
        ];
    });
    return response()->json($saidas);
}



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $saidalucro = $request->validate([
                'nome_saida'   => 'required|string', 
                'saida_lucro' => 'required|numeric|min:0',
                'tipo' => 'required|string|in:Gasto,Lucro', // O tipo deve ser 'Gasto' ou 'Lucro'
                
            ]);
            $monthlyEarningsController = new MonthlyEarningsController();
            $monthlyEarningsController->subtractFromEarnings($saidalucro['tipo'], $saidalucro['saida_lucro']);

            $createsaidaslucro = UpdateTotalLucroonSaida::create([
                'user_id' => Auth::id(),
                'nome_saida' =>  $saidalucro['nome_saida'],
                'saida_lucro' => $saidalucro['saida_lucro'],
                'tipo' => $saidalucro['tipo'],
                
            ]);

            return response()->json(['message' => 'Saidas added successfully']);
        } catch (\Exception $e) {
            // Log do erro
            \Log::error('Failed to add Saidas: ' . $e->getMessage());

            // Retornar uma resposta de erro
            return response()->json(['message' => 'Failed to add Saidas. Please try again later.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UpdateTotalLucroonSaida $updateTotalLucroonSaida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UpdateTotalLucroonSaida $updateTotalLucroonSaida)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UpdateTotalLucroonSaida $updateTotalLucroonSaida)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UpdateTotalLucroonSaida $updateTotalLucroonSaida)
    {
        //
    }
}
