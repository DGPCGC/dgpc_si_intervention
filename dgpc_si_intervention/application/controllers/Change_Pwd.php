<?php

 class Change_Pwd extends CI_Controller {

    public function __construct() {
        parent::__construct();
         $this->is_Oauth();
        $this->make_bread->add('Password', "Change_Pwd", 0);
        $this->breadcrumb = $this->make_bread->output();
    }

      public function is_Oauth()
    {
       if($this->session->userdata('DGPC_USER_EMAIL') == NULL)
        redirect(base_url());
    }

     function index() 
     {
        $this->make_bread->add('Changer mot de passe', " ", 1);
        $data['breadcrumb'] = $this->make_bread->output(); 
        $data['msg']="";
        $this->load->view('Change_Pwd_View',$data);

     }

     function changer_info(){
      if($_SERVER['REQUEST_METHOD']=='GET'){

          $data['infor']=$this->Model->getOne('admin_collaborateurs',array('COLLABORATEUR_EMAIL'=>$this->session->userdata('DGPC_USER_EMAIL')));
          $this->make_bread->add('Changer Information', " ", 1);
          $data['breadcrumb'] = $this->make_bread->output(); 
          $data['msg']="";
          $this->load->view('Change_Information_View',$data);
        }
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $this->form_validation->set_rules('NOM_COLAB','','trim|required',array('required'=>'<font size="2">Le nom est obligatoire</font>'));
        $this->form_validation->set_rules('PRENOM_COLAB','','trim|required',array('required'=>'<font size="2">Le prenom est requis</font>'));
        $this->form_validation->set_rules('DATE_NAISSANCE','','trim|required',array('required'=>'<font size="2">La date naissance est requise</font>'));

        $this->form_validation->set_rules('TELEPHONE','','trim|required',array('required'=>'<font size="2">La Téléphone est requis</font>'));
       $this->form_validation->set_rules('ADRESSE_COLAB','','trim|required',array('required'=>'<font size="2">La date naissance est requise</font>'));

       if($this->form_validation->run()==TRUE)
           {
              $data=array(
                'COLLABORATEUR_NOM'=>$this->input->post('NOM_COLAB'),
                'COLLABORATEUR_PRENOM'=>$this->input->post('PRENOM_COLAB'),
                'DATE_NAISSANCE'=>$this->input->post('DATE_NAISSANCE'),
                'COLLABORATEUR_TELEPHONE  '=>$this->input->post('TELEPHONE'),
                'COLLABORATEUR_ADRESSE '=>$this->input->post('ADRESSE_COLAB'),
                );
              if(!empty($this->session->userdata('DGPC_USER_EMAIL'))){
                 $update=$this->Model->update('admin_collaborateurs',array('COLLABORATEUR_EMAIL'=>$this->session->userdata('DGPC_USER_EMAIL')),$data);
                 if($update){
                   $data['msg']="<div class='alert alert-success'>Modification reussie!</div>";
                    $data['infor']=$this->Model->getOne('admin_collaborateurs',array('COLLABORATEUR_EMAIL'=>$this->session->userdata('DGPC_USER_EMAIL')));
                 }
              }
           



           }else{
              $data['infor']=$this->Model->getOne('admin_collaborateurs',array('COLLABORATEUR_EMAIL'=>$this->session->userdata('DGPC_USER_EMAIL')));
              $data['msg']="";
              

           }
           
           $this->make_bread->add('Changer Information', " ", 1);
           $data['breadcrumb'] = $this->make_bread->output(); 
           $this->load->view('Change_Information_View',$data);








      }

     }

    function changer()
        {

    $this->form_validation->set_rules('ACTUEL_PASSWORD','','trim|required',array('required'=>'<font size="2"> Le mot de passe actuel est obligatoire </font>'));
    $this->form_validation->set_rules('NEW_PASSWORD','','trim|required',array('required'=>'<font size="2"> Le nouveau mot de passe est obligatoire </font>'));

    $this->form_validation->set_rules('PASSWORDCONFIRM','','trim|required|matches[NEW_PASSWORD]',array('required'=>'La confirmation du nouveau mot de passe est obligatoire'),array('matches[NEW_PASSWORD]'=>'La confirmation du nouveau mot de passe et le nouveau mot de passe sont uniforme'));
       if($this->form_validation->run()==TRUE)
           {
            $criteres['USER_EMAIL']=$this->session->userdata('DGPC_USER_EMAIL');
            $curentpassword=$this->Model->getOne('admin_users',$criteres);

            if($curentpassword['USER_PASSWORD']==md5($this->input->post('ACTUEL_PASSWORD')))
               {
              $password=md5($this->input->post('NEW_PASSWORD'));
              $confirmpasswd=md5($this->input->post('PASSWORDCONFIRM'));
              $data=array(
               
               'USER_PASSWORD'=>$password
              );

              $criteres['USER_EMAIL']=$this->session->userdata('DGPC_USER_EMAIL');
              $this->Model->update('admin_users',$criteres,$data);
              $data['message']='<div class="alert alert-success text-center">Changement de mot de passe fait avec succès! vous pouvez vous connecter</div>';
              $this->session->set_flashdata($data);
              redirect(base_url('Login/do_logout'));
              }
              else{
                $this->make_bread->add('Changer mot de passe', " ", 1);
                $data['breadcrumb'] = $this->make_bread->output(); 
                $data['msg']="<div class='alert alert-danger' style='text-align:center'>Mot de passe actuel n'est pas correct</div>";
                $this->load->view('Change_Pwd_View',$data);
              }
            }

        else{
          $data['msg']="";
          $this->make_bread->add('Changer mot de passe', " ", 1);
          $data['breadcrumb'] = $this->make_bread->output(); 
          $this->load->view('Change_Pwd_View',$data);
            }
        }
 }