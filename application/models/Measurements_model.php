<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require_once APPPATH.'/libraries/AR_class.php';

class Measurements_model extends AR_class{
    function __construct() {
        parent::__construct();
        $this->table = 'measurements';
    }
    
    function add($data = array()) {
        $id = $this->insert_it($data);
        if($data['loudness'] >= 80) {
            $this->send_alert("admin", $id);
        }
        
        $this->send_alert($data['email'], $id);
        
        return $id;
    }
    
    function get_grouped() {
        $sql = "SELECT company, admin, space, COUNT(id) AS count
                FROM measurements
                GROUP BY company, admin, space
                ORDER BY created_on DESC";
        return $this->select_by_query($sql);
    }
    
    function get_companies() {
        $sql = "SELECT DISTINCT company, admin FROM measurements";
        return $this->select_by_query($sql);
    }
    
    function get_spaces($company = "dsdsa") {
        $sql = "SELECT DISTINCT space, company FROM measurements";
        return $this->select_by_query($sql);
    }
    
    function get_download($date, $date_to, $admin, $company, $space) {
        $sql = "SELECT created_on AS fecha_medicion, id, position AS latitud_lognitud, loudness AS nivel_ruido,
                time_interval AS duracion, company AS empresa, admin AS mutualidad, email, area AS area, space AS puesto,
                tasks AS tarea, events_characteristics AS tipo_medicion, external_type AS marca_sonometro,
                external_model AS modelo_sonometro, external_serial AS numero_serie_sonometro,
                primary_source AS fuente, other_sources AS otras_fuentes, hours AS tpo_exposicion, count AS cant_trabajadores,
                other_afected AS otros_puestos, use_protection AS uso_proteccion, protection_type AS tipo_proteccion,
                protection_model AS info_proteccion, aditional AS observaciones FROM measurements WHERE 
                admin = '$admin' AND company='$company' AND space='$space' AND
                DATE(created_on) >= '$date' and DATE(created_on) <= '$date_to'";
        
        //echo $sql; exit;
        
        $this->load->dbutil();
        $query = $this->db->query($sql);
        $delimiter = ",";
        $newline = "\r\n";
        return $this->dbutil->csv_from_result($query, $delimiter, $newline);
    }
    
    function get_single_download($id) {
        $sql = "SELECT created_on AS fecha_medicion, id, position AS latitud_lognitud, loudness AS nivel_ruido, company AS empresa,
                admin AS mutualidad, email, space AS puesto, tasks AS tarea, events_characteristics AS tipo_medicion,
                primary_source AS fuente, other_sources AS otras_fuentes, hours AS tpo_exposicion, count AS cant_trabajadores,
                other_afected AS otros_puestos, use_protection AS uso_proteccion, protection_type AS tipo_proteccion,
                protection_model AS info_proteccion, aditional AS observaciones FROM measurements
                WHERE id = '$id'";
        
        //echo $sql; exit;
        
        $this->load->dbutil();
        $query = $this->db->query($sql);
        $delimiter = ",";
        $newline = "\r\n";
        return $this->dbutil->csv_from_result($query, $delimiter, $newline);
    }
    
    function get_by_company($admin = NULL, $company = NULL, $space = NULL) {
        
        if(empty($company)) return array();
        
        return $this->select_simple(array('where' => array('admin' => $admin, 'company' => $company, 'space' => $space)));
    }
    
    function get_single($id = NULL) {
        
        if(empty($id)) return NULL;
        
        $records = $this->select_simple(array('where' => array('id' => $id)));
        
        if(count($records) == 0) {
            return NULL;
        }
        
        return $records[0];
    }
    
    function send_alert($to, $id) {
        
        /*
        $mails = array(
            "rocio" => "",
            "milan" => "milan.djidara@gmail.com"
        );
         * 
         */
        
        $template = "emails/alert";
        $subject = "Registro de medición con Apprexor";

        if($to == "admin") {
            $to = "rocioola@gmail.com";
            $template = "emails/alert_admin";
            $subject = "Alerta Episodio de ruido Apprexor";
        } else if($to == "milan") {
            $to = "milan.djidara@gmail.com";
        }
        
        $this->load->library('email');

        $data['item'] = $this->get_single($id);
        
        $data['item']->level = "Tarea con probable nivel sobre 10 veces el límite permisible para 8 horas de exposición.";
        if($data['item']->loudness <= 80) {
            $data['item']->level = "Tarea de probable nivel bajo";
        } else if($data['item']->loudness > 80 && $data['item']->loudness <= 82) {
            $data['item']->level = "Tarea con probable nivel sobre criterio de exposición de 80 dB (A).";
        } else if($data['item']->loudness > 82 && $data['item']->loudness <= 85) {
            $data['item']->level = "Tarea con probable nivel sobre el criterio de acción de 82 dB(A).";
        } else if($data['item']->loudness > 85 && $data['item']->loudness <= 95) {
            $data['item']->level = "Tarea con probable nivel sobre el límite permisible para 8 horas de exposición.";
        }
        
        $message = $this->load->view($template, $data, TRUE);
        
        $config = array(
           'mailtype' => "html" 
        );

        $this->email->initialize($config);

        $this->email->from('reportes@apprexor.udd.cl', 'APPrexor');
        $this->email->to($to);

        $this->email->subject($subject);
        $this->email->message($message);

        return $this->email->send();
    }
}