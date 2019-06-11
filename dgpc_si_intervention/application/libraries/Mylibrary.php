<?php

class Mylibrary 
{
      protected $CI;	
	function __construct()
	{
	  $this->CI = & get_instance();
      $this->CI->load->library('email');
      $this->CI->load->model('Model');
	}

	public function getOne($table, $array)
	{
		return $this->CI->Model->getOne($table,$array);
	}

	public function checkProfil($user_id)
	{
	   $datas = $this->CI->Model->check_profile($user_id);
        
       $sous_menu = '';
	   if(!empty($datas)){
          foreach ($datas as $data) {
          	$sous_menu .="<li><a href='".base_url("tickets/Intervention/rapport_ticket/").$data['NIVEAU_VALIDATION']."'>Rapport d'intervention</a>
                                </li>"; 
          }
	   }

	   echo $sous_menu;	
	}

	public function get_permission($url)
	{   
		//echo $url;
		$autorised = 0;
		if(empty($this->CI->Model->getOne('admin_fonctionnalites',array('FONCTIONNALITE_URL'=>$url)))){
          $autorised =1;
		}else{
			$data = $this->CI->Model->get_permission($url);
			
		  if(!empty($data))
		  	{
		  		$autorised =1;
		  	} 
	  }

	  return $autorised;
	}

	public function verify_is_admin()
	{   
		$autorised = 0;
		$autho = $this->CI->Model->verify_admin_dgpc();

	   if(!empty($autho)){
        $autorised = 1;
	   }
	    return $autorised;
	}

	public function verify_standard_dgpc($user_id)
	{   
		$autorised = 0;
		$autho = $this->CI->Model->verify_standard_dgpc($user_id);

	   if(!empty($autho)){
        $autorised = 1;
	   }
	    return $autorised;
	}
}
?>