<?php 

  /**
   * 
   */
  class Materiaux extends CI_Controller
  {
    
    function __construct()
    {
      # code...
      parent::__construct();
      $this->make_bread->add('Liste des materiels', "materiaux/Materiaux", 0);
      $this->breadcrumb = $this->make_bread->output();
      $this->autho();
    }

    public function autho()
    {
    if(empty($this->session->userdata('DGPC_USER_EMAIL'))){
        redirect(base_url());
       }
    }

    function add_form(){
      if($this->mylibrary->get_permission('Profiles/index') ==0){
        redirect(base_url());
      }

      $data['title'] = "Nouveau matériel";      
      $data['breadcrumb'] = $this->make_bread->output();

      $this->load->view('materiaux/Materiaux_Nouveau_View',$data);
    }

    function index(){

    if($this->mylibrary->get_permission('Profiles/liste') ==0){
        redirect(base_url());
      }

       // $var_search = $_POST['search']['value'];

       //  $table = "interv_materiaux";
       //  $critere_txt = !empty($_POST['search']['value']) ? ("MATERIEL_DESCR LIKE '%$var_search%' OR MATERIEL_CODE LIKE '%$var_search%'") : NULL;
       //  $critere_array = array();
       //  $order_column = array('MATERIEL_DESCR','MATERIEL_CODE');
       //  $order_by = isset($_POST['order']) ? array($order_column[$_POST['order']['0']['column']] => $_POST['order']['0']['dir']) : array('MATERIEL_ID' => 'DESC');
       //  $select_column = array('MATERIEL_DESCR', 'MATERIEL_CODE','CATEGORIE_ID','CPPC_ID','MATERIEL_ID','ETAT','QUANTITE','QUANTITE_DISPONIBLE');

        $fetch_profiles = $this->Model->getList("interv_materiaux");

        // print_r($fetch_tickets);
        $resultat = array();
        foreach ($fetch_profiles as $row) {
            $sub_array = array();
            $interv_categorie_materiaux=$this->Model->getOne('interv_categorie_materiaux',array('CATEGORIE_ID'=>$row['CATEGORIE_ID']));
            $rh_cppc=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$row['CPPC_ID']));
            $etat=$this->Model->getOne('interv_etat_materiaux',array('ETAT_ID'=>$row['ETAT']));
                      
            $sub_array[] = $row['MATERIEL_DESCR'];
            $sub_array[] = $row['MATERIEL_CODE']; 
            $sub_array[] = $interv_categorie_materiaux['CATEGORIE_DESCR'];
            $sub_array[] = $rh_cppc['CPPC_NOM'];
            $sub_array[] = $etat['DESCRIPTION'];
            $sub_array[] = $row['QUANTITE'];
            $sub_array[] = $row['QUANTITE_DISPONIBLE'];

            if($this->mylibrary->verify_is_admin() ==1){ 
            
            $options = '<div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            ';
            
            $options .= "<li><a href='" . base_url('materiaux/Materiaux/Modifier/' . $row['MATERIEL_ID']) . "'>
                                        Modifier</li>";
            //}
             $options .= "<li><a href='" . base_url('materiaux/Materiaux/distribuer/' . $row['MATERIEL_ID']) . "'>
                                        Distribution</li>";
            

            $options .= "<li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete" . $row['MATERIEL_ID'] . "'><font color='red'>Supprimer</font></button></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete" . $row['MATERIEL_ID'] . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Supprimer :<b>" . $row['MATERIEL_DESCR']. "</b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('materiaux/Materiaux/supprimer/' . $row['MATERIEL_ID']) . "'>Supprimer</a>
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
        
           $this->table->set_heading('DESCRIPTION','CODE','CATEGORIE','CPPC','ETAT','QUANTITE TOTALE','QUANTITE DISPONIBLE','OPTIONS');
        }else{
        $this->table->set_heading('DESCRIPTION','CODE','CATEGORIE','CPPC','ETAT','QUANTITE TOTALE','QUANTITE DISPONIBLE');
      }
        $this->table->set_template($template);
        
    $data['table']=$resultat;
        
      $data['title'] = "Liste des matériels";      
      $data['breadcrumb'] = $this->make_bread->output();

      $this->load->view('materiaux/Materiaux_Liste_View',$data);
   }

   public function get_materiaux()
    {
       $var_search = $_POST['search']['value'];

        $table = "interv_materiaux";
        $critere_txt = !empty($_POST['search']['value']) ? ("MATERIEL_DESCR LIKE '%$var_search%' OR MATERIEL_CODE LIKE '%$var_search%'") : NULL;
        $critere_array = array();
        $order_column = array('MATERIEL_DESCR','MATERIEL_CODE');
        $order_by = isset($_POST['order']) ? array($order_column[$_POST['order']['0']['column']] => $_POST['order']['0']['dir']) : array('MATERIEL_ID' => 'DESC');
        $select_column = array('MATERIEL_DESCR', 'MATERIEL_CODE','CATEGORIE_ID','CPPC_ID','MATERIEL_ID','ETAT','QUANTITE','QUANTITE_DISPONIBLE');

        $fetch_profiles = $this->Model->make_datatables($table, $select_column, $critere_txt, $critere_array, $order_by);

        // print_r($fetch_tickets);
        $data = array();
        foreach ($fetch_profiles as $row) {
            $sub_array = array();
            $interv_categorie_materiaux=$this->Model->getOne('interv_categorie_materiaux',array('CATEGORIE_ID'=>$row->CATEGORIE_ID));
            $rh_cppc=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$row->CPPC_ID));
            $etat=$this->Model->getOne('interv_etat_materiaux',array('ETAT_ID'=>$row->ETAT));
                      
            $sub_array[] = $row->MATERIEL_DESCR;
            $sub_array[] = $row->MATERIEL_CODE; 
            $sub_array[] = $interv_categorie_materiaux['CATEGORIE_DESCR'];
            $sub_array[] = $rh_cppc['CPPC_NOM'];
            $sub_array[] = $etat['DESCRIPTION'];
            $sub_array[] = $row->QUANTITE;
            $sub_array[] = $row->QUANTITE_DISPONIBLE;

            $options = '<div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            ';
            
            $options .= "<li><a href='" . base_url('materiaux/Materiaux/Modifier/' . $row->MATERIEL_ID) . "'>
                                        Modifier</li>";
            //}
             $options .= "<li><a href='" . base_url('materiaux/Materiaux/distribuer/' . $row->MATERIEL_ID) . "'>
                                        Distribution</li>";
            

            $options .= "<li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete" . $row->MATERIEL_ID . "'><font color='red'>Supprimer</font></button></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete" . $row->MATERIEL_ID . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Supprimer :<b>" . $row->MATERIEL_DESCR. "</b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('materiaux/Materiaux/supprimer/' . $row->MATERIEL_ID) . "'>Supprimer</a>
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

    function save(){

      $this->form_validation->set_rules('MATERIEL_DESCR', 'Description', 'required',array("is_unique"=>"<font color='red'>ce champ est obligatoire</font>"));
       $this->form_validation->set_rules('MATERIEL_CODE', 'Profile code', 'required|is_unique[interv_materiaux.MATERIEL_CODE]',array("is_unique"=>"<font color='red'>Code est déjà utilisé</font>"));
       
        if ($this->form_validation->run() == FALSE) {            
            $data['title'] = "Nouveau matériel";      
            $data['breadcrumb'] = $this->make_bread->output();

            $this->load->view('materiaux/Materiaux_Nouveau_View',$data);
      
           }else{
            $array_profile = array(
                                'MATERIEL_DESCR'=>$this->input->post('MATERIEL_DESCR'),
                                'MATERIEL_CODE'=>$this->input->post('MATERIEL_CODE'),
                                'CAUSE_ID'=>$this->input->post('CATEGORIE_ID'),
                                'CPPC_ID'=>$this->input->post('CPPC_ID'),
                                'ETAT'=>$this->input->post('ETAT')
                                );
            $profile_id = $this->Model->insert_last_id('interv_materiaux',$array_profile);

            $msg = "<font color='red'>Ce profile n'a pas été enregistré.</font>";
            if($profile_id >0){
              $msg = "<font color='green'> <b>".$this->input->post('MATERIEL_DESCR')."</b> a été enregistré.</font>";           
            }

            $donne['msg'] =$msg;
            $this->session->set_flashdata($donne);

            redirect(base_url().'materiaux/Materiaux');
        }
    

}

    public function supprimer()
    {
      $MATERIEL_ID =$this->uri->segment(4);

       
          $sp=$this->Model->delete('interv_materiaux',array('MATERIEL_ID'=>$MATERIEL_ID));
          if($sp){
             $msg = "<font color='green'>Matériel supprimé</font>";
         
          }else{
        $msg = "<font color='red'>Le matériel que vous voulez n'existe plus.</font>";        
      }
      $donne['msg'] =$msg;
      $this->session->set_flashdata($donne);

      redirect(base_url().'materiaux/Materiaux/index');
    }


    function Modifier(){

     $MATERIEL_ID =$this->uri->segment(4);
     $data['title'] = "Modification du matériel";      
     $data['breadcrumb'] = $this->make_bread->output();
   $data['list_mat']=$this->Model->getOne('interv_materiaux',array('MATERIEL_ID'=>$MATERIEL_ID));
    $this->load->view('materiaux/Materiaux_Update_View',$data);

    }


    function Modifier_data(){

     $MATERIEL_ID =$this->input->post('MATERIEL_ID');

  //    $this->form_validation->set_rules('MATERIEL_CODE', 'Profile code', 'required|is_unique[interv_materiaux.MATERIEL_CODE]',array("is_unique"=>"<font color='red'>Code est déjà utilisé</font>"));

  //        if ($this->form_validation->run() == FALSE) {            
  //    $data['title'] = "Modification du materiel";      
  //    $data['breadcrumb'] = $this->make_bread->output();
   // $data['list_mat']=$this->Model->getOne('interv_materiaux',array('MATERIEL_ID'=>$MATERIEL_ID));
  //   $this->load->view('materiaux/Materiaux_Update_View',$data);

  //       }else{

          $array_profile = array(
                                'MATERIEL_DESCR'=>$this->input->post('MATERIEL_DESCR'),
                                'MATERIEL_CODE'=>$this->input->post('MATERIEL_CODE'),
                                'CAUSE_ID'=>$this->input->post('CATEGORIE_ID'),
                                'CPPC_ID'=>$this->input->post('CPPC_ID'),
                                'ETAT'=>$this->input->post('ETAT')
                                );

          $sp=$this->Model->update('interv_materiaux',array('MATERIEL_ID'=>$MATERIEL_ID),$array_profile);
          if($sp){
             $msg = "<font color='green'>Matériel modifié</font>";
         
          }else{
        $msg = "<font color='red'>Le matériel que vous voulez n'existe plus.</font>";        
      }
      $donne['msg'] =$msg;
      $this->session->set_flashdata($donne);

      redirect(base_url().'materiaux/Materiaux/index');

        // }
    }
     function approv(){
      
      if($_SERVER['REQUEST_METHOD']=='GET'){
      $data['approv']=$this->Model->getList('interv_materiaux');
      $data['title'] = "Nouveau Approvisionnement";      
      $data['breadcrumb'] = $this->make_bread->output();

      $this->load->view('Approvisionnement_View.php',$data);
    }else{
       $this->form_validation->set_rules('MATERIEL_ID', 'Materiel', 'required',array("required"=>"<font color='red'>Le Materiel est requis</font>"));
       $this->form_validation->set_rules('QUANTITE', 'quantitie', 'required|is_numeric',array("is_numeric"=>"<font color='red'>La Quantite est invalide</font>"));
       
        if ($this->form_validation->run() == FALSE) {            
            $data['approv']=$this->Model->getList('interv_materiaux');
            $data['title'] = "Nouveau Approvisionnement";      
            $data['breadcrumb'] = $this->make_bread->output();

            $this->load->view('Approvisionnement_View',$data);
        }else{
            $quantiteapprov=$this->input->post('QUANTITE');
            $id=$this->input->post('MATERIEL_ID');
            $appr=$this->Model->getOne('interv_materiaux', array('MATERIEL_ID'=>$id));
            $quantite=$appr['QUANTITE']+$quantiteapprov;
            
            // $data=array('QUANTITE'=>$quantite,'QUANTITE_DISPONIBLE'=>$quantiteapprov);
            $data=array('QUANTITE'=>$quantite,'QUANTITE_DISPONIBLE'=>($quantiteapprov+$appr['QUANTITE_DISPONIBLE']));

            $criteres['MATERIEL_ID']=$id;
            $sql=$this->Model->update('interv_materiaux',$criteres,$data);
            if($sql >0){
              $msg = "<font color='green'> <b>Approvisionnement de ".$appr['MATERIEL_DESCR']."</b> fait avec succès.</font>";           
            }
            $donne['msg'] =$msg;
            $this->session->set_flashdata($donne);
            redirect(base_url().'materiaux/Materiaux');

        }
    }

  }
  

   function distribuer()
    {
      $data['cppc']=$this->Model->getList('rh_cppc',array());
      $MATERIEL_ID=$this->uri->segment(4);
      $data['materiel']=$MATERIEL_ID;
      $data['breadcrumb'] = $this->make_bread->output();
      $data['nb']=0;
      $data['title']="Distribution des matériels";
      $data['msg']="";
      $this->load->view('materiaux/Distribution_Materiaux_View',$data);

    }



      function  Fx_input()

      {

      $NB_INP=$this->input->post('QUANTITE');
      $QUANTITE_DISPONIBLE=$this->input->post('QUANTITE_DISPONIBLE');

      if($QUANTITE_DISPONIBLE<$NB_INP)
      {

      $data['cppc']=$this->Model->getList('rh_cppc',array());
      $MATERIEL_ID=$this->input->post('MATERIEL_ID');
      $data['materiel']=$MATERIEL_ID;
      $data['breadcrumb'] = $this->make_bread->output();
      $data['nb']=0;
      $data['title']="Distribution des matériels";
      $data['msg']='<div class=" text-danger">'."La quantité à distribuer doit être <= à la quantité disponible !".'</div>';
      $this->load->view('materiaux/Distribution_Materiaux_View',$data);
       
      }

      elseif(empty($NB_INP))
      {

      $data['cppc']=$this->Model->getList('rh_cppc',array());
      $MATERIEL_ID=$this->input->post('MATERIEL_ID');
      $data['materiel']=$MATERIEL_ID;
      $data['breadcrumb'] = $this->make_bread->output();
      $data['nb']=0;
      $data['title']="Distribution des matériels";
      $data['msg']='<div class=" text-danger">'."Il faut préciser la quantité à distribuer".'</div>';
      $this->load->view('materiaux/Distribution_Materiaux_View',$data);

      }

      else
      {

      $data['nb']=$NB_INP;
      $data['cppc']=$this->Model->getList('rh_cppc',array());
      $MATERIEL_ID=$this->input->post('MATERIEL_ID');
      $data['materiel']=$MATERIEL_ID;
      $data['breadcrumb'] = $this->make_bread->output();
      $data['CPPC_ID']=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$this->input->post('CPPC_ID')));
      $data['title']="Distribution des matériels";
      $this->load->view('materiaux/Distribution_Materiaux_New_View',$data);

      }

    }


    function send()
    {

         $code=$this->input->post('code');
         $descr=$this->input->post('descr');
     
         $data=array();

          for ($i=0;$i<sizeof($code);$i++)
               { 
                   $data[$i]=array(
                  'MATERIEL_ID'=>$this->input->post('MATERIEL_ID'),
                  'CPPC_ID'=>$this->input->post('CPPC_ID'),
                  'CODE_MATERIEL'=>$code[$i],
                  'QUANTITE_DISTRIBUE'=>$descr[$i],);

               }

           $table="inter_materiaux_distribue";
           $MATERIEL_DISTRIBUE_ID=$this->Model->insert_batch($table, $data);

           $materiel=$this->Model->getOne('interv_materiaux',array('MATERIEL_ID'=>$this->input->post('MATERIEL_ID')));

            // MISE A JOUR DU STOCK DES MATERIAUX
           $qte_a_distr=$this->input->post('QUANTITE');
           $newqtedispo=$materiel['QUANTITE_DISPONIBLE']-$qte_a_distr;
           $this->Model->update('interv_materiaux',array('MATERIEL_ID'=>$this->input->post('MATERIEL_ID')),array('QUANTITE_DISPONIBLE'=>$newqtedispo));

           $data['message']='<div class="alert alert-success text-center">'."Distribution du matériel ".$materiel['MATERIEL_DESCR']." faite avec succès".'</div>';
           $this->session->set_flashdata($data);
           redirect(base_url('materiaux/Materiaux/listing_qte_distr'));
           

    }



    function listing_qte_distr()
    {

      // $fetch_materiaux = $this->Model->getList_distinct('inter_materiaux_distribue','DISTINCT(MATERIEL_ID)');
      $fetch_materiaux = $this->Model->getList('inter_materiaux_distribue');

      $data = array();

      $table='<table id="mytable" class="table table-bordered table-stripped table-hover table-condensed table-responsive">
                                   <thead>
                                      <tr>
                                       <th>Matériel</th>
                                        <th>Code matériel</th>
                                       <th>Quantité distribuée</th>
                                       <th>CPPCs</th>
                                       <th>Date de distribution</th>
                                                               
                                       </tr>
                                  </thead>';

              
          foreach ($fetch_materiaux as $row)
             {

          $materiel=$this->Model->getOne('interv_materiaux',array('MATERIEL_ID'=>$row['MATERIEL_ID']));
          $cppc=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$row['CPPC_ID']));

           $table.='<tr>
            <td>'.$materiel['MATERIEL_DESCR'].'</td>
            <td>'.$row['CODE_MATERIEL'].'</td>
            <td>'.$row['QUANTITE_DISTRIBUE'].'</td>
            <td>'.$cppc['CPPC_NOM'].'</td>
            <td>'.$row['DATE_DISTRIBUTION'].'</td>
            
            </tr>'; 
                  
              }

            $table.='</table>';
            $data['table'] =$table;
            $data['title']="Matériels distribués aux CPPCs";
            $data['breadcrumb'] = $this->make_bread->output();
            $this->load->view('Distribution_Materiaux_Liste_View',$data);

    }
    }
 ?>