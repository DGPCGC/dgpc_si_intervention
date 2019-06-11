<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Password_Oublier extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($params = NULL) {
       
            $datas['message'] = $params;
            $this->load->view('password_renew', $datas);
        
    }

    public function check() {

        $login = $this->input->post('USERNAME');
        
        $criteresmail= array('USER_EMAIL'=>$login);
        //$user= $this->Model->getOne('admin_users',$criteresmail); 
        $users=$this->Model->checkvalue('admin_users', array('USER_EMAIL'=>$login));

        //print_r($users);
       // exit();             
        
       if($users!=1){
            
              //$this->session->set_flashdata($data);           
              $message = "<div class='alert alert-danger'> L'utilisateur n'existe pas/plus dans notre système informatique!</div>";
              //$this->index($message);
              $data['message'] = $message;
              //print_r($data['message']) ;
              //exit();
              $this->load->view('password_renew', $data);
        }else{
              
              $login = $this->input->post('USERNAME');
              $criteresmail= array('USER_EMAIL'=>$login);
              $user= $this->Model->getOne('admin_users',$criteresmail);
              $id_user=$user['USER_ID'];

              $password = $this->notifications->generate_password(8);


              $data = array(
                                'USER_EMAIL'=>$user['USER_EMAIL'],
                                'USER_ODK'=>$user['USER_ODK'],
                                'USER_NOM'=>$user['USER_NOM'],
                                'USER_PRENOM'=>$user['USER_PRENOM'],
                                'USER_TELEPHONE'=>$user['USER_TELEPHONE'],
                                'USER_ADRESSE'=>$user['USER_ADRESSE'],                                
                                'USER_CODE'=>$user['USER_CODE'],
                                //'PERSONNEL_ID'=>$user['PERSONNEL_ID'],
                                'PERSONNEL_ID'=>"1",
                                'USER_PASSWORD'=>md5($password)
                                );
            $sav=$this->Model->update('admin_users',array('USER_ID'=>$id_user),$data);
                        
            $msg_mail = "Chèr(e) ".$user['USER_NOM']." ".$user['USER_PRENOM'].", vos IDs de connexion sur l'appliction <a href=".base_url().">DGPC Centre de situation</a> sont <br> Email: ".$this->input->post('USERNAME')."<br> et Mot de passe: ".$password." <br> Cordialement.";
             $this->notifications->send_mail(array($this->input->post('USERNAME')),'DGPC SI vous nouveaux IDs de connexion',array(),$msg_mail,array());

           $message = "<font color='green'>Chèr(e) <b>".$user['USER_NOM']." ".$user['USER_PRENOM']."</b>, Vos IDs de connexion ont été mise à jour. Veuillez consulter votre boite Email.</font>";
            $datas['message'] = $message;
         
            $this->load->view('Login_View', $datas);

            //redirect(base_url().'Login');
           }  
        }

    }

