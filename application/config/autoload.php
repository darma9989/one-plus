<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Libraries
$autoload['libraries'] = array('database', 'session', 'form_validation', 'template');

// Helpers
$autoload['helper'] = array('url', 'form', 'security');

// Models - autoload core models
$autoload['model'] = array('Log_model', 'Setting_model');

// Config
$autoload['config'] = array();

// Language
$autoload['language'] = array();

// Drivers
$autoload['drivers'] = array();

// Packages
$autoload['packages'] = array();
