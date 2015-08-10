<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Log;
use Validator;
use App\ValueObjects\CRUDResultData;

class AdminController extends Controller
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function createValidator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function updateValidator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    public function getCreateUser()
    {
        return View('admin/create_user')->with('creation_data', null);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function postCreateUser(Request $request)
    {
        $creation_data = $this->create($request->all());
        return View('admin/create_user')->with('creation_data', $creation_data);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $creation_data = new CRUDResultData;
        $validator = $this->createValidator($data);

        if (!$validator->fails()) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            if ($user->exists) {
                $role = Role::where('name', '=', 'user')->firstOrFail();
                $user->attachRole($role);
                $creation_data->success = true;
            }
            else{
                $creation_data->success = false;
                $creation_data->errors = array('CreateError' => 'Couldn\'t create user');
            }
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
    protected function deleteUser($id)
    {
        return User::destroy($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postDeleteUser($id)
    {
        $this->deleteUser($id);
        return redirect('/');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getDeleteUser($id)
    {
        $this->deleteUser($id);
        return redirect('/');
    }

    /**
     * @param User $updated_user
     * @param array $data
     * @return int
     */
    protected function updateUser(User $updated_user,array $data)
    {
        $update_data = new CRUDResultData;
        $validator = $this->updateValidator($data);
        if (!$validator->fails()) {
            if(password_verify($data['old_password'],$updated_user->password))
            {
                $updated_user->name = $data['name'];
                $updated_user->email = $data['email'];
                $updated_user->password = bcrypt($data['password']);

                $updated_user->save();

                $update_data->success = true;
            }
            else{
                $update_data->success = false;
                $update_data->errors = array('PassMismatch' => 'Old password is incorrect');
            }
        }
        else{
            $update_data->success = false;
            $update_data->errors = $validator->errors()->all();
        }
        return $update_data;
    }

    /**
     * @param Request $request
     * @param $id
     * @return View
     */
    public function postUpdateUser(Request $request,$id)
    {
        $updated_user = User::find($id);
        $update_data = $this->updateUser($updated_user,$request->all());
        if($update_data->success){
            return redirect('/');
        }
        else{
            return View('admin/update_user')->with('update_data', $update_data)->with('updated_user',$updated_user);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return View
     */
    public function getUpdateUser(Request $request, $id)
    {
        $updated_user = User::find($id);
        return View('admin/update_user')->with('update_data', null)->with('updated_user',$updated_user);
    }
}