<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diagnosis;

class DiagnosesController extends Controller {

    public function index(Request $request) {
        $length = 10;
        if (request()->get('length')) {
            $length = $request->get('length');
        }
        $diagnosis = Diagnosis::query();

        if ($request->get('search')) {
            $diagnosis->where(\DB::raw("name"), "like", '%' . request()->get('search') . '%');
        }

        if ($request->get('asc')) {
            $symptoms->orderBy($request->get('asc'), 'asc');
        }
        if ($request->get('desc')) {
            $diagnosis->orderBy($request->get('desc'), 'desc');
        }

        $diagnosis = $diagnosis->latest()->paginate($length);

        if ($request->ajax()) {
            return view('panel.diagnosis.load', ['diagnosis' => $diagnosis])->render();
        }

        return view('panel.diagnosis.index', compact('diagnosis'));
    }

    public function create() {
        try {
            return view('panel.diagnosis.create');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function store(Request $request) {
        //    return $request->all();
        $this->validate($request, [
            'name' => 'required',
        ]);

        try {
            $diagnosis = Diagnosis::create([
                        'name' => $request->name,
            ]);

            return redirect()->route('panel.diagnosis.index')->with('success', 'Diagnosis Added Successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    public function import() {
        try {
            return view('panel.diagnosis.import');
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
                $diagnosis = Diagnosis::create([
                            'name' => $data[0],
                ]);
            }

            return redirect()->route('panel.diagnosis.index')->with('success', 'Diagnosis Added Successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    public function edit(Request $request) {
        try {
            $diagnosis = Diagnosis::where('id', $request->id)->first();

            return view('panel.diagnosis.edit', compact('diagnosis'));
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id) {
        // return $request->all();
        sleep(4);

        // Cases
        try {

            $chk = Diagnosis::where('id', $id)->update([
                // Summary
                'name' => $request->name,
            ]);

            return redirect()->route('panel.diagnosis.index')->with('success', 'Diagnosis Data Updated Successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    public function destroy(Request $request) {
        Diagnosis::where('id', $request->id)->delete();
        return back()->with('success', 'Diagnosis deleted successfully');
    }
}
