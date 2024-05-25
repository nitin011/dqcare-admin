<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicines;

class MedicinesController extends Controller {

    public function index(Request $request) {
        $length = 10;
        if (request()->get('length')) {
            $length = $request->get('length');
        }
        $medicines = Medicines::query();

        if ($request->get('search')) {
            $medicines->where(\DB::raw("name"), "like", '%' . request()->get('search') . '%')
                    ->orWhere(\DB::raw("company_name"), "like", '%' . request()->get('search') . '%')
                    ->orWhere(\DB::raw("content_name"), "like", '%' . request()->get('search') . '%')
                    ->orWhere(\DB::raw("types"), "like", '%' . request()->get('search') . '%')
                    ->orWhere(\DB::raw("abc"), "like", '%' . request()->get('search') . '%');
        }

        if ($request->get('asc')) {
            $medicines->orderBy($request->get('asc'), 'asc');
        }
        if ($request->get('desc')) {
            $medicines->orderBy($request->get('desc'), 'desc');
        }

        $medicines = $medicines->latest()->paginate($length);

        if ($request->ajax()) {
            return view('panel.medicines.load', ['medicines' => $medicines])->render();
        }

        return view('panel.medicines.index', compact('medicines'));
    }

    public function print(Request $request) {
        $medicines = collect($request->records['data']);
        return view('panel.medicines.print', ['medicines' => $medicines])->render();
    }

    public function create() {
        try {
            return view('panel.medicines.create');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function import() {
        try {
            return view('panel.medicines.import');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function storef(Request $request) {
        $file = $request->file('importfile');
        $fileContents = file($file->getPathname());

        try {
            foreach ($fileContents as $line) {
                $data = str_getcsv($line);
                $medicine = Medicines::create([
                            'name' => $data[0],
                            'company_name' => $data[1],
                            'content_name' => $data[2],
                            'types' => $data[3],
                            'abc' => $data[4],
                ]);
            }

            return redirect()->route('panel.medicines.index')->with('success', 'Medicine Added Successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    public function store(Request $request) {
        //    return $request->all();
        $this->validate($request, [
            'medicine_name' => 'required',
            'company_name' => 'required',
            'content_name' => 'required',
            'types' => 'required',
            'abc' => 'required',
        ]);

        try {
            $medicine = Medicines::create([
                        'name' => $request->medicine_name,
                        'company_name' => $request->company_name,
                        'content_name' => $request->content_name,
                        'types' => $request->types,
                        'abc' => $request->abc,
            ]);

            return redirect()->route('panel.medicines.index')->with('success', 'Medicine Added Successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    public function edit(Request $request) {
        try {
            $medicines = Medicines::where('id', $request->id)->first();

            return view('panel.medicines.edit', compact('medicines'));
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id) {
        // return $request->all();
        sleep(4);

        // Cases
        try {

            $chk = Medicines::where('id', $id)->update([
                // Summary
                'name' => $request->medicine_name,
                'company_name' => $request->company_name,
                'content_name' => $request->content_name,
                'types' => $request->types,
                'abc' => $request->abc,
            ]);

            return redirect()->route('panel.medicines.index')->with('success', 'Medicine Data Updated Successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    public function destroy(Request $request) {
        Medicines::where('id', $request->id)->delete();
        return back()->with('success', 'Medicine deleted successfully');
    }
}
