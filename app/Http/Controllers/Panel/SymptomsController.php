<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Symptoms;

class SymptomsController extends Controller {

    public function index(Request $request) {
        $length = 10;
        if (request()->get('length')) {
            $length = $request->get('length');
        }
        $symptoms = Symptoms::query();

        if ($request->get('search')) {
            $symptoms->where(\DB::raw("name"), "like", '%' . request()->get('search') . '%');
        }

        if ($request->get('asc')) {
            $symptoms->orderBy($request->get('asc'), 'asc');
        }
        if ($request->get('desc')) {
            $symptoms->orderBy($request->get('desc'), 'desc');
        }

        $symptoms = $symptoms->latest()->paginate($length);

        if ($request->ajax()) {
            return view('panel.symptoms.load', ['symptoms' => $symptoms])->render();
        }

        return view('panel.symptoms.index', compact('symptoms'));
    }

    public function create() {
        try {
            return view('panel.symptoms.create');
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
            $symptoms = Symptoms::create([
                        'name' => $request->name,
            ]);

            return redirect()->route('panel.symptoms.index')->with('success', 'Symptoms Added Successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    public function import() {
        try {
            return view('panel.symptoms.import');
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
                $symptoms = Symptoms::create([
                            'name' => $data[0],
                ]);
            }

            return redirect()->route('panel.symptoms.index')->with('success', 'Symptoms Added Successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    public function edit(Request $request) {
        try {
            $symptoms = Symptoms::where('id', $request->id)->first();

            return view('panel.symptoms.edit', compact('symptoms'));
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id) {
        // return $request->all();
        sleep(4);

        // Cases
        try {

            $chk = Symptoms::where('id', $id)->update([
                // Summary
                'name' => $request->name,
            ]);

            return redirect()->route('panel.symptoms.index')->with('success', 'Symptoms Data Updated Successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    public function destroy(Request $request) {
        Symptoms::where('id', $request->id)->delete();
        return back()->with('success', 'Symptom deleted successfully');
    }
}
