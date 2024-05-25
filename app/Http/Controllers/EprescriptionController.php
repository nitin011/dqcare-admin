<?php

namespace App\Http\Controllers;

use App\Models\EPrescription;
use App\Models\PrescriptionDownload;
use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\User;
use App\Models\Symptoms;
use App\Models\MedicalTests;
use App\Models\Medicines;
use App\Models\Category;
use App\Models\Story;
use App\Models\SymptomsData;
use App\Models\Diagnosis;
use App\Models\FollowUp;
use \PDF;

class EprescriptionController extends Controller {

    public function createNewEprescription(Request $request) {

        $this->validate($request, [
            'patient_id' => 'required',
                //'symptoms' => 'required',
                //'tests_to_take' => 'required',
                //'advice' => 'required'
        ]);

        $medicationArray = $request->get('medications');
        $symptomsArray = $request->get('symptoms');

        $user = User::whereId(auth()->id())->first();

        $sym_ids = array();
        $sym_array = array();
        foreach ($symptomsArray as $key => $value) {
            $new_sym = new SymptomsData();
            $new_sym->name = $value['name'];
            $new_sym->duration = $value['duration'];
            $new_sym->duration_type = $value['duration_type'];
            $new_sym->save();

            array_push($sym_ids, $new_sym->id);
            array_push($sym_array, $new_sym);
        }
        $medi_ids = array();
        $medi_array = array();
        foreach ($medicationArray as $key => $value) {
            $new_medi = new Medication();
            $new_medi->doctor_id = $user->id;
            $new_medi->drug_name = $value['drug_name'];
            $new_medi->duration = $value['duration'];
            $new_medi->duration_type = $value['duration_type'];
            $new_medi->after_meal_morning = isset($value['after_meal_morning']) ? $value['after_meal_morning'] : 0;
            $new_medi->after_meal_afternoon = isset($value['after_meal_afternoon']) ? $value['after_meal_afternoon'] : 0;
            $new_medi->after_meal_evening = isset($value['after_meal_evening']) ? $value['after_meal_evening'] : 0;
            $new_medi->after_meal_night = isset($value['after_meal_night']) ? $value['after_meal_night'] : 0;
            $new_medi->before_meal_morning = isset($value['before_meal_morning']) ? $value['before_meal_morning'] : 0;
            $new_medi->before_meal_afternoon = isset($value['before_meal_afternoon']) ? $value['before_meal_afternoon'] : 0;
            $new_medi->before_meal_evening = isset($value['before_meal_evening']) ? $value['before_meal_evening'] : 0;
            $new_medi->before_meal_night = isset($value['before_meal_night']) ? $value['before_meal_night'] : 0;
            $new_medi->remarks = $value['remarks'];
            $new_medi->save();

            array_push($medi_ids, $new_medi->id);
            array_push($medi_array, $new_medi);
        }
        // convert array to string
        $id_string = implode(',', $medi_ids);
        $sym_string = implode(',', $sym_ids);
        $new_pres = new EPrescription();
        $new_pres->doctor_id = $user->id;
        $new_pres->patient_id = $request->patient_id;
        $new_pres->medication_id = $id_string;
        $new_pres->symptoms = $sym_string;
        $new_pres->diagnosis = $request->diagnosis;
        $new_pres->tests_to_take = $request->tests_to_take;
        $new_pres->advice = $request->advice;
        $new_pres->save();

        $patient = User::whereId($request->patient_id)->first();

        $patient->height = $request->height;
        $patient->weight = $request->weight;
        $patient->save();

        return response()->json([
                    "status" => "success",
                    "message" => "Success",
                    'data' => $new_pres,
                    'medications' => $medi_array,
                    'symptoms' => $sym_array,
        ]);
    }

    // list of all eprescription with medications
    public function getAllDoctorEprescription() {
        $user = User::whereId(auth()->id())->first();
        $eprescriptions = EPrescription::where('doctor_id', $user->id)->get();

        foreach ($eprescriptions as $key => $value) {
            $medication_ids = explode(',', $value->medication_id);
            $medications = Medication::whereIn('id', $medication_ids)->get();
            $eprescriptions[$key]->medications = $medications;
        }
        foreach ($eprescriptions as $key => $value) {
            $symptom_ids = explode(',', $value->symptoms);
            $symptomData = SymptomsData::whereIn('id', $symptom_ids)->get();
            $eprescriptions[$key]->symptomData = $symptomData;
        }
        return response()->json([
                    "status" => "success",
                    "message" => "Success",
                    'data' => $eprescriptions,
        ]);
    }

    public function getAllDoctorPEprescription($id) {
        $user = User::whereId(auth()->id())->first();
        $eprescriptions = EPrescription::where('patient_id', $id)->orderBy('created_at', 'desc')->get();

        foreach ($eprescriptions as $key => $value) {
            $medication_ids = explode(',', $value->medication_id);
            $symptom_ids = explode(',', $value->symptoms);
            $medications = Medication::whereIn('id', $medication_ids)->get();
            $symptomData = SymptomsData::whereIn('id', $symptom_ids)->get();
            $doctor = User::whereId($value->doctor_id)->first();
		
			
            $specility = Category::where('id', $doctor->speciality)->first();
			$ss ['id'] = $specility['id'];
			$ss ['name'] = $specility['name'];
            $doctor['speciality'] = $ss;
            
			
            $doctor['pri_dr_note'] = json_decode($doctor['pri_dr_note']);
            $eprescriptions[$key]->doctor = $doctor;
            $eprescriptions[$key]->medications = $medications;
            $eprescriptions[$key]->symptomData = $symptomData;
        }


        if (empty($eprescriptions)) {
            $eprescriptions = NULL;
        }
        return response()->json([
                    "status" => "success",
                    "message" => "Success",
                    'data' => $eprescriptions,
        ]);
    }

    public function getAllPatientEprescription($id) {
        $user = User::whereId(auth()->id())->first();
        $eprescriptions = EPrescription::where('patient_id', $id)->orderBy('created_at', 'desc')->get();

        foreach ($eprescriptions as $key => $value) {
            $medication_ids = explode(',', $value->medication_id);
            $symptom_ids = explode(',', $value->symptoms);
            $medications = Medication::whereIn('id', $medication_ids)->get();
            $symptomData = SymptomsData::whereIn('id', $symptom_ids)->get();
            $doctor = User::whereId($value->doctor_id)->first();
            $specility = Category::where('id', $doctor->speciality)->first();
            $ss ['id'] = $specility['id'];
			$ss ['name'] = $specility['name']; 
            $doctor['speciality'] = NULL;
            $doctor['pri_dr_note'] = json_decode($doctor['pri_dr_note']);
            $eprescriptions[$key]->doctor = $doctor;
            $eprescriptions[$key]->medications = $medications;
            $eprescriptions[$key]->symptomData = $symptomData;
        }
        if (empty($eprescriptions)) {
            $eprescriptions = NULL;
        }
        return response()->json([
                    "status" => "success",
                    "message" => "Success",
                    'data' => $eprescriptions,
        ]);
    }

    // list by patient id
    public function getEprescriptionDetails(Request $request) {
        $eprescriptions = EPrescription::where('id', $request->id)->get();
        foreach ($eprescriptions as $key => $value) {
            $medication_ids = explode(',', $value->medication_id);
            $symptom_ids = explode(',', $value->symptoms);
            $medications = Medication::whereIn('id', $medication_ids)->get();
            $symptomData = SymptomsData::whereIn('id', $symptom_ids)->get();
            $doctor = User::whereId($value->doctor_id)->first();
            $specility = Category::where('id', $doctor->speciality)->first();
            $ss ['id'] = $specility['id'];
			$ss ['name'] = $specility['name'];
            $doctor['speciality'] = $ss;
            $doctor['pri_dr_note'] = json_decode($doctor['pri_dr_note']);
            $eprescriptions[$key]->doctor = $doctor;
            $eprescriptions[$key]->medications = $medications;
            $eprescriptions[$key]->symptomData = $symptomData;
        }
        return response()->json([
                    "status" => "success",
                    "message" => "Success",
                    'data' => $eprescriptions,
                        // 'medications'  => $medications,
        ]);
    }

    // list by doctor id both patient id
    public function getEprescriptionByDoctorId($patient_id, $doctor_id) {
        $eprescriptions = EPrescription::where('patient_id', $patient_id)->where('doctor_id', $doctor_id)->get();
        foreach ($eprescriptions as $key => $value) {
            $medication_ids = explode(',', $value->medication_id);
            $medications = Medication::whereIn('id', $medication_ids)->get();
            $eprescriptions[$key]->medications = $medications;
        }
        foreach ($eprescriptions as $key => $value) {
            $symptom_ids = explode(',', $value->symptoms);
            $symptomData = SymptomsData::whereIn('id', $symptom_ids)->get();
            $eprescriptions[$key]->symptomData = $symptomData;
        }
        return response()->json([
                    'success' => true,
                    'eprescriptions' => $eprescriptions,
                        // 'medications'  => $medications,
        ]);
    }

    // update eprescription
    public function updateEprescription(Request $request) {
        $medicationArray = $request->get('medications');
        $symptomsArray = $request->get('symptoms');

        $user = User::whereId(auth()->id())->first();

        $sym_ids = array();
        $sym_array = array();
        foreach ($symptomsArray as $key => $value) {
            $new_sym = new SymptomsData();
            $new_sym->name = $value['name'];
            $new_sym->duration = $value['duration'];
            $new_sym->save();

            array_push($sym_ids, $new_sym->id);
            array_push($sym_array, $new_sym);
        }

        $medi_ids = array();
        $medi_array = array();
        foreach ($medicationArray as $key => $value) {
            $new_medi = new Medication();
            $new_medi->drug_name = $value['drug_name'];
            $new_medi->duration = $value['duration'];
            $new_medi->after_meal = $value->after_meal;
            $new_medi->after_breakfast = $value->after_breakfast;
            $new_medi->after_lunch = $value->after_lunch;
            $new_medi->after_dinner = $value->after_dinner;
            $new_medi->save();

            array_push($medi_ids, $new_medi->id);
            array_push($medi_array, $new_medi);
        }
        // convert array to string
        $id_string = implode(',', $medi_ids);
        $sym_string = implode(',', $sym_ids);
        $new_pres = new EPrescription();
        $new_pres->doctor_id = $request->doctor_id;
        $new_pres->patient_id = $request->patient_id;
        $new_pres->medication_id = $id_string;
        $new_pres->symptoms = $sym_string;
        $new_pres->tests_to_take = $request->tests_to_take;
        $new_pres->advice = $request->advice;
        $new_pres->save();

        return response()->json([
                    'success' => true,
                    'prescription' => $new_pres,
                    'medications' => $medi_array,
        ]);
    }

    public function removeMedication(Request $request) {
        $medication_id = $request->get('medication_id');
        Medication::where('id', $medication_id)->delete();

        return response()->json([
                    "status" => "success",
                    "message" => "Success",
                    'data' => "Medication is removed Successfully",
        ]);
    }

    public function getSymptoms() {

        $symptoms = Symptoms::all();

        $data = [];
        foreach ($symptoms as $key => $value) {
            $data[$key]['id'] = $value->id;
            $data[$key]['name'] = $value->name;
        }
        return response()->json([
                    "status" => "success",
                    "message" => "Success",
                    'data' => $data,
        ]);
    }

    public function getDiagnosis() {

        $diagnosis = Diagnosis::all();

        $data = [];
        foreach ($diagnosis as $key => $value) {
            $data[$key]['id'] = $value->id;
            $data[$key]['name'] = $value->name;
        }
        return response()->json([
                    "status" => "success",
                    "message" => "Success",
                    'data' => $data,
        ]);
    }

    public function getMedicalTests() {

        $tests = MedicalTests::all();

        $data = [];
        foreach ($tests as $key => $value) {
            $data[$key]['id'] = $value->id;
            $data[$key]['name'] = $value->name;
        }
        return response()->json([
                    "status" => "success",
                    "message" => "Success",
                    'data' => $data,
        ]);
    }

    public function getMedicines() {

        $medicines = Medicines::all();

        $data = [];
        foreach ($medicines as $key => $value) {
            $data[$key]['id'] = $value->id;
            $data[$key]['name'] = $value->types . ' - ' . $value->name;
        }
        return response()->json([
                    "status" => "success",
                    "message" => "Success",
                    'data' => $data,
        ]);
    }

    public function view($id) {
        $eprescriptions = EPrescription::where('id', $id)->first();
        $doctor = User::whereId($eprescriptions->doctor_id)->first();
        $patient = User::whereId($eprescriptions->patient_id)->first();
        $summary = Story::where('user_id', $eprescriptions->patient_id)->where('type', 1)->first();
        $specility = Category::where('id', $doctor->speciality)->first();
        $FollowUp = FollowUp::where(['doctor_id' => $eprescriptions->doctor_id, 'user_id' => $eprescriptions->patient_id])->latest('created_at')->first();

        return view('frontend.prescription.view', compact('eprescriptions', 'doctor', 'patient', 'summary', 'specility', 'FollowUp'));
    }

    public function previewPdf($id) {
        $eprescriptions = EPrescription::where('id', $id)->first();
        $download = PrescriptionDownload::where('e_id', $id)->first();
        $doctor = User::whereId($eprescriptions->doctor_id)->first();
        $patient = User::whereId($eprescriptions->patient_id)->first();
        $summary = Story::where('user_id', $eprescriptions->patient_id)->where('type', 1)->first();
        $specility = Category::where('id', $doctor->speciality)->first();
        $FollowUp = FollowUp::where(['doctor_id' => $eprescriptions->doctor_id, 'user_id' => $eprescriptions->patient_id])->latest('created_at')->first();

        $pdf = PDF::loadView('frontend.prescription.index', ['eprescriptions' => $eprescriptions, 'doctor' => $doctor, 'patient' => $patient, 'summary' => $summary, 'specility' => $specility, 'followup' => $FollowUp]);
        if (!isset($download->id)) {
            PrescriptionDownload::create([
                'e_id' => $id,
            ]);
        }

        // save this pdf in public folder and return the path as link to download the pdf file
        $pdf->save(base_path() . '/public/images/' . $id . '.pdf');
        $link = url('/core/public/images/' . $id . '.pdf');
        return response()->json([
                    "status" => "success",
                    "message" => "Success",
                    'data' => $link,
        ]);
    }

    public function downloadPdf($id) {
        $eprescriptions = EPrescription::where('id', $id)->first();
        $download = PrescriptionDownload::where('e_id', $id)->first();
        $doctor = User::whereId($eprescriptions->doctor_id)->first();
        $patient = User::whereId($eprescriptions->patient_id)->first();
        $summary = Story::where('user_id', $eprescriptions->patient_id)->where('type', 1)->first();
        $specility = Category::where('id', $doctor->speciality)->first();
        $FollowUp = FollowUp::where(['doctor_id' => $eprescriptions->doctor_id, 'user_id' => $eprescriptions->patient_id])->latest('created_at')->first();

        $pdf = PDF::loadView('frontend.prescription.index', ['eprescriptions' => $eprescriptions, 'doctor' => $doctor, 'patient' => $patient, 'summary' => $summary, 'specility' => $specility, 'followup' => $FollowUp]);

        if (!isset($download->id)) {
            PrescriptionDownload::create([
                'e_id' => $id,
            ]);
        }

        // save this pdf in public folder and return the path as link to download the pdf file
        $pdf->save(base_path() . '/public/images/' . $id . '.pdf');
        $link = url('/core/public/images/' . $id . '.pdf');
        return $pdf->download($id . '.pdf');
    }

    public function index(Request $request) {
        $length = 10;
        if (request()->get('length')) {
            $length = $request->get('length');
        }
        $prescription = EPrescription::query();

        if ($request->get('search')) {
            $prescription->whereHas('user', function ($q) {
                        $q->where(\DB::raw("advice"), "like", '%' . request()->get('search') . '%');
                    })
                    ->orWhere('doctor_id', 'like', '%' . $request->search . '%')
                    ->orWhere('patient_id', 'like', '%' . $request->search . '%');
        }

        if ($request->get('asc')) {
            $prescription->orderBy($request->get('asc'), 'asc');
        }
        if ($request->get('desc')) {
            $prescription->orderBy($request->get('desc'), 'desc');
        }

        $prescription = $prescription->latest()->paginate($length);

        if ($request->ajax()) {
            return view('frontend.prescription.load', ['prescription' => $prescription])->render();
        }

        return view('frontend.prescription.show', compact('prescription'));
    }

    public function destroy(Request $request) {
        EPrescription::where('id', $request->id)->delete();
        return back()->with('success', 'Prescription deleted successfully');
    }
}
