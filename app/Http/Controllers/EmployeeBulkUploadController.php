<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Excel;
use Illuminate\Support\Str;
use App\EmployeeImport;
use Log;

class EmployeeBulkUploadController extends Controller
{
    public function index () {
        return view('backend.staff.bulk_import');
    }

    public function bulk_upload (Request $request)
    {
        if ($request->hasFile('bulk_file')) {
            try {
                Excel::import(new EmployeeImport, request()->file('bulk_file'));
                flash(translate('Employees imported successfully'));
            } catch (\Exception $e) {
                Log::error($e);
                $failures = null;
                if ($e != null) {
                    $failures = $e->failures();

                    foreach ($failures as $failed) {
                        if ($failed->attribute() == 'employee_id') {
                            $error_value = $failed->values()['employee_id'];
                        }

                        elseif ($failed->attribute() == 'email') {
                            $error_value = $failed->values()['email'];
                        }

                        flash($failed->errors()[0] . ' | ' . $error_value);
                    }
                }
            }
        }

        return redirect()->back();
    }
}
