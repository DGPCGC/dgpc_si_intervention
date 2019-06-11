
<?php

class Model_Demande extends CI_Model{

  function __construct() {
  parent::__construct();  
    }

    public function make_query($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
    {
    	$this->db->select($select_column);
    	$this->db->from($table);

    	if($critere_txt != NULL){
    		$this->db->where($critere_txt);
    	}
    	if(!empty($critere_array))
    	$this->db->where($critere_array);
        //$this->db->order_by($order_by);
    }
    
    public function make_datatables($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
    {
    	$this->make_query($table,$select_column,$critere_txt,$critere_array,$order_by);
    	if($_POST['length'] != -1){
           $this->db->limit($_POST["length"],$_POST["start"]);
    	}
    	$query = $this->db->get();
    	return $query->result();
    }

    public function get_filtered_data($table,$select_column,$critere_txt,$critere_array,$order_by)
    {
    	$this->make_query($table,$select_column,$critere_txt,$critere_array,$order_by);
    	$query = $this->db->get();
    	return $query->num_rows();
    	
    }

    public function count_all_data($table,$critere = array())
    {
       $this->db->select('*');
       $this->db->where($critere);
       $this->db->from($table);
       return $this->db->count_all_results();	
    }



  }
