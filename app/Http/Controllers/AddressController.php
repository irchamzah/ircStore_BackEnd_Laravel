<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $data['is_primary'] = $request->has('is_primary') ? true : false;

        $request->validate([
            'full_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'is_primary' => 'nullable|boolean'
        ]);

        $user = User::findOrFail(auth()->id());

        if ($request->has('is_primary') && $request->input('is_primary')) {
            $user->addresses()->update(['is_primary' => false]);
        }

        $user->addresses()->create($request->all());

        return redirect()->route('account.profile')->with('success', 'Address added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'full_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'is_primary' => 'boolean',
        ]);

        $address = Address::findOrFail($id);
        $address->update($request->all());
        $user = User::findOrFail(auth()->id());

        // Update primary address
        if ($request->has('is_primary') && $request->is_primary) {
            $user->addresses()->update(['is_primary' => false]);
            $address->is_primary = true;
        }

        $address->save();

        return redirect()->route('account.profile')->with('success', 'Address updated successfully.');
    }


    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        $address->delete();

        return redirect()->route('account.profile')->with('success', 'Address deleted successfully.');
    }

    public function edit($id)
    {
        $address = Address::findOrFail($id);
        return view('account.addresses.edit', compact('address'));
    }
}
