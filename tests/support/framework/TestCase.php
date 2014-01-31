<?php
use Symfony\Component\HttpFoundation\Request;

class CIUnit_TestCase extends PHPUnit_Framework_TestCase
{
    public static $userdata = array();

    public static $request;

    public static $response;

    public static function request_create($uri, $method = 'GET', $parameters = array(), $cookies = array(), $files = array(), $server = array(), $content = null)
    {
        static::$request = Request::create($uri, $method, $parameters, $cookies, $files, $server, $content);
        return static::$request;
    }

    public static function response_create($content = '', $status = 200, $headers = array())
    {
        static::$response = new CIUnit_Response($content, $status, $headers);
        return static::$response;
    }

    protected function perform()
    {
        static::$request->overrideGlobals();

        $this->bootstrap();

        return static::$response;
    }

    protected function performAjax()
    {
        static::$request->server->set('HTTP_X_REQUESTED_WITH', 'XMLHttpRequest');
        return $this->perform();
    }

    protected function perform_dummy()
    {
        static::request_create('/sessions/login');
        $this->bootstrap();
    }

    protected function set_userdata($key, $value)
    {
        self::$userdata[$key] = $value;
    }

    protected function login_user($user_id)
    {
        $this->set_userdata('user_id', $user_id);
    }

    protected function bootstrap()
    {
        try {
            include __DIR__ . '/../../../bootstrap.php';
        } catch (CIUnit_Exception $e) {}
    }
}
