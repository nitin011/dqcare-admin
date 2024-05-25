<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;

class BulkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $validatedData = $request->validate([
            'file' => 'required'
        ]);
        $count = 0;
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = [];
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // This loops through all cells,
            $cells = [];
            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }
            $rows[] = $cells;
        }
        $head = array_shift($rows);
        $master = $rows;
        // Index
        $FirstNameIndex = 0;
        $LastNameIndex = 1;
        $EmailIndex = 2;
        $RoleIndex = 3;
        $PasswordIndex = 4;
        $user_obj = null;
        
        // return $request->all();
        foreach ($master as $index => $item) {
            $row_number = $index + 1;
            $user_email = User::whereEmail($item[$EmailIndex])->first();
            if($user_email){
                return back()->with("error","Email is already exists in DB at Row: ".$row_number);
            }
        
            if($item[$FirstNameIndex] == ''){
                return back()->with("error","First Name is missing at Row:".$row_number." Please export again!");
            }
            if($item[$LastNameIndex] == ''){
                return back()->with("error","Last Name is missing at Row:".$row_number." Please export again!");
            }

            if($item[$EmailIndex] == ''){
                return back()->with("error","Email is missing at Row:".$row_number." Please export again!");
            }
            if($item[$RoleIndex] == ''){
                return back()->with("error","Role is missing at Row:".$row_number." Please export again!");
            }
            if($item[$PasswordIndex] == ''){
                return back()->with("error","Role is missing at Row:".$row_number." Please export again!");
            }
            if(strlen($item[$PasswordIndex]) < 6){
                return back()->with("error","Passowrd should be in 6 digit at Row: ".$row_number." Please export again!");
            }
            if(!ctype_upper($item[$RoleIndex][0])){
                return back()->with("error","Role name should be in first letter at Row:".$row_number." Please export again!");
            }

                $user_obj = User::create([ 
                'first_name' =>Str::ucfirst($item[$FirstNameIndex]),
                'last_name' =>Str::ucfirst($item[$LastNameIndex]),
                'email' => $item[$EmailIndex],
                'password' => $item[$PasswordIndex],
            ]);
            $user_obj->syncRoles($item[$RoleIndex]);
        }

        return back()->with('success','Record Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
