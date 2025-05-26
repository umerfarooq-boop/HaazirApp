<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlumberAppointment;
use Illuminate\Support\Facades\Auth;

class PlumberAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $plumber = new PlumberAppointment();
        $plumber->plumber_p_id = $request->plumber_p_id;
        $plumber->user_p_id = $request->user_p_id;
        $plumber->description = $request->description;
        $plumber->status = 'inactive';
        $plumber->created_by = Auth::id();
        $destinationPath = public_path('uploads/plumber_appointment_image');

        if ($request->hasFile('p_problem_image')) {
            $destinationPath = public_path('uploads/plumber_appointment_image');
            $plumberImage = $request->file('p_problem_image');
            $imageName = time() . '.' . $plumberImage->getClientOriginalExtension();
            $plumberImage->move($destinationPath, $imageName);
            $plumber->p_problem_image = $imageName;
        }
        $plumber->save();

        return response()->json([
            'success' => true,
            'message' => 'Record Store Successfully',
            'plumber' => $plumber
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Appointment = PlumberAppointment::where('plumber_p_id',$id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Record Found',
            'Appointment' => $Appointment
        ],201);
    }

    public function Accpet_P_Appointment(Request $request,$id){
        $appointment = PlumberAppointment::find($id);
        if($request->status === 'accept'){
            $appointment->status = 'accept';
        }
        
        if($request->status === 'reject'){
            $appointment->status = 'reject';
        }
        $appointment->save();

        return response([
            'success' => true,
            'message' => 'Status Update',
            'appointment' => $appointment
        ],201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
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
