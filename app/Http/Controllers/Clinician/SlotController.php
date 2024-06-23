<?php

namespace App\Http\Controllers\Clinician;

use App\Http\Controllers\Controller;
use App\Http\Resources\SlotRS;
use App\Models\Slot;
use Illuminate\Http\Request;
use App\Http\Requests\{
    SlotStoreRequest,
    SlotUpdateRequest
};
use Illuminate\Support\Facades\{
    Auth,
    Session
};

class SlotController extends Controller
{
    function index() {
        return view('clinician_slot_details');
    }

    function getSlots(Request $request) {
        $slots = Slot::where('clinician_id',$this->loginClinician()['id'])
            ->whereDate('start_time' , '>=', $request->start)
            ->whereDate('end_time', '<=', $request->end)->get();

        return response()->json([
            'status' => true,
            'data' => SlotRS::collection($slots) 
        ]);
    }

    function getSlot($id) {
        $slot = Slot::find($id);
        if ($slot) {
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $slot
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Slot not found',
        ]);
    }

    function store(SlotStoreRequest $request)  {
        $request->validated();

        try {
            $slot = new Slot();
            $slot->clinician_id = Auth::guard('clinician')->user()->id;
            $slot->date = $request->slot_date;
            $slot->start_time = $request->start_time;
            $slot->end_time = $request->end_time;
            $slot->save();

            Session::flash('message','Slot Successfully created');
            return redirect()->back();

        } catch (\Exception $ex) {
            Session::flash('message',$ex->getMessage());
            return redirect()->back();
        }

    }

    function Update($id, SlotUpdateRequest $request) {
        $request->validated();
        $slot = Slot::find($id);
        if ($slot) {
            $slot->date = $request->slot_date;
            $slot->start_time = $request->start_time;
            $slot->end_time = $request->end_time;
            $slot->save();
            Session::flash('message','Slot successfully updated');
            return redirect()->back();
        }
        Session::flash('message','Slot not found');
        return redirect()->back();
        
    }

    function delete($id) {
        $slot = Slot::find($id);
        if ($slot) {
            $slot->delete();

            return response()->json([
                'status' => true,
                'message' => 'Slot Deleted Successfully'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Slot Not found'
        ]);
    }
}
