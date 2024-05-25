<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalTests;

class MedicalTestsController extends Controller {

    public function index(Request $request) {
        $length = 10;
        if (request()->get('length')) {
            $length = $request->get('length');
        }
        $tests = MedicalTests::query();

        if ($request->get('search')) {
            $tests->where(\DB::raw("name"), "like", '%' . request()->get('search') . '%');
        }

        if ($request->get('asc')) {
            $tests->orderBy($request->get('asc'), 'asc');
        }
        if ($request->get('desc')) {
            $tests->orderBy($request->get('desc'), 'desc');
        }

        $tests = $tests->latest()->paginate($length);

        if ($request->ajax()) {
            return view('panel.tests.load', ['tests' => $tests])->render();
        }

        return view('panel.tests.index', compact('tests'));
    }

    public function create() {
        try {
            return view('panel.tests.create');
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
            $tests = MedicalTests::create([
                        'name' => $request->name,
            ]);

            return redirect()->route('panel.tests.index')->with('success', 'Tests Added Successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }
    
    public function import() {
        try {
            return view('panel.tests.import');
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
                $tests = MedicalTests::create([
                            'name' => $data[0],
                ]);
            }

            return redirect()->route('panel.tests.index')->with('success', 'Tests Added Successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    public function edit(Request $request) {
        try {
            $tests = MedicalTests::where('id', $request->id)->first();

            return view('panel.tests.edit', compact('tests'));
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id) {
        // return $request->all();
        sleep(4);

        // Cases
        try {

            $chk = MedicalTests::where('id', $id)->update([
                // Summary
                'name' => $request->name,
            ]);

            return redirect()->route('panel.tests.index')->with('success', 'Tests Data Updated Successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    public function destroy(Request $request) {
        MedicalTests::where('id', $request->id)->delete();
        return back()->with('success', 'Tests deleted successfully');
    }
}
