<?php

namespace App\Http\Controllers;

use App\Models\MonthlyEarnings;
use App\Models\UpdateTotalLucroSaida;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MonthlyEarningsController extends Controller
{


    public function index()
{

    $monthlyEarnings = MonthlyEarnings::where('user_id', Auth::id())->get();
    return response()->json($monthlyEarnings);
}


    /**
     * Resetar o total_lucro de todos os usuários no começo de cada mês.
     */
    public function resetMonthlyEarnings()
    {
        try {
            // Pegar a data atual e o primeiro dia do mês
            $currentMonthStart = Carbon::now()->startOfMonth();

            // Buscar todos os registros de lucro mensal
            $monthlyEarnings = MonthlyEarnings::whereMonth('created_at', $currentMonthStart->month)
                                              ->whereYear('created_at', $currentMonthStart->year)
                                              ->get();

            if ($monthlyEarnings->isEmpty()) {
                return response()->json(['message' => 'No earnings data found for this month.'], 404);
            }

            // Resetar o total_lucro para todos os registros
            foreach ($monthlyEarnings as $earning) {
                $earning->total_lucro = 0;
                $earning->save();
            }

            return response()->json(['message' => 'Monthly earnings reset successfully.'], 200);
        } catch (\Exception $e) {
            \Log::error('Failed to reset monthly earnings: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to reset monthly earnings. Please try again later.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validar os dados recebidos
            $validatedData = $request->validate([
                'total_lucro' => 'required|numeric',
                'total_gasto' => 'required|numeric',
                'valor_corrida' => 'required|numeric',
            ]);
    
            // Pegar o ID do usuário autenticado
            $userId = Auth::id();
    
            // Pegar o mês e ano atuais
            $currentMonthStart = Carbon::now()->startOfMonth();
    
            // Buscar ou criar o registro mensal baseado no usuário e data do mês
            $monthlyEarnings = MonthlyEarnings::where('user_id', $userId)
                ->whereDate('created_at', '>=', $currentMonthStart)
                ->first();
    
            if ($monthlyEarnings) {
                // Se o registro já existir, incrementar o total_lucro
                $monthlyEarnings->total_lucro += $validatedData['total_lucro'];
                $monthlyEarnings->total_gasto += $validatedData['total_gasto'];
                $monthlyEarnings->valor_corrida  += $validatedData['valor_corrida'];
                $monthlyEarnings->save();
            } else {
                // Se não existir, criar um novo registro
                MonthlyEarnings::create([
                    'user_id' => $userId,
                    'total_lucro' => $validatedData['total_lucro'],
                    'total_gasto' => $validatedData['total_gasto'],
                    'valor_corrida' => $validatedData['valor_corrida'],
                ]);
            }
    
            return response()->json(['message' => 'Monthly earnings updated successfully'], 201);
        } catch (\Exception $e) {
            \Log::error('Failed to insert monthly earnings: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to insert monthly earnings. Please try again later.'], 500);
        }
    }

    public function subtractFromEarnings($tipo, $valor)
{
    $userId = Auth::id();
    $earnings = MonthlyEarnings::where('user_id', $userId)->first();

    if ($earnings) {
        if ($tipo === 'Gasto') {
            $earnings->total_gasto -= $valor;
        } elseif ($tipo === 'Lucro') {
            $earnings->total_lucro -= $valor;
        }
        // Subtrai do valor_corrida
        $earnings->valor_corrida -= $valor;
        
        $earnings->save();

        return true;
    }

    return false;
}

    
}
