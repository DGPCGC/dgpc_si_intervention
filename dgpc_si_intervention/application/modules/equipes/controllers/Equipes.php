<?php

 class Equipes extends MY_Controller
 {
 	
 	function __construct()
 	{
 	  parent::__construct();
    $this->make_bread->add('Equipes', "equipes/Equipes", 0);
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
      $data['title'] = "Nouvelle Equipe";
      $data['breadcrumb'] = $this->make_bread->output();
      $data['cppc'] = $this->Model->getList('rh_cppc');
      $data['services'] = $this->Model->getList('rh_service_cppc');

      $this->load->view('equipe/Equipes_New_View',$data);
    }


    public function save()
    {
       $this->form_validation->set_rules('EQUIPE_NOM', 'Nom', 'required');
       $this->form_validation->set_rules('EQUIPE_EMAIL', 'Email', 'required|valid_email');
       $this->form_validation->set_rules('CPPC_ID', 'CPPCs', 'required');
       $this->form_validation->set_rules('TRANCHE', 'Horaire', 'required');
       $this->form_validation->set_rules('EQUIPE_TEL', 'Télephone', 'required|numeric');
       
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Nouvelle Equipe";
            $data['breadcrumb'] = $this->make_bread->output();
            $data['cppc'] = $this->Model->getList('rh_cppc');
            $data['services'] = $this->Model->getList('rh_service_cppc');
// echo "yes";exit();
            $this->load->view('equipe/Equipes_New_View',$data);
        }else{
            $cppc_n=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$this->input->post('CPPC_ID')));
            $equipe_existant=$this->Model->count_all_data('rh_equipe_cppc',array('CPPC_ID'=>$this->input->post('CPPC_ID')));
            $chec_equipe=$this->Model->checkvalue('rh_equipe_cppc',array('CPPC_ID'=>$this->input->post('CPPC_ID'),'EQUIPE_NOM'=>$this->input->post('EQUIPE_NOM')));

            //CONTROLE HORAIRE
            $equipe_cppc=$this->Model->getList('rh_equipe_cppc',array('CPPC_ID'=>$this->input->post('CPPC_ID')));
            if ($this->input->post('type_equipe')==1) {
             
            $v=array();
            foreach ($equipe_cppc as $key) {
                $equipe_hor=$this->Model->getList('horaire_equipe',array('EQUIPE_ID'=>$key['EQUIPE_ID'],'DESCRIPTION'=>$this->input->post('TRANCHE')));
                if(sizeof($equipe_hor)>0){
                $v[]=sizeof($equipe_hor);
               }
            }

            }
             if ($this->input->post('type_equipe')==2) {
            $v=array();
            foreach ($equipe_cppc as $key) {
                $equipe_hor=$this->Model->getList('horaire_equipe',array('EQUIPE_SECOUR_ID'=>$key['EQUIPE_ID'],'DESCRIPTION'=>$this->input->post('TRANCHE')));
                if(sizeof($equipe_hor)>0){
                $v[]=sizeof($equipe_hor);
               }
            }
            
            }
             // echo $s;exit();
            if (sizeof($v)==0) {
                
            
            if ($chec_equipe!=1) {

            if ($equipe_existant<6) {
                
                $array_equipe = array(
                                'EQUIPE_NOM'=>$this->input->post('EQUIPE_NOM'),
                                'EQUIPE_EMAIL'=>$this->input->post('EQUIPE_EMAIL'),
                                'EQUIPE_TEL'=>"+257".$this->input->post('EQUIPE_TEL'),                                
                                'IS_ACTIVE'=>1,
                                'CPPC_ID'=>$this->input->post('CPPC_ID'),
                                // 'SERVICE_CPPC_ID'=>$this->input->post('SERVICE_CPPC_ID'),
                                'USER_ID'=>$this->session->userdata('DGPC_USER_ID')
                                );
             $equipe_id = $this->Model->insert_last_id('rh_equipe_cppc',$array_equipe);

            if ($this->input->post('type_equipe')==1) {
                $explode_dte=explode("-", $this->input->post('TRANCHE'));
                $deb=substr($explode_dte[0], 0,2);
                $fin=substr($explode_dte[1], 0,2);
                // echo $fin;exit();
                $array_horaire= array(
                                'DESCRIPTION'=>$this->input->post('TRANCHE'),
                                'EQUIPE_ID'=>$equipe_id,
                                'EQUIPE_SECOUR_ID'=>0,                                
                                'HEURE_DEBUT'=>$deb,
                                'HEURE_FIN'=>$fin,
                                
                                );
            }
             if ($this->input->post('type_equipe')==2) {
                $explode_dte=explode("-", $this->input->post('TRANCHE'));
                $deb=substr($explode_dte[0], 0,2);
                $fin=substr($explode_dte[1], 0,2);
                // echo $fin;exit();
                $array_horaire= array(
                                'DESCRIPTION'=>$this->input->post('TRANCHE'),
                                'EQUIPE_ID'=>0,
                                'EQUIPE_SECOUR_ID'=>$equipe_id,                                
                                'HEURE_DEBUT'=>$deb,
                                'HEURE_FIN'=>$fin,
                                
                                );
            }
            $this->Model->create('horaire_equipe',$array_horaire);

            $msg = "<font color='red'>L'équipe <b>".$this->input->post('EQUIPE_NOM')."</b> n'a pas été enregistré.</font>";
            if($equipe_id >0){
              
              $msg = "<div class='alert alert-success text-center'>  L'équipe <b>".$this->input->post('EQUIPE_NOM')."</b> a été enregistré.Cliquez ici <a href='".base_url()."equipes/Equipes/Addmembre/".$equipe_id."'>pour ajouter des membres</a></div>";
              $donne['msg'] =$msg;
              $this->session->set_flashdata($donne);

              redirect(base_url().'equipes/Equipes/liste');
              // redirect(base_url().'equipes/Equipes/Addmembre/'.$equipe_id);
            }else{
              $data['title'] = "Nouvelle Equipe";
              $data['cppc'] = $this->Model->getList('rh_cppc');
              $data['services'] = $this->Model->getList('rh_service_cppc');
              $data['breadcrumb'] = $this->make_bread->output();
              $donne['msg'] =$msg;
              $this->session->set_flashdata($donne);

              $this->load->view('equipe/Equipes_New_View',$data);
            }
   
            }else{
                $msg = "<div class='alert alert-success text-center'>  Echec! ".$cppc_n['CPPC_NOM']." a deja atteint 6 equipes</div>";
                $data['title'] = "Nouvelle Equipe";
              $data['cppc'] = $this->Model->getList('rh_cppc');
              $data['services'] = $this->Model->getList('rh_service_cppc');
              $data['breadcrumb'] = $this->make_bread->output();
              $donne['msg'] =$msg;
              $this->session->set_flashdata($donne);

              redirect(base_url().'equipes/Equipes/liste',$data);
            }

            }else{

                $msg = "<div class='alert alert-danger text-center'>  Echec! le nom de cette equipe existe deja pour ".$cppc_n['CPPC_NOM']."</div>";
                $data['title'] = "Nouvelle Equipe";
              $data['cppc'] = $this->Model->getList('rh_cppc');
              $data['services'] = $this->Model->getList('rh_service_cppc');
              $data['breadcrumb'] = $this->make_bread->output();
              $donne['msg'] =$msg;
              // echo "ok";
              $this->session->set_flashdata($donne);
              $this->load->view('equipe/Equipes_New_View',$data);
            }

            }else{
                $msg = "<div class='alert alert-danger text-center'>  Echec! cette horaire est occupé par une autre equipe pour <b>".$cppc_n['CPPC_NOM']."</b></div>";
                $data['title'] = "Nouvelle Equipe";
              $data['cppc'] = $this->Model->getList('rh_cppc');
              $data['services'] = $this->Model->getList('rh_service_cppc');
              $data['breadcrumb'] = $this->make_bread->output();
              $donne['msg'] =$msg;
              // echo "ok";
              $this->session->set_flashdata($donne);
              $this->load->view('equipe/Equipes_New_View',$data);
            }
        }
    }

public function liste()
    {
      
        $fetch_equipes = $this->Model->getList("rh_equipe_cppc", array());

        // print_r($fetch_tickets);
        $resultat = array();
        foreach ($fetch_equipes as $row) {
            $sub_array = array();           
            $les_membres = $this->Model->getList('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$row['EQUIPE_ID']));
            $cppc = $this->Model->getOne('rh_cppc',array('CPPC_ID'=>$row['CPPC_ID']));
            $service = $this->Model->getOne('rh_service_cppc',array('SERVICE_CPPC_ID'=>$row['SERVICE_CPPC_ID']));
            $horaire = $this->Model->getOne('horaire_equipe',array('EQUIPE_ID'=>$row['EQUIPE_ID']));

            //Membres equipes
            $id_eq=$row['EQUIPE_ID'];
            $getListMembre=$this->Model->querysql("SELECT * FROM rh_equipe_membre_cppc join rh_personnel_dgpc on rh_equipe_membre_cppc.PERSONEL_ID=rh_personnel_dgpc.PERSONNEL_ID WHERE rh_equipe_membre_cppc.EQUIPE_ID='$id_eq'");

            $table='<table class="table table-bordered  table-responsive"><tr><th> Nom </th><th> Prénom </th><th> Chef d\'équipe</th></tr>';
            foreach ($getListMembre as $key => $value) {
              $chef=($value['IS_CHEF_EQUIPE']==1)?'Oui':'Non';
              $table.='<tr><td>'.$value['PERSONNEL_NOM'].'</td><td>'.$value['PERSONNEL_PRENOM'].'</td><td>'.$chef.'</td></tr></tr>';
            }
            $table.="</table>";
            $chef=$this->Model->getOne('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$row['EQUIPE_ID']));
            $nom_chef=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$chef['PERSONEL_ID']));

            $sub_array[] = $row['EQUIPE_NOM'];
            $sub_array[] = $row['EQUIPE_TEL'];
            $sub_array[] = $row['EQUIPE_EMAIL'];
            $sub_array[] = $cppc['CPPC_NOM'];
            $sub_array[] = $horaire['DESCRIPTION'];

            
            $sub_array[] = ($row['IS_ACTIVE'] ==1)?'Active':'Désactive';
            $sub_array[] = $nom_chef['PERSONNEL_PRENOM']." ".$nom_chef['PERSONNEL_NOM'];
            $sub_array[] = "<a href='#' data-toggle='modal' 
                                  data-target='#membersTeams" . $row['EQUIPE_ID'] . "'><font color='red'>".count($les_membres)."</font></a>";

            if($this->mylibrary->verify_is_admin() ==1){
            $options = '<div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            ';
            
            $options .= "<li><a href='" . base_url('equipes/Equipes/Modifier/' . $row['EQUIPE_ID']) . "'>
                                        Modifier</li>";
            
           
            $options .= "<li><a href='" . base_url('equipes/Equipes/Addmembre/' . $row['EQUIPE_ID']) . "'>
                                        Membres</li>";
            
            $options .= "<li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete" . $row['EQUIPE_ID'] . "'><font color='red'>Supprimer</font></a></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete" . $row['EQUIPE_ID'] . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Supprimer :<b>" . $row['EQUIPE_NOM'] . "</b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('equipes/Equipes/supprimer/' . $row['EQUIPE_ID']) . "'>Supprimer</a>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    ";
                $options .= "
                                </div>
                                    <div class='modal fade' id='membersTeams" . $row['EQUIPE_ID'] . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Membre de l'Equipe :<b>" . $row['EQUIPE_NOM'] . "</b></h5>
                                                    ".$table."
                                                </div>

                                                <div class='modal-footer'>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    ";

            $sub_array[] = $options;
             }
            $resultat[] = $sub_array;
        }
$template=array(
        'table_open'=>'<table id="mytable" class="table table-responsive">',
        '<table_close'=>'</table>'
        );
        if($this->mylibrary->verify_is_admin() ==1){
          $this->table->set_heading('NOM','TELEPHONE','EMAIL','CPPCs','HORAIRE','STATUT','CHEF','MEMBRE','OPTIONS');
        }else{
          $this->table->set_heading('NOM','TELEPHONE','EMAIL','CPPCs','HORAIRE','SERVICE','STATUT','CHEF','MEMBRE');
        }
        $this->table->set_template($template);
    
    $datas['table']=$resultat;
    $datas['title'] = "Listes des equipes";
    $datas['breadcrumb'] = $this->make_bread->output();
    $this->load->view('equipe/Equipes_Liste_View',$datas);
    }
    public function get_equipes()
    {
      $var_search = $_POST['search']['value'];

        $table = "rh_equipe_cppc";
        $critere_txt = !empty($_POST['search']['value']) ? ("EQUIPE_NOM LIKE '%$var_search%' OR EQUIPE_TEL LIKE '%$var_search%' OR EQUIPE_EMAIL LIKE '%$var_search%'") : NULL;
        $critere_array = array();
        $order_column = array('EQUIPE_EMAIL', 'EQUIPE_NOM', 'EQUIPE_TEL');
        $order_by = isset($_POST['order']) ? array($order_column[$_POST['order']['0']['column']] => $_POST['order']['0']['dir']) : array('EQUIPE_ID' => 'DESC');
        $select_column = array('EQUIPE_NOM', 'EQUIPE_TEL', 'CPPC_ID', 'SERVICE_CPPC_ID','EQUIPE_ID', 'EQUIPE_EMAIL','IS_ACTIVE');

        $fetch_equipes = $this->Model->make_datatables($table, $select_column, $critere_txt, $critere_array, $order_by);

        // print_r($fetch_tickets);
        $data = array();
        foreach ($fetch_equipes as $row) {
            $sub_array = array();           
            $les_membres = $this->Model->getList('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$row->EQUIPE_ID));
            $cppc = $this->Model->getOne('rh_cppc',array('CPPC_ID'=>$row->CPPC_ID));
            $service = $this->Model->getOne('rh_service_cppc',array('SERVICE_CPPC_ID'=>$row->SERVICE_CPPC_ID));

            $sub_array[] = $row->EQUIPE_NOM;
            $sub_array[] = $row->EQUIPE_TEL;
            $sub_array[] = $row->EQUIPE_EMAIL;
            $sub_array[] = $cppc['CPPC_NOM'];
            $sub_array[] = $service['DESCRIPTION'];
            $sub_array[] = ($row->IS_ACTIVE ==1)?'Active':'Désactive';
            $sub_array[] = count($les_membres);


            $options = '<div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            ';
            
            $options .= "<li><a href='" . base_url('equipes/Equipes/Modifier/' . $row->EQUIPE_ID) . "'>
                                        Modifier</li>";
            
            $options .= "<li><a href='" . base_url('equipes/Equipes/detail/' . $row->EQUIPE_ID) . "'>
                                        Détail</li>";
            $options .= "<li><a href='" . base_url('equipes/Equipes/Addmembre/' . $row->EQUIPE_ID) . "'>
                                        Membres</li>";
            
            $options .= "<li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete" . $row->EQUIPE_ID . "'><font color='red'>Supprimer</font></button></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete" . $row->EQUIPE_ID . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Supprimer :<b>" . $row->EQUIPE_NOM . "</b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('equipes/Equipes/supprimer/' . $row->EQUIPE_ID) . "'>Supprimer</a>
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
        echo json_encode($output);
    }

    // public function Addmembre()
    // {
    //   $equipe_id = $this->uri->segment(4);
    //   $message = '';
    //   if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //     //echo 'YES';
    //     $array_membre = array(
    //                         'EQUIPE_ID'=>$equipe_id,
    //                         'PERSONEL_ID'=>$this->input->post('PERSONNEL_ID'),
    //                         'IS_CHEF_EQUIPE'=>$this->input->post('POSTE_ID'),
    //                         'DESCRIPTION'=>$this->input->post('DESCRIPTION'),
    //                         'USER_ID'=>$this->session->userdata('DGPC_USER_ID')
    //                         );

    //     if(empty($this->Model->getOne('rh_equipe_membre_cppc',$array_membre))){

    //       $array_check = array(
    //                         'PERSONEL_ID'=>$this->input->post('PERSONNEL_ID'));
    //         $donnee_check = $this->Model->getOne('rh_equipe_membre_cppc',$array_check);
    //         $chef_check='';
    //         if($this->input->post('POSTE_ID')==1){
    //           $chef_check = $this->Model->getOne('rh_equipe_membre_cppc',array('IS_CHEF_EQUIPE'=>1,'EQUIPE_ID'=>$equipe_id));
    //         }
    //         //print_r($array_check);
    //        if(!empty($donnee_check)){
    //         $message = "<font color='red'>Ce collaborateur est actif dans une autre équipe.</font>";
    //        }else{
    //         if(empty($chef_check)){
    //           $this->Model->insert_last_id('rh_equipe_membre_cppc',$array_membre);
    //         }else{
    //            $message = "<font color='red'>un autre chef existe dans cette equipe.</font>";
    //         }
            
    //       }
    //     }
    //   }

    //   $mes_users = $this->Model->member();
    //   $mon_equipe= $this->Model->getList('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$equipe_id));
    //   $array_users = array();
    //   foreach ($mes_users as $user) {
    //       if(empty($this->Model->getOne('rh_equipe_membre_cppc',array('PERSONEL_ID'=>$user['PERSONNEL_ID'],'EQUIPE_ID'=>$equipe_id)))){
    //         $array_users[] =$user;
    //       }
    //   }

    //   $data['users'] = $array_users;
    //   $data['equipe'] = $mon_equipe;
    //   $data['EQUIPE_ID'] = $equipe_id;
      
    //   $data['title'] = "Ajouter des membres";
    //   $data['breadcrumb'] = $this->make_bread->output();
    //   // $data['postes'] = $this->Model->getList('admin_poste');

    //   $donne['msg'] =$message;
    //   $this->session->set_flashdata($donne);

    //   $this->load->view('equipe/Equipe_Ajoute_Membre_View',$data);
    // }

 public function Addmembre()
    {
      $equipe_id = $this->uri->segment(4);
      $message = '';
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //echo 'YES';
        $this->form_validation->set_rules('EQUIPE_ID', 'Equipe', 'required');
        $this->form_validation->set_rules('PERSONNEL_ID', 'personnel', 'required');
        $this->form_validation->set_rules('POSTE_ID', 'Chef', 'required');
        $this->form_validation->set_rules('DESCRIPTION', 'Description', 'required');


         if ($this->form_validation->run() == FALSE) {
         }else{
          $array_membre = array(
                              'EQUIPE_ID'=>$this->input->post('EQUIPE_ID'),
                              'PERSONEL_ID'=>$this->input->post('PERSONNEL_ID'),
                              'IS_CHEF_EQUIPE'=>$this->input->post('POSTE_ID'),
                              'DESCRIPTION'=>$this->input->post('DESCRIPTION'),
                              'USER_ID'=>$this->session->userdata('DGPC_USER_ID')
                              );
          

          if(empty($this->Model->getOne('rh_equipe_membre_cppc',$array_membre))){
            $message = "<font color='red'>Ce collaborateur est actif dans une autre équipe.</font>";
            $array_check = array(
                              'PERSONEL_ID'=>$this->input->post('PERSONNEL_ID'));
              $donnee_check = $this->Model->getOne('rh_equipe_membre_cppc',$array_check);
              $chef_check='';
              if($this->input->post('POSTE_ID')==1){
                $chef_check = $this->Model->getOne('rh_equipe_membre_cppc',array('IS_CHEF_EQUIPE'=>1,'EQUIPE_ID'=>$this->input->post('EQUIPE_ID')));
                $message = "<font color='green'>Le collaborateur a été affecté dans cette equipe.</font>";
              }
              //print_r($array_check);
             if(!empty($donnee_check)){
              $message = "<font color='red'>Ce collaborateur est actif dans une autre équipe.</font>";
             }else{
              if(empty($chef_check)){
                $this->Model->insert_last_id('rh_equipe_membre_cppc',$array_membre);
                $message = "<font color='green'>Le collaborateur a été affecté dans cette equipe.</font>";
              }else{
                 $message = "<font color='red'>un autre chef existe dans cette equipe.</font>";
              }
              
            }
          
          }else{
            $message = "<font color='red'>Ce collaborateur existe déjà dans cette equipe.</font>";
          }
      }
      }

      

      $data['cppc']=$this->Model->getList('rh_cppc');
      $data['equipe']=$this->Model->getList('rh_equipe_cppc');
      $data['cppc_id_equipe']=$this->Model->getOne('rh_equipe_cppc',array('EQUIPE_ID'=>$equipe_id));

     // $data['personnel']=$this->Model->querysql("SELECT rh_personnel_dgpc.PERSONNEL_ID,rh_personnel_dgpc.PERSONNEL_NOM,rh_personnel_dgpc.PERSONNEL_PRENOM FROM `admin_profile` join admin_profiles_users on admin_profile.PROFILE_ID=admin_profiles_users.PROFILE_ID join admin_users on admin_users.USER_ID=admin_profiles_users.USER_ID join rh_personnel_dgpc on rh_personnel_dgpc.PERSONNEL_ID=admin_users.PERSONNEL_ID WHERE admin_profile.PROFILE_CODE='CHEQINYT' OR admin_profile.PROFILE_CODE='AGCPPC'");
      $data['personnel']=$this->Model->getList('rh_personnel_dgpc',array());
      $data['title'] = "Ajouter des membres";
      $data['breadcrumb'] = $this->make_bread->output();
      // $data['postes'] = $this->Model->getList('admin_poste');

      $donne['msg'] =$message;
      $this->session->set_flashdata($donne);

     //echo $this->session->flashdata('msg');
     //exit();

      $this->load->view('equipe/Equipe_Ajoute_Membre_View',$data);
    }

    public function getInfoCppc(){
      $html='';
      $cppc_id=$this->input->post('cppc');
      $info_cppc=$this->Model->querysqlone("SELECT rh_cppc.CPPC_NOM,ststm_provinces.PROVINCE_NAME FROM `rh_cppc` JOIN ststm_provinces on rh_cppc.PROVINCE_ID=ststm_provinces.PROVINCE_ID WHERE rh_cppc.CPPC_ID='$cppc_id'");
      $info_manager=$this->Model->querysqlone("SELECT rh_personnel_dgpc.PERSONNEL_NOM, rh_personnel_dgpc.PERSONNEL_PRENOM, rh_cppc_manager.CPPC_MANAGER_ID FROM `rh_cppc_manager` JOIN rh_personnel_dgpc ON rh_cppc_manager.PERSONNEL_ID=rh_personnel_dgpc.PERSONNEL_ID WHERE CPPC_ID='$cppc_id' ORDER BY rh_cppc_manager.CPPC_MANAGER_ID DESC");
      if(empty($info_manager)){
        $chef='-';
      }else{
        $chef=$info_manager['PERSONNEL_PRENOM'].' '.$info_manager['PERSONNEL_NOM'];
      }

      $html.="<b>".$info_cppc['CPPC_NOM']."</b><br>
      <span>Province :".$info_cppc['PROVINCE_NAME']."<br>";
      $html.="Manager : ".$chef;

      echo $html;
    }

    public function getInfoEquipe(){
      $html="";
      $equipe_id=$this->input->post('equipe_id');
      $info_equipe=$this->Model->getOne('rh_equipe_cppc',array('EQUIPE_ID'=>$equipe_id));
      $html.="<div><b> Equipe : ".$info_equipe['EQUIPE_NOM']."</b><br>
      <span>Membres</span>
      </div>";

      $id_eq=$equipe_id;
            $getListMembre=$this->Model->querysql("SELECT * FROM rh_equipe_membre_cppc join rh_personnel_dgpc on rh_equipe_membre_cppc.PERSONEL_ID=rh_personnel_dgpc.PERSONNEL_ID WHERE rh_equipe_membre_cppc.EQUIPE_ID='$id_eq'");

            $table='<table class="table table-bordered  table-responsive"><tr><th> Nom </th><th> Prénom </th><th> Chef d\'équipe</th></tr>';
            foreach ($getListMembre as $key => $value) {
              $chef=($value['IS_CHEF_EQUIPE']==1)?'<span style="color:red">Oui</span>':'';
              $table.='<tr><td>'.$value['PERSONNEL_NOM'].'</td><td>'.$value['PERSONNEL_PRENOM'].'</td><td>'.$chef.'</td></tr></tr>';
            }
            $table.="</table>";
      $html.=$table;
      $tables='';

      //Horaire
      $getHoraire=$this->Model->getList('horaire_equipe',array('EQUIPE_ID'=>$id_eq));

            $tables.='<span>Horaire</span><br><table class="table table-bordered  table-responsive"><tr><th> HEURE </th></tr>';
            foreach ($getHoraire as $key => $value) {
              
              $tables.='<tr><td>'.$value['DESCRIPTION'].'</tr>';
            }
            $tables.="</table>";
      $html.=$tables;

      echo $html;

    }


    public function Movemembre()
    {
      $equipe_id = $this->uri->segment(4);
       
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //echo 'YES';
        $array_membre = array(
                            'EQUIPE_ID'=>$equipe_id,
                            'PERSONEL_ID'=>$this->input->post('PERSONNEL_ID'));

        $this->Model->delete('rh_equipe_membre_cppc',$array_membre);
      }

      //$mes_users = $this->Model->getList('rh_personnel_dgpc');
      $mes_users = $this->Model->member();
      $mon_equipe= $this->Model->getList('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$equipe_id));
      $array_users = array();
      foreach ($mes_users as $user) {
          if(empty($this->Model->getOne('rh_equipe_membre_cppc',array('PERSONEL_ID'=>$user['PERSONNEL_ID'],'EQUIPE_ID'=>$equipe_id)))){
            $array_users[] =$user;
          }
      }

      $data['users'] = $array_users;
      $data['equipe'] = $mon_equipe;
      $data['EQUIPE_ID'] = $equipe_id;
      
      $data['title'] = "Ajouter des membres";
      $data['breadcrumb'] = $this->make_bread->output();
      //$data['postes'] = $this->Model->getList('admin_poste');

      $this->load->view('equipe/Equipe_Ajoute_Membre_View',$data);
    }
    public function ModifierMembre()
    {
      $equipe_id = $this->uri->segment(4);
      $user_id = $this->input->post('PERSONNEL_ID');
      $EQUIPE_MEMBRE_ID = $this->input->post('EQUIPE_MEMBRE_ID');
      $poste_id = $this->input->post('POSTE_ID');

  
      $array_membre = array(
                            'IS_CHEF_EQUIPE'=>$this->input->post('POSTE_ID'),
                            'DESCRIPTION'=>$this->input->post('DESCRIPTION'),
                            );
      
       //$msg = "<font color='green'>Modification du poste a été faite.</font>";
      
       // $check_data = $this->Model->getOne('interv_equipe_membre',$array_check);
        
       //  if(!empty($check_data)){
       //    $msg = "<font color='red'>Dans une équipe, il n'y a qu'un chef d'équipe.</font>";
       //  }else{          
       //    $this->Model->update_table('interv_equipe_membre',array('EQUIPE_MEMBRE_ID'=>$EQUIPE_MEMBRE_ID),$array_poste);
       //  }
        $chef_check='';
            if($this->input->post('POSTE_ID')==1){
              $chef_check = $this->Model->getOne('rh_equipe_membre_cppc',array('IS_CHEF_EQUIPE'=>1));
            }
          
            if(empty($chef_check)){
              $this->Model->update_table('rh_equipe_membre_cppc',array('EQUIPE_MEMBRE_ID'=>$EQUIPE_MEMBRE_ID),$array_membre);
            }else{
               $msg = "<font color='red'>un autre chef existe dans cette equipe.</font>";
            }
          
      $donne['msg'] =$msg;
      $this->session->set_flashdata($donne);

      redirect(base_url().'equipes/Equipes/Addmembre/'.$equipe_id);
    }

    public function validerEquipe()
    {
      $EQUIPE_ID = $this->uri->segment(4);
            
      $array_poste_chef = array(
                                'EQUIPE_ID'=>$EQUIPE_ID,
                                'DATE_FIN'=>NULL,
                                'IS_CHEF_EQUIPE'=>1
                                );

      $check_poste = $this->Model->getOne('rh_equipe_membre_cppc',$array_poste_chef);
        $msg = "<font color='red'>Dans une équipe, il doit y avoir un chef d'équipe.</font>";
        if(!empty($check_poste)){
           $msg = "<font color='green'>L'équipe est bien enregistré.</font>";          
        }

      $donne['msg'] =$msg;
      $this->session->set_flashdata($donne);

      redirect(base_url().'equipes/Equipes/Addmembre/'.$EQUIPE_ID);
    }

    public function Mutation()
    {
      $USER_ID = $this->uri->segment(4);
      $POSTE_ID = $this->uri->segment(5);
      $EQUIPE_ID = $this->uri->segment(6);
      
    }
   public function Modifier()

    {
      
      $equipe_id = $this->uri->segment(4);
      $equipe=$this->Model->getOne('rh_equipe_cppc',array('EQUIPE_ID'=>$equipe_id));
      $date_insertion=new DateTime($equipe['DATE_INSERTION']);
      $date_insertion=$date_insertion->format('Y-m-d H:i');
      $data['title'] = "Modifier une Equipe";
      $data['breadcrumb'] = $this->make_bread->output();
      $data['cppc'] = $this->Model->getList('rh_cppc');
      $horaire = $this->Model->getRequeteOne("SELECT* FROM horaire_equipe WHERE DATE_INSERTION LIKE  '%$date_insertion%' AND (EQUIPE_ID=$equipe_id OR EQUIPE_SECOUR_ID=$equipe_id)");
       // $horaire = $this->Model->getRequeteOne("SELECT* FROM horaire_equipe WHERE DATE_INSERTION LIKE  '%$date_insertion%' AND (EQUIPE_ID=$equipe_id OR EQUIPE_SECOUR_ID=$equipe_id)");
      // echo $data['horaire']['EQUIPE_ID']."|".$data['horaire']['EQUIPE_SECOUR_ID'];exit();\
      // echo $date_insertion;exit();
      $data['check']=0;
      if($horaire['EQUIPE_ID']==$equipe_id){$data['check']=1;
      }else if($horaire['EQUIPE_SECOUR_ID']==$equipe_id){
            $data['check']=2;
      }

      $data['horaire'] = $horaire['DESCRIPTION'];
      $data['services'] = $this->Model->getList('rh_service_cppc');
      $data['equipe'] = $this->Model->getOne('rh_equipe_cppc',array('EQUIPE_ID' =>$equipe_id));
      $equipes= $this->Model->getOne('rh_equipe_cppc',array('EQUIPE_ID' =>$equipe_id));
      $data['service_selected'] = $this->Model->getOne('rh_service_cppc',array('SERVICE_CPPC_ID' =>$equipes['SERVICE_CPPC_ID']));

      $this->load->view('equipe/Equipes_Edit_View',$data);
    }

    public function saveModification()
    {
$equipe_id = $this->uri->segment(4);
      $this->form_validation->set_rules('EQUIPE_NOM', 'Nom', 'required');
       $this->form_validation->set_rules('EQUIPE_EMAIL', 'Email', 'required|valid_email');
       $this->form_validation->set_rules('CPPC_ID', 'CPPCs', 'required');
       // $this->form_validation->set_rules('SERVICE_CPPC_ID', 'Service', 'required');
       $this->form_validation->set_rules('EQUIPE_TEL', 'Télephone', 'required|numeric');
       
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Nouvelle Equipe";
            $data['breadcrumb'] = $this->make_bread->output();
            $data['cppc'] = $this->Model->getList('rh_cppc');
            $data['services'] = $this->Model->getList('rh_service_cppc');

            $this->load->view('equipe/Equipes_Edit_View',$data);
        }else{
            $array_equipe = array(
                                'EQUIPE_NOM'=>$this->input->post('EQUIPE_NOM'),
                                'EQUIPE_EMAIL'=>$this->input->post('EQUIPE_EMAIL'),
                                'EQUIPE_TEL'=>"+257".$this->input->post('EQUIPE_TEL'),              
                                'CPPC_ID'=>$this->input->post('CPPC_ID'),
                                // 'SERVICE_CPPC_ID'=>$this->input->post('SERVICE_CPPC_ID')
                                );
            $equipe_id = $this->Model->update_table('rh_equipe_cppc',array('EQUIPE_ID' => $equipe_id),$array_equipe);


            if ($this->input->post('type_equipe')==1) {
                 // echo $this->uri->segment(4);exit();
                $explode_dte=explode("-", $this->input->post('TRANCHE'));
                $deb=substr($explode_dte[0], 0,2);
                $fin=substr($explode_dte[1], 0,2);
                // echo $fin;exit();
                $array_horaire= array(
                                'DESCRIPTION'=>$this->input->post('TRANCHE'),
                                'EQUIPE_ID'=>$this->uri->segment(4),                               
                                'HEURE_DEBUT'=>$deb,
                                'HEURE_FIN'=>$fin,
                                
                                );
                // $updt=$this->Model->update('horaire_equipe',array('EQUIPE_ID'=>$this->uri->segment(4),'DESCRIPTION'=>$this->input->post('TRANCHE1')),$array_horaire);
                $updt=$this->Model->update('horaire_equipe',array('EQUIPE_ID'=>$this->uri->segment(4)),$array_horaire);


            }
             if ($this->input->post('type_equipe')==2) {
                 // echo "b";exit();
                $explode_dte=explode("-", $this->input->post('TRANCHE'));
                $deb=substr($explode_dte[0], 0,2);
                $fin=substr($explode_dte[1], 0,2);
                // echo $fin;exit();
                $array_horaire= array(
                                'DESCRIPTION'=>$this->input->post('TRANCHE'),
                                'EQUIPE_SECOUR_ID'=>$this->uri->segment(4),                                
                                'HEURE_DEBUT'=>$deb,
                                'HEURE_FIN'=>$fin,
                                
                                );
                // $updt=$this->Model->update('horaire_equipe',array('EQUIPE_SECOUR_ID'=>$this->uri->segment(4),'DESCRIPTION'=>$this->input->post('TRANCHE1')),$array_horaire);
                $updt=$this->Model->update('horaire_equipe',array('EQUIPE_SECOUR_ID'=>$this->uri->segment(4)),$array_horaire);
            }
            


            $msg = "<font color='red'>L'équipe <b>".$this->input->post('EQUIPE_NOM')."</b> n'a pas été enregistré.</font>";
            if($equipe_id >0){
              
              $msg = "<div class='alert alert-success text-center'>  L'équipe <b>".$this->input->post('EQUIPE_NOM')."</b> a été modifiée.</div>";
              $donne['msg'] =$msg;
              $this->session->set_flashdata($donne);

              redirect(base_url().'equipes/Equipes/liste');
              // redirect(base_url().'equipes/Equipes/Addmembre/'.$equipe_id);
            }else{
              $data['title'] = "Nouvelle Equipe";
              $data['cppc'] = $this->Model->getList('rh_cppc');
              $data['services'] = $this->Model->getList('rh_service_cppc');
              $data['breadcrumb'] = $this->make_bread->output();
              $donne['msg'] =$msg;
              
            }

            
        }
          $donne['msg'] =$msg;
          $this->session->set_flashdata($donne);
          redirect(base_url().'equipes/Equipes/liste');
    }

    public function supprimer()
    {
      $equipe_id =$this->uri->segment(4);
      
      $equipe = $this->Model->getOne('rh_equipe_cppc',array('EQUIPE_ID'=>$equipe_id));
      $interventions = $this->Model->getList('interv_intervenants',array('EQUIPE_ID'=>$equipe_id));
      
      $msg = "<font color='red'>L'équipe cherchée n'est plus.</font>";
      if(!empty($equipe)){
        if(empty($interventions)){
           $this->Model->delete('rh_equipe_cppc',array('EQUIPE_ID'=>$equipe_id));
           // $this->Model->delete('interv_equipe_membre',array('EQUIPE_ID'=>$equipe_id));

          $msg = "<font color='green'>L'équipe <b>".$equipe['EQUIPE_NOM']."</b> a été supprimée.</font>";
        }else
         $msg = "<font color='red'>Il faut commencer à supprimer les interventions que cette équipe <b>".$equipe['EQUIPE_NOM']."</b> a effectuée.</font>";

      }
      $donne['msg'] =$msg;
      $this->session->set_flashdata($donne);

      redirect(base_url().'equipes/Equipes/liste');
    }
  }