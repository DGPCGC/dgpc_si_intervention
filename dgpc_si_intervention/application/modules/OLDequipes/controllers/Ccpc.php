<?php

 class Ccpc extends MY_Controller
 {
 	
 	function __construct()
 	{
 	  parent::__construct();
    $this->make_bread->add('Equipes', "equipes/Ccpc", 0);
    $this->breadcrumb = $this->make_bread->output();
 	  $this->autho();
    }

  public function autho()
    {
    if(empty($this->session->userdata('DGPC_USER_EMAIL'))){
        redirect(base_url());
       }
    }

    public function index()
    {
      $data['title'] = "Nouvelle CCPC";
      $data['breadcrumb'] = $this->make_bread->output();
      $data['provinces'] = $this->Model->getList('ststm_provinces');
      $data['ccpc'] = $this->Model->getList('rh_cppc');

      $this->load->view('ccpc/ccpc_New_View',$data);
    }

    public function save()
    {
       $this->form_validation->set_rules('CPPC', 'Nom', 'required');
       $this->form_validation->set_rules('CCPC_DESCR', 'Description', 'required');
       $this->form_validation->set_rules('PROVINCE_ID', 'Province', 'required');
       $this->form_validation->set_rules('COMMUNE_ID', 'commune', 'required');
       $this->form_validation->set_rules('CCPC_LONG', 'Longitude', 'required');
       $this->form_validation->set_rules('CCPC_LAT', 'Latitude', 'required');
       
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Nouvelle CCPC provinciale";
            $data['breadcrumb'] = $this->make_bread->output();
            $data['provinces'] = $this->Model->getList('ststm_provinces');
            $data['ccpc'] = $this->Model->getList('rh_cppc');

            $this->load->view('ccpc/ccpc_New_View',$data);
        }else{
            $array_ccpc = array(
                                'CPPC_ID'=>$this->input->post('CPPC'),
                                'DESCRIPTION'=>$this->input->post('CCPC_DESCR'),
                                'LONGITUDE'=>$this->input->post('CCPC_LONG'),
                                'LATITUDE'=>$this->input->post('CCPC_LAT'),
                                'COMMUNE_ID '=>$this->input->post('COMMUNE_ID'),
                                'USER_ID'=>$this->session->userdata('DGPC_USER_ID')
                                );
            $ccpc_id = $this->Model->insert_last_id('rh_ccpc',$array_ccpc);

            $msg = "<font color='red'>La CCPC <b>".$this->input->post('CCPC_DESCR')."</b> n'a pas été enregistré.</font>";
            if($ccpc_id >0){
              
              $msg = "<font color='green'> La CCPC <b>".$this->input->post('CCPC_DESCR')."</b> a été enregistré.</font>";
              $donne['msg'] =$msg;
              $this->session->set_flashdata($donne);

              //redirect(base_url().'equipes/Caserne/liste');
              redirect(base_url().'equipes/Ccpc');
            }

            
        }
    }

    public function edit($id)
    {
      if($_SERVER['REQUEST_METHOD']=='GET'){
      $ccpc_data=$this->Model->getOne('rh_ccpc',array('CCPC_ID'=>$id));
      $data['ccpc']=$ccpc_data;
      $data['title'] = "Modification CCPC";
      $data['breadcrumb'] = $this->make_bread->output();
      $data['provinces'] = $this->Model->getList('ststm_provinces');
      $data['commune']=$this->Model->getOne('ststm_communes',array('COMMUNE_ID'=>$ccpc_data['COMMUNE_ID']));
      $data['cppc'] = $this->Model->getList('rh_cppc');

      $this->load->view('ccpc/ccpc_Edit_View',$data);
      }else{      $array_ccpc=array(
                            'DESCRIPTION'=>$this->input->post('CCPC_DESCR'),
                                'LONGITUDE'=>$this->input->post('CCPC_LONG'),
                                'LATITUDE'=>$this->input->post('CCPC_LAT'),
                                'COMMUNE_ID '=>$this->input->post('COMMUNE_ID'),
                                'USER_ID'=>$this->session->userdata('DGPC_USER_ID')
                                );
          $ccpc_id = $this->Model->update('rh_ccpc',array('CCPC_ID'=>$id),$array_ccpc);

            $msg = "<font color='red'>Echec.</font>";
            if($ccpc_id){
              
              $msg = "<font color='green'>La modification reussie</font>";
              }
              $donne['msg'] =$msg;
              $this->session->set_flashdata($donne);

              //redirect(base_url().'equipes/Caserne/liste');
              redirect(base_url().'equipes/Ccpc/edit/'.$id);
            
      }
    }


    public function listing(){

    $list_ccpc=$this->Model->getList('rh_ccpc');
    $resultat=array();
    foreach ($list_ccpc as $ccpc) {
        $get_cppc=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$ccpc['CPPC_ID']));
        $get_commune=$this->Model->getOne('ststm_communes',array('COMMUNE_ID'=>$ccpc['COMMUNE_ID']));


        $get_id_manager=$this->Model->getOne('rh_ccpc_manager',array('CCPC_ID'=>$ccpc['CCPC_ID']));

        $info=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$get_id_manager['PERSONNEL_ID']));
        if(empty($info)){
          $identite='-';
        }else{
          $identite=$info['PERSONNEL_NOM'].' '.$info['PERSONNEL_PRENOM'];
        }

        $data=Null;
        $data[]=$ccpc['DESCRIPTION'];
        $data[]=$get_cppc['CPPC_NOM'];
        $data[]=$get_commune['COMMUNE_NAME'];
        $data[]=$identite;
        
        
        
        $data[]='<div class="dropdown ">
                    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Action
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href='.base_url("equipes/Ccpc/edit/").$ccpc["CCPC_ID"].'>Modifer</li>
                        <li><a href='.base_url("equipes/Ccpc/add_manager/").$ccpc["CCPC_ID"].'>Manager ccpc</li>
                        <li style="color:red"><a href="'.base_url("equipes/Ccpc/delete/").$ccpc["CCPC_ID"].'" >Supprimers</li>
                                
                    </ul>
                  </div>';
        //$data[]=$list_societes[''];
    $resultat[]=$data;
    }

    $template=array(
        'table_open'=>'<table id="mytable" class="table table-bordered table-stripped table-hover table-condensed table-responsive">',
        '<table_close'=>'</table>'
        );
        
        $this->table->set_heading('Description','CPPC','Commune','Manager','Action');
        $this->table->set_template($template);
    $datas['title']="Liste des CCPCs";
    $datas['table']=$resultat;
    $this->make_bread->add('Liste des CCPCs ', "listing", 1);
    $datas['breadcrumb'] = $this->make_bread->output();
    $this->load->view('ccpc/ccpc_Liste_View',$datas);
  }

  public function add_manager($id){
    
    if($_SERVER['REQUEST_METHOD']=='GET'){
        $datas['title']="Manager des CCPCs";
        $datas['personnel']=$this->Model->getList('rh_personnel_dgpc');
        $this->make_bread->add('Manager de CCPC ', "listing", 1);
        $datas['breadcrumb'] = $this->make_bread->output();
        $this->load->view('ccpc/manager_New_View',$datas);
    }else{


        $this->form_validation->set_rules('PERSONNEL_ID', 'Personnel', 'required');
        $this->form_validation->set_rules('DATE_DEBUT', 'Date debut', 'required');
        $this->form_validation->set_rules('CCPC_ID', 'ccpc', 'required');
        if ($this->form_validation->run() == FALSE) {
          $data['personnel']=$this->Model->getList('rh_personnel_dgpc');
            $data['title'] = "Manager CCPCs";
            $data['breadcrumb'] = $this->make_bread->output();
            $data['provinces'] = $this->Model->getList('ststm_provinces');
            $data['ccpc'] = $this->Model->getList('rh_cppc');

            $this->load->view('ccpc/manager_New_View',$data);
        }else{
          $date=new DateTime($this->input->post('DATE_DEBUT'));
          $date_new=$date->format('Y-m-d');
            $array_manager = array(
                                'CCPC_ID'=>$this->input->post('CCPC_ID'),
                                'PERSONNEL_ID'=>$this->input->post('PERSONNEL_ID'),
                                'DATE_DEBUT'=>$date_new,
                                'USER_ID'=>$this->session->userdata('DGPC_USER_ID')
                                );

            $check=$this->Model->checkvalue('rh_ccpc_manager',array('CCPC_ID'=>$this->input->post('CCPC_ID'),'PERSONNEL_ID'=>$this->input->post('PERSONNEL_ID')));
            $perso_id=$this->input->post('PERSONNEL_ID');
            $ccpc_id_cn=$this->input->post('CCPC_ID');
            $checkmangeexit=$this->Model->querysql("SELECT * FROM rh_ccpc_manager WHERE CCPC_ID='$ccpc_id_cn' AND PERSONNEL_ID !='$perso_id'");

            if($check==TRUE){
              $msg = "<font color='red'>Ce manager gère déjà cette CCPC.</font>";
            }elseif(!empty($checkmangeexit)){
              $checklastmanager=$this->Model->getLast('rh_ccpc_manager',array('CCPC_ID'=>$ccpc_id_cn),'CCPC_MANAGER_ID');
              $update=$this->Model->update('rh_ccpc_manager',array('CCPC_MANAGER_ID'=>$checklastmanager['CCPC_MANAGER_ID']),array('DATE_FIN'=>$date_new));


              $manager_id = $this->Model->insert_last_id('rh_ccpc_manager',$array_manager);

              $msg = "<font color='red'>Le manager n'a pas été enregistré.</font>";
            }else{
            $manager_id = $this->Model->insert_last_id('rh_ccpc_manager',$array_manager);

            $msg = "<font color='red'>Le manager n'a pas été enregistré.</font>";
            
          }
            if($manager_id >0){
              
              $msg = "<font color='green'> Le manager a été enregistré.</font>";
              
              
            }
            $donne['msg'] =$msg;
            $this->session->set_flashdata($donne);
            redirect(base_url().'equipes/Ccpc/add_manager/'.$this->input->post('CCPC_ID'));

        }
    }
  }

  public function delete($id){
        $delete=$this->Model->delete('rh_ccpc_manager',array('CCPC_ID'=>$id));
        $delete=$this->Model->delete('rh_ccpc',array('CCPC_ID'=>$id));
        if($delete){
            $msg="<div class='alert alert-success'>Suppression reussie!</div>";
        }else{
            $msg="<div class='alert alert-danger'>Echec!</div>";
        }
            $donne['msg'] =$msg;
            $this->session->set_flashdata($donne);
            redirect(base_url().'equipes/Ccpc/listing');
    }


}

?>