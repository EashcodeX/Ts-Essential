<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Area;

class RegistrationStep2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showForm()
    {
        $user = Auth::user();
        // Fetch active countries
        $countries = Country::where('status', 1)->get();
        return view('auth.boxed.registration_step2', compact('user', 'countries'));
    }

    public function store(Request $request)
    {
        $user = User::find(Auth::id());

        $rules = [
            'address' => 'required|string|max:255',
            'country_id' => 'required',
            // 'country_code' => 'required|string|max:10', // Removed field validation
            'gender' => 'required|in:male,female,other',
            'secondary_phone' => 'nullable|string|max:50',
        ];

        if (empty($user->phone)) {
            $rules['phone'] = 'required|string|max:50|unique:users,phone,' . $user->id;
        }

        $request->validate($rules);

        $user->address = $request->address;

        // Convert IDs to Names (Strings) for storage in users table
        $country = Country::find($request->country_id);
        $user->country = $country ? $country->name : null;

        $state = State::find($request->state_id);
        $user->state = $state ? $state->name : null;

        $city = City::find($request->city_id);
        $user->city = $city ? $city->name : null;

        // Area can be from dropdown (area_id) or direct text input (area)
        if ($request->has('area_id') && !empty($request->area_id)) {
            $area = Area::find($request->area_id);
            $user->area = $area ? $area->name : $request->area;
        } else {
            $user->area = $request->area;
        }

        // $user->country_code = $request->country_code;
        $user->postal_code = $request->postal_code;
        $user->gender = $request->gender;
        $user->secondary_phone = $request->secondary_phone;

        if (empty($user->phone)) {
            $user->phone = $request->phone;
        }

        $user->save();

        flash(translate('Registration completed successfully.'))->success();

        if ($user->user_type == 'seller') {
            return redirect()->route('seller.dashboard');
        }
        return redirect()->route('dashboard');
    }
}
