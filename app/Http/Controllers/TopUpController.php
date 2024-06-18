<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\TopUp;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopUpController extends Controller
{
    // User
    public function create()
    {
        $paymentMethods = PaymentMethod::all();
        return view('topups.create', compact('paymentMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $adminFee = $this->generateAdminFee();
        $totalAmount = $validated['amount'] + $adminFee;
        $invoice = $this->generateInvoiceNumber();

        $topUp = TopUp::create([
            'user_id' => Auth::id(),
            'payment_method_id' => $validated['payment_method_id'],
            'amount' => $validated['amount'],
            'admin_fee' => $adminFee,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'invoice' => $invoice,
        ]);

        return redirect()->route('topups.detail', $topUp->id);
    }

    private function generateAdminFee()
    {
        return rand(1, 10);
    }

    private function generateInvoiceNumber()
    {
        return 'TP-' . strtoupper(uniqid());
    }

    public function detail($id)
    {
        $topUp = TopUp::with('paymentMethod')->findOrFail($id);
        return view('topups.detail', compact('topUp'));
    }

    public function uploadProof(Request $request, $id)
    {
        $validated = $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        $topUp = TopUp::findOrFail($id);
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $topUp->update(['payment_proof' => $path]);

        return back()->with('success', 'Payment proof uploaded successfully.');
    }

    public function index()
    {
        $topUps = TopUp::where('user_id', Auth::id())->paginate(10);
        return view('topups.index', compact('topUps'));
    }

    public function adminIndex()
    {
        $topUps = TopUp::where('status', 'pending')->paginate(10);
        return view('topups.indexAdmin', compact('topUps'));
    }

    public function approve(TopUp $topUp)
    {
        $topUp->update(['status' => 'approved']);

        $user = $topUp->user;

        // Saldo sebelum transaksi
        $balanceBefore = $user->balance;

        // Tambahkan saldo pengguna
        $user->balance += $topUp->amount;
        $user->save();

        // Saldo setelah transaksi
        $balanceAfter = $user->balance;

        // Buat riwayat transaksi
        Transaction::create([
            'user_id' => $topUp->user_id,
            'type' => 'topup',
            'amount' => $topUp->total_amount,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'description' => 'Top-up approved',
        ]);

        return back()->with('success', 'Top-up approved and balance updated.');
    }

    public function reject(TopUp $topUp)
    {
        $topUp->update(['status' => 'rejected']);
        return back()->with('success', 'Top-up rejected.');
    }

    public function generateInvoice($id)
    {
        $topUp = TopUp::with('paymentMethod')->findOrFail($id);

        $invoiceData = [
            'id' => $topUp->id,
            'user' => $topUp->user->name,
            'paymentMethod' => $topUp->paymentMethod->name,
            'amount' => $topUp->amount,
            'adminFee' => $topUp->admin_fee,
            'totalAmount' => $topUp->total_amount,
            'status' => $topUp->status,
            'createdAt' => $topUp->created_at,
        ];

        return view('topups.invoice', compact('invoiceData'));
    }
}
