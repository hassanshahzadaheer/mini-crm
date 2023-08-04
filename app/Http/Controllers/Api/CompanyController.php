<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index() {
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
}
