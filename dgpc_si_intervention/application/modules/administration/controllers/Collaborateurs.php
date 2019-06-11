<?php

 class Collaborateurs extends MY_Controller
 {
  
  function __construct()
  {
    parent::__construct();
    $this->make_bread->add('Collaborateurs', "administration/Collaborateurs", 0);
    $this->breadcrumb = $this->make_bread->output();

    //$this->permission();
  }

    public function permission(){
         if($this->mylibrary->get_permission('Collaborateurs') ==0){
          redirect(base_url());
         }
    }
  
    public function index()
    {     

      $data['title'] = "Nouveau collaborateur";      
      $data['breadcrumb'] = $this->make_bread->output();
      $data['casernes']=$this->Model->getList('rh_cppc');
      //$data['postes']=$this->Model->getList('admin_poste');

      $this->load->view('collaborateur/Collaborateur_Nouveau_View',$data);
    }

        public function mail_check()
        {
                  $mail1=$this->input->post('EMAIL');
                  $mail2=$this->input->post('EMAIL_CONFIRM');
                if ($mail1 <> $mail2)
                {
                        $this->form_validation->set_message('mail_check', 'Les deux Mails ne sont pas identiques');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }


    public function enregistrer()
    {

      
   // $this->form_validation->set_rules('password', 'Password', 'required');
       
       $this->form_validation->set_rules('FONCTION', 'Fonction', 'required');


       $this->form_validation->set_rules('EMAIL', 'Email', 'required|valid_email|is_unique[admin_users.USER_EMAIL]',array("is_unique"=>"<font color='red'>Email déjà utilisé</font>"));
       $this->form_validation->set_rules('EMAIL_CONFIRM', 'Email Confirmation', 'required|valid_email');

       $this->form_validation->set_rules('ODK', 'User ODK', 'required|is_unique[admin_users.USER_ODK]',array("is_unique"=>"<font color='red'>Utilisateur ODK déjà utilisé</font>"));
       $this->form_validation->set_rules('NOM', 'Nom', 'required');
       $this->form_validation->set_rules('PRENOM', 'Prénom', 'required');
       $this->form_validation->set_rules('TELEPHONE', 'Télephone', 'required|is_unique[admin_users.USER_TELEPHONE]',array("is_unique"=>"<font color='red'>Numéro de Télephone déjà utilisé</font>"));
       $this->form_validation->set_rules('ADRESSE', 'Adresse', 'required');
       $this->form_validation->set_rules('MATRICULE', 'Matricule', 'required|is_unique[rh_personnel_dgpc.PERSONNEL_MATRICULE]',array("is_unique"=>"<font color='red'>Matricule déjà utilisé</font>"));
       $this->form_validation->set_rules('GRADE', 'Grade', 'required');

       $this->form_validation->set_rules('EMAIL_CONFIRM', 'mail', 'callback_mail_check');
       $this->form_validation->set_rules('DATE_ENTREE', 'Date', 'required');

        if ($this->form_validation->run() == FALSE) {
            
            $data['title'] = "Nouveau collaborateur";      
            $data['profil'] = $this->input->post("PROFILE_ID");      
            $data['breadcrumb'] = $this->make_bread->output();
           
            /*echo "<pre>";            
            print_r($this->input->post());
            echo "</pre>";*/
           
            $this->load->view('collaborateur/Collaborateur_Nouveau_View',$data);
        }else{
            $EST_UTILISATEUR = $this->input->post('EST_UTILISATEUR');

            // echo $EST_UTILISATEUR ;exit();

            $array_collabo = array(
                                'PERSONNEL_EMAIL'=>$this->input->post('EMAIL'),
                                'PERSONNEL_ODK'=>$this->input->post('ODK'),
                                'PERSONNEL_NOM'=>strtoupper($this->input->post('NOM')),
                                'PERSONNEL_PRENOM'=>ucfirst($this->input->post('PRENOM')),
                                'PERSONNEL_TELEPHONE'=>$this->input->post('TELEPHONE'),
                                'FONCTION'=>$this->input->post('FONCTION'),
                                'PERSONNEL_ADRESSE'=>$this->input->post('ADRESSE'),                                
                                'PERSONNEL_MATRICULE'=>$this->input->post('MATRICULE'),
                                'GRADE'=>$this->input->post('GRADE'),
                                'DATE_ENTREE'=>$this->input->post('DATE_ENTREE')
                                );

            $collaborateur_id = $this->Model->insert_last_id('rh_personnel_dgpc',$array_collabo);  

            $password = $this->notifications->generate_password(8);
            $array_ticket = array(
                                'USER_EMAIL'=>$this->input->post('EMAIL'),
                                'USER_ODK'=>$this->input->post('ODK'),
                                'USER_NOM'=>strtoupper($this->input->post('NOM')),
                                'USER_PRENOM'=>ucfirst($this->input->post('PRENOM')),
                                'USER_TELEPHONE'=>$this->input->post('TELEPHONE'),
                                'USER_ADRESSE'=>$this->input->post('ADRESSE'),                                
                                'USER_CODE'=>$this->input->post('MATRICULE'),
                                'PERSONNEL_ID'=>$collaborateur_id,
                                'USER_PASSWORD'=>md5($password),
                                'IS_ACTIVE'=>($EST_UTILISATEUR ==1)?1:0
                                );

            $user_id = $this->Model->insert_last_id('admin_users',$array_ticket);

            /*$this->Model->update_table('admin_collaborateurs',array('COLLABORATEUR_ID'=>$collaborateur_id),array('COLLABORATEUR_CODE'=>$collabo_code));*/
            // $user_id = 0;
            $link="";
            if($EST_UTILISATEUR == 1){            

             
            $msg_mail = "Cher Mr,Mme ".$this->input->post('NOM')." ".$this->input->post('PRENOM').", vos IDs de connexion sur l'application <a href=".base_url().">DGPC Centre de situation</a> sont <br> Email: ".$this->input->post('EMAIL')."<br> et Mot de passe: ".$password."<br> Cordialement.";
             $this->notifications->send_mail(array($this->input->post('EMAIL')),'DGPC app Vos IDs de connection',array(),$msg_mail,array());
            
            $array_profile = array(
                                   "PROFILE_ID"=>$this->input->post("PROFILE_ID"),
                                   'USER_ID'=>$user_id);
            $this->Model->insert_last_id('admin_profiles_users',$array_profile);
            //$link="<div class='alert'><b>Cliquer ici pour l'affecter à <a href='".base_url('equipes/Equipes/liste')."'>une équipe</a> ou soit comme <a href='".base_url('equipes/Caserne/add_manager/0/'.$collaborateur_id)."'>Manager d'une cppc</a> ou soit à <a href='".base_url('equipes/Services/new/0/'.$collaborateur_id)."'>un service dgpc</a></b></div>";

          }
            
            
            //$msg = "<font color='green'> L'utilisateur <b>".$this->input->post('NOM')." ".$this->input->post('PRENOM')."</b> a été enregistré.</font>";

            $msg = "<div class='alert alert-success'>Le collaborateur <b>".$this->input->post('NOM')." ".$this->input->post('PRENOM')."</b> a été crée.</div>";

        

            $donne['msg'] =$msg;
            $donnees['link']=$link;
            $this->session->set_flashdata($donne);
            $this->session->set_flashdata($donnees);
            
            redirect(base_url().'administration/Collaborateurs/liste_collaborateur');
            
        }
    }
    
    // public function liste_collaborateur()
    // {
    //  if($this->mylibrary->get_permission('Collaborateurs/liste_collaborateur') ==0){
    //   redirect(base_url());
    //  }

    //     $collabos = array();
    //     $collabos = $this->Model->getList('rh_personnel_dgpc');

        
    //     $collabo_list = array();

    //     /*foreach($collabos as $collabo):
    //         print_r($collabo);

    //     endforeach;*/

    //     foreach ($collabos as $collabo) {

    //         $array = NULL;

    //         $array['CODE'] = $collabo['PERSONNEL_MATRICULE'];
    //         $array['EMAIL'] = $collabo['PERSONNEL_EMAIL'];
    //         $array['NOM'] = $collabo['PERSONNEL_NOM']." ".$collabo['PERSONNEL_PRENOM'];
    //         $array['TELEPHONE'] = $collabo['PERSONNEL_TELEPHONE'];
    //         $array['ODK'] = $collabo['PERSONNEL_ODK'];
    //         $array['FONCTION'] = $collabo['FONCTION'];
    //         $array['ADRESSE'] = $collabo['PERSONNEL_ADRESSE'];
    //         $array['DATE'] = $collabo['DATE_ENTREE'];            

    //         $array['OPTIONS'] = '<div class="dropdown ">
    //                 <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
    //                 <span class="caret"></span></a>
    //                 <ul class="dropdown-menu dropdown-menu-left">
    //                     ';            

    //         $array['OPTIONS'] .= "<li><a href='" . base_url('administration/Collaborateurs/Modifier/' . $collabo['PERSONNEL_ID']) . "'>Modifier</a></li>";

    //         $array['OPTIONS'] .= "<li><a href='" . base_url('administration/Collaborateurs/Deploiement/' . $collabo['PERSONNEL_ID']) . "'>Ses Déploiements</a></li>";
            
    //         $array['OPTIONS'] .= "<li><a hre='#' data-toggle='modal' 
    //                               data-target='#mydelete" . $collabo['PERSONNEL_ID'] . "'><font color='red'>Supprimer</font></a></li></ul>
    //               </div>";
           
    //         $array['OPTIONS'] .="
    //                                 <div class='modal fade' id='mydelete" . $collabo['PERSONNEL_ID'] . "'>
    //                                     <div class='modal-dialog'>
    //                                         <div class='modal-content'>

    //                                             <div class='modal-body'>
    //                                                 <h5>Supprimer le collaborateur <b>" . $array['NOM'] . "</b>?</h5>
    //                                             </div>

    //                                             <div class='modal-footer'>
    //                                                 <a class='btn btn-danger btn-md' href='" . base_url('administration/Collaborateurs/supprimer/' . $collabo['PERSONNEL_ID']) . "'>Supprimer</a>
    //                                                 <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
    //                                             </div>

    //                                         </div>
    //                                     </div>
    //                                 </div>";

    //         $collabo_list[] =$array;
    //     }
    //     $template = array(
    //         'table_open' => '<table id="collabo_list" class="table table-bordered table-striped table-hover table-condensed table-responsive">',
    //         'table_close' => '</table>'
    //     );

    //     $this->table->set_heading('CODE','EMAIL','NOM & PRENOM','TELEPHONE','LOGIN ODK','FONCTION','ADDRESSE','DATE ENTREE','OPTIONS');
    //     $this->table->set_template($template);
    //     $data['collabo_list'] = $collabo_list;


    //   $data['title'] = "Liste des collaborateurs";      
    //   $data['breadcrumb'] = $this->make_bread->output();

    //   $this->load->view('collaborateur/Collaborateur_Liste_View',$data);
    // }
     public function liste_collaborateur()
    {
    /* if($this->mylibrary->get_permission('Collaborateurs/liste_collaborateur') ==0){
      redirect(base_url());
     } */

        $collabos = array();
        $collabos = $this->Model->getList('rh_personnel_dgpc');

        
        $collabo_list = array();

        /*foreach($collabos as $collabo):
            print_r($collabo);

        endforeach;*/

        foreach ($collabos as $collabo) {
            $id_personel=$collabo['PERSONNEL_ID'];
            $condition=array('PERSONEL_ID'=>$id_personel);
            $condition_m=array('PERSONNEL_ID'=>$id_personel);
            $get_dans_equipe=$this->Model->getOne('rh_equipe_membre_cppc',$condition);
            $get_dans_manager=$this->Model->getOne('rh_cppc_manager',$condition_m);
            $get_dans_service=$this->Model->getOne('rh_service_manager',$condition_m);

            $agent_usr=$this->Model->member_profile($collabo['PERSONNEL_ID']);
            //print_r($get_dans_service);


           
            if (!empty($get_dans_equipe)) {
               $id_equipe=$get_dans_equipe['EQUIPE_ID'];
               $is_chef=$get_dans_equipe['IS_CHEF_EQUIPE'];
               if($is_chef==1){
                $chef=' : Chef d\'equipe';
               }else{
                $chef="";
               }
               $equipe=$this->Model->getOne('rh_equipe_cppc',array('EQUIPE_ID'=>$id_equipe));
               $ccpc=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$equipe['CPPC_ID']));
               $affectation=' - '.$equipe['EQUIPE_NOM'].$chef.'('.$ccpc['CPPC_NOM'].')';
                }else{
                   
                    $affectation='';
                }

            if(!empty($get_dans_manager)){
                if(empty($get_dans_manager['DATE_FIN'])){
                    $nom_cppc=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$get_dans_manager['CPPC_ID']));
                    $affectation_m=' - Manager '.$nom_cppc['CPPC_NOM'];
                }else{
                    $affectation_m="";
                }
            }else{
                $affectation_m="";
            }

            if(!empty($get_dans_service)){
                    $nom_service=$this->Model->getOne('rh_service_dgpc',array('SERVICE_DGPC_ID'=>$get_dans_service['SERVICE_DGPC_ID']));
                    
                    $affectation_s=' - '.$nom_service['SERVICE_DGPC_DESCR'];
            }else{
                $affectation_s="";
            }

            if(empty($affectation) and empty($affectation_m) and empty($affectation_s)){
                $affecfinal='Non affecté';
            }else{
                $affecfinal=$affectation.'<br>'.$affectation_m.'<br>'.$affectation_s;
            }


            $get_user_statut=$this->Model->getOne('admin_users',array('PERSONNEL_ID'=>$collabo['PERSONNEL_ID']));
            if($get_user_statut['IS_ACTIVE']==1){
                $statut='<div style="text-align:center"><span><input type="checkbox" checked disabled><span></div>';
            }else{
                $statut='<div style="text-align:center"><span><input type="checkbox" disabled></span></div>';
            }
            $array = NULL;
            $array['CODE'] = $collabo['PERSONNEL_MATRICULE'];
            $array['EMAIL'] = $collabo['PERSONNEL_EMAIL'];
            $array['NOM'] = $collabo['PERSONNEL_NOM']." ".$collabo['PERSONNEL_PRENOM'];
            $array['TELEPHONE'] = $collabo['PERSONNEL_TELEPHONE'];
            $array['ODK'] = $collabo['PERSONNEL_ODK'];
            $array['PROFILE'] = $agent_usr['PROFILE_DESCR'];
            $array['FONCTION'] = $collabo['FONCTION'].'/'.$collabo['GRADE'];
            $array['AFFECTATION'] =$affecfinal;
            $array['ADRESSE'] = $collabo['PERSONNEL_ADRESSE'];
            $array['DATE'] = $collabo['DATE_ENTREE'];            
            $array['EST_UTILISATEUR'] =$statut;            
            
            if($this->mylibrary->verify_is_admin() ==1){
            $array['OPTIONS'] = '<div class="dropdown ">
                    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-left">
                        ';            

            

            $array['OPTIONS'] .= "<li><a href='" . base_url('administration/Collaborateurs/Deploiement/' . $collabo['PERSONNEL_ID']) . "'>Affectations</a></li>";
             $array['OPTIONS'] .= "<li><a hre='#' data-toggle='modal' 
                                  data-target='#affecter" . $collabo['PERSONNEL_ID'] . "'><font color=''>Affecter</font></a></li>";
            
            $array['OPTIONS'] .= "<li><a href='" . base_url('tickets/Tickets/get_interventions1/' .$collabo['PERSONNEL_ID']) . "'>Interventions</a></li>";

            $array['OPTIONS'] .= "<li><a href='" . base_url('administration/Collaborateurs/Modifier/' . $collabo['PERSONNEL_ID']) . "'>Modifier</a></li>";
            
            $array['OPTIONS'] .= "<li><a hre='#' data-toggle='modal' 
                                  data-target='#mydelete" . $collabo['PERSONNEL_ID'] . "'><font color='red'>Supprimer</font></a></li></ul>
                  </div>";
           
            $array['OPTIONS'] .="
                                    <div class='modal fade' id='mydelete" . $collabo['PERSONNEL_ID'] . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Supprimer le collaborateur <b>" . $array['NOM'] . "</b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('administration/Collaborateurs/supprimer/' . $collabo['PERSONNEL_ID']) . "'>Supprimer</a>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>";
                    $array['OPTIONS'] .="
                                    <div class='modal fade' id='affecter" . $collabo['PERSONNEL_ID'] . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Affecter le collaborateur <b>" . $array['NOM'] . "</b>?</h5>
                                                    <a href='".base_url('equipes/Equipes/Addmembre/0/'. $collabo['PERSONNEL_ID'])."' class='btn btn-primary'>Dans une CPPC</a>
                                                    <a href='".base_url('equipes/Caserne/add_manager/0/'. $collabo['PERSONNEL_ID'])."' class='btn btn-primary'>Comme Manager d'une CPPC</a>
                                                    <a href='".base_url('equipes/Services/new/0/'.$collabo['PERSONNEL_ID']). "' class='btn btn-primary'>Dans un service DGPC</a>
                                                </div>

                                                <div class='modal-footer'>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>";
        }
            $collabo_list[] =$array;
          
        }
        $template = array(
            'table_open' => '<table id="collabo_list" class="table table-bordered table-striped table-hover table-condensed table-responsive">',
            'table_close' => '</table>'
        );
        if($this->mylibrary->verify_is_admin() ==1){
        $this->table->set_heading('CODE','EMAIL','IDENTITE','TELEPHONE','LOGIN ODK','PROFIL','FONCTION','AFFECTATION','ADRESSE','DATE ENTREE','UTILISATEUR','OPTIONS');
       }else{
         $this->table->set_heading('CODE','EMAIL','IDENTITE','TELEPHONE','LOGIN ODK','PROFIL','FONCTION','AFFECTATION','ADRESSE','DATE ENTREE','UTILISATEUR');
       }

       
        $this->table->set_template($template);
        $data['collabo_list'] = $collabo_list;


      $data['title'] = "Liste des collaborateurs";      
      $data['breadcrumb'] = $this->make_bread->output();

      $this->load->view('collaborateur/Collaborateur_Liste_View',$data);
    }

    public function nouveau()
    {

        $data['MATRICULE']= NULL;
        $data['NOM']= NULL;
        $data['PRENOM']= NULL;
        $data['EMAIL']= NULL;
        $data['ODK']= NULL;
        $data['TELEPHONE']= NULL;
        $data['GRADE']= NULL;
        $data['DOB']= NULL;
        $data['profil'] = ""; 


        $data['title'] = "Nouveau collaborateur";
        $this->make_bread->add('Nouveau collaborateur', "nouveau", 1);
        $data['breadcrumb'] = $this->make_bread->output();

        $this->load->view('collaborateur/Collaborateur_Nouveau_View', $data);
    }
    
    public function get_collaborateur()
    {
        $var_search = $_POST['search']['value'];

        $table = "admin_collaborateurs";
        $critere_txt = !empty($_POST['search']['value']) ? ("COLLABORATEUR_CODE LIKE '%$var_search%' OR COLLABORATEUR_EMAIL LIKE '%$var_search%' OR COLLABORATEUR_ODK LIKE '%$var_search%' OR COLLABORATEUR_NOM LIKE '%$var_search%' OR COLLABORATEUR_PRENOM LIKE '%$var_search%' OR COLLABORATEUR_TELEPHONE LIKE '%$var_search%'") : NULL;
        $critere_array = array();
        $order_column = array('COLLABORATEUR_CODE','COLLABORATEUR_EMAIL', 'COLLABORATEUR_ODK', 'COLLABORATEUR_NOM','COLLABORATEUR_PRENOM','COLLABORATEUR_TELEPHONE');
        $order_by = isset($_POST['order']) ? array($order_column[$_POST['order']['0']['column']] => $_POST['order']['0']['dir']) : array('COLLABORATEUR_ID' => 'DESC');
        $select_column = array('COLLABORATEUR_ID', 'COLLABORATEUR_CODE','COLLABORATEUR_NOM', 'COLLABORATEUR_PRENOM', 'COLLABORATEUR_TELEPHONE','COLLABORATEUR_EMAIL', 'COLLABORATEUR_ODK','COLLABORATEUR_FONCTION','COLLABORATEUR_ADRESSE');

        $fetch_tickets = $this->Model->make_datatables($table, $select_column, $critere_txt, $critere_array, $order_by);

        // print_r($fetch_tickets);
        $data = array();
        foreach ($fetch_tickets as $row) {
            $sub_array = array();
                      
            $sub_array[] = $row->COLLABORATEUR_CODE;
            $sub_array[] = $row->COLLABORATEUR_EMAIL;            
            $sub_array[] = $row->COLLABORATEUR_NOM.' '.$row->COLLABORATEUR_PRENOM;
            $sub_array[] = $row->COLLABORATEUR_TELEPHONE;
            $sub_array[] = $row->COLLABORATEUR_ODK;
            $sub_array[] = $row->COLLABORATEUR_FONCTION;
            $sub_array[] = $row->COLLABORATEUR_ADRESSE;

            $options = '<div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            ';
            
            $options .= "<li><a href='" . base_url('administration/Collaborateurs/Modifier/' . $row->COLLABORATEUR_ID) . "'>
                                        Modifier</li>";
            //}
            $array['OPTIONS'] .= "<li><a href='" . base_url('administration/Collaborateurs/Deploiement/' .$collabo['PERSONNEL_ID']) . "'>Ses affectations</a></li>";

            $options .= "<li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete" . $row->COLLABORATEUR_ID . "'><font color='red'>Supprimer</font></button></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete" . $row->COLLABORATEUR_ID . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Supprimer :<b>" . $row->COLLABORATEUR_NOM." ".$row->COLLABORATEUR_PRENOM. "</b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('administration/Collaborateurs/supprimer/' . $row->COLLABORATEUR_ID) . "'>Supprimer</a>
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
    public function get_user()
    {
       $var_search = $_POST['search']['value'];

        $table = "admin_users";
        $critere_txt = !empty($_POST['search']['value']) ? ("USER_ODK LIKE '%$var_search%' OR USER_EMAIL LIKE '%$var_search%' OR USER_NOM LIKE '%$var_search%' OR USER_PRENOM LIKE '%$var_search%' OR USER_TELEPHONE LIKE '%$var_search%'") : NULL;
        $critere_array = array();
        $order_column = array('USER_EMAIL','USER_TELEPHONE', 'USER_NOM', 'USER_PRENOM');
        $order_by = isset($_POST['order']) ? array($order_column[$_POST['order']['0']['column']] => $_POST['order']['0']['dir']) : array('USER_ID' => 'DESC');
        $select_column = array('USER_ID', 'USER_CODE','USER_EMAIL', 'USER_NOM', 'USER_PRENOM','USER_TELEPHONE', 'USER_ODK','USER_ADRESSE');

        $fetch_tickets = $this->Model->make_datatables($table, $select_column, $critere_txt, $critere_array, $order_by);

        // print_r($fetch_tickets);
        $data = array();
        foreach ($fetch_tickets as $row) {
            $sub_array = array();
                      
            $sub_array[] = $row->USER_CODE;
            $sub_array[] = $row->USER_EMAIL;            
            $sub_array[] = $row->USER_NOM;
            $sub_array[] = $row->USER_PRENOM;
            $sub_array[] = $row->USER_TELEPHONE;
            $sub_array[] = $row->USER_ODK;
            $sub_array[] = $row->USER_ADRESSE;           

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

    public function modifier()
    {
      $user_id = $this->uri->segment(4);

      $data['title'] = "Modifier un collaborateur";
      $data['collabo'] = $this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$user_id));
      $data['user'] = $this->Model->getOne('admin_users',array('PERSONNEL_ID'=>$user_id,'IS_ACTIVE'=>1));
      // $data['user'] = $this->Model->getOne('admin_users',array('PERSONNEL_ID'=>$user_id));
      $data['breadcrumb'] = $this->make_bread->output();

      $this->load->view('collaborateur/Collaborateur_Modifier_View',$data);
    }


 public function modifier_collaborateur()
    {
       if($this->input->post('EST_UTILISATEUR')==1){
         $EST_UTILISATEUR = $this->input->post('EST_UTILISATEUR');
     }else{
        $EST_UTILISATEUR =0;
     }
             

      
   // $this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_rules('EMAIL_CONFIRM', 'Email Confirmation', 'required');
     $this->form_validation->set_rules('FONCTION', 'Fonction', 'required');


       $this->form_validation->set_rules('EMAIL', 'Email', 'required');

       $this->form_validation->set_rules('NOM', 'Nom', 'required');
       $this->form_validation->set_rules('PRENOM', 'Prénom', 'required');
       $this->form_validation->set_rules('TELEPHONE', 'Télephone', 'required');
       $this->form_validation->set_rules('ADRESSE', 'Adresse', 'required');
       $this->form_validation->set_rules('MATRICULE', 'Matricule', 'required');
       $this->form_validation->set_rules('GRADE', 'Grade', 'required');
       $this->form_validation->set_rules('DATE_ENTREE', 'Date entrée en service', 'required');
       $this->form_validation->set_rules('EMAIL_CONFIRM', 'mail', 'callback_mail_check');
        
     
        if ($this->form_validation->run() == FALSE) {
            
            $data['title'] = "Nouveau utilisateur";      
            $data['breadcrumb'] = $this->make_bread->output();
            $collaborateur_id=$this->input->post('PERSONNEL_ID');
            $data['collabo'] = $this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$collaborateur_id));
      $data['user'] = $this->Model->getOne('admin_users',array('PERSONNEL_ID'=>$collaborateur_id));

            $this->load->view('collaborateur/Collaborateur_Modifier_View',$data);

        }else{
             // $EST_UTILISATEUR = $this->input->post('EST_UTILISATEUR');
             // echo  $EST_UTILISATEUR; exit();

            $collaborateur_id=$this->input->post('PERSONNEL_ID');
           
             $CollaborateursOne=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$collaborateur_id));
              // $col=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$collaborateur_id));
            $user=$this->Model->getOne('admin_users',array('USER_EMAIL'=>$CollaborateursOne['PERSONNEL_EMAIL']));
             $Mail_entered=$this->input->post('EMAIL');
            if ($Mail_entered<>$CollaborateursOne['PERSONNEL_EMAIL']) {


            // $EST_UTILISATEUR = $this->input->post('EST_UTILISATEUR');
            
            $array_collabo = array(
                                'PERSONNEL_EMAIL'=>$this->input->post('EMAIL'),
                                'PERSONNEL_ODK'=>$this->input->post('ODK'),
                                'PERSONNEL_NOM'=>$this->input->post('NOM'),
                                'PERSONNEL_PRENOM'=>$this->input->post('PRENOM'),
                                'PERSONNEL_TELEPHONE'=>$this->input->post('TELEPHONE'),
                                'FONCTION'=>$this->input->post('FONCTION'),
                                'PERSONNEL_ADRESSE'=>$this->input->post('ADRESSE'),                                
                                'PERSONNEL_MATRICULE'=>$this->input->post('MATRICULE'),
                                'GRADE'=>$this->input->post('GRADE'),
                                'DATE_ENTREE'=>$this->input->post('DATE_ENTREE')
                                );

            $this->Model->update('rh_personnel_dgpc',array('PERSONNEL_ID'=>$collaborateur_id),$array_collabo);  
 
            $password = $this->notifications->generate_password(8);
            $array_ticket = array(
                                'USER_EMAIL'=>$this->input->post('EMAIL'),
                                'USER_ODK'=>$this->input->post('ODK'),
                                'USER_NOM'=>$this->input->post('NOM'),
                                'USER_PRENOM'=>$this->input->post('PRENOM'),
                                'USER_TELEPHONE'=>$this->input->post('TELEPHONE'),                                
                                'USER_ADRESSE'=>$this->input->post('ADRESSE'),                                
                                'USER_CODE'=>$this->input->post('MATRICULE'),
                                'PERSONNEL_ID'=>$collaborateur_id,
                                'USER_PASSWORD'=>md5($password),
                                'IS_ACTIVE'=>$EST_UTILISATEUR
                                );

             $this->Model->update('admin_users',array('PERSONNEL_ID'=>$collaborateur_id),$array_ticket);           
            /*$this->Model->update_table('admin_collaborateurs',array('COLLABORATEUR_ID'=>$collaborateur_id),array('COLLABORATEUR_CODE'=>$collabo_code));*/

             // $user_id = 0;
             $AdminOne=$this->Model->getOne('admin_users',array('PERSONNEL_ID'=>$collaborateur_id));
             $user_id = $AdminOne['USER_ID'];

            if($EST_UTILISATEUR == 1){

            

             // echo $user_id;exit();
             
            $msg_mail = "Cher Mr,Mme ".$this->input->post('NOM')." ".$this->input->post('PRENOM').", vos IDs de connexion sur l'application <a href=".base_url().">DGPC Centre de situation</a> sont <br> Email: ".$this->input->post('EMAIL')."<br> et Mot de passe: ".$password."<br> Cordialement.";
             $this->notifications->send_mail(array($this->input->post('EMAIL')),'DGPC app Vos IDs de connection',array(),$msg_mail,array());
             $array_profile = array(
                                   "PROFILE_ID"=>$this->input->post("PROFILE_ID"),
                                   'USER_ID'=>$user_id);
             $this->Model->delete('admin_profiles_users',array('USER_ID'=>$user_id));
            $this->Model->create('admin_profiles_users',$array_profile);
            
          }else{
            $this->Model->delete('admin_profiles_users',array('USER_ID'=>$user_id));
            // $this->Model->update('admin_users',array('PERSONNEL_ID'=>$collaborateur_id),$array_ticket);
          }
            
            //$msg = "<font color='green'> L'utilisateur <b>".$this->input->post('NOM')." ".$this->input->post('PRENOM')."</b> a été enregistré.</font>";

            $msg = "<div class='alert alert-success'>L'utilisateur <b>".$this->input->post('NOM')." ".$this->input->post('PRENOM')."</b> a été enregistré.</div>";

        

            $donne['msg'] =$msg;
            $this->session->set_flashdata($donne);
            
          /*  if($EST_UTILISATEUR == 1){
               redirect(base_url().'administration/Collaborateurs/AddProfile/'.$user_id);
            }else{ */
            redirect(base_url().'administration/Collaborateurs/liste_collaborateur');
           // }


             } else {
               
             $collaborateur_id=$this->input->post('PERSONNEL_ID');
            // $EST_UTILISATEUR = $this->input->post('EST_UTILISATEUR');
            
            $array_collabo = array(
                                
                                'PERSONNEL_ODK'=>$this->input->post('ODK'),
                                'PERSONNEL_NOM'=>$this->input->post('NOM'),
                                'PERSONNEL_PRENOM'=>$this->input->post('PRENOM'),
                                'PERSONNEL_TELEPHONE'=>$this->input->post('TELEPHONE'),
                                'FONCTION'=>$this->input->post('FONCTION'),
                                'PERSONNEL_ADRESSE'=>$this->input->post('ADRESSE'),                                
                                'PERSONNEL_MATRICULE'=>$this->input->post('MATRICULE'),
                                'GRADE'=>$this->input->post('GRADE'),
                                'DATE_ENTREE'=>$this->input->post('DATE_ENTREE')
                                );

            $this->Model->update('rh_personnel_dgpc',array('PERSONNEL_ID'=>$collaborateur_id),$array_collabo);  
            
            /*$this->Model->update_table('admin_collaborateurs',array('COLLABORATEUR_ID'=>$collaborateur_id),array('COLLABORATEUR_CODE'=>$collabo_code));*/
            $user_id = 0;
             $AdminOne=$this->Model->getOne('admin_users',array('PERSONNEL_ID'=>$collaborateur_id));
             $user_id = $AdminOne['USER_ID'];
             $this->Model->delete('admin_profiles_users',array('USER_ID'=>$user_id));
             $AdminOne=$this->Model->getOne('admin_users',array('PERSONNEL_ID'=>$collaborateur_id));
             $user_id = $AdminOne['USER_ID'];
            if($EST_UTILISATEUR == 1){

             
            $array_ticket = array(
                                
                                'USER_ODK'=>$this->input->post('ODK'),
                                'USER_NOM'=>$this->input->post('NOM'),
                                'USER_PRENOM'=>$this->input->post('PRENOM'),
                                'USER_TELEPHONE'=>$this->input->post('TELEPHONE'),
                                //'FONCTION'=>$this->input->post('FONCTION'),
                                'USER_ADRESSE'=>$this->input->post('ADRESSE'),                                
                                'USER_CODE'=>$this->input->post('MATRICULE'),
                                'PERSONNEL_ID'=>$collaborateur_id  ,
                                'IS_ACTIVE'=>$EST_UTILISATEUR                              
                                );
            // $array_ticket = array(
            //                     'USER_EMAIL'=>$this->input->post('EMAIL'),
            //                     'USER_ODK'=>$this->input->post('ODK'),
            //                     'USER_NOM'=>$this->input->post('NOM'),
            //                     'USER_PRENOM'=>$this->input->post('PRENOM'),
            //                     'USER_TELEPHONE'=>$this->input->post('TELEPHONE'),                                
            //                     'USER_ADRESSE'=>$this->input->post('ADRESSE'),                                
            //                     'USER_CODE'=>$this->input->post('MATRICULE'),
            //                     'PERSONNEL_ID'=>$collaborateur_id,
            //                     'USER_PASSWORD'=>md5($password),
            //                     'IS_ACTIVE'=>$EST_UTILISATEUR
            //                     );

             $this->Model->update('admin_users',array('PERSONNEL_ID'=>$collaborateur_id),$array_ticket);
            

              $array_profile = array(
                                   "PROFILE_ID"=>$this->input->post("PROFILE_ID"),
                                   'USER_ID'=>$user_id);
             $this->Model->delete('admin_profiles_users',array('USER_ID'=>$user_id));
            $this->Model->create('admin_profiles_users',$array_profile);
  
          }else{
            // echo $EST_UTILISATEUR; exit();
            $array_ticket = array(
                                
                                'USER_ODK'=>$this->input->post('ODK'),
                                'USER_NOM'=>$this->input->post('NOM'),
                                'USER_PRENOM'=>$this->input->post('PRENOM'),
                                'USER_TELEPHONE'=>$this->input->post('TELEPHONE'),
                                //'FONCTION'=>$this->input->post('FONCTION'),
                                'USER_ADRESSE'=>$this->input->post('ADRESSE'),                                
                                'USER_CODE'=>$this->input->post('MATRICULE'),
                                'PERSONNEL_ID'=>$collaborateur_id  ,
                                'IS_ACTIVE'=>$EST_UTILISATEUR                              
                                );
            
             $this->Model->update('admin_users',array('PERSONNEL_ID'=>$collaborateur_id),$array_ticket);
            $this->Model->delete('admin_profiles_users',array('USER_ID'=>$user_id));
          }
            
            //$msg = "<font color='green'> L'utilisateur <b>".$this->input->post('NOM')." ".$this->input->post('PRENOM')."</b> a été enregistré.</font>";

            $msg = "<div class='alert alert-success'>L'utilisateur <b>".$this->input->post('NOM')." ".$this->input->post('PRENOM')."</b> a été enregistré.</div>";

        

            $donne['msg'] =$msg;
            $this->session->set_flashdata($donne);
            
          /*  if($EST_UTILISATEUR == 1){

               redirect(base_url().'administration/Collaborateurs/AddProfile/'.$user_id);
            }else{ */
            redirect(base_url().'administration/Collaborateurs/liste_collaborateur');
          //  }
            } 

        }

            
       
    }

    public function save_modification()
    {       
       $this->form_validation->set_rules('COLLABORATEUR_NOM', 'Nom', 'required');
       $this->form_validation->set_rules('COLLABORATEUR_PRENOM', 'Prénom', 'required');
       $this->form_validation->set_rules('COLLABORATEUR_TELEPHONE', 'Télephone', 'required');
       $this->form_validation->set_rules('COLLABORATEUR_ADRESSE', 'Adresse', 'required');


       
       $collaborateur_id = $this->uri->segment(4);
               
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Modifier un collaborateur";

            $data['utilisateur'] = $this->Model->getOne('admin_collaborateurs',array('COLLABORATEUR_ID'=>$collaborateur_id));            
            $data['breadcrumb'] = $this->make_bread->output();
            $data['casernes']=$this->Model->getList('interv_caserne');
            $data['postes']=$this->Model->getList('admin_poste');

            $this->load->view('collaborateur/Collaborateur_Modifier_View',$data); 
          }else{
           
            $array_user = array(
                                'COLLABORATEUR_NOM'=>$this->input->post('COLLABORATEUR_NOM'),
                                'COLLABORATEUR_PRENOM'=>$this->input->post('COLLABORATEUR_PRENOM'),
                                'COLLABORATEUR_TELEPHONE'=>$this->input->post('COLLABORATEUR_TELEPHONE'),
                                'COLLABORATEUR_ADRESSE'=>$this->input->post('COLLABORATEUR_ADRESSE'), 
                                );
            $msg = "<font color='red'>L'utilisateur <b>".$this->input->post('COLLABORATEUR_NOM')." ".$this->input->post('COLLABORATEUR_PRENOM')."</b> n'a pas été enregistré.</font>";

            //partie equipe 
              $array_equipe = array(
                               'EQUIPE_ID' =>$this->input->post('EQUIPE_ID'),
                               'COLLABORATEUR_ID' =>$collaborateur_id,
                               'POSTE_ID' =>$this->input->post('POSTE_ID')
                                );
              $this->Model->delete('interv_equipe_membre',$array_equipe);
              $this->Model->insert_last_id('interv_equipe_membre',$array_equipe);
            //Fin equipe

            if($this->Model->update_table('admin_collaborateurs',array('COLLABORATEUR_ID'=>$collaborateur_id),$array_user)){
              $msg = "<font color='green'> Le collaborateur <b>".$this->input->post('COLLABORATEUR_NOM')." ".$this->input->post('COLLABORATEUR_PRENOM')."</b> a été modifié.</font>";
            }
            $donne['msg'] =$msg;
            $this->session->set_flashdata($donne);

            redirect(base_url().'administration/Collaborateurs/liste_collaborateur');
        }
    }
    
    
    public function supprimer()
    {
        $personnel_id = $this->uri->segment(4);

        $collabo = $this->Model->getOne('rh_personnel_dgpc', array('PERSONNEL_ID' => $personnel_id));
        
        $msg = '';

        $this->Model->delete('rh_personnel_dgpc', array('PERSONNEL_ID' => $personnel_id));
        $this->Model->delete('admin_users', array('USER_CODE' => $collabo['PERSONNEL_MATRICULE']));

        //$msg = "<font color='green'>L'utilisateur <b>".$collabo['PERSONNEL_NOM']." ".$collabo['PERSONNEL_PRENOM']."</b> a été supprimé</font>";

        $msg = "<div class='alert alert-success'>L'utilisateur <b>".$collabo['PERSONNEL_NOM']." ".$collabo['PERSONNEL_PRENOM']."</b> a été supprimé.</div>";


        $donne['msg'] =$msg;
        $this->session->set_flashdata($donne);

      redirect(base_url().'administration/Collaborateurs/liste_collaborateur');
    }

    public function AddProfile()
    {
      $data['title'] = "Ajouter des profiles";      
      $data['breadcrumb'] = $this->make_bread->output();
      $data['profiles'] = $this->Model->getList('admin_profile');
      $data['users'] = $this->Model->getList('admin_users');
      
      $USER_ID = $this->uri->segment(3);

      if($_SERVER['REQUEST_METHOD'] == 'POST'){
           $user_id = $this->input->post('USER_ID');
           $USER_ID = $user_id;
           $profiles = $this->input->post('PROFILE');
          
           $user = $this->Model->getOne('admin_users', array('USER_ID' => $user_id));
           $this->Model->delete('admin_profiles_users',array('USER_ID'=>$user_id));
           $taille_donne =0; 
           if(!empty($profiles)){
             foreach ($profiles as $key => $value) {
                $array_profile = array(
                                   'PROFILE_ID'=>$value,
                                   'USER_ID'=>$user_id);
                $this->Model->insert_last_id('admin_profiles_users',$array_profile);
             }
             $taille_donne = count($profiles);
            }
           $donne['msg'] ="<font color='green'>Le(s) ".$taille_donne." profile(s) est(sont) affecté(s) sur l'utilisateur ".$user['USER_NOM']." ".$user['USER_PRENOM']."</font>";
          $this->session->set_flashdata($donne);
      }

      $this->load->view('collaborateur/Ajouter_Profile_View.php',$data);
    }
    public function getProfiles()
    {
      $user_id = $this->input->post('USER_ID');

      $profiles = $this->Model->getListOrder('admin_profile',array('FOR_CATA'=>0),'PROFILE_DESCR');
      
      $mes_profile ='';
      foreach ($profiles as $profile) {
        if(!empty($this->Model->getOne('admin_profiles_users',array('USER_ID'=>$user_id,'PROFILE_ID'=>$profile['PROFILE_ID'])))){
          $mes_profile .= '<div class="col-md-4">
                         <div class="form-check">
                         <input class="form-check-input" type="checkbox" checked name="PROFILE[]" value="'.$profile['PROFILE_ID'].'">
                         <label class="form-check-label" for="defaultCheck1"> '.$profile['PROFILE_DESCR'].'</label>
                        </div>
                       </div>';
        }else{
        $mes_profile .= '<div class="col-md-4">
                         <div class="form-check">
                         <input class="form-check-input" type="checkbox" name="PROFILE[]" value="'.$profile['PROFILE_ID'].'">
                         <label class="form-check-label" for="defaultCheck1"> '.$profile['PROFILE_DESCR'].'</label>
                        </div>
                       </div>';
           }
      }
    
      echo $mes_profile;
    }
    
    public function getEquipes()
    {
      $CASERNE_ID = $this->input->post('CASERNE_ID');
      $EQUIPE_ID = $this->input->post('EQUIPE_ID');
      $equipes =$this->Model->getList('interv_equipe',array('CASERNE_ID'=>$CASERNE_ID),'EQUIPE_NOM','ASC');
     
      $mes_equipes = "<select class='form-control' name='EQUIPE_ID' id='EQUIPE_ID'><option value=''> - Sélectionner -</option>";
      if(!empty($equipes)){
        foreach ($equipes as $equipe) {
          if($equipe['EQUIPE_ID'] == $EQUIPE_ID){
          $mes_equipes .= "<option value='".$equipe['EQUIPE_ID']."' selected>".$equipe['EQUIPE_NOM']."</option>";
        }else{
          $mes_equipes .= "<option value='".$equipe['EQUIPE_ID']."'>".$equipe['EQUIPE_NOM']."</option>";
        }
        }
      }
      $mes_equipes .= "</select>";

      echo $mes_equipes;
    }

    public function user_infos()
    {
       $infos = $this->agent->platform();
       
       echo "<pre>";
       //print_r($_SERVER);
       echo "</pre>";
       
       echo exec('getmac');
      /* $mac = system('arp -an');
       echo $mac;*/
    }


    public function liste()
    {
     if($this->mylibrary->get_permission('Collaborateurs/liste') ==0){
      redirect(base_url());
     }

        $utilisateurs = $this->Model->getList('admin_users');

        
        $collabo_list = array();

        foreach ($utilisateurs as $utilisateur): 

        $collabos = $this->Model->getList('rh_personnel_dgpc',array('PERSONNEL_MATRICULE'=>$utilisateur['USER_CODE']));

        foreach ($collabos as $collabo) {

            $array = NULL;

            $array['CODE'] = $collabo['PERSONNEL_MATRICULE'];
            $array['EMAIL'] = $collabo['PERSONNEL_EMAIL'];
            $array['NOM'] = $collabo['PERSONNEL_NOM']." ".$collabo['PERSONNEL_PRENOM'];
            $array['TELEPHONE'] = $collabo['PERSONNEL_TELEPHONE'];
            $array['ODK'] = $collabo['PERSONNEL_ODK'];
            $array['ADRESSE'] = $collabo['PERSONNEL_ADRESSE'];
            

            $array['OPTIONS'] = '<div class="dropdown ">
                    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-left">
                        ';


            $array['OPTIONS'] .= "<li><a href='" . base_url('administration/Collaborateurs/Modifier/' .$collabo['PERSONNEL_ID']) . "'>Modifier</a></li>";
            
            $array['OPTIONS'] .= "<li><a href='" . base_url('administration/Collaborateurs/Deploiement/' .$collabo['PERSONNEL_ID']) . "'>Affectations</a></li>";

            $array['OPTIONS'] .= "<li><a href='" . base_url('tickets/Tickets/get_interventions1/' .$collabo['PERSONNEL_ID']) . "'>Intervaention</a></li>";


            $array['OPTIONS'] .= "<li><a hre='#' data-toggle='modal' 
                                  data-target='#mydelete" . $collabo['PERSONNEL_ID'] . "'><font color='red'>Supprimer</font></a></li></ul>
                  </div>";
           
            $array['OPTIONS'] .="
                                    <div class='modal fade' id='mydelete" . $collabo['PERSONNEL_ID'] . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Supprimer l'utilisateur <b>" . $array['NOM'] . "</b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('administration/Collaborateurs/supprimer/' . $collabo['PERSONNEL_ID']) . "'>Supprimer</a>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>";

            $collabo_list[] =$array;
        }

    endforeach;


        $template = array(
            'table_open' => '<table id="collabo_list" class="table table-bordered table-striped table-hover table-condensed table-responsive">',
            'table_close' => '</table>'
        );

        $this->table->set_heading('CODE','EMAIL','NOM & PRENOM','TELEPHONE','LOGIN ODK','ADDRESSE','OPTIONS');
        $this->table->set_template($template);
        $data['collabo_list'] = $collabo_list;


      $data['title'] = "Liste des utilisateurs"; 
      $this->make_bread->add("Utilisateurs", "administration/Collaborateurs/liste", 0);     
      $data['breadcrumb'] = $this->make_bread->output();

      $this->load->view('collaborateur/Utilisateur_Liste_View',$data);
    }

    public function getListeProfile()
    {
        $profiles = $this->Model->getListOrder('admin_profile',array('FOR_CATA'=>0),'PROFILE_DESCR');
        $liste_profil = "<option value=''> - Sélectionner -</option>";

        foreach ($profiles as $profile) {
            if($profile['PROFILE_ID'] == $this->input->post('profil_id')){
              $liste_profil .= "<option value='".$profile['PROFILE_ID']."' selected>".$profile['PROFILE_DESCR']."</option>";
            }else{ 
           $liste_profil .= "<option value='".$profile['PROFILE_ID']."'>".$profile['PROFILE_DESCR']."</option>";
            }
        }

        echo $liste_profil;
    }
     public function getListeProfile1()
    {
        $id=$_POST['id'];
        $profiles = $this->Model->getListOrder('admin_profile',array('FOR_CATA'=>0),'PROFILE_DESCR');
        $pro_user=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$id));
        $user=$this->Model->getOne('admin_users',array('USER_EMAIL'=>$pro_user['PERSONNEL_EMAIL']));
        $prof_user=$this->Model->getOne('admin_profiles_users',array('USER_ID'=> $user['USER_ID']));
        $liste_profil = "<option value=''> - Sélectionner -</option>";
// echo $pro_user['PROFILE_ID'];exit();
        foreach ($profiles as $profile) {
            if($profile['PROFILE_ID']==$prof_user['PROFILE_ID']){
              $liste_profil .= "<option value='".$profile['PROFILE_ID']."' selected>".$profile['PROFILE_DESCR']."</option>";  
            }else{
            $liste_profil .= "<option value='".$profile['PROFILE_ID']."'>".$profile['PROFILE_DESCR']."</option>"; 
            }
           
        }

        echo $liste_profil;
    }

    public function Deploiement($id){
     $cppc_manager = array();
        $cppc_manager = $this->Model->getListOrdered('rh_cppc_manager','DATE_DEBUT',array('PERSONNEL_ID'=>$id));
        $ccpc_manager = $this->Model->getListOrdered('rh_ccpc_manager','DATE_DEBUT',array('PERSONNEL_ID'=>$id));

        $pers=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$id));
        $equipe=$this->Model->getList('rh_equipe_membre_cppc',array('PERSONEL_ID'=>$id));
        $chef_service=$this->Model->getList('rh_service_manager',array('PERSONNEL_ID'=>$id));
        $personel=$this->Model->getList('rh_personnel_service',array('PERSONNEL_ID'=>$id));
        
        $deploement_list = array();

        /*foreach($collabos as $collabo):
            print_r($collabo);

        endforeach;*/

        foreach ($cppc_manager as $dp) {

            $array = NULL;

            $cppc=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$dp['CPPC_ID']));
            $array['POSTE'] ="Manager ". $cppc['CPPC_DESCR'];
            $array['DATE_DEBUT'] = $dp['DATE_DEBUT'];
            if($dp['DATE_FIN']==""){
                $dateFin="-";
            }else{
                $dateFin= $dp['DATE_FIN'];
            }
            $array['DATE_FIN'] =$dateFin;
            
          
            $deploement_list[] =$array;
        }
         foreach ($ccpc_manager as $dp) {

            $array = NULL;

            $ccpc=$this->Model->getOne('rh_ccpc',array('CCPC_ID'=>$dp['CCPC_ID']));
            $array['POSTE'] ="Manager " .$ccpc['DESCRIPTION'];
            $array['DATE_DEBUT'] = $dp['DATE_DEBUT'];
            if($dp['DATE_FIN']==""){
                $dateFin="-";
            }else{
                $dateFin= $dp['DATE_FIN'];
            }
            $array['DATE_FIN'] =$dateFin;
            
          
            $deploement_list[] =$array;
        }
         foreach ($equipe as $dp) {

            $array = NULL;

            $equip=$this->Model->getOne('rh_equipe_cppc',array('EQUIPE_ID'=>$dp['EQUIPE_ID']));
            $cppc=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$equip['CPPC_ID']));
            if ( $dp['IS_CHEF_EQUIPE']==1) {
               $array['POSTE'] ="chef d'equipe " .$equip['EQUIPE_NOM']." de ".$cppc['CPPC_NOM']; 
            }else{
               $array['POSTE'] ="Membre d'equipe " .$equip['EQUIPE_NOM']." de ".$cppc['CPPC_NOM'];  
            }
            // $array['POSTE'] ="Manager " .$ccpc['DESCRIPTION'];
            $array['DATE_DEBUT'] = $dp['DATE_DEBUT'];
            if($dp['DATE_FIN']==""){
                $dateFin="-";
            }else{
                $dateFin= $dp['DATE_FIN'];
            }
            $array['DATE_FIN'] =$dateFin;
            
          
            $deploement_list[] =$array;
        }
         foreach ($chef_service as $dp) {

            $array = NULL;

            $sevice_dgpc=$this->Model->getOne('rh_service_dgpc',array('SERVICE_DGPC_ID'=>$dp['SERVICE_DGPC_ID']));
            // $cppc=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$equip['CPPC_ID']));
           
               $array['POSTE'] ="Manager Service " .$sevice_dgpc['SERVICE_DGPC_DESCR']; 
           
            // $array['POSTE'] ="Manager " .$ccpc['DESCRIPTION'];
            $array['DATE_DEBUT'] = $dp['DATE_DEBUT'];
            if($dp['DATE_FIN']==""){
                $dateFin="-";
            }else{
                $dateFin= $dp['DATE_FIN'];
            }
            $array['DATE_FIN'] =$dateFin;
            
          
            $deploement_list[] =$array;
        }
        foreach ($personel as $dp) {

            $array = NULL;

            $sevice_dgpc=$this->Model->getOne('rh_service_dgpc',array('SERVICE_DGPC_ID'=>$dp['SERVICE_DGPC_ID']));
            // $cppc=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$equip['CPPC_ID']));
           
               $array['POSTE'] ="Employé Service " .$sevice_dgpc['SERVICE_DGPC_DESCR']; 
           
            // $array['POSTE'] ="Manager " .$ccpc['DESCRIPTION'];
            $array['DATE_DEBUT'] = $dp['DATE_DEBUT'];
            if($dp['DATE_FIN']==""){
                $dateFin="-";
            }else{
                $dateFin= $dp['DATE_FIN'];
            }
            $array['DATE_FIN'] =$dateFin;
            
          
            $deploement_list[] =$array;
        }
        $template = array(
            'table_open' => '<table id="collabo_list" class="table table-bordered table-striped table-hover table-condensed table-responsive">',
            'table_close' => '</table>'
        );

        $this->table->set_heading('FONCTION','DATE DEBUT','DATE FIN');
        $this->table->set_template($template);
        $data['collabo_list'] = $deploement_list;


      $data['title'] = "Liste des collaborateurs";      
      $data['titre'] = "Historique des affectations de ".strtoupper($pers['PERSONNEL_PRENOM']." ".$pers['PERSONNEL_NOM']) ;      
      $data['breadcrumb'] = $this->make_bread->output();
     $this->load->view('collaborateur/Collaborateur_Depliement_View',$data);
 }
 }