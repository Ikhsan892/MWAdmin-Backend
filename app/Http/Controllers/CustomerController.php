<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function getAllCustomers(Request $request)
    {
        $data = Customer::all();

        return response()->json($data, 200);
    }
}
