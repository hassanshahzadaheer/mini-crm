<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::paginate(10); // Change the number '10' to your desired items per page
        return EmployeeResource::collection($employees);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        // If validation fails, return the error response
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Create and store the new employee record
        $employee = Employee::create($validator->validated());

        return response()->json(['message' => 'Employee created successfully', 'data' => $employee], 201);
    }

    public function show($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        return response()->json(['data' => $employee]);
    }

    public function update(Request $request, $employeeId)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        // If validation fails, return the error response
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Find the employee record
        $employee = Employee::findOrFail($employeeId);

        // Update fields
        $employee->update($validator->validated());

        return response()->json(['message' => 'Employee updated successfully', 'data' => $employee], 200);
    }

    public function destroy($employeeId)
    {
        try {
            $employee = Employee::findOrFail($employeeId);
            $employee->delete();

            return response()->json(['message' => 'Employee deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete employee'], 500);
        }
    }
}
