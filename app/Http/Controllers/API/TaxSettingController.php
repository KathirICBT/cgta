<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TaxSetting;
use Illuminate\Http\Request;

class TaxSettingController extends Controller
{
    public function index()
    {
        return TaxSetting::latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'tax_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $tax = TaxSetting::create($request->all());
        return response()->json($tax, 201);
    }

    public function show($id)
    {
        return TaxSetting::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tax_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $tax = TaxSetting::findOrFail($id);
        $tax->update($request->all());
        return response()->json($tax);
    }

    public function destroy($id)
    {
        TaxSetting::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
