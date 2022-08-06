<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Compensation;

class FeaturesController extends Controller
{
    //
    public function getCompensation(){

        $compensation = Compensation::paginate(10);

        return response()->json([
            'message' => 'Successful',
            'compensation' => $compensation,            
        ], 200);

    }

    public function addNew(Request $request){

        $request->validate([
            'industry' => ['required', 'string', 'max:255'],
            'age' => ['required', 'string'],
            'job' => ['required'],
            'salary' => ['required', 'string'],
            'currency' => ['required', 'string'],
            'city' => ['required', 'string'],
            'work_experience' => ['required', 'string']

        ]);

        $compensation = new Compensation;
        $compensation->industry = $request->industry;
        $compensation->age = $request->age;
        $compensation->job = $request->job;
        $compensation->salary = $request->salary;
        $compensation->currency = $request->currency;
        $compensation->city = $request->city;
        $compensation->work_experience = $request->work_experience;


        $compensation->save();

        return response()->json([
            'message' => 'Congratulations You have Successfully Added a New Record',
            'compensation' => $compensation
        ]);

    }

    public function updateRecord(Request $request, $id){

        $request->validate([
            'industry' => ['required', 'string', 'max:255'],
            'age' => ['required', 'string'],
            'job' => ['required'],
            'salary' => ['required', 'int'],
            'currency' => ['required', 'string'],
            'city' => ['required', 'string'],
            'work_experience' => ['required', 'string']

        ]);
         
        $compensation= Compensation::where('id', $id)->first();

        $compensation->industry = $request->industry;
        $compensation->age = $request->age;
        $compensation->job = $request->job;
        $compensation->salary = $request->salary;
        $compensation->currency = $request->currency;
        $compensation->city = $request->city;
        $compensation->work_experience = $request->work_experience;


        $compensation->save();

        return response()->json([
            'message' => 'Congratulations You have Successfully Added a New Record',
            'compensation' => $compensation
        ]);

    }
}
