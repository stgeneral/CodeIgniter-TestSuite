<?php

class SessionControllerTest extends CIUnit_TestCase
{
    protected $_registration_data = array(
        'last_name'     => 'Tester LN',
        'first_name'    => 'Tester FN',
        'email_address' => 'tester5@example.com',
        'password'      => 'Password',
        'passwordv'     => 'Password',
        'language_id'   => '2'
    );

    public function testLoginPage()
    {
        static::request_create('/sessions/login');
        $response = $this->perform();
        $this->assertEquals(t('login_title'),
            $response->filter('h3')->first()->text(),
            'Wrong heading');
        $this->assertRegExp('/<a.*href=".*\/sessions\/forgot_password".*>Mot de passe oublié \?<\/a>/',
            $response->getContent(),
            "Lacks forgot password link");
        $this->assertRegExp('/<a.*href=".*\/sessions\/register".*>Inscription<\/a>/',
            $response->getContent(),
            "Lacks register link");
    }

    public function testForgotPasswordPage()
    {
        static::request_create('/sessions/forgot_password');
        $response = $this->perform();
        $this->assertRegExp('/<h.*>Mot de passe oublié \?<\/h.>/',
            $response->getContent(),
            "Wrong heading");
    }

    public function testRegisterPage()
    {
        static::request_create('/sessions/register');
        $response = $this->perform();
        $this->assertRegExp('/<h.*>Inscription<\/h.>/',
            $response->getContent());
    }

    public function testDeleteRegistrant()
    {
        $this->perform_dummy();
        $model = get_instance()->load->model('mdl_users');
        $registrant = $model->getByEmail($this->_registration_data['email_address']);

        get_instance()->load->model('mdl_users_user_groups')->deleteByUserId($registrant->user_id);

        $model->delete(array('user_id' => $registrant->user_id));
    }

    /**
     * @depends testDeleteRegistrant
     */
    public function testRegistrantDoNotExists()
    {
        $this->perform_dummy();
        $model = get_instance()->load->model('mdl_users');
        $registrant = $model->getByEmail($this->_registration_data['email_address']);
        $this->assertNull($registrant);
    }

    /**
     * @depends testRegistrantDoNotExists
     */
    public function testRegistration()
    {
        static::request_create('/sessions/register', 'POST', $this->_registration_data);

        $response = $this->perform();

        $this->assertTrue($response->isRedirect(), 'Response is not redirect, registration failed');
        $this->assertEquals(site_url('/sessions/login'),
            $response->getTargetUrl());

        $model = get_instance()->load->model('mdl_users');
        $registrant = $model->getByEmail($this->_registration_data['email_address']);

        $this->assertNotNull($registrant);
        $this->assertEquals($this->_registration_data['last_name'], $registrant->last_name);
        $this->assertEquals($this->_registration_data['first_name'], $registrant->first_name);
    }

    /**
     * @ depends testRegistration
     */
    public function testLogin()
    {
        static::request_create('/sessions/login', 'POST', array(
            'username' => $this->_registration_data['email_address'],
            'password' => $this->_registration_data['password'],
            ));
        $response = $this->perform();
        $this->assertTrue($response->isRedirect(), 'Response is not redirect, registration failed');
        $this->assertEquals(site_url('/dashboard'),
            $response->getTargetUrl());
    }

    public function testShouldRedirectWithoutAuth()
    {
        $request = static::request_create('/');
        $response = $this->perform();
        $this->assertTrue($response->isRedirect());
        $this->assertEquals(site_url('/sessions/login'), $response->getTargetUrl());
    }
}
