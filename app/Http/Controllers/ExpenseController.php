<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function addExpenses(Request $request)
    {
        $request->validate([
            'gastos' => 'required|array',
            'gastos.*.name' => 'required|string|max:255',
            'gastos.*.amount' => 'required|numeric|min:0',
        ]);

        $totalAmount = 0;

        foreach ($request->gastos as $gasto) {
            $totalAmount += $gasto['amount'];
        }

        $expense = Expense::create([
            'user_id' => Auth::id(),
            'gastos' => $request->gastos,
            'amount' => $totalAmount,
        ]);

        return response()->json(['message' => 'Expenses added successfully', 'totalAmount' => $totalAmount, 'id' => $expense->id], 201);
    }

    public function getExpenses()
    {
        $expenses = Auth::user()->expenses;
        return response()->json($expenses, 200);
    }

    public function updateExpense(Request $request, $id)
    {
        $request->validate([
            'gastos' => 'required|array',
            'gastos.*.name' => 'required|string|max:255',
            'gastos.*.amount' => 'required|numeric|min:0',
        ]);

        $expense = Expense::findOrFail($id);

        if ($expense->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $totalAmount = 0;

        foreach ($request->gastos as $gasto) {
            $totalAmount += $gasto['amount'];
        }

        $expense->gastos = $request->gastos;
        $expense->amount = $totalAmount;
        $expense->save();

        return response()->json(['message' => 'Expense updated successfully', 'totalAmount' => $totalAmount], 200);
    }
}
