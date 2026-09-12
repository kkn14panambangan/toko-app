<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentCallbackController extends Controller
{
    public function receive(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            $transaction = Transaction::where('kode_transaksi', $request->order_id)->first();
            
            if ($transaction) {
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    $transaction->update(['status' => 'success']);
                } else if ($request->transaction_status == 'cancel' || $request->transaction_status == 'deny' || $request->transaction_status == 'expire') {
                    $transaction->update(['status' => 'cancelled']);
                } else if ($request->transaction_status == 'pending') {
                    $transaction->update(['status' => 'pending']);
                }
            }
            
            return response()->json(['message' => 'Callback received']);
        }
        
        return response()->json(['message' => 'Invalid signature'], 403);
    }
}
