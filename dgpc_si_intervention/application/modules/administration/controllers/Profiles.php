<?php

 class Profiles extends MY_Controller
 {
  
  function __construct(){
    parent::__construct();
    $this->make_bread->add('Profils', "administration/Profiles", 0);
    $this->breadcrumb = $this->make_bread->output();

   // $this->permission();    
  }

  public function permission(){
         if($this->mylibrary->get_permission('Profiles') ==0){
          redirect(base_url());
         }
  }

    public function index()
    {
     
      $data['title'] = "Nouveau profil";      
      $data['breadcrumb'] = $this->make_bread->output();

      $this->load->view('profiles/Profile_Nouveau_View',$data);
    }

    public function save()
    {
       $this->form_validation->set_rules('PROFILE_DESCR', 'Description', 'required');
       $this->form_validation->set_rules('PROFILE_CODE', 'Profil code', 'required|is_unique[admin_profile.PROFILE_CODE]',array("is_unique"=>"<font color='red'>Code est déjà utilisé</font>"));
       
        if ($this->form_validation->run() == FALSE) {            
            $data['title'] = "Nouveau profil";      
            $data['breadcrumb'] = $this->make_bread->output();

            $this->load->view('profiles/Profile_Nouveau_View',$data);
        }else{
           
            $array_profile = array(
                                'PROFILE_DESCR'=>$this->input->post('PROFILE_DESCR'),
                                'PROFILE_CODE'=>$this->input->post('PROFILE_CODE')
                                );
            $profile_id = $this->Model->insert_last_id('admin_profile',$array_profile);

            $msg = "<font color='red'>Ce profil n'a pas été enregistré.</font>";
            if($profile_id >0){
              $msg = "<font color='green'> Le profil <b>".$this->input->post('PROFILE_DESCR')."</b> a été enregistré.</font>";           
            }

            $donne['msg'] =$msg;
            $this->session->set_flashdata($donne);
           
           //echo $profile_id;

            redirect(base_url().'administration/Profiles/AddFonctionnalite/'.$profile_id);
        }
    }
    
    public function liste()
    {
        $fetch_profiles = $this->Model->getListOrder('admin_profile',array('FOR_CATA'=>0),'PROFILE_DESCR');        
        $data_profile = array();

        foreach ($fetch_profiles as $row) {
            $sub_array = array();
                      
            $sub_array[] = $row['PROFILE_CODE'];
            $sub_array[] = $row['PROFILE_DESCR']; 

            $fonctionnalites = $this->Model->getFonctionnalites($row['PROFILE_ID']);

           // print_r($fonctionnalites);
            $liste_fonct = "";
            foreach ($fonctionnalites as $fonctionnalite) {
              $liste_fonct .= "<li>".$fonctionnalite['FONCTIONNALITE_DESCR'].'</li>'; 
            }
            $sub_array[] = "<a href='#' data-toggle='modal' 
                                  data-target='#myfonctionnalites" .$row['PROFILE_ID']. "'>".count($fonctionnalites)."</a> 
                                  <div class='modal fade' id='myfonctionnalites" . $row['PROFILE_ID'] . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h4>Liste de fonctionnalités </h4>
                                                    <ul>
                                                    ".$liste_fonct."
                                                    </ul>
                                                </div>

                                                <div class='modal-footer'>
                                                    
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>";


          //  $sub_array[] = '';
            
            $users = $this->Model->getUsersProfile($row['PROFILE_ID']);
            $liste_user = "";
            foreach ($users as $user) {
              $liste_user .= "<tr><td>".$user['USER_NOM']."</td><td>".$user['USER_PRENOM']."</td><td>".$user['USER_TELEPHONE']."</td><td>".$user['USER_EMAIL']."</td></tr>"; 
            }

             
            $sub_array[] = "<a href='#' data-toggle='modal' 
                                  data-target='#myusers" .$row['PROFILE_ID']. "'>".count($users)."</a> 
                                  <div class='modal fade' id='myusers" . $row['PROFILE_ID'] . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h4>Liste de fonctionnalités </h4>
                                                    <table id='list_usrs' class='table table-bordered table-striped'>
                                                    <tr><th>NOM</th><th>PRENOM</th><th>TELEPHONE</th><th>EMAIL</th>
                                                    ".$liste_user."
                                                    </table>
                                                </div>

                                                <div class='modal-footer'>
                                                    
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>";; 
          //  $sub_array[] = '';
            if($this->mylibrary->verify_is_admin() ==1){
            $options = '<div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            ';
            
            $options .= "<li><a href='" . base_url('administration/Profiles/Modifier/' . $row['PROFILE_ID']) . "'>
                                        Modifier</li>";
            //}
            

            $options .= "<li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete" . $row['PROFILE_ID'] . "'><font color='red'>Supprimer</font></button></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete" . $row['PROFILE_ID'] . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Supprimer :<b>" . $row['PROFILE_DESCR']. "</b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('administration/Profiles/supprimer/' . $row['PROFILE_ID']) . "'>Supprimer</a>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    ";

            $sub_array[] = $options; 
             }
            $data_profile[] = $sub_array;
        }
       
       $template = array(
            'table_open' => '<table id="profile_list" class="table table-bordered table-striped table-hover table-condensed table-responsive">',
            'table_close' => '</table>'
        );
       if($this->mylibrary->verify_is_admin() ==1){
        $this->table->set_heading('CODE','DESCRIPTION','FONCTIONNALITES','UTILISATEURS','OPTIONS');
      }else{
        $this->table->set_heading('CODE','DESCRIPTION','FONCTIONNALITES','UTILISATEURS');
      }
        $this->table->set_template($template);
      
      $data['liste_profile'] = $data_profile;
      $data['title'] = "Liste des profils";      
      $data['breadcrumb'] = $this->make_bread->output();

      $this->load->view('profiles/Profile_Liste_View',$data);
    }

    public function oldliste()
    {
      if($this->mylibrary->get_permission('Profiles/liste') ==0){
        redirect(base_url());
      }

      $data['title'] = "Liste des profils";      
      $data['breadcrumb'] = $this->make_bread->output();

      $this->load->view('profiles/Profile_Liste_View',$data);
    }

    public function get_profile()
    {
       $var_search = $_POST['search']['value'];

        $table = "admin_profile";
        $critere_txt = !empty($_POST['search']['value']) ? ("PROFILE_DESCR LIKE '%$var_search%' OR PROFILE_CODE LIKE '%$var_search%'") : NULL;
        $critere_array = array();
        $order_column = array('PROFILE_DESCR','PROFILE_CODE');
        $order_by = isset($_POST['order']) ? array($order_column[$_POST['order']['0']['column']] => $_POST['order']['0']['dir']) : array('PROFILE_ID' => 'DESC');
        $select_column = array('PROFILE_DESCR', 'PROFILE_CODE','PROFILE_ID');

        $fetch_profiles = $this->Model->make_datatables($table, $select_column, $critere_txt, $critere_array, $order_by);

        // print_r($fetch_tickets);
        $data = array();
        foreach ($fetch_profiles as $row) {
            $sub_array = array();
                      
            $sub_array[] = $row->PROFILE_CODE;
            $sub_array[] = $row->PROFILE_DESCR; 

            $options = '<div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            ';
            
            $options .= "<li><a href='" . base_url('administration/Profiles/Modifier/' . $row->PROFILE_ID) . "'>
                                        Modifier</li>";
            //}
            

            $options .= "<li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete" . $row->PROFILE_ID . "'><font color='red'>Supprimer</font></button></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete" . $row->PROFILE_ID . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Supprimer :<b>" . $row->PROFILE_DESCR. "</b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('administration/Profiles/supprimer/' . $row->PROFILE_ID) . "'>Supprimer</a>
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

    public function modifier()
    {
      $profile_id = $this->uri->segment(4);

      $data['title'] = "Modifier un profil";
      $data['profile'] = $this->Model->getOne('admin_profile',array('PROFILE_ID'=>$profile_id));

      $data['breadcrumb'] = $this->make_bread->output();

      $this->load->view('profiles/Profile_Modifier_View',$data);
    }

    public function save_modification()
    {       
       $this->form_validation->set_rules('PROFILE_DESCR', 'Description', 'required');
       $this->form_validation->set_rules('PROFILE_CODE', 'Code', 'required');
       
      $profile_id = $this->uri->segment(4);
               
        if ($this->form_validation->run() == FALSE) {           

            $data['title'] = "Modifier un profil";
            $data['profile'] = $this->Model->getOne('admin_profile',array('PROFILE_ID'=>$profile_id));

            $data['breadcrumb'] = $this->make_bread->output();

            $this->load->view('utilisateurs/Profile_Modifier_View',$data); 
          }else{
           
            $array_profile = array(
                                'PROFILE_DESCR'=>$this->input->post('PROFILE_DESCR'),
                                'PROFILE_CODE'=>$this->input->post('PROFILE_CODE')
                                );
            $msg = "<font color='red'>Le profil <b>".$this->input->post('PROFILE_DESCR')."</b> n'a pas été modifié.</font>";

            if($this->Model->update_table('admin_profile',array('PROFILE_ID'=>$profile_id),$array_profile)){
              $msg = "<font color='green'> Le profil <b>".$this->input->post('PROFILE_DESCR')."</b> a été modifié.</font>";
            }
            $donne['msg'] =$msg;
            $this->session->set_flashdata($donne);

            redirect(base_url().'administration/Profiles/liste');
        }
    }
    
    public function supprimer()
    {
      $profile_id =$this->uri->segment(4);

      $profile = $this->Model->getOne('admin_profile',array('PROFILE_ID'=>$profile_id));  
      $admin_profiles_users = $this->Model->getList('admin_profiles_users',array('PROFILE_ID'=>$profile_id));
      $admin_profiles_fonctionnalites = $this->Model->getList('admin_fonctionnalite_profil',array('PROFILE_ID'=>$profile_id));
      
       $msg = '';
      if(!empty($profile)){
        if(empty($admin_profiles_users) && empty($admin_profiles_fonctionnalites)){
          $this->Model->delete('admin_profile',array('PROFILE_ID'=>$profile_id));
          $msg = "<font color='green'>Le profil <b>".$profile['PROFILE_DESCR']."</b> a été supprimé</font>";
        }else{
          $msg = "<font color='red'>Pour supprimer le profil <b>".$profile['PROFILE_DESCR']."</b> commencer à supprimer les liens entre différents utilisaateurs et/ou différentes fonctionnalités enregistrés auparvant.</font>"; 
        }
      }else{
        $msg = "<font color='red'>Le profil que vous voulez n'existe plus.</font>";        
      }
      $donne['msg'] =$msg;
      $this->session->set_flashdata($donne);

      redirect(base_url().'administration/Profiles/liste');
    }

    public function AddFonctionnalite()
    {
      $data['title'] = "Ajouter des fonctionnalités";      
      $data['breadcrumb'] = $this->make_bread->output();
      $data['profiles'] = $this->Model->getList('admin_profile');

     // 
           $profile_id = $this->input->post('PROFILE_ID');
           $profile_id = ($profile_id >0)?$profile_id:$this->uri->segment(4);
           
        if($profile_id >0){
         if($_SERVER['REQUEST_METHOD'] == 'POST'){
           $fonctionnalites = $this->input->post('FONCTIONNALITE');
          
           $profile = $this->Model->getOne('admin_profile', array('PROFILE_ID' => $profile_id));
           $this->Model->delete('admin_fonctionnalite_profil',array('PROFILE_ID'=>$profile_id));

           $taille_fonct =0;
           if(!empty($fonctionnalites)){
             foreach ($fonctionnalites as $key => $value) {
                $array_profile = array(
                                   'FONCTIONNALITE_ID'=>$value,
                                   'PROFILE_ID'=>$profile_id);
                $this->Model->insert_last_id('admin_fonctionnalite_profil',$array_profile);
             }
             $taille_fonct =count($fonctionnalites);

           }

           $donne['msg'] ="<font color='green'>Le(s) ".$taille_fonct." fonctionnalites(s) est(sont) affecté(s) sur au profile ".$profile['PROFILE_DESCR']."</font>";
          $this->session->set_flashdata($donne);
          }
        }
        $data['PROFILE_ID'] =$profile_id;
      $this->load->view('profiles/Ajouter_Fonctionnalite_View.php',$data);
    }
    public function getFonctionnalite()
    {
      $PROFILE_ID = $this->input->post('PROFILE_ID');

      $fonctionnalites = $this->Model->getList('admin_fonctionnalites');
      
      

      $mes_fonctionnalites ='';
      foreach ($fonctionnalites as $fonctionnalite) {
        if(!empty($this->Model->getOne('admin_fonctionnalite_profil',array('PROFILE_ID'=>$PROFILE_ID,'FONCTIONNALITE_ID'=>$fonctionnalite['FONCTIONNALITE_ID'])))){
          $mes_fonctionnalites .= '<div class="col-md-4">
                         <div class="form-check">
                         <input class="form-check-input" type="checkbox" checked name="FONCTIONNALITE[]" value="'.$fonctionnalite['FONCTIONNALITE_ID'].'">
                         <label class="form-check-label" for="defaultCheck1"> '.$fonctionnalite['FONCTIONNALITE_DESCR'].'</label>
                        </div>
                       </div>';
        }else{
        $mes_fonctionnalites .= '<div class="col-md-4">
                         <div class="form-check">
                         <input class="form-check-input" type="checkbox" name="FONCTIONNALITE[]" value="'.$fonctionnalite['FONCTIONNALITE_ID'].'">
                         <label class="form-check-label" for="defaultCheck1"> '.$fonctionnalite['FONCTIONNALITE_DESCR'].'</label>
                        </div>
                       </div>';
           }
      }
    
      echo $mes_fonctionnalites;
    }
    
 }