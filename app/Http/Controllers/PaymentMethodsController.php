<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodsController extends Controller
{
    /**
     * Display a listing of the payment methods.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return view('admin.payment_methods.index', compact('paymentMethods'))->with('user', auth()->user());
    }

    /**
     * Show the form for creating a new payment method.
     */
    public function create()
    {
        return view('admin.payment_methods.create')->with('user', auth()->user());
    }

    /**
     * Store a newly created payment method in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $paymentMethod = PaymentMethod::create($validatedData);
        return redirect()->route('paymentMethods.index')->with('success', 'Payment method created successfully');
    }

    /**
     * Remove the specified payment method from storage.
     */
    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::find($id);

        if (!$paymentMethod) {
            return redirect()->route('paymentMethods.index')->with('error', 'Payment method not found');
        }

        $paymentMethod->delete();
        return redirect()->route('paymentMethods.index')->with('success', 'Payment method deleted successfully');
    }
}
