<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Add this line for Storage

class CompanyController extends Controller
{
    // Store a new Company
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|email|max:255|unique:companies,email',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'region_id' => 'required|exists:regions,id',
            'province' => 'nullable|string',
            'city' => 'nullable|string',
            'country' => 'nullable|string',
            'description' => 'nullable|string',
            'joinDate' => 'nullable|date',
            'services' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        if ($request->hasFile('logo')) {
            $photoPath = $request->file('logo')->store('uploads/companies', 'public');
            $validated['logo'] = '/storage/' . $photoPath;
        }

        $company = Company::create($validated);

        return response()->json($company, 201); // Return the company object with a 201 Created status
    }

    // Get all companies
    public function index()
    {
        $companies = Company::all();
        return response()->json($companies, 200); // Return all companies with a 200 OK status
    }

    // Get a single company by ID
    public function show($id)
    {
        $company = Company::findOrFail($id);
        return response()->json($company, 200); // Return the company data
    }

    // Update a company's information
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
    
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'nullable|email|max:255|unique:companies,email,' . $company->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'region_id' => 'nullable|exists:regions,id',
            'province' => 'nullable|string',
            'city' => 'nullable|string',
            'country' => 'nullable|string',
            'description' => 'nullable|string',
            'joinDate' => 'nullable|date',
            'services' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
        ]);
    
        // ✅ Handle logo file update
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/companies', $filename, 'public');
    
            // Delete old logo if exists
            if ($company->logo && Storage::disk('public')->exists(str_replace('/storage/', '', $company->logo))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $company->logo));
            }
    
            // ✅ Set proper logo path
            $validated['logo'] = '/storage/' . $path;
        }
    
        $company->update($validated);
    
        return response()->json($company, 200);
    }
    

    // Delete a company
    public function destroy($id)
    {
        $company = Company::findOrFail($id);

        // Optional: Delete the logo file before deleting the company
        if ($company->logo) {
            $existingPath = str_replace('/storage/', '', $company->logo);
            Storage::disk('public')->delete($existingPath);
        }

        $company->delete();

        return response()->json(['message' => 'Company deleted successfully'], 200); // Success message
    }

    // Activate a company
    public function activate($id)
    {
        $company = Company::findOrFail($id);
        $company->activate(); // Calls the 'activate' method on the model to set the status to 'active'

        return response()->json(['message' => 'Company activated successfully'], 200); // Success message
    }

    // Get the active subscription of a company
    public function getActiveSubscription($id)
    {
        $company = Company::findOrFail($id);
        $activeSubscription = $company->activeSubscription;

        if ($activeSubscription) {
            return response()->json($activeSubscription, 200);
        } else {
            return response()->json(['message' => 'No active subscription found'], 404);
        }
    }
}
