<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Compensation;
use App\Models\Role;

class FeaturesController extends Controller
{

    /**
     * get all paginated data
     */
    public function getCompensation()
    {

        //   = Compensation::Paginate(10);

        $compensation = Compensation::join('role', 'compensation.role_id', '=', 'role.id')
            ->paginate(10);

        return response()->json([
            'message' => 'Successful',
            'data' => $compensation
        ], 200);

    }


    /**
     * add New data
     *
     */

    public function addNew(Request $request)
    {

        $request->validate([
            'industry' => ['required', 'string', 'max:255'],
            'age' => ['required', 'string'],
            'role_name' => ['required', 'string'],
            'salary' => ['required'],
            'currency' => ['required', 'string'],
            'city' => ['required', 'string'],
            'work_experience' => ['required', 'string']

        ]);


        $role = Role::create([
            'role_name' => $request->role_name,
            'salary' => $request->salary,
            'currency' => $request->currency,
        ]);

        $compensation = Compensation::create([
            'industry' => $request->industry,
            'age' => $request->age,
            'role_id' => $role->id,
            'city' => $request->city,
            'work_experience' => $request->work_experience,

        ], 200);


        return response()->json([
            'message' => 'Congratulations You have Successfully Added a New Record',
            'data' => [
                'compensation' => [
                    'industry' => $compensation->industry,
                    'age' => $compensation->age,
                    'role_id' => $compensation->role_id,
                    'city' => $compensation->city,
                    'work_experience' => $compensation->work_experience,
                ],
                'role' => $role
            ]
        ], 200);

    }


    /**
     * get a Single record
     */

    public function updateRecord(Request $request, $id)
    {

        $request->validate([
            'industry' => ['required', 'string', 'max:255'],
            'age' => ['required', 'string'],
            'role_name' => ['required'],
            'salary' => ['required', 'int'],
            'currency' => ['required', 'string'],
            'city' => ['required', 'string'],
            'work_experience' => ['required', 'string']

        ]);


        $role = Role::join('compensation', 'role.id', '=', 'compensation.id')
            ->where('role.id', $id)->first();

        $role->role_name = $request->role_name;
        $role->salary = $request->salary;
        $role->currency = $request->currency;

        $role->update();

        $compensation = Compensation::join('role', 'compensation.role_id', '=', 'role.id')
            ->where('compensation.role_id', $id)->first();

        $compensation->industry = $request->industry;
        $compensation->age = $request->age;
        $compensation->role_id = $role->id;
        $compensation->city = $request->city;
        $compensation->work_experience = $request->work_experience;

        $compensation->update();

        return response()->json([
            'message' => 'Congratulations You have Successfully updated a Record',
            'data' => $role,
            'data' => $compensation,
        ], 201);

    }


    /**
     * get a Single record
     */

    public function getSingle($id)
    {

        $compensation = Compensation::join('role', 'compensation.role_id', '=', 'role.id')
            ->where('compensation.role_id', $id)->get()->first();


        return response()->json([
            'message' => 'Successfully',
            'data' => $compensation
        ], 200);

    }


    /**
     * filter with multiple options and paginate
     */

    public function filter(Request $request)
    {

        $compensation = Compensation::query()->join('role', 'compensation.role_id', '=', 'role.id');

        $industry = $request->industry;
        $age = $request->age;
        $role_name = $request->role_name;
        $salary = $request->salary;
        $currency = $request->currency;
        $city = $request->city;
        $work_experience = $request->work_experience;

        if ($industry) {
            $compensation->where('industry', 'LIKE', '%' . $industry . '%');
        }
        if ($age) {
            $compensation->where('age', 'LIKE', '%' . $age . '%');
        }

        if ($role_name) {
            $compensation->where('job_name', 'LIKE', '%' . $role_name . '%');
        }

        if ($salary) {
            $compensation->where('salary', $salary);
        }

        if ($currency) {
            $compensation->where('currency', $currency);
        }

        if ($city) {
            $compensation->where('city', $city);
        }

        if ($work_experience) {
            $compensation->where('work_experience', $work_experience);
        }

        $data = [
            'industry' => $industry,
            'age' => $age,
            'role_name' => $role_name,
            'salary ' => $salary,
            'currency' => $currency,
            'city' => $city,
            'work_experience' => $work_experience,
            'compensation' => $compensation->Paginate(10),
        ];

        return response()->json([
            'message' => 'Successful',
            'data' => $data
        ], 200);
    }


    /**
     * sort in Desending order with multiple columns
     */

    public function sortDesc(Request $request)
    {


        $compensation = Compensation::orderByRaw("industry desc, age desc, role_name asc, salary desc, currency desc, city desc, work_experience desc, compensation.timestamp desc, compensation.created_at desc")->join('role', 'compensation.role_id', '=', 'role.id')->paginate(10);

        //orderByRaw

        return response()->json([
            'message' => 'Successful',
            'data' => $compensation
        ], 200);

    }


    /**
     * sort in Asending order with multiple columns
     */

    public function sortAsc(Request $request)
    {

        $compensation = Compensation::orderByRaw("industry asc, age asc, role_name asc, salary asc, currency asc, city asc, work_experience asc, compensation.timestamp asc, compensation.created_at asc")->join('role', 'compensation.role_id', '=', 'role.id')->paginate(10);

        //orderByRaw

        return response()->json([
            'message' => 'Successful',
            'data' => $compensation
        ], 200);

    }


    /**
     * Average salary per city
     */

    public function avgCity(Request $request)
    {

        $city = $request->input('city');

        //$result= DB::select('SELECT salary from compensation WHERE city = ?', [$request->city]);

        $data = [];

        $result = Compensation::join('role', 'compensation.role_id', '=', 'role.id')
            ->where('city', $request->city)->get('salary');
        $data['average'] = $result->avg('salary');
        $data['maxium'] = $result->max('salary');
        $data['minium'] = $result->min('salary');


        return response()->json([
            'message' => 'Successful',
            'data' => $data
        ], 200);

    }


    /**
     * Average salary per role
     */

    public function avgRole(Request $request)
    {

        $role_name = $request->input('role_name');

        $result = Role::where('role_name', $request->role_name)->get('salary');
        $data['average'] = $result->avg('salary');


        return response()->json([
            'message' => 'Successfully',
            'data' => $data
        ], 200);

    }

}
