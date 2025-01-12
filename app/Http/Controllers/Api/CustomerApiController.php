<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */ 

    public function index()
    {
        $data = Customer::latest()->paginate(10);

        $totalCustomerCount = Customer::count();
        $totalMaleCustomerCount = Customer::where('gender', 'M')->count();
        $totalFemaleCustomerCount = Customer::where('gender', 'F')->count();

        return response()->json([
            'data' => $data->items(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'total_customer_count' => $totalCustomerCount,
            'total_male_customer_count' => $totalMaleCustomerCount,
            'total_female_customer_count' => $totalFemaleCustomerCount,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'branch_id' => 'required|max:255',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:customers',
            'phone' => 'required',
            'gender' => 'required'


        ]);

        $customer = Customer::create($fields);

        return [
            'customer' => $customer,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
