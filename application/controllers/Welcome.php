<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
                
                $this->load->model(array("files_model", "measurements_model", "reports_model"));

		$this->lang->load('auth');
	}

	// redirect if needed, otherwise display the user list
	function index() {

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
                    $this->data['measurements'] = $this->measurements_model->get_grouped();
                    $this->load->view("header", $this->data);
                    $this->load->view("navigation");
                    $this->load->view("welcome_message");
                    $this->load->view("footer");
		}
	}
        
        function details($admin = NULL, $company = NULL, $space = NULL) {

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
                elseif (empty($company)) {
                	redirect('welcome', 'refresh');
                }
		else
		{
                    $this->data['details'] = $this->measurements_model->get_by_company(rawurldecode($admin), rawurldecode($company), rawurldecode($space));
                    //echo "<pre>"; print_r($this->data); exit;
                    $this->load->view("header", $this->data);
                    $this->load->view("navigation");
                    $this->load->view("details");
                    $this->load->view("footer");
		}
	}
        
        function export() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		if (!$this->ion_auth->is_admin()) {
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
                
                if(isset($_POST) && !empty($_POST)) {
                    // validate form input
                    $this->form_validation->set_rules('date', "Desde", 'required');
                    $this->form_validation->set_rules('date_to', "Hasta", 'required');
                    $this->form_validation->set_rules('admin', "Organismo administrador", 'required');
                    $this->form_validation->set_rules('company', "Empresa", 'required');
                    $this->form_validation->set_rules('space', "Puesto de trabajo", 'required');
                    
                    if ($this->form_validation->run() === TRUE) {
                        $this->load->helper('file');
                        $this->load->helper('download');
                        $date = "";
                        $datearr = explode("/", $this->input->post('date'));
                        @$date = "{$datearr[2]}-{$datearr[0]}-{$datearr[1]}";
                        $date_to = "";
                        $datearr_to = explode("/", $this->input->post('date_to'));
                        @$date_to = "{$datearr_to[2]}-{$datearr_to[0]}-{$datearr_to[1]}";
                        $data = $this->measurements_model->get_download(
                                    $date, $date_to,
                                    $this->input->post('admin'),
                                    $this->input->post('company'),
                                    $this->input->post('space')
                                );
                        
                        if ( ! write_file('uploads/CSV_Report.csv', $data))
                        {
                           echo 'Unable to write the file';
                        }
  
                        
                        //load the excel library
                        $this->load->library('excel');
                        $objReader = PHPExcel_IOFactory::createReader('CSV');
                        $objPHPExcel = $objReader->load('uploads/CSV_Report.csv');
                        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                        $objWriter->save('uploads/Report.xls');
                        redirect('uploads/Report.xls');
                        //force_download('CSV_Report.csv', $data);
                    } else {
                        show_error(validation_errors());
                    }
                    
                } else{ 
                    $this->data['companies'] = $this->measurements_model->get_companies();
                    $this->data['spaces'] = $this->measurements_model->get_spaces();
                    //echo "<pre>"; print_r($this->data['companies']); exit;
                    $this->load->view("header", $this->data);
                    $this->load->view("navigation");
                    $this->load->view("export");
                    $this->load->view("footer");
		}
	}
        
        function reports() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		if (!$this->ion_auth->is_admin()) {
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
                
                $this->data['reports'] = $this->reports_model->get_all();
                $this->data['spaces'] = $this->measurements_model->get_spaces();
                //echo "<pre>"; print_r($this->data['details']); exit;
                $this->load->view("header", $this->data);
                $this->load->view("navigation");
                $this->load->view("reports");
                $this->load->view("footer");
	}
        
        function add_report() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		if (!$this->ion_auth->is_admin()) {
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
                
                if(isset($_POST) && !empty($_POST)) {
                    // validate form input
                    $this->form_validation->set_rules('period', "Periodicidad", 'numeric|required');
                    $this->form_validation->set_rules('emails', "Destinatarios", 'required');
                    $this->form_validation->set_rules('admin', "Mutualidad", 'required');
                    $this->form_validation->set_rules('company', "Empresa", 'required');
                    
                    if ($this->form_validation->run() === TRUE) {
                        $this->load->helper('file');
                        $this->load->helper('download');
                        $date = "";
                        $datearr = explode("/", $this->input->post('date'));
                        @$date = "{$datearr[2]}-{$datearr[1]}-{$datearr[1]}";
                        $data = array(
                            'period'        => $this->input->post('period'),
                            'emails'        => $this->input->post('emails'),
                            'admin'         => $this->input->post('admin'),
                            'company'       => $this->input->post('company'),
                            'created_on'    => date("Y-m-d H:i:s")
                        );
                        $this->reports_model->add($data);
                        redirect("welcome/reports");
                    } else {
                        show_error(validation_errors());
                    }
                    
                } else{ 
                    $this->data['companies'] = $this->measurements_model->get_companies();
                    $this->data['spaces'] = $this->measurements_model->get_spaces();
                    $this->load->view("header", $this->data);
                    $this->load->view("navigation");
                    $this->load->view("add_report");
                    $this->load->view("footer");
		}
	}
        
        function delete_report($id = NULL) {
            $del = $this->reports_model->delete_report($id);
            redirect("welcome/reports");
        }
        
        function send_alert($to = "milan", $id = 1) {
            var_dump($this->measurements_model->send_alert($to, $id));
        }
        
        function download_csv($id = 1) {
            $data = $this->measurements_model->get_single_download($id);
            $this->load->helper('file');
            $this->load->helper('download');
            $this->load->library('excel');
            $objReader = PHPExcel_IOFactory::createReader('CSV');
            $objPHPExcel = $objReader->load('uploads/CSV_Report.csv');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('uploads/Report.xls');
            redirect('uploads/Report.xls');
            //force_download('CSV_Report.csv', $data);
        }
}