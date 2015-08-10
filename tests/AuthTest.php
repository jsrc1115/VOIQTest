<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    /**
     * Testing login page accessible.
     *
     * @return void
     */
    public function testLoginPage()
    {
        $this->call('GET', '/auth/login');
        $this->assertResponseOk();
    }

    /**
     * Testing admin Auth.
     *
     * @return void
     */
    public function testAdminForbiddenAccess()
    {
        $this->visit('/admin/create_user')
        ->see('Forbidden access.');
    }

    /**
     * Testing user auth
     *
     * @return void
     */
    public function testContactForbiddenAccess()
    {
        $this->visit('/contacts/create_contact')
            ->see('Forbidden access.');
    }
}
