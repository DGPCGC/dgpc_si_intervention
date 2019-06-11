<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($params = NULL) {
        if (!empty($this->session->userdata('DGPC_USER_EMAIL'))) {
        redirect(base_url().'tickets/Tickets/liste');
        } else {
            $datas['message'] = $params;
            $this->load->view('Login_View', $datas);
         }
    }

    public function do_login() {
        $login = $this->input->post('USERNAME');
        $password = $this->input->post('PASSWORD');

        $criteresmail= array('USER_EMAIL'=>$login);
        $user= $this->Model->getOne('admin_users',$criteresmail);              
        
        if (!empty($user)) {
            
            if ($user['USER_PASSWORD'] == md5($password))
             {  
               $mon_equipe = $this->Model->getOne('rh_equipe_membre_cppc',array('PERSONEL_ID'=> $user['PERSONNEL_ID']));
                $ma_cppc = $this->Model->getOne('rh_equipe_cppc',array('EQUIPE_ID'=> $mon_equipe['EQUIPE_ID']));
                   $is_cppc = 0;
                   $cppc_id= 0;

                   //print_r($mon_equipe);
                   if(empty($mon_equipe))
                   {
                      $cpp_manager = $this->Model->getOne('rh_cppc_manager',array('PERSONNEL_ID'=> $user['PERSONNEL_ID']));
                     // print_r($cpp_manager);
                      if(!empty($cpp_manager)){
                        $is_cppc = 1;
                     $cppc_id = $cpp_manager['CPPC_ID'];
                      }  
                   }else{
                    $is_cppc =1;
                     $cppc_id = $ma_cppc['CPPC_ID'];
                   } 

                $session = array(
                    'DGPC_USER_ID' => $user['USER_ID'],
                    'DGPC_PERSONNEL_ID' => $user['PERSONNEL_ID'],
                    'DGPC_CPPC_ID' => $cppc_id,
                    'DGPC_USER_EMAIL' => $user['USER_EMAIL'],
                    'DGPC_USER_NOM' => $user['USER_NOM'],
                    'DGPC_USER_PRENOM' => $user['USER_PRENOM'],
                    'DGPC_USER_CODE' => $user['USER_CODE'],
                    'DGPC_USER_ODK' => $user['USER_ODK']
                );
                

	               $this->session->set_userdata($session);
	                redirect(base_url().'tickets/Tickets/liste');
                   //redirect(base_url().'equipes/Horaire/odk_form');
                 //  redirect(base_url().'geolocalisation/Map/enintervention');
            }

             else
                $message = "<div class='alert alert-danger'> Le nom d'utilisateur ou/et mot de passe incorect(s) !</div>";
        }
         else
            $message = "<div class='alert alert-danger'> L'utilisateur n'existe pas/plus dans notre système informatique !</div>";
       $this->index($message);

    }

    public function do_logout()
    {
        $session = array(
                    'DGPC_USER_ID' => NULL,
                    'DGPC_PERSONNEL_ID' => NULL,
                    'DGPC_CPPC_ID' => NULL,
                    'DGPC_USER_EMAIL' => NULL,
                    'DGPC_USER_NOM' => NULL,
                    'DGPC_USER_PRENOM' => NULL,
                    'DGPC_USER_CODE' => NULL,
                    'DGPC_USER_ODK' => NULL
            );

		        $this->session->set_userdata($session);
		        redirect(base_url('Login'));
	}
}
