<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZoneRequest;
use App\Models\Country;
use App\Models\State;
use App\Models\Zone;


class ZoneController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:manage_zones'])->only('index', 'create', 'edit', 'destroy');
    }

    public function index()
    {
        $zones = Zone::latest()->paginate(10);
        return view('backend.setup_configurations.zones.index', compact('zones'));
    }


    public function create()
    {
        $states = State::where('status', 1)->where('zone_id', 0)->get();
        return view('backend.setup_configurations.zones.create', compact('states'));
    }


    public function store(ZoneRequest $request)
    {
        $zone = Zone::create($request->only(['name', 'status']));

        foreach ($request->state_id as $val) {
            State::where('id', $val)->update(['zone_id' => $zone->id]);
        }

        flash(translate('Zone has been created successfully'))->success();
        return redirect()->route('zones.index');
    }

    public function edit(Zone $zone)
    {
        $states = State::where('status', 1)
            ->where(function ($query) use ($zone) {
                $query->where('zone_id', 0)
                    ->orWhere('zone_id', $zone->id);
            })
            ->get();
        return view('backend.setup_configurations.zones.edit', compact('states', 'zone'));
    }


    public function update(ZoneRequest $request, Zone $zone)
    {
        $zone->update($request->only(['name']));

        State::where('zone_id', $zone->id)->update(['zone_id' => 0]);
        foreach ($request->state_id as $val) {
            State::where('id', $val)->update(['zone_id' => $zone->id]);
        }

        flash(translate('Zone has been update successfully'))->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $zone = Zone::findOrFail($id);

        State::where('zone_id', $zone->id)->update(['zone_id' => 0]);

        Zone::destroy($id);

        flash(translate('Zone has been deleted successfully'))->success();
        return redirect()->route('zones.index');
    }
}
