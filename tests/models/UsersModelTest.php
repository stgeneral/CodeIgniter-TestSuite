<?php

class UsersModelTest extends CIUnit_TestCase
{
    public function testGetsAllUsers()
    {
        $users = get_instance()->mdl_users->get();
        $this->assertGreaterThan(0, count($users));
    }

    public function testShoudValidateEmail()
    {
        $_POST = array(
            'email_address' => 'invalid_email'
        );

        $this->assertFalse(get_instance()->mdl_users->validate());
        $this->assertArrayHasKey('email_address',
            get_instance()->mdl_users->form_validation->get_error_array());
    }

    public function assertPreConditions()
    {
        $this->perform_dummy();
        get_instance()->load->model('mdl_users');
    }
}
