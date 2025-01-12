<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['customers'] = Customer::latest()->paginate(10);

        return view('customers', $data);
        // return response([
        //     'customers' => $customers
        // ]);
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
        $fields = $request->validate([
            'branch_id' => 'required|max:255',
            'first_name' => 'required|max:255',
            'email' => 'required|email|unique:customers'
        ]);

        $user = Customer::create($fields);

        return [
            'user' => $user,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $user)
    {
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $fields = $request->validate([           
            'branch_id' => 'required|max:255',
            'first_name' => 'required|max:255',

            'email' => 'required|email',
            Rule::unique('customers')->ignore($customer)
        ]);

     

        $customer->update($fields);

        return [
            'customer' => $customer,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $user)
    {
        $user->delete();
        return [
            'message' => 'Data Deleted'
        ];
    }
}
