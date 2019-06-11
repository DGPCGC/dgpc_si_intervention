<?php

 class Caserne extends MY_Controller
 {
 	
 	function __construct()
 	{
 	  parent::__construct();
    $this->make_bread->add('CPPC', "equipes/Caserne", 0);
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
      $data['title'] = "Nouvelle CPPC provinciale";
      $data['breadcrumb'] = $this->make_bread->output();
      $data['provinces'] = $this->Model->getList('ststm_provinces');
      $data['services'] = $this->Model->getList('rh_service_dgpc');

      $this->load->view('caserne/Casernes_New_View',$data);
    }

    public function save()
    {
       $this->form_validation->set_rules('CPPC_NOM', 'Nom', 'required|is_unique[rh_cppc.CPPC_NOM]',array("is_unique"=>"<font color='red'>Ce nom existe deja</font>"));
       $this->form_validation->set_rules('CPPC_EMAIL', 'Email', 'required|valid_email',array("valid_email"=>"<font color='red'>email n'est pas valide</font>"));
       $this->form_validation->set_rules('CPPC_DESCR', 'Description', 'required');
       $this->form_validation->set_rules('CPPC_TEL', 'Télephone', 'required');
       $this->form_validation->set_rules('PROVINCE_ID', 'Province', 'required');
       $this->form_validation->set_rules('CASERNE_LONG', 'Longitude', 'required');
       $this->form_validation->set_rules('SERVICE_DGPC_ID', 'Service DGPC', 'required');
       $this->form_validation->set_rules('CASERNE_LAT', 'Latitude', 'required');
       
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Nouvelle CPPC provinciale";
            $data['breadcrumb'] = $this->make_bread->output();
            $data['provinces'] = $this->Model->getList('ststm_provinces');
            $data['services'] = $this->Model->getList('rh_service_dgpc');

            $this->load->view('caserne/Casernes_New_View',$data);
        }else{
            $execution =$this->input->post('CPPC_EMAIL');
            $emails=$this->Model->checkvalue('rh_cppc',array('CPPC_EMAIL'=>$execution));
            $phone=$this->Model->checkvalue('rh_cppc',array('CPPC_TEL'=>"+257".$this->input->post('CPPC_TEL')));
            
         if($emails ==1){
            $data['msg']='<div class="alert alert-success text-center">le Email <b> '.$execution.' </b> existe déjà</div>';
            $this->session->set_flashdata($data); 
           redirect(base_url().'equipes/Caserne');
           }
        if($phone ==1){
            $data['msg']='<div class="alert alert-success text-center">le numéro <b> +257'.$this->input->post('CPPC_TEL').' </b> existe déjà</div>';
            $this->session->set_flashdata($data); 
           redirect(base_url().'equipes/Caserne');
           
        }else{
            $array_equipe = array(
                                'CPPC_NOM'=>$this->input->post('CPPC_NOM'),
                                'CPPC_TEL'=>"+257".$this->input->post('CPPC_TEL'),
                                'CPPC_DESCR'=>$this->input->post('CPPC_DESCR'),                                
                                'CPPC_EMAIL'=>$this->input->post('CPPC_EMAIL'),
                                'PROVINCE_ID'=>$this->input->post('PROVINCE_ID'),
                                'LONGITUDE'=>$this->input->post('CASERNE_LONG'),
                                'LATITUDE'=>$this->input->post('CASERNE_LAT'),
                                'SERVICE_DGPC_ID'=>$this->input->post('SERVICE_DGPC_ID'),
                                'USER_ID'=>$this->session->userdata('DGPC_USER_ID')
                                );
            $caserne_id = $this->Model->insert_last_id('rh_cppc',$array_equipe);

            $msg = "<font color='red'>La CPPC <b>".$this->input->post('CPPC_NOM')."</b> n'a pas été enregistré.</font>";
            if($caserne_id >0){
              
              $msg = "<font color='green'> La CPPC <b>".$this->input->post('CPPC_NOM')."</b> a été enregistré.</font>";
              $donne['msg'] =$msg;
              $this->session->set_flashdata($donne);

              redirect(base_url().'equipes/Caserne/liste');
            }

            
        }
    }

    }
    public function liste()
    {
        $data['title'] = "Les CPPCs";
        $data['breadcrumb'] = $this->make_bread->output();

        $fetch_casernes = $this->Model->getListOrdered('rh_cppc', 'CPPC_NOM', array());
        //print_r($fetch_casernes);
        //exit();

        // print_r($fetch_tickets);
        $datas = array();
        foreach ($fetch_casernes as $row) {
            $sub_array = array();           
            $equipes = $this->Model->getList('rh_equipe_cppc',array('CPPC_ID'=>$row['CPPC_ID']));
            
            $mes_equipes ='';
            
            foreach ($equipes as $equipe) {
                    $mes_equipes .= $equipe['EQUIPE_NOM']." ".$equipe['EQUIPE_TEL']."\n";
                }
            
            $province = $this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$row['PROVINCE_ID']));
            $get_id_manager=$this->Model->getLast('rh_cppc_manager',array('CPPC_ID'=>$row['CPPC_ID']),'CPPC_MANAGER_ID');
            $info=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$get_id_manager['PERSONNEL_ID']));
            if(empty($info)){
              $identite='-';
            }else{
              $identite=$info['PERSONNEL_NOM'].' '.$info['PERSONNEL_PRENOM'];
            }
           
            $sub_array[] = $row['CPPC_NOM'];
            $sub_array[] = $row['CPPC_DESCR'];
            $sub_array[] = $row['CPPC_TEL'];
            $sub_array[] = $row['CPPC_EMAIL'];
            $sub_array[] = $province['PROVINCE_NAME'];
            $sub_array[] = '<label title="'.$mes_equipes.'">'.count($equipes).'</label>';
            $sub_array[]=$identite;

           if($this->mylibrary->verify_is_admin() ==1){

            $options = '<div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            '; 
            
            $options .= "<li><a href='" . base_url('equipes/Caserne/Modifier/' . $row['CPPC_ID']) . "'>Modifier</li>";
            $options .= "<li><a href='" . base_url('equipes/Caserne/Detail/' . $row['CPPC_ID']) . "'>Detail</a></li>";
            
            $options .= "<li><a href='" . base_url('equipes/Affectation_equipe/index/' . $row['CPPC_ID']) . "'>Equipes & Effectis</a></li>";

            $options .= "<li><a href='" . base_url('equipes/Caserne/add_manager/' . $row['CPPC_ID']) . "'>Manager CPPC</li>";
                      
            $options .= "<li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete" . $row['CPPC_ID'] . "'><font color='red'>Supprimer</font></button></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete" . $row['CPPC_ID'] . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Supprimer :<b>" . $row['CPPC_NOM'] . "</b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('equipes/Caserne/supprimer/' . $row['CPPC_ID']) . "'>Supprimer</a>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    ";

            $sub_array[] = $options;
             }
            $datas[] = $sub_array;
        }
        $template = array(
            'table_open' => '<table id="collabo_list" class="table table-bordered table-striped table-hover table-condensed table-responsive">',
            'table_close' => '</table>'
        );
        if($this->mylibrary->verify_is_admin() ==1){
          $this->table->set_heading('NOM','DESCRIPTION','TEL','EMAIL','PROVINCE','EQUIPES','MANAGER','OPTIONS');
        }else{
          $this->table->set_heading('NOM','DESCRIPTION','TEL','EMAIL','PROVINCE','EQUIPES','MANAGER');
        }
        $this->table->set_template($template);
        $data['collabo_list'] = $datas;
         $data['breadcrumb'] = $this->make_bread->output();
        $this->load->view('caserne/Casernes_Liste_View', $data);
    }

    public function listing(){

    $list_cppc=$this->Model->getList('rh_cppc',array());
    // print_r($list_cppc);
    // exit();
    $resultat=array();
    foreach ($list_cppc as $cppc) {
        
        $get_province=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$cppc['PROVINCE_ID']));


        $get_id_manager=$this->Model->getOne('rh_cppc_manager',array('CPPC_ID'=>$cppc['CPPC_ID']));
        $equipes=count($this->Model->getList('rh_equipe_cppc',array('CPPC_ID'=>$cppc['CPPC_ID'])));
        $info=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$get_id_manager['PERSONNEL_ID']));
        if(empty($info)){
          $identite='-';
        }else{
          $identite=$info['PERSONNEL_NOM'].' '.$info['PERSONNEL_PRENOM'];
        }
        $equipes = $this->Model->getList('rh_equipe_cppc',array('CPPC_ID'=>$cppc['CPPC_ID']));
        $mes_equipes ='';
            
            foreach ($equipes as $equipe) {
                    $mes_equipes .= $equipe['EQUIPE_NOM']." ".$equipe['EQUIPE_TEL']."\n";
                };
            

        $data=Null;
        $data[]=$cppc['CPPC_NOM'];
        $data[]=$cppc['CPPC_DESCR'];
        $data[]=$cppc['CPPC_TEL'];
        $data[]=$cppc['CPPC_EMAIL'];
        $data[]=$get_province['PROVINCE_NAME'];
        $data[]='<label title="'.$mes_equipes.'">'.count($equipes).'</label>';;
        $data[]=$identite;
        $options = '<div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            ';
            
            $options .= "<li><a href='".base_url('equipes/Caserne/Modifier/'.$cppc['CPPC_ID'])."'>Modifier</li>";
            $options .= "<li><a href='".base_url('equipes/Caserne/Detail/'.$cppc['CPPC_ID'])."'>Detail</a></li>";
            $options .= "<li><a href='".base_url('equipes/Caserne/add_manager/'.$cppc['CPPC_ID'])."'>Manager CPPC</li>";
                      
            $options .= "<li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete".$cppc['CPPC_ID']. "'><font color='red'>Supprimer</font></button></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete".$cppc['CPPC_ID']."'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Supprimer :<b>".$cppc['CPPC_NOM']."</b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='". base_url('equipes/Caserne/supprimer/'.$cppc['CPPC_ID'])."'>Supprimer</a>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>";

            $data[] = $options;
        
        
        //$data[]=$list_societes[''];
    $resultat[]=$data;
    }

    $template=array(
        'table_open'=>'<table id="mytable" class="table table-bordered table-stripped table-hover table-condensed table-responsive">',
        '<table_close'=>'</table>'
        );
        
        $this->table->set_heading('NOM','DESCRIPTION','TEL','EMAIL','PROVINCE','EQUIPES','MANAGER','OPTIONS');
        $this->table->set_template($template);
    $datas['title']="Liste des CPPCs";
    $datas['table']=$resultat;
    $this->make_bread->add('Liste des CPPCs ', "listing", 1);
    $datas['breadcrumb'] = $this->make_bread->output();
    $this->load->view('caserne/Casernes_Liste_View',$datas);
  }

  /*

    public function get_casernes()
    {
      $var_search = $_POST['search']['value'];

        $table = "rh_cppc";
        $critere_txt = !empty($_POST['search']['value']) ? ("CPPC_NOM LIKE '%$var_search%' OR CPPC_DESCR LIKE '%$var_search%' OR CPPC_TEL LIKE '%$var_search%' OR CPPC_EMAIL LIKE '%$var_search%'") : NULL;
        $critere_array = array();
        $order_column = array('CPPC_NOM', 'CPPC_DESCR','CPPC_TEL', 'CPPC_EMAIL');
        $order_by = isset($_POST['order']) ? array($order_column[$_POST['order']['0']['column']] => $_POST['order']['0']['dir']) : array('CPPC_ID' => 'DESC');
        $select_column = array('CPPC_NOM', 'CPPC_DESCR', 'CPPC_ID','CPPC_TEL', 'CPPC_EMAIL','PROVINCE_ID');

        $fetch_casernes = $this->Model->make_datatables($table, $select_column, $critere_txt, $critere_array, $order_by);
        //print_r($fetch_casernes);
        //exit();

        // print_r($fetch_tickets);
        $data = array();
        foreach ($fetch_casernes as $row) {
            $sub_array = array();           
            $equipes = $this->Model->getList('rh_equipe_cppc',array('CPPC_ID'=>$row->CPPC_ID));
            
            $mes_equipes ='';
            
            foreach ($equipes as $equipe) {
                    $mes_equipes .= $equipe['EQUIPE_NOM']." ".$equipe['EQUIPE_TEL']."\n";
                }
            
            $province = $this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$row->PROVINCE_ID));
            $get_id_manager=$this->Model->getLast('rh_cppc_manager',array('CPPC_ID'=>$row->CPPC_ID),'CPPC_MANAGER_ID');
            $info=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$get_id_manager['PERSONNEL_ID']));
            if(empty($info)){
              $identite='-';
            }else{
              $identite=$info['PERSONNEL_NOM'].' '.$info['PERSONNEL_PRENOM'];
            }
           
            $sub_array[] = $row->CPPC_NOM;
            $sub_array[] = $row->CPPC_DESCR;
            $sub_array[] = $row->CPPC_TEL;
            $sub_array[] = $row->CPPC_EMAIL;
            $sub_array[] = $province['PROVINCE_NAME'];
            $sub_array[] = '<label title="'.$mes_equipes.'">'.count($equipes).'</label>';
            $sub_array[]=$identite;


            $options = '<div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            ';
            
            $options .= "<li><a href='" . base_url('equipes/Caserne/Modifier/' . $row->CPPC_ID) . "'>Modifier</li>";
            $options .= "<li><a href='" . base_url('equipes/Caserne/Detail/' . $row->CPPC_ID) . "'>
                                        Detail</a></li>";
            $options .= "<li><a href='" . base_url('equipes/Caserne/add_manager/' . $row->CPPC_ID) . "'>Manager CPPC</li>";
                      
            $options .= "<li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete" . $row->CPPC_ID . "'><font color='red'>Supprimer</font></button></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete" . $row->CPPC_ID . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Supprimer :<b>" . $row->CPPC_NOM . "</b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('equipes/Caserne/supprimer/' . $row->CPPC_ID) . "'>Supprimer</a>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    ";

            $sub_array[] = $options;

            $data[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" => $this->Model->count_all_data($table, $critere_array),
            "recordsFiltered" => $this->Model->get_filtered_data($table, $select_column, $critere_txt, $critere_array, $order_by),
            "data" => $data
        );
        // print_r($data);
        // exit();
        echo json_encode($output);
    } */

    public function Modifier()
    {
      $caserne_id = $this->uri->segment(4);
      $data['title'] = "Modifier un CPPC";
      $data['breadcrumb'] = $this->make_bread->output();
      $data['provinces'] = $this->Model->getList('ststm_provinces');
      $data['cppc'] = $this->Model->getOne('rh_cppc',array('CPPC_ID'=>$caserne_id));
      $data['services'] = $this->Model->getList('rh_service_dgpc');

      $this->load->view('caserne/Casernes_Edit_View',$data);
    }

    public function saveModification()
    { 
        $caserne_id = $this->uri->segment(4);
       $this->form_validation->set_rules('CPPC_NOM', 'Nom', 'required');
       $this->form_validation->set_rules('CPPC_EMAIL', 'Email', 'required');
       $this->form_validation->set_rules('CPPC_DESCR', 'Description', 'required');
       $this->form_validation->set_rules('CPPC_TEL', 'Télephone', 'required');
       $this->form_validation->set_rules('PROVINCE_ID', 'Province', 'required');
       $this->form_validation->set_rules('CASERNE_LONG', 'Longitude', 'required');
       $this->form_validation->set_rules('SERVICE_DGPC_ID', 'Service DGPC', 'required');
       $this->form_validation->set_rules('CASERNE_LAT', 'Latitude', 'required');
       
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Modification CPPC provinciale";
            $data['cppc'] = $this->Model->getOne('rh_cppc',array('CPPC_ID'=>$caserne_id));
            $data['breadcrumb'] = $this->make_bread->output();
            $data['provinces'] = $this->Model->getList('ststm_provinces');
            $data['services'] = $this->Model->getList('rh_service_dgpc');

            $this->load->view('caserne/Casernes_Edit_View',$data);
            
        }else{
             $array_caserne = array(
                                'CPPC_NOM'=>$this->input->post('CPPC_NOM'),
                                'CPPC_TEL'=>$this->input->post('CPPC_TEL'),
                                'CPPC_DESCR'=>$this->input->post('CPPC_DESCR'),                                
                                'CPPC_EMAIL'=>$this->input->post('CPPC_EMAIL'),
                                'PROVINCE_ID'=>$this->input->post('PROVINCE_ID'),
                                'LONGITUDE'=>$this->input->post('CASERNE_LONG'),
                                'LATITUDE'=>$this->input->post('CASERNE_LAT'),
                                'SERVICE_DGPC_ID'=>$this->input->post('SERVICE_DGPC_ID'),
                                'USER_ID'=>$this->session->userdata('DGPC_USER_ID')
                                );
           $msg = "<font color='red'>La cppc <b>".$this->input->post('CPPC_NOM')."</b> n'a pas été mise à jour.</font>";
            if($this->Model->update_table('rh_cppc',array('CPPC_ID' => $caserne_id),$array_caserne)){
              
              $msg = "<font color='green'> La CPPC <b>".$this->input->post('CPPC_NOM')."</b> a été mise à jour.</font>";
              $donne['msg'] =$msg;
              $this->session->set_flashdata($donne);

              redirect(base_url().'equipes/Caserne/liste');
            }

            
        }
    }

    public function supprimer()
    {
      $caserne_id =$this->uri->segment(4);
      
      $caserne = $this->Model->getOne('rh_cppc',array('CPPC_ID'=>$caserne_id));
      $equipes = $this->Model->getList('rh_equipe_cppc',array('CPPC_ID'=>$caserne_id));
      
      $msg = "<font color='red'>La CPPC cherchée n'est plus.</font>";
      if(!empty($caserne)){
        if(empty($equipes)){
           $this->Model->delete('rh_cppc',array('CPPC_ID'=>$caserne_id));

          $msg = "<font color='green'>La CPPC <b>".$caserne['CPPC_NOM']."</b> a été supprimée.</font>";
        }else
         $msg = "<font color='red'>Il faut commencer à supprimer les equipes que cette DGPC <b>".$caserne['CPPC_NOM']."</b> a effectuée.</font>";

      }
      $donne['msg'] =$msg;
      $this->session->set_flashdata($donne);

      redirect(base_url().'equipes/Caserne/liste');
    }

    public function add_manager($id=""){
    $datas['cppc']=$this->Model->getList('rh_cppc');
    if($_SERVER['REQUEST_METHOD']=='GET'){
        $datas['title']="Manager de CPPC";
        $datas['personnel']=$this->Model->getList('rh_personnel_dgpc');
        
        $this->make_bread->add('Manager de CPPC ', "listing", 1);
        $datas['breadcrumb'] = $this->make_bread->output();
        $this->load->view('caserne/manager_New_View',$datas);
    }else{


        $this->form_validation->set_rules('PERSONNEL_ID', 'Personnel', 'required');
        $this->form_validation->set_rules('DATE_DEBUT', 'Date debut', 'required');
        $this->form_validation->set_rules('CPPC_ID', 'cppc', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Manager CPPCs";
            
            $data['breadcrumb'] = $this->make_bread->output();
            $data['personnel']=$this->Model->getList('rh_personnel_dgpc');
            $data['provinces'] = $this->Model->getList('ststm_provinces');
            //$data['ccpc'] = $this->Model->getList('rh_cppc');

            $this->load->view('caserne/manager_New_View',$data);
        }else{
          $date=new DateTime($this->input->post('DATE_DEBUT'));
          $date_new=$date->format('Y-m-d');
            $array_manager = array(
                                'CPPC_ID'=>$this->input->post('CPPC_ID'),
                                'PERSONNEL_ID'=>$this->input->post('PERSONNEL_ID'),
                                'DATE_DEBUT'=>$date_new,
                                'USER_ID'=>$this->session->userdata('DGPC_USER_ID')
                                );

            $check=$this->Model->checkvalue('rh_cppc_manager',array('CPPC_ID'=>$this->input->post('CPPC_ID'),'PERSONNEL_ID'=>$this->input->post('PERSONNEL_ID')));
            // $checkmangeexit=$this->Model->checkvalue('rh_cppc_manager',array('CPPC_ID'=>$this->input->post('CPPC_ID')));
            $perso_id=$this->input->post('PERSONNEL_ID');
            $cppc_id_cn=$this->input->post('CPPC_ID');
            $checkmangeexit=$this->Model->querysql("SELECT * FROM rh_cppc_manager WHERE CPPC_ID='$cppc_id_cn' AND PERSONNEL_ID !='$perso_id'");
            if($check==TRUE){
              $msg = "<font color='red'>Ce manager gère déjà cette CPPC.</font>";
            }elseif(!empty($checkmangeexit)){
              $checklastmanager=$this->Model->getLast('rh_cppc_manager',array('CPPC_ID'=>$cppc_id_cn),'CPPC_MANAGER_ID');
              $update=$this->Model->update('rh_cppc_manager',array('CPPC_MANAGER_ID'=>$checklastmanager['CPPC_MANAGER_ID']),array('DATE_FIN'=>$date_new));


              $manager_id = $this->Model->insert_last_id('rh_cppc_manager',$array_manager);

              $msg = "<font color='red'>Le manager n'a pas été enregistré.</font>";
            }else{
            $manager_id = $this->Model->insert_last_id('rh_cppc_manager',$array_manager);

            $msg = "<font color='red'>Le manager n'a pas été enregistré.</font>";
            
          }

          if($manager_id >0){
               $personnel_id=$this->input->post('PERSONNEL_ID');
              $pers=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$personnel_id));
              $perso_name=$pers['PERSONNEL_NOM']." ".$pers['PERSONNEL_PRENOM'];
              $cppc_id=$this->input->post('CPPC_ID');
              $cppc=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$cppc_id));
    
              $msg = "<font color='green'> ".$perso_name." est désormais manager de ".$cppc['CPPC_NOM']."</font>";
              
              
            }
            $donne['msg'] =$msg;
            $this->session->set_flashdata($donne);
            redirect(base_url().'equipes/Caserne/add_manager/'.$this->input->post('CPPC_ID'));

        }
    }
  }
 /*   public function Detail(){
     $CPPC_ID =$this->uri->segment(4);

      $cppc = $this->Model->getOne('rh_cppc',array('CPPC_ID'=>$CPPC_ID));
      $ticket = $this->Model->getList('tk_ticket',array('CPPC_ID'=>$CPPC_ID));
$nb=0;
$nb1=0;
      foreach ($ticket as $value) {
        $dega_humain_blesse=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$value['TICKET_CODE'],'CONCERNE_DGPC'=>1,'STATUT_SANTE'=>0));
        $dega_humain_blesse=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$value['TICKET_CODE'],'CONCERNE_DGPC'=>1,'STATUT_SANTE'=>1));
        $nb+=sizeof($dega_humain_blesse);
        $nb1+=sizeof($dega_humain_blesse);
      }

      $serie_intervention="{name: 'intervention ', data: [".sizeof($ticket)."]}";
      $serie_blesse="{name: 'Blessés ', data: [".$nb."]}";
        $serie_mort="{name: 'Morts ', data: [".$nb1."]}";
 

      $data['series1'] = "[".$serie_intervention.",".$serie_blesse.",".$serie_mort."]";
      // echo "[".$serie_intervention.",".$serie_blesse.",".$serie_mort."]";exit();
      $data['blesse'] =$nb;
      $data['mort'] =$nb1;
      $data['equipe'] =$this->Model->getList('rh_equipe_cppc',array('CPPC_ID'=>$CPPC_ID));
      $data['materiel'] =$this->Model->getList('interv_materiaux',array('CPPC_ID'=>$CPPC_ID));
      $data['ticket'] =$ticket;
      $data['cppc'] = $cppc['CPPC_NOM'];
      $data['latitude'] = $cppc['LATITUDE'];
      $data['longitude'] = $cppc['LONGITUDE'];

      //DEGA MATERIEL
      // $degat=$this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>1));

    $data['breadcrumb'] = $this->make_bread->output();
          // echo $ticket['LATITUDE']."|".$ticket['LONGITUDE']; exit();
      $this->load->view('equipes/caserne/Caserne_Dashboard_View',$data); 
  }*/

       public function Detail(){
     $CPPC_ID =$this->uri->segment(4);

      $cppc = $this->Model->getOne('rh_cppc',array('CPPC_ID'=>$CPPC_ID));
      $ticket = $this->Model->getList('tk_ticket',array('CPPC_ID'=>$CPPC_ID));
      $data['equipe'] =$this->Model->getList('rh_equipe_cppc',array('CPPC_ID'=>$CPPC_ID));
      $data['equipe2'] =$this->Model->getList('rh_equipe_cppc',array('CPPC_ID'=>$CPPC_ID));

$nb=0;
$nb1=0;
$serie_materiel="";
$nombre_materiel=0;
      foreach ($ticket as $value) {

        $dega_humain_blesse=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$value['TICKET_CODE'],'STATUT_SANTE'=>0));
        $dega_humain_mort=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$value['TICKET_CODE'],'STATUT_SANTE'=>1));

        $nb+=sizeof($dega_humain_blesse);
        $nb1+=sizeof($dega_humain_mort);
        $dega_materiel=$this->Model->getSommes('interv_odk_degat_materiel',array('TICKET_CODE'=>$value['TICKET_CODE'],'CONCERNE_DGPC'=>1),'NOMBRE','MATERIEL_ENDO_CODE','MATERIEL_ENDO_CODE');
        $n=0;
        foreach ($dega_materiel as $key) {
          $mater=$this->Model->getOne('interv_materiaux',array('MATERIEL_ID'=>$key['MATERIEL_ENDO_CODE']));
         
         // $serie_materiel.="{name: '".trim($mater['MATERIEL_DESCR'])."', data: [0,0,".$key['NOMBRE']."]},";
       $nombre_materiel+=$key['NOMBRE'];
        }
      }
      $serie_materiel="{name: 'Materiels($nombre_materiel)', data: [0,0,".$nombre_materiel."]}";
      //  $serie_materiel.="|";
      // $serie_materiel= str_replace(",|", "", $serie_materiel);
         // echo $serie_materiel;exit();sizeof($ticket)
      $serie_intervention="{name: 'interventions(".sizeof($ticket).")', data: [".sizeof($ticket).",0,0]}";
      $serie_blesse="{name: 'Blessés($nb)', data: [0,".$nb.",0]}";
        $serie_mort="{name: 'Morts($nb1)', data: [0,".$nb1.",0]}";
 

      // $data['series1'] = "[{name: 'intervention ', data: [11]},{name: 'Blessés ', data: [4]},{name: 'Morts ', data: [2]},{name: 'Motopompes ', data: [2]},{name: 'Autres', data: [5]}]";
      $data['series1'] = "[".$serie_intervention.",".$serie_blesse.",".$serie_mort.",".$serie_materiel."]";
          // echo "[".$serie_intervention.",".$serie_blesse.",".$serie_mort.",".$serie_materiel."]";exit();
      $data['blesse'] =$nb;
      $data['cppc1'] =$CPPC_ID;
      $data['mort'] =$nb1;
      $data['nombre_materiel'] =$nombre_materiel;
      
      $data['materiel'] =$this->Model->getList('interv_materiaux',array('CPPC_ID'=>$CPPC_ID));

      $total_mat =$this->Model->getList('interv_materiaux',array('CPPC_ID'=>$CPPC_ID));
      $mat_total=0;
      // echo sizeof($total_mat);exit();
      foreach ($total_mat as $vale) {
        $mat_total+= $vale['QUANTITE'];
        // echo $vale['QUANTITE'];
      }
      $data['mat_total'] =$mat_total;
      $data['ticket'] =$ticket;
      $data['cppc'] = $cppc['CPPC_NOM'];
      $data['latitude'] = $cppc['LATITUDE'];
      $data['longitude'] = $cppc['LONGITUDE'];

      //DEGA MATERIEL
      // $degat=$this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>1));
      $data['title'] = "Detail CPPC";
    $data['breadcrumb'] = $this->make_bread->output();
          // echo $ticket['LATITUDE']."|".$ticket['LONGITUDE']; exit();
      $this->load->view('equipes/caserne/Caserne_Dashboard_View',$data); 
  }
  public function chaque_detail($infos){
    
    $info=explode(".", $infos);
    $tableau="";
    $ticket = $this->Model->getListOrdered('tk_ticket','DATE_INSERTION',array('CPPC_ID'=>$info[1]));
    if($info[0]=='interventions'){
    
    $tableau.="<table id='mytable' class='table table-bordered  table-responsive'>
    <tr><th>No</th><th>DATE TIME</th><th>CODE INTERV</th><th>DESCRIPTION</th><th>CAUSES</th><th>DECLARANT</th><th>STATUT</th></tr>";
    $i=1;
    foreach ($ticket as $value) {

      $cause=$this->Model->getOne('tk_causes',array('CAUSE_ID'=>$value['CAUSE_ID']));
      $statut=$this->Model->getOne('tk_statuts',array('STATUT_ID'=>$value['STATUT_ID']));
      $tableau.="<tr><td>".$i."</td><td>".$value['DATE_INSERTION']."</td><td>".$value['CODE_EVENEMENT']."</td><td>".$value['TICKET_DESCR']."</td><td>".$cause['CAUSE_DESCR']."</td><td>".$value['TICKET_DECLARANT']."</td><td style='color:".$statut['STATUT_COLOR']."'>".$statut['STATUT_DESCR']."</td></tr>";
      $i++;
    }
     $tableau.="</table>";
    }else
  

    if($info[0]=='Blesses'){
      $tableau.="<h3>Liste des blessés</h3><table id='mytable' class='table table-bordered  table-responsive'>
    <tr><th>No</th><th>NOM ET PRENOM</th></tr>";
      $blesse=$this->Model->getListJoin(array('STATUT_SANTE'=>0,'CONCERNE_DGPC'=>1));
      $j=1;
       foreach ($blesse as $key) {
          $tableau.="<tr><td>".$j."</td><td>".$key['NOM_PRENOM']."</td></tr>";

          $j++;
       }
      $tableau.="</table>";
    }else
    if($info[0]=='Morts'){
      $tableau.="<h3>Liste des morts</h3><table id='mytable' class='table table-bordered  table-responsive'>
    <tr><th>No</th><th>NOM ET PRENOM</th></tr>";
      $blesse=$this->Model->getListJoin(array('STATUT_SANTE'=>1,'CONCERNE_DGPC'=>1));
      $j=1;
       foreach ($blesse as $key) {
          $tableau.="<tr><td>".$j."</td><td>".$key['NOM_PRENOM']."</td></tr>";

          $j++;
       }
      $tableau.="</table>";
    }else{
      $materiel=$this->Model->getList('interv_materiaux');
      $tableau.="<h3>Liste des materiels endomagés</h3><table id='mytable' class='table table-bordered  table-responsive'><tr><th>No</th><th>DATE</th><th>MATERIEL</th><th>NOMBRE</th></tr>";
      foreach ($materiel as $v) {

         if(trim($v['MATERIEL_DESCR'])==$info[0]){
          $id_materiel=$this->Model->getOneSearch('interv_materiaux',array('MATERIEL_DESCR'=>$v['MATERIEL_DESCR']));

          foreach ($ticket as $val) {

            $dega=$this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$val['TICKET_CODE'],'CONCERNE_DGPC'=>1,'MATERIEL_ENDO_CODE'=>$id_materiel['MATERIEL_ID']));
            $k=1;
            foreach ($dega as $vl) {
              # code...
               
              $mat=$this->Model->getOne('interv_materiaux',array('MATERIEL_ID'=>$vl['MATERIEL_ENDO_CODE']));
              
              $tableau.="<tr><td>".$k."</td><td>".$val['DATE_INSERTION']."</td><td>".$mat['MATERIEL_DESCR']."</td><td>".$vl['NOMBRE']."</td></tr>";
              $k++;
            
            }
          
         }
         }
      }
       $tableau.="</table>";
    }
    $data['tableau'] = $tableau;
     $data['title'] = "Detail CPPC";
    $this->load->view('equipes/caserne/Caserne_info_View',$data);
  }

  public function getExisteManager(){
    $cppc_id=$this->input->post('cppc');
    $checklastmanager=$this->Model->getLast('rh_cppc_manager',array('CPPC_ID'=>$cppc_id),'CPPC_MANAGER_ID');
    $personnel_id=$checklastmanager['PERSONNEL_ID'];
    $pers=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$personnel_id));
    $perso_name=$pers['PERSONNEL_NOM']." ".$pers['PERSONNEL_PRENOM'];
    if(!empty($checklastmanager)){
      echo '1|'.$perso_name;
    }else{
      echo '0|'.$perso_name;
    }
  }

public function getName(){
    $personnel_id=$this->input->post('PERSONNEL_ID');
     $pers=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$personnel_id));
    $perso_name=$pers['PERSONNEL_NOM']." ".$pers['PERSONNEL_PRENOM'];

    echo $perso_name;
}
  // public function getExisteManager(){
  //   $cppc_id=$this->input->post('cppc');
  //   $checklastmanager=$this->Model->getLast('rh_cppc_manager',array('CPPC_ID'=>$cppc_id),'CPPC_MANAGER_ID');
  //   if(!empty($checklastmanager)){
  //     echo '1';
  //   }else{
  //     echo '0';
  //   }
  // }

  // public function getExisteManagerCcpc(){
  //   $ccpc_id=$this->input->post('ccpc');
  //   $checklastmanager=$this->Model->getLast('rh_ccpc_manager',array('CCPC_ID'=>$ccpc_id),'CCPC_MANAGER_ID');
  //   if(!empty($checklastmanager)){
  //     echo '1';
  //   }else{
  //     echo '0';
  //   }
  // }

  
  }