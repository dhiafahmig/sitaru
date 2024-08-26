<?php

// Autoload Composer dependencies
require __DIR__ . '/../vendor/autoload.php';

// Load the CodeIgniter framework
define('BASEPATH', __DIR__ . '/../system/');
define('APPPATH', __DIR__ . '/../application/');
define('ENVIRONMENT', 'testing');

// Load the CodeIgniter instance
require_once BASEPATH . 'core/CodeIgniter.php';

// Mock the get_instance function to return the CI instance
function get_instance()
{
    return CI_Controller::get_instance();
}
