<?php

 class Information_User extends MY_Controller
 {
  
  function __construct()
  {
    parent::__construct();
    $this->make_bread->add('Utilisateur', "administration/Information_User", 0);
    $this->breadcrumb = $this->make_bread->output();
  }
  

  function getOne(){

   // print_r($this->session->userdata('USER_PASSWORD'));

    $user_email= $this->session->userdata('DGPC_USER_EMAIL');
        
    $user= $this->Model->getOne('admin_users',array('USER_EMAIL'=>$this->session->userdata('DGPC_USER_EMAIL')));

    $personnel = $this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$user['PERSONNEL_ID']));

    $data['donnee']=$personnel;

    $data['title'] =("Modifier les Informations de l'utilisateur ".$user_email);
    //$this->make_bread->add('Modifier', "getOne/".$user_email, 1);
    $data['breadcrumb'] = $this->make_bread->output();
    $this->load->view('collaborateur/Modifier_Mes_Infos_View',$data);

  }

   public function update() { 

            //$id=$this->uri->segment(4);
            $idn = $this->input->post('idn');

            $user_email=$this->session->userdata('DGPC_USER_EMAIL');

            $user_id= $this->Model->getOne('admin_users',array('USER_EMAIL'=>$this->session->userdata('DGPC_USER_EMAIL')));

            $id_user=$user_id['USER_ID'];

                      $data = array(
                                'PERSONNEL_EMAIL'=>$this->input->post('EMAIL'),
                                'PERSONNEL_ODK'=>$this->input->post('ODK'),
                                'PERSONNEL_NOM'=>$this->input->post('NOM'),
                                'PERSONNEL_PRENOM'=>$this->input->post('PRENOM'),
                                'PERSONNEL_TELEPHONE'=>$this->input->post('TELEPHONE'),
                                'PERSONNEL_ADRESSE'=>$this->input->post('ADRESSE'),                                
                                'PERSONNEL_MATRICULE'=>$this->input->post('MATRICULE'),
                                'GRADE'=>$this->input->post('GRADE'),
                                'FONCTION'=>$this->input->post('FONCTION')
                                );
                       
            $sav=$this->Model->update('rh_personnel_dgpc',array('PERSONNEL_ID'=>$idn),$data);
                    
                      $array = array(
                                'USER_EMAIL'=>$this->input->post('EMAIL'),
                                'USER_ODK'=>$this->input->post('ODK'),
                                'USER_NOM'=>$this->input->post('NOM'),
                                'USER_PRENOM'=>$this->input->post('PRENOM'),
                                'USER_TELEPHONE'=>$this->input->post('TELEPHONE'),
                                'USER_ADRESSE'=>$this->input->post('ADRESSE'),                                
                                'USER_CODE'=>$this->input->post('MATRICULE'),
                                //'PERSONNEL_ID'=>$collaborateur_id,
                                //'USER_PASSWORD'=>$this->input->post('USER_PASSWORD2')
                                );
            $sav=$this->Model->update('admin_users',array('USER_ID'=>$id_user),$array);    
                
                   $msg = "<div class='alert alert-success'> <b>".$this->input->post('GRADE')." ".$this->input->post('NOM')." ".$this->input->post('PRENOM')."</b>, Vos modifications ont été prise en charge.</div>";

            $donne['msg'] =$msg;
            $this->session->set_flashdata($donne);

            redirect(base_url().'administration/Information_User/getOne/'.$idn);        

        }

  }