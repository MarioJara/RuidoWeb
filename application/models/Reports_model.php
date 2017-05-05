<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require_once APPPATH.'/libraries/AR_class.php';

class Reports_model extends AR_class{
    function __construct() {
        parent::__construct();
        $this->table = 'reports';
    }
    
    function add($data = array()) {
        return $this->insert_it($data);
    }
    
    function get_all() {
        $sql = "SELECT *
                FROM reports";
        return $this->select_by_query($sql);
    }
    
    function delete_report($id) {
        return $this->delete(array('id' => $id));
    }
}