<?php

namespace App\Http\Controllers\Clinician;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentRS;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class AppointmentController extends Controller
{
    function index() {
        return view('clinician_appointment_details');
    }

    function getAppointments(Request $request) {
        $slots = Appointment::select('appointments.*','slots.start_time', 'slots.end_time','slots.date','slots.is_booked')->where('appointments.clinician_id',$this->loginClinician()['id'])
            ->join('slots','slot_id','=','slots.id')
            ->whereDate('slots.start_time' , '>=', $request->start)
            ->whereDate('slots.end_time', '<=', $request->end)->get();

        return response()->json([
            'status' => true,
            'data' => AppointmentRS::collection($slots) 
        ]);
    }

    
    function getSingleAppointment($appointment) {
        $appointment = Appointment::with('slot','clinician')->find($appointment);
        if ($appointment) {
            return response()->json([
                'status' => true,
                'message' => 'appointment details',
                'data' => $appointment
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'appointment Not found',
        ]);
    }

    function appointmentStatus($id, Request $request)  {

        $appointment = Appointment::find($id);
        if ($appointment) {
            $appointment->appointment_status = $request->status;
            $appointment->save();

            if ($appointment->fcm_token) {
                $messaging = app('firebase');
                $body = 'Your Appointment '. $appointment->appointment_no.' has been ' .$request->status;
    
                $message = CloudMessage::withTarget('token', $appointment->fcm_token)
                ->withNotification(Notification::create('Appointment Update', $body)); 
                try {
                    $response = $messaging->send($message);
                    Session::flash('message','successfully updated');
                    return redirect()->back();
                } catch (\Kreait\Firebase\Exception\Messaging\NotFound $e) {
                    Session::flash('message','Requested entity was not found.');
                    return redirect()->back();

                } 
            }
            Session::flash('message','successfully updated');
        }
        Session::flash('message','Appointment not found');
        return redirect()->back();

    }
}
