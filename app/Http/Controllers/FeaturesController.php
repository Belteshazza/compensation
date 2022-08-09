<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Compensation;
use DB;

class FeaturesController extends Controller
{
    
    /**
   * get all paginated data

    */
    public function getCompensation(){

        $compensation = Compensation::Paginate(10);

        return response()->json([
            'message' => 'Successful',
            'data' => $compensation            
        ], 200);

    }


    /**
     * add New data
     */

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
            'data' => $compensation
        ],200);

    }


    /**
     * get a Single record
     */

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
            'message' => 'Congratulations You have Successfully updated a Record',
            'data' => $compensation
        ],201);

    }


     /**
     * get a Single record
     */

    public function getSingle($id){

        
        $compensation = Compensation::where('id', $id)->get()->first();

        return response()->json([
            'message' => 'Congratulations You have Successfully updated a Record',
            'data' => $compensation
        ],200);

    }



     /**
     * filter with multiple options and paginate
     */

    public function filter(Request $request)
    {
   
        $compensation = Compensation::query();

        $industry = $request->industry;
        $age = $request->age;
        $job = $request->job;
        $salary = $request->salary;
        $currency = $request->currency;
        $city = $request->city;
        $work_experience = $request->work_experience;

        if ($industry) {
            $compensation->where('industry','LIKE','%'.$industry.'%');
        }
        if ($age) {
            $compensation->where('age','LIKE','%'.$age.'%');
        }

        if ($job) {
            $compensation->where('job','LIKE','%'.$job.'%');
        }

        if ($salary) {
            $compensation->where('salary',$salary);
        }

        if ($currency) {
            $compensation->where('currency',$currency);
        }

        if ($city ) {
            $compensation->where('city',$city);
        }

        if ($work_experience) {
            $compensation->where('work_experience',$work_experience);
        }

        $data = [
            'industry' => $industry,
            'age' => $age,
            'job' => $job,
            'salary ' => $salary,
            'currency' => $currency,
            'city' => $city,
            'work_experience' => $work_experience,
            'compensation' => $compensation->Paginate(10),
        ];

        return response()->json([
            'message' => 'Successful',
            'data' => $data
        ],200);
    }


     /**
     * sort in Desending order with multiple columns
     */

    public function sortDesc(Request $request){


        $compensation =Compensation::orderByRaw("industry desc, age desc, job asc, salary desc, currency desc, city desc, work_experience desc, timestamp desc, created_at desc")->paginate(10); 
        
        //orderByRaw

        return response()->json([
            'message' => 'Successful',
            'data' => $compensation
       ],200);

    }


     /**
     * sort in Asending order with multiple columns
     */
    
    public function sortAsc(Request $request){

        $compensation =Compensation::orderByRaw("industry asc, age asc, job asc, salary asc, currency asc, city asc, work_experience asc, timestamp asc, created_at asc")->paginate(10); 
        
        //orderByRaw

        return response()->json([
            'message' => 'Successful',
            'data' => $compensation
       ],200);

    }


     /**
     * Average salary per city
     */

    public function avgCity(Request $request){

        $city = $request->input('city');

        //$result= DB::select('SELECT salary from compensation WHERE city = ?', [$request->city]);

        $data = [];

         $result= Compensation::where('city', $request->city)->get('salary');
         $data['average'] =  $result->avg('salary');
         $data['maxium'] =  $result->max('salary');
         $data['minium'] =  $result->min('salary');


        return response()->json([
            'message' => 'Successful',
            'data' => $data
        ],200);

    }

    

    /**
     * Average salary per role
     */

    public function avgRole(Request $request){

        $city = $request->input('job'); 

         $result= Compensation::where('job', $request->job)->get('salary');
         $data['average'] =  $result->avg('salary');
         

        return response()->json([
            'message' => 'Successfully',
            'data' => $data
       ],200);

    }
    
}
