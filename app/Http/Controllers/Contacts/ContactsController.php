<?php

namespace App\Http\Controllers\Contacts;

use App\Contact;
use App\ContactEmail;
use App\ContactNumber;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ValueObjects\CRUDResultData;
use Log;
use Validator;

class ContactsController extends Controller
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        if (array_key_exists('added_email',$data)) {
            foreach ($data['added_email'] as $key => $email)
            {
                $validator = Validator::make(Array('email' => $email), ['email' => 'email|max:255']);
                if($validator->fails())
                {
                    return $validator;
                }
            }
        }
        if (array_key_exists('additional_number',$data)) {
            foreach ($data['additional_number'] as $key => $phone_number)
            {
                $validator = Validator::make(Array('phone_number' => $phone_number), ['phone_number' => 'required|phone:US']);
                if($validator->fails())
                {
                    return $validator;
                }
            }
        }
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone_number' => 'required|phone:US'
        ]);
    }

    public function getCreateContact()
    {
        return View('contacts/create_contact')->with('creation_data', null);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function postCreateContact(Request $request)
    {
        $authenticated_user = $request->user();
        $creation_data = $this->create($request->all(),$authenticated_user);
        return View('contacts/create_contact')->with('creation_data', $creation_data);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @param $authenticated_user
     * @return CRUDResultData
     */
    protected function create(array $data,$authenticated_user)
    {
        $creation_data = new CRUDResultData;
        $validator = $this->validator($data);
        Log::info(print_r($data,true));
        if (!$validator->fails() && isset($authenticated_user) && isset($authenticated_user->id)) {
            $contact = Contact::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'user_id' => $authenticated_user->id
            ]);
            if($contact->exists)
            {
                if (array_key_exists('added_email',$data)) {
                    foreach ($data['added_email'] as $key => $email) {
                        ContactEmail::create([
                            'contact_id' => $contact->id,
                            'email' => $email,
                            'primary' => array_key_exists($key,$data['primary_email'])
                        ]);
                    }
                }
                ContactNumber::create([
                    'contact_id' => $contact->id,
                    'phone_number' => $data['phone_number']
                ]);
                if (array_key_exists('additional_number',$data)) {
                    foreach ($data['additional_number'] as $phone_number) {
                        ContactNumber::create([
                            'contact_id' => $contact->id,
                            'phone_number' => $phone_number
                        ]);
                    }
                }
            }
            else{
                $creation_data->success = false;
                $creation_data->errors = $validator->errors()->all();
            }
            $creation_data->success = true;
        } else {
            $creation_data->success = false;
            $creation_data->errors = $validator->errors()->all();
        }
        return $creation_data;
    }

    /**
     * @param $id
     * @return int
     */
    protected function deleteContact($id)
    {
        return Contact::destroy($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postDeleteContact($id)
    {
        $this->deleteContact($id);
        return redirect('/');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getDeleteContact($id)
    {
        $this->deleteContact($id);
        return redirect('/');
    }

}