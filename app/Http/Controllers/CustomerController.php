<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with(['offertes', 'facturen', 'contracts'])->get();
        return view('sales.customerIndex')->with('customers',$customers);
    }

    public function create(){
        return view('sales.createCustomer');
   }

   public function store(Request $request)
    {
        $validated = $request->validate([
            'name_company' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone_number' => 'required|regex:/^[0-9\s\-\+()]{7,20}$/',
            'bkr_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'zipcode' => 'required|regex:/^[0-9]{4}\s?[A-Z]{2}$/i|max:10',
            'notes' => 'nullable|string|max:1000',
        ]);

        $newCustomer = new Customer();
        $newCustomer->name_company = $validated['name_company'];
        $newCustomer->contact_person = $validated['contact_person'];
        $newCustomer->email = $validated['email'];
        $newCustomer->phone_number = $validated['phone_number'];
        $newCustomer->bkr_number = $validated['bkr_number'];
        $newCustomer->address = $validated['address'];
        $newCustomer->city = $validated['city'];
        $newCustomer->zipcode = $validated['zipcode'];
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
        $validated = $request->validate([
            'name_company' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone_number' => 'required|regex:/^[0-9\s\-\+()]{7,20}$/',
            'bkr_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'zipcode' => 'required|regex:/^[0-9]{4}\s?[A-Z]{2}$/i|max:10',
            'notes' => 'nullable|string|max:1000',
        ]);

        $customer->name_company = $validated['name_company'];
        $customer->contact_person = $validated['contact_person'];
        $customer->email = $validated['email'];
        $customer->phone_number = $validated['phone_number'];
        $customer->bkr_number = $validated['bkr_number'];
        $customer->address = $validated['address'];
        $customer->city = $validated['city'];
        $customer->zipcode = $validated['zipcode'];
        $customer->notes = $validated['notes'];
        $customer->save();

        return redirect()->route('customers.show', $customer->id);
    }
}
