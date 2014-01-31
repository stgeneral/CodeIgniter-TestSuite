<?php
use Symfony\Component\HttpFoundation\RedirectResponse;

function redirect($uri = '', $method = 'location', $http_response_code = 302)
{
    if (!preg_match('#^https?://#i', $uri)) {
        $uri = site_url($uri);
    }

    CIUnit_TestCase::$response = new RedirectResponse($uri, $http_response_code);
    throw new CIUnit_RedirectException();
}
