<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('sales.customerIndex')->with('customers',$customers);
    }

    public function create(){
        return view('sales.createCustomer');
   }

   public function store(Request $request)
    {
        $newCustomer = new Customer();
        $newCustomer->name_company = $request->name_company;
        $newCustomer->contact_person = $request->contact_person;
        $newCustomer->email = $request->email;
        $newCustomer->phone_number = $request->phone_number;
        $newCustomer->bkr_number = $request->bkr_number;
        $newCustomer->address = $request->address;
        $newCustomer->city = $request->city;
        $newCustomer->zipcode = $request->zipcode;
        $newCustomer->bkr_status = 'pending';
        $newCustomer->save();

        return redirect()->route('customers.index');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    public function goToEdit(Customer $customer)
    {
        return view('sales.editCustomer', ['customer' => $customer]);
    }

    public function show(Customer $customer)
    {
        return view('sales.showCustomer', ['customer' => $customer]);
    }

    public function edit(Customer $customer, Request $request)
    {
        $customer->name_company = $request->name_company;
        $customer->contact_person = $request->contact_person;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->bkr_number = $request->bkr_number;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->zipcode = $request->zipcode;
        $customer->notes = $request->notes;
        $customer->save();

        return redirect()->route('customers.show', $customer->id);
    }
}
