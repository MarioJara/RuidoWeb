<?php defined('BASEPATH') OR exit('No direct script access allowed');

abstract class AR_class extends CI_Model{
    
    protected $table = NULL;
       
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /*
     * Select data from $table based on 
     * $conditions = array(
     *              'where' => array(`column` => `value`,...) ONLY USE FOR AND!,
     *              'order' => array(`column` => ASC, DESC or RANDOM),
     *              'limit' => 'from, number_of_rows'
     */
    function select_simple($conditions = NULL){

        $this->db->select(isset($conditions['select']) ? $conditions['select'] : "*");
        
        if(isset($conditions['where']))
            $this->db->where($conditions['where']);
        
        if(isset($conditions['order']))
            foreach($conditions['order'] as $order => $by){
                $this->db->order_by($order, $by);
            }
        
        if(isset($conditions['limit'])){
            $limit = explode(",", $conditions['limit']);
            if(count($limit)>1){
                $query = $this->db->get($this->table,$limit[1],$limit[0]);
            }else{
                $query = $this->db->get($this->table,$limit[0],0);
            }
        }else{
            $query = $this->db->get($this->table);
        }
        
        if($query)
            return $query->result();
        return array();
    }
    
    /*
     * Select data by query.
     * For complex queries
     */
    function select_by_query($query){
        
        $query = $this->db->query($query);
        if($query)
            return $query->result();
        return array(0); 
    }
    
    function run_query($query){
        $query = $this->db->query($query);
        if($query)
            return TRUE;
        return FALSE; 
    }
    
    /*
     * Insert $data into $table.
     * $data = array(`column` => `value`, ...)
     * If we want to insert multiple values use "insert_more"
     */        
    function insert_it($data){
        $query =  $this->db->insert($this->table, $data);
        if($query)
                return $this->db->insert_id();
        return FALSE;
    }
    
    /*
     * Insert multiple data into table
     */
    function insert_all($data){
        $query =  $this->db->insert_batch($this->table, $data);
        if($query)
                return TRUE;
        return FALSE;
    }
    /*
     * Update $data into $table with $were condition
     * $data = array(`column` => `value`, ...)
     * $where = array(`column` => `value`,...)
     */ 
    function update($data, $where=NULL){
        if($this->db->update($this->table, $data, $where))
                return TRUE; 
        return FALSE;
    }
    
    /*
     * Delete from $table with $were condition
     * $where = array(`column` => `value`,...)
     * if $where is not set then empty table;
     */ 
    function delete($where){
        if(isset($where))
            $this->db->where($where);
        if($this->db->delete($this->table))
        {
            $this->run_query("ALTER TABLE $this->table AUTO_INCREMENT = 1");
            return TRUE; 
        }
        return FALSE;
    }
    
    /*
     * Delete from $table with $were condition
     * $where = array(`column` => `value`,...)
     * if $where is not set then empty table;
     */ 
    function truncate($table){
        if($this->db->truncate($table))
                return TRUE; 
        return FALSE;
    }
    
    function dropdown($conditions = NULL){
        $temp = $this->select_simple($conditions);
        $vars = explode(",", $conditions['select']);
        if(count($temp) > 0){
            foreach($temp as $t_object){
                $t = (array) $t_object;
                $dropdown[$t[trim($vars[0])]] = $t[trim($vars[1])];
            }
            return $dropdown;
        }
        return array();
    }
    
    function dropdown_selected($conditions = NULL){
        $dropdown_selected = $this->select_simple($conditions);
        $vars = explode(",", $conditions['select']);
        if(isset($dropdown_selected[0]))
            return $dropdown_selected[0]->$vars[0];
        return 0; 
    }
    
    function stats($conditions = array()){
        
        if(!is_array($conditions) || count($conditions)==0){
            return FALSE;
        }
        
        $interval = "(select -{$conditions['end']} N union all\n";
        for($i = ($conditions['end']+1); $i<$conditions['count_interval']; $i++){
            $interval .= "select -$i union all\n";
        }
        $interval .= "select -{$conditions['count_interval']}) N) N\n";
        
        $time_format = $conditions['is_timestamp'] ? "FROM_UNIXTIME($this->table.{$conditions['time_column']})" : "$this->table.{$conditions['time_column']}";
        
        $query = "SELECT DATE_FORMAT(N.PivotDate,'{$conditions['frame']}') AS {$conditions['frame_alias']}, COALESCE({$conditions['operation']}($this->table.{$conditions['count']}),0) AS {$conditions['count_alias']}
        FROM (
        select ADDDATE(NOW(), INTERVAL N {$conditions['frame_interval']}) PivotDate
        FROM $interval
        LEFT JOIN $this->table ON DATE_FORMAT(N.PivotDate,'{$conditions['frame']}')=DATE_FORMAT($time_format,'{$conditions['frame']}')
        GROUP BY {$conditions['frame_alias']}";
                        
        $query = $this->db->query($query);
        
        if($query)
            return $query->result();
        return array(); 
    }
}