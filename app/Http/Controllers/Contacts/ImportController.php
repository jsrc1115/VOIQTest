<?php
/**
 * Created by PhpStorm.
 * User: sebastian
 * Date: 9/08/15
 * Time: 06:03 PM
 */

namespace App\Http\Controllers\Contacts;

use App\Contact;
use App\ContactEmail;
use App\ContactImportLog;
use App\ContactNumber;
use App\Http\Controllers\Controller;
use App\ValueObjects\CRUDResultData;
use Input;
use Log;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class ImportController extends Controller
{
    public function getImportContacts()
    {
        return View('contacts/import_contact')->with('creation_data', null);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function postImportContacts(Request $request)
    {
        $start = microtime(true);
        $authenticated_user = $request->user();
        $creation_data = new CRUDResultData;

        $file = Input::file('imported_contacts');
        if(is_null($file))
        {
            $extension = 'ERROR';
            $creation_data->extra_info .= 'No file uploaded. ';
        }
        else{
            $extension = $file->getClientOriginalExtension();
        }

        if ($extension == 'xls' or $extension == 'xlsx') {
            $php_excel = Excel::load($file->getPathname());
            $worksheet = $php_excel->setActiveSheetIndex(0)->toArray();

            $validation_data = $this->validateExcel($worksheet);
            if ($validation_data->success == false) {
                $creation_data = $validation_data;
            }
            else{
                $creation_data->success = true;
                $creation_data->extra_info = $validation_data->extra_info;
                $this->insertFromExcel($worksheet, $authenticated_user);
            }
        } elseif ($extension == 'csv' or $extension == 'tsv') {

        }

        $creation_data->extra_info .= 'Time to finish: ' . round((microtime(true) - $start) * 1000, 3) . ' ms. ';
        $creation_data->extra_info .= 'Uploaded by: ' . $authenticated_user->name . ' - ' . $authenticated_user->email . '. ';

        $this->logImportResult($creation_data, $authenticated_user);

        return View('contacts/import_contact')->with('creation_data', $creation_data);
    }

    protected function validateExcel(&$worksheet)
    {
        $validation_data = new CRUDResultData;
        $headerVerified = false;
        foreach ($worksheet as $row) {
            $data = array();
            $data['first_name'] = $row[0];
            $data['last_name'] = $row[1];
            $data['email'] = $row[2];
            $data['primary'] = $row[3] == 'true';
            $data['phone_number'] = $row[4];

            $validator = $this->validator($data);
            if ($validator->fails()) {
                if ($headerVerified) {
                    $validation_data->success = false;
                    $validation_data->errors = $validator->errors()->all();
                    $validation_data->extra_info .= 'Failing data, first_name: ' . $row[0] .
                        ', last_name: ' . $row[1] .
                        ', email: ' . $row[2] .
                        ', primary: ' . $row[3] .
                        ', phone_number: ' . $row[4] . '. ';
                    return $validation_data;
                } else {
                    $validation_data->extra_info .= 'Header detected. ';
                    $headerVerified = true;
                }
            }
        }
        if ($headerVerified) {
            unset($worksheet[0]);
        }
        $validation_data->success = true;
        return $validation_data;
    }

    protected function insertFromExcel($worksheet, $authenticated_user)
    {
        foreach ($worksheet as $row) {
            $data = array();
            $data['first_name'] = $row[0];
            $data['last_name'] = $row[1];
            $data['email'] = $row[2];
            $data['primary'] = $row[3] == 'true';
            $data['phone_number'] = $row[4];

            $contact = Contact::where(['first_name' => $data['first_name'], 'last_name' => $data['last_name'], 'user_id' => $authenticated_user->id]);
            if ($contact->exists()) {
                $contact = $contact->first();
            } else {
                $contact = Contact::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'user_id' => $authenticated_user->id
                ]);
            }
            if (isset($data['email']) && trim($data['email']) !== '') {
                ContactEmail::create([
                    'contact_id' => $contact->id,
                    'email' => $data['email'],
                    'primary' => $data['primary']
                ]);
            }
            if (isset($data['phone_number']) && trim($data['phone_number']) !== '') {
                ContactNumber::create([
                    'contact_id' => $contact->id,
                    'phone_number' => $data['phone_number']
                ]);
            }
        }
    }

    protected function logImportResult($creation_data, $authenticated_user)
    {
        $error_text = '';
        if (is_array($creation_data->errors)) {
            foreach ($creation_data->errors as $error) {
                $error_text .= $error;
            }
        }
        ContactImportLog::create([
            'success' => $creation_data->success,
            'errors' => $error_text,
            'extra_info' => $creation_data->extra_info,
            'user_id' => $authenticated_user->id
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'email|max:255',
            'phone_number' => 'phone:US'
        ]);
    }
}