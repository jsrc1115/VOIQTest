<?php
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: sebastian
 * Date: 9/08/15
 * Time: 04:10 PM
 */
class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Juan Sebastian Rodriguez',
            'email' => 'email1@example.com',
            'password' => bcrypt('password'),
        ]);

        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'User Administrator';
        $admin->description  = 'User is allowed to manage and edit other users';
        $admin->save();

        // role attach alias
        $user->attachRole($admin); // parameter can be an Role object, array, or id

        $editUsers = new Permission();
        $editUsers->name         = 'edit-users';
        $editUsers->display_name = 'Edit users'; // optional
        // Allow a user to...
        $editUsers->description  = 'Can create, edit, update users.'; // optional
        $editUsers->save();

        $admin->attachPermission($editUsers);

        $contacts = new Role();
        $contacts->name         = 'user';
        $contacts->display_name = 'Contacts client user';
        $contacts->description  = 'User is allowed to manage and edit contacts';
        $contacts->save();

        $editContacts = new Permission();
        $editContacts->name         = 'edit-contacts';
        $editContacts->display_name = 'Edit contacts'; // optional
        // Allow a user to...
        $editContacts->description  = 'Can create, edit, update contacts.'; // optional
        $editContacts->save();

        $user = User::create([
            'name' => 'User1 Lastname1',
            'email' => 'user1@email.com',
            'password' => bcrypt('password'),
        ]);
        $user->attachRole($contacts);

        $contacts->attachPermission($editContacts);
    }
}