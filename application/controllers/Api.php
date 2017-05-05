<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
                
                $this->load->model(array("files_model", "measurements_model"));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}
        
        function process_audio() {
            //header('Access-Control-Allow-Origin: *'); 
            //validate form input
            $this->form_validation->set_rules('file_name', 'File Name', 'required');

            if ($this->form_validation->run() == true) {
                $filename = $this->input->post('file_name');
                $wavname = str_replace(".amr", ".wav", $filename);
                $command = "ffmpeg -i uploads/$filename -af 'volumedetect' -f null /dev/null 2>&1";
                $exec = exec($command, $output_ff, $return_ff);
                if($return_ff == 0) {
                    if(count($output_ff) > 28) {
                        $line_mid = $output_ff[28];
                        $line_max = $output_ff[29];
                        $str_pos = strpos($line_max, "max_volume: ");
                        
                        if($str_pos !== FALSE){
                            $loudness_max = 100 + ((int)substr($line_max, $str_pos + 12) * 2.083);
                        } else {
                            $loudness_max = 0;
                        }
                        
                        $str_pos = strpos($line_mid, "mean_volume: ");
                        
                        if($str_pos !== FALSE){
                            //$loudness_mid = 100 + ((int)substr($line_mid, $str_pos + 13) * 2.083);
                            $loudness_mid = 100 + ((int)substr($line_mid, $str_pos + 13));
                        } else {
                            $loudness_mid = 0;
                        }
                            $data = array(
                                'name'  => $wavname,
                                'loudness'  => $loudness_mid,
                                'checked'   => 1,
                                'checked_on' => date('Y-m-d H:i:s')
                            );

                            $output = array(
                                'type' => "success",
                                'loudness' => round($loudness_mid),
                                'loudness_max' => round($loudness_max)
                            );

                            $result =  $this->files_model->add_file($data);
                            if($result) {
                                $output['id'] = $result;
                            } else {
                                $output['type'] = "error";
                                $output['message'] = "Can't write to database";
                            }
                        } else {
                            $output = array(
                                'type' => "error",
                                'message' => $output[0]
                            );
                        }
                        unlink("uploads/$wavname");
                    }
                /*
                print_r($output_ff);
                echo $return_ff;
                exit();
                $return_ff = 0;
                if($return_ff == 0) {
                    #unlink("uploads/$filename");
                    $exec = exec("python script/db.py $wavname", $output, $return);
                    if(count($output) == 1 && is_numeric($output[0])) {
                        $data = array(
                            'name'  => $wavname,
                            'loudness'  => round($output[0]),
                            'checked'   => 1,
                            'checked_on' => date('Y-m-d H:i:s')
                        );
                        
                        $output = array(
                            'type' => "success",
                            'loudness' => round($output[0])
                        );
                        
                        $result =  $this->files_model->add_file($data);
                        if($result) {
                            $output['id'] = $result;
                        } else {
                            $output['type'] = "error";
                            $output['message'] = "Can't write to database";
                        }
                    } else {
                        $output = array(
                            'type' => "error",
                            'message' => $output[0]
                        );
                    }
                    unlink("uploads/$wavname");
                 * 
                 */
            } else {
                $output = array(
                    'type' => "error",
                    'message' => (validation_errors()) ? validation_errors() : $this->session->flashdata('message')
                );
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }
        
        function save() {
            header('Access-Control-Allow-Origin: *'); 
            if(isset($_POST) && !empty($_POST)) {
                $data = array(
                    'file_id'                   => $this->input->post('id'),
                    'company'                   => $this->input->post('company'),
                    'admin'                     => $this->input->post('admin'),
                    'email'                     => $this->input->post('email'),
                    'area'                      => $this->input->post('area'),
                    'space'                     => $this->input->post('space'),
                    'activity'                  => "",
                    'tasks'                     => $this->input->post('tasks'),
                    'primary_source'            => $this->input->post('primary_source'),
                    'other_sources'             => $this->input->post('other_sources'),
                    'events_characteristics'    => $this->input->post('events_characteristics'),
                    'external_type'             => $this->input->post('external_type'),
                    'external_model'            => $this->input->post('external_model'),
                    'external_serial'           => $this->input->post('external_serial'),
                    'hours'                     => $this->input->post('hours'),
                    'count'                     => $this->input->post('count'),
                    'other_afected'             => $this->input->post('other_afected'),
                    'use_protection'            => $this->input->post('use_protection'),
                    'protection_type'           => $this->input->post('protection_type'),
                    'protection_model'          => $this->input->post('protection_model'),
                    'aditional'                 => $this->input->post('aditional'),
                    'position'                  => json_encode($this->input->post('position')),    
                    'loudness'                  => $this->input->post('loudness'),
                    'time_interval'             => $this->input->post('time_interval'),
                    'image'                     => $this->input->post('image'),
                    'created_on'                => date("Y-m-d H:i:s")
                );

                if($this->measurements_model->add($data)) {
                    $output = array(
                        'type' => "success",
                    );
                } else {
                    $output = array(
                        'type' => "error",
                        'message' => "Error saving to database"
                    );
                }
            } else {
                $output = array(
                    'type' => "error",
                    'message' => "Nothing posted!"
                );
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }
}
