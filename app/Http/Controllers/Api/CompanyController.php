<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

use Validator;



class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return CompanyResource::collection($companies);
    }

    // store data
    public function store(Request $request)
    {


        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'website' => 'nullable|string|max:255',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=100,min_height=100|nullable',
        ]);

        // Handle the logo file upload (if provided)
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('public/logos');
            $validatedData['logo'] = $logoPath;
        }


        // Create and store the new company record
        $company = Company::create($validatedData);


        return response()->json(['message' => 'Company created successfully', 'data' => $company], 201);
    }
    public function show($companyId)
    {
        $company = Company::findOrFail($companyId);
        return response()->json(['data' => $company]);
    }

    public function update(Request $request, $id)
    {

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'website' => 'nullable',
        ]);


        // If validation fails, return the error response
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Update the company record with the new data
        $affectedRows = Company::where('id', $id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'website' => $request->input('website'),
        ]);

        // Check if any rows were affected by the update
        if ($affectedRows > 0) {
            // Find and return the updated company record
            $company = Company::find($id);
            return response()->json(['message' => 'Company updated successfully', 'data' => $company], 200);
        } else {
            // If the company doesn't exist, return an error response
            return response()->json(['message' => 'Company not found'], 404);
        }
    }


     public function destroy($id)
    {
        try {
            $company = Company::findOrFail($id);
            $company->delete();

            return response()->json(['message' => 'Company deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete company'], 500);
        }
    }
}
