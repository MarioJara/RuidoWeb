<?php

class Migrate extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
        
        $this->config->set_item('log_threshold',array(0));
        
        $this->load->library('migration');
        
        //if($this->config->item('subdomain') != "admin") redirect("/", "refresh");

        if(!$this->input->is_cli_request() && ENVIRONMENT == "production")
        {
            show_404();
            return;
        }
    }
    
    function current()
    {   
        if($this->migration->current())
            echo "Migrated successfuly to current version" . PHP_EOL;
        else
            echo $this->migration->error_string() . PHP_EOL;
    }
    
    function version($version = null)
    {
        if($this->migration->version($version))
            echo "Migrated successfuly to version $version" . PHP_EOL;
        else
            echo $this->migration->error_string() . PHP_EOL;
    }
}