<?php

class MY_Controller extends CI_Controller {
   
   public function __construct()
   {
   	parent::__construct();
   	//$this->load->library('pagination');
   }

   public function layout($data=array())
   {
      $this->data = $data;
      $this->template['header'] = $this->load->view('template/header',$this->data,TRUE);
      $this->template['footer'] = $this->load->view('template/footer',$this->data,TRUE);
      $this->template['page'] = $this->load->view($this->page,$this->data,TRUE);

      $this->load->view('template/main',$this->template);
   }

   public function built_pagination($num_rows =0,$url ='',$per_page =10,$uri_segment=3)
   {
   	if($uri_segment === ''){
       $uri_segment = uri_string().'index';
   	}

     $config = array(
     	          'base_url' => $url,
     	          'total_rows'=>$num_rows,
     	          'per_page'=>$per_page,
     	          'uri_segment'=>$uri_segment,
     	          'next_link'=>'Suivant',
     	          'prev_link' );
     $this->pagination->initialize($config);
   	}

}	