<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require_once APPPATH.'/libraries/AR_class.php';

class Files_model extends AR_class{
    function __construct() {
        parent::__construct();
        $this->table = 'files';
    }
    
    function add_file($data = array()) {
        return $this->insert_it($data);
    }
}