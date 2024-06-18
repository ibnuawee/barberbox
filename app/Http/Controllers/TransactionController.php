<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TransactionController extends Controller
{
    //
    public function saldoUser()
    {
        $transactions = Transaction::where('user_id', Auth::id())->paginate(10);
        return view('transactions.user', compact('transactions'));
    }

    public function saldoBarber()
    {
        if(Gate::denies('barber-saldo')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
        $transactions = Transaction::where('user_id', Auth::id())->paginate(10);
        return view('barbers.saldo', compact('transactions'));
    }

    public function saldoAdmin(Request $request)
    {
        if(Gate::denies('admin-saldo')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
        $transactions = DB::table('transactions')
            ->when($request->input('search'), function($query,$search){
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('role', 'like', '%' . $search . '%');
            })->paginate(10);
        return view('transactions.admin', compact('transactions'));

    }
}
