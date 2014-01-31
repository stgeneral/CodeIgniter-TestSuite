<?php

function show_error($message, $status_code = 500, $heading = 'An Error Was Encountered')
{
    throw new CIUnit_Exception($heading . '(' . $status_code . '):' . $message, 1);
}

function show_404($page = '', $log_error = TRUE)
{
    CIUnit_TestCase::response_create($page, 404);
    throw new CIUnit_NotFoundException();
}
