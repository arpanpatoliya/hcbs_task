<?php

namespace App\Http\Controllers\Clinician;

use App\Http\Controllers\Controller;
use App\Http\Resources\SlotRS;
use App\Models\{
    Slot,
    Clinician,
    Appointment
};
use Illuminate\Http\Request;
use App\Http\Requests\{
    SlotStoreRequest,
    SlotUpdateRequest,
    AppointmentSaveRequest
};
use Illuminate\Support\Facades\{
    Auth,
    Session,
    Storage
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

    function saveAppointment(Slot $slot, AppointmentSaveRequest $request) {
        $request->validated();
        try {
            $data = $request->signature;
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $filename = uniqid() . '.png';

            $path = 'public/signatures/' . $filename;
            Storage::put($path, $data);

            $appointment = new Appointment();
            $appointment->slot_id = $slot->id;
            $appointment->clinician_id = $slot->clinician_id;
            $appointment->name = $request->name;
            $appointment->email = $request->email;
            $appointment->phone_number = $request->phone_number;
            $appointment->signature = $filename;
            $appointment->save();

            $slot->is_booked = 1;
            $slot->save();
            Session::flash('message','Appointment Request Submit, Your Appointment No Is :- ' . $appointment->appointment_no);
            return redirect()->back();
        } catch (\Exception $ex) {
            Session::flash('message',$ex->getMessage());
            return redirect()->back();   
        }

    }

    function getSlot($id) {
        $slot = Slot::with('clinician:id,email,name,occupation,gender')->find($id);
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

    function slots() {
        $clinician = Clinician::pluck('name','id');
        return view('slots',compact('clinician'));
    }

    function slotAjax(Request $request) {
        $slots = Slot::where('clinician_id',$request->clinician_id)
            ->where('is_booked',0)
            ->whereDate('start_time' , '>=', $request->start)
            ->whereDate('end_time', '<=', $request->end)->get();

        return response()->json([
            'status' => true,
            'data' => SlotRS::collection($slots) 
        ]);
    }

    function appointment()  {
        return view('search-appointment');
    }

    function getAppointment(Request $request) {
        $appt = Appointment::where('appointment_no',$request->appointment_no)->with(['slot','clinician'])->first();
        if ($appt) {
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $appt
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'appointment not found',
            ]);
        }
    }

}
