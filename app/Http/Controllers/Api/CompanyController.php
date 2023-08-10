<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Mail\NewCompanyNotification;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\CompanyResource;




class CompanyController extends Controller
{
    public function index(Request $request)
    {

        $companies = Company::paginate(10); // Change the number '10' to your desired items per page
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


        // Send email notification
        Mail::to('hassanshahzadaheer@gmail.com')->send(new NewCompanyNotification());

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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'website' => 'nullable|string|max:255',

        ]);

        // If validation fails, return the error response
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Find the company record
        $company = Company::findOrFail($id);

        // Update other fields like name, email, and website
        $company->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'website' => $request->input('website'),
        ]);

        // Handle the logo file upload (if provided)

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('public/logos');
            // Update the database logo field with the new path
            $company->update(['logo' => $request->input('modifiedLogoFilename')]);
        }


        return response()->json(['message' => 'Company updated successfully', 'data' => $company], 200);
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
