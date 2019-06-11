<?php

 class Services extends MY_Controller
 {
 	
 	function __construct()
 	{
 	  parent::__construct();
    $this->make_bread->add('Services', "equipes/Services", 0);
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
     

        $fetch_services = $this->Model->getList('rh_service_dgpc', array());
        

         // print_r($fetch_services);
        $resultat = array();
        foreach ($fetch_services as $row) {
            $sub_array = array();
            $managers=$this->Model->getMembresServices($row['SERVICE_DGPC_ID']);
            
            $mes_membres = '';
            $i =1;
            foreach ($managers as $manager) {
              $mes_membres .=$i.")".$manager['GRADE']." ".$manager['PERSONNEL_NOM']." ".$manager['PERSONNEL_PRENOM']."<br>";
            }

            $les_membres= "<a href='#' data-toggle='modal' 
                                  data-target='#membres" . $row['SERVICE_DGPC_ID'] . "'>".count($managers)."</a>
                                   
                                    <div class='modal fade' id='membres" . $row['SERVICE_DGPC_ID'] . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    ".$mes_membres."
                                                </div>

                                                <div class='modal-footer'>                                                    
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    ";
            $sub_array[] =$les_membres;

            if($row['IS_CPPC']==1){
              $rp="Oui";

              $sub_array[] = $row['SERVICE_DGPC_DESCR'];
              
              $sub_array[] =$rp;
           

            if($this->mylibrary->verify_is_admin() ==1){
            $options = '<div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            ';
            
            $options .= "<li><a href='" . base_url('equipes/Services/modifier/' . $row['SERVICE_DGPC_ID']) . "'>
                                        Modifier</li>";
            
            
            $options .= "<li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete" . $row['SERVICE_DGPC_ID'] . "'><font color='red'>Supprimer</font></button></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete" . $row['SERVICE_DGPC_ID'] . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Voulez-vous vraiment supprimer ce service?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('equipes/Services/supprimer/' . $row['SERVICE_DGPC_ID']) . "'>Supprimer</a>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    ";

              $sub_array[] = $options;
             }
            $resultat[] = $sub_array;


            }else{


              $rp="Non";
              $sub_array[] = $row['SERVICE_DGPC_DESCR'];
            $sub_array[] =$rp;
           
           if($this->mylibrary->verify_is_admin() ==1){

            $options = '<div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            ';
            
            $options .= "<li><a href='" . base_url('equipes/Services/modifier/' . $row['SERVICE_DGPC_ID']) . "'>
                                        Modifier</li>";

            
            $options .= "<li><a href='" . base_url('equipes/Services/new/' . $row['SERVICE_DGPC_ID']) . "'>
                                      Ajouter</li>";                            
            
            $options .= "<li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete" . $row['SERVICE_DGPC_ID'] . "'><font color='red'>Supprimer</font></button></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete" . $row['SERVICE_DGPC_ID'] . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Voulez-vous vraiment supprimer ce service?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('equipes/Services/supprimer/' . $row['SERVICE_DGPC_ID']) . "'>Supprimer</a>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div> ";

              $sub_array[] = $options;
             }
            $resultat[] = $sub_array;
            }       
            
        }

         $template=array(
        'table_open'=>'<table id="mytable" class="table table-bordered table-stripped table-hover table-condensed table-responsive">',
        '<table_close'=>'</table>'
        );
        if($this->mylibrary->verify_is_admin() ==1){
         $this->table->set_heading('PERSONNEL SERVICE','SERVICE','EST UN CPPC','OPTIONS');
       }else{
        $this->table->set_heading('PERSONNEL SERVICE','SERVICE','EST UN CPPC');
       }
        $this->table->set_template($template);
    $data['title']="Liste des Services";
    $data['table']=$resultat;
      $data['breadcrumb'] = $this->make_bread->output();
     


      $this->load->view('services/Services_list_View',$data);
    }
    public function ajouter(){

     $data['title'] = "Nouveau Service";
      $data['breadcrumb'] = $this->make_bread->output();
      
      $data['provinces'] = $this->Model->getListOrder('ststm_provinces',array(),'PROVINCE_NAME');

      $this->load->view('services/Services_New_View',$data);
    }

    public function add(){
      $service=$this->input->post('service');
      $is_cppc=$this->input->post('is_cppc');
     $check=$this->Model->checkvalue('rh_service_dgpc',array('SERVICE_DGPC_DESCR'=>$service));
        if( $check!=1){
              $array=array(
                'SERVICE_DGPC_DESCR'=>$service,
                'IS_CPPC'=>$is_cppc,
                'USER_ID'=>$this->session->userdata('DGPC_USER_ID')
              );
              $this->Model->create('rh_service_dgpc',$array);

              $data['msg']='<div class="alert alert-success text-center"> Enregistrement avec succès</div>';
          
            $this->session->set_flashdata($data);
          redirect(base_url('equipes/Services'));
        }else{
              $data['msg']='<div class="alert alert-danger text-center"> Echec! le service existe deja</div>';
              
                $this->session->set_flashdata($data);
              redirect(base_url('equipes/Services'));
        }

    }
    public function get_list(){

       $var_search = $_POST['search']['value'];

        $table = "rh_service_dgpc";
        $critere_txt = !empty($_POST['search']['value']) ? ("SERVICE_DGPC_DESCR LIKE '%$var_search%'") : NULL;
        $critere_array = array();
        $order_column = array('SERVICE_DGPC_DESCR');
        $order_by = isset($_POST['order']) ? array($order_column[$_POST['order']['0']['column']] => $_POST['order']['0']['dir']) : array('SERVICE_DGPC_ID' => 'DESC');
        $select_column = array('SERVICE_DGPC_ID','SERVICE_DGPC_DESCR','IS_CPPC');

        $fetch_services = $this->Model->make_datatables($table, $select_column, $critere_txt, $critere_array, $order_by);
        

         // print_r($fetch_services);
        $data = array();
        foreach ($fetch_services as $row) {
            $sub_array = array();
            $managers=$this->Model->getMembresServices($row->SERVICE_DGPC_ID);
            
            $mes_membres = '';
            $i =1;
            foreach ($managers as $manager) {
              $mes_membres .=$i.")".$manager['GRADE']." ".$manager['PERSONNEL_NOM']." ".$manager['PERSONNEL_PRENOM']."<br>";
            }

            $les_membres= "<a href='#' data-toggle='modal' 
                                  data-target='#membres" . $row->SERVICE_DGPC_ID . "'>".count($managers)."</a>
                                   
                                    <div class='modal fade' id='membres" . $row->SERVICE_DGPC_ID . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    ".$mes_membres."
                                                </div>

                                                <div class='modal-footer'>                                                    
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    ";
            $sub_array[] =$les_membres;

            if($row->IS_CPPC==1){
              $rp="Oui";

              $sub_array[] = $row->SERVICE_DGPC_DESCR;
              
              $sub_array[] =$rp;
           


            $options = '<div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            ';
            
            $options .= "<li><a href='" . base_url('equipes/Services/modifier/' . $row->SERVICE_DGPC_ID) . "'>
                                        Modifier</li>";
            
            
            $options .= "<li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete" . $row->SERVICE_DGPC_ID . "'><font color='red'>Supprimer</font></button></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete" . $row->SERVICE_DGPC_ID . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Voulez-vous vraiment supprimer ce service?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('equipes/Services/supprimer/' . $row->SERVICE_DGPC_ID) . "'>Supprimer</a>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    ";

            $sub_array[] = $options;

            $data[] = $sub_array;


            }else{


              $rp="Non";
              $sub_array[] = $row->SERVICE_DGPC_DESCR;
            $sub_array[] =$rp;
           


            $options = '<div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            ';
            
            $options .= "<li><a href='" . base_url('equipes/Services/modifier/' . $row->SERVICE_DGPC_ID) . "'>
                                        Modifier</li>";

            
            $options .= "<li><a href='" . base_url('equipes/Services/new/' . $row->SERVICE_DGPC_ID) . "'>
                                      Ajouter</li>";                            
            
            $options .= "<li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete" . $row->SERVICE_DGPC_ID . "'><font color='red'>Supprimer</font></button></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete" . $row->SERVICE_DGPC_ID . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Voulez-vous vraiment supprimer ce service?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('equipes/Services/supprimer/' . $row->SERVICE_DGPC_ID) . "'>Supprimer</a>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div> ";

            $sub_array[] = $options;

            $data[] = $sub_array;
            }       
            
        }

        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" => $this->Model->count_all_data($table, $critere_array),
            "recordsFiltered" => $this->Model->get_filtered_data($table, $select_column, $critere_txt, $critere_array, $order_by),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function supprimer($id){
      $this->Model->delete("rh_service_dgpc",array("SERVICE_DGPC_ID"=>$id));
       $data['msg']='<div class="alert alert-success text-center"> Suppression avec succès</div>';
      
        $this->session->set_flashdata($data);
      redirect(base_url('equipes/Services'));
    }


    public function modifier($id){
       $service=$this->Model->getOne('rh_service_dgpc',array('SERVICE_DGPC_ID'=>$id));
       $data['title'] = "modifier Service";
       $data['id'] =$id;
       $data['description'] =$service['SERVICE_DGPC_DESCR'];
       $data['IS_CPPC'] = $service['IS_CPPC'];
       $data['breadcrumb'] = $this->make_bread->output();

      $this->load->view('services/Services_update_View',$data);
    }

    public function update(){

      $id=$this->input->post('id');
      $service=$this->input->post('service');
      $is_cppc=$this->input->post('is_cppc');
      $check=$this->Model->checkvalue('rh_service_dgpc',array('SERVICE_DGPC_DESCR'=>$service));

    if(($check!=1)){
          $array=array(
                'SERVICE_DGPC_DESCR'=>$service,
                'IS_CPPC'=>$is_cppc
              );
          $this->Model->update('rh_service_dgpc',array('SERVICE_DGPC_ID'=>$id),$array);

          $data['msg']='<div class="alert alert-success text-center"> Modification avec succès</div>';
      
        $this->session->set_flashdata($data);
      redirect(base_url('equipes/Services'));
    }else{
          $array=array(
                'IS_CPPC'=>$is_cppc,
              );
          $this->Model->update('rh_service_dgpc',array('SERVICE_DGPC_ID'=>$id),$array);
          $data['msg']='<div class="alert alert-info text-center"> Modification reussie</div>';
          
            $this->session->set_flashdata($data);
          redirect(base_url('equipes/Services'));
    }
    }



 // public function new($id){

 //   // $service=$this->Model->getOne('rh_service_dgpc',array('SERVICE_DGPC_ID'=>$id));
 //    //print_r($service['SERVICE_DGPC_ID'] );
   
 //    $data['title'] = "Nouveau Service";
 //    $data['breadcrumb'] = $this->make_bread->output();
 //    $data['personnel'] = $this->Model->getList('rh_personnel_dgpc');
 //    $data['date'] = $this->Model->getList('rh_service_dgpc');

 //    $this->load->view('services/service_collabo',$data);

 //     }
    public function new($id){

   // $service=$this->Model->getOne('rh_service_dgpc',array('SERVICE_DGPC_ID'=>$id));
    //print_r($service['SERVICE_DGPC_ID'] );
   
    $data['title'] = "Nouveau Service";
    $data['breadcrumb'] = $this->make_bread->output();
    $data['personnel'] = $this->Model->getList('rh_personnel_dgpc');
    $data['service'] = $this->Model->getList('rh_service_dgpc',array('IS_CPPC'=>0));
    $data['date'] = $this->Model->getList('rh_service_dgpc');

    $this->load->view('services/service_collabo',$data);

     }

  // public function ajout(){

  //     $collabo=$this->input->post('PERSONNEL_ID');
  //     $date=$this->input->post('SERVICE_DGPC_ID');
  //     $dates=$this->Model->getOne('rh_service_dgpc',array('SERVICE_DGPC_ID'=>$date));  
  //     $chef=$this->input->post('is_cppc');
  //     $description=$this->input->post('description');

  //     $check=$this->Model->checkvalue('rh_service_manager',array('PERSONNEL_ID'=>$collabo));

  //     if( $check!=1){

  //           $array=array(
  //               'PERSONNEL_ID'=>$collabo,
  //               'IS_CHEF'=>$chef,
  //               'DATE_DEBUT'=>$dates['DATE_INSERTION'],
  //               'DESCRIPTION'=>$description,
  //               'SERVICE_DGPC_ID'=>$id,
  //               'USER_ID'=>$this->session->userdata('DGPC_USER_ID')
  //             );
  //             $this->Model->create('rh_service_manager',$array);


  //             //print_r('ok');
  //             //exit();
              
  //             $data['msg']='<div class="alert alert-success text-center"> Enregistrement avec succès</div>';
          
  //             $this->session->set_flashdata($data);
  //             redirect(base_url('equipes/Services/listing/'));

  //     }else{

  //             //print_r('Non');
  //             //exit();
  //             $data['msg']='<div class="alert alert-danger text-center"> Echec! le personnel existe deja</div>';
              
  //             $this->session->set_flashdata($data);
  //             redirect(base_url('equipes/Services/listing/'));
  //       }    

  //   }   

     public function ajout(){

      $collabo=$this->input->post('PERSONNEL_ID');
      $id=$this->input->post('SERVICE_DGPC_ID');
      $dates=$this->Model->getOne('rh_service_dgpc',array('SERVICE_DGPC_ID'=>$id));  
      $chef=$this->input->post('is_cppc');
      $description=$this->input->post('description');

      $check=$this->Model->checkvalue('rh_service_manager',array('PERSONNEL_ID'=>$collabo));

      if( $check!=1){

            $array=array(
                'PERSONNEL_ID'=>$collabo,
                'IS_CHEF'=>$chef,
                'DATE_DEBUT'=>$dates['DATE_INSERTION'],
                'DESCRIPTION'=>$description,
                'SERVICE_DGPC_ID'=>$id,
                'USER_ID'=>$this->session->userdata('DGPC_USER_ID')
              );
            
              $this->Model->create('rh_service_manager',$array);


              //print_r('ok');
              //exit();
              
              $data['msg']='<div class="alert alert-success text-center"> Enregistrement avec succès</div>';
          
              $this->session->set_flashdata($data);
              redirect(base_url('equipes/Services/listing/'));

      }else{

              //print_r('Non');
              //exit();
              $data['msg']='<div class="alert alert-danger text-center"> Echec! le personnel existe deja</div>';
              
              $this->session->set_flashdata($data);
              redirect(base_url('equipes/Services/listing/'));
        }    

    }   


    public function listing(){ 

    $manag=$this->Model->getList('rh_service_manager');
    
    $resultat=array();
     
     foreach ($manag as $key) {

        $person=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$key['PERSONNEL_ID']));
        //$date=$this->Model->getOne('rh_service_dgpc',array('DATE_INSERTION'=>$key['DATE_DEBUT']));
        $service=$this->Model->getOne('rh_service_dgpc',array('SERVICE_DGPC_ID'=>$key['SERVICE_DGPC_ID']));

        if ($key['IS_CHEF']==1) {
          
           $chef='oui';
        }
        else{

           $chef='Non';
          }
        
        $data = Null;
        $data[]= $person['PERSONNEL_NOM'].' - '.$person['PERSONNEL_PRENOM'];
        $data[]= $key['DESCRIPTION'];
        $data[]= $chef;
        $data[]= $key['DATE_DEBUT'];
        $data[]= $service['SERVICE_DGPC_DESCR'];
        
        $data[]='<div class="dropdown ">
                    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Action
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-left">
                        
                        <li><a href='.base_url("equipes/Services/getOne/").$key["SERVICE_MANAGER_ID"].'>Modifier</li>
                        <li>
                          <a href="" data-toggle="modal" data-target="#mydesactivation'.$key["SERVICE_MANAGER_ID"].'">Supprimer</a>
                       </li>   
                  </div>

                 

          <div class="modal fade" id="mydesactivation'.$key["SERVICE_MANAGER_ID"].'">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                <h4>Voulez-vous vraiment Supprimer ce personnel nommé :</h4><h3>'.$person['PERSONNEL_NOM'].' - '.$person['PERSONNEL_PRENOM'].' ...?</h3>
                </div>
                <div class="modal-footer">
                <a class="btn  btn-danger btn-md"href='.base_url("equipes/Services/delete/").$key["SERVICE_MANAGER_ID"].'>Supprimer</a>
                <button class="btn  btn-md" class="close" data-dismiss="modal">Annuler</button>
                </div>                             
            </div>
          </div>
          </div>
                    ';

        //$data[]=$list_societes[''];
    $resultat[]=$data;
    }

    $template=array(
        'table_open'=>'<table id="mytable" class="table table-responsive">',
        '<table_close'=>'</table>'
        );
        
        $this->table->set_heading('Nom et Prenom','Déscription','chef Oui/Nom','Date debut','Service','Action');
        $this->table->set_template($template);
        
    $datas['table']=$resultat;
    $this->make_bread->add("Liste", "", 1);
    $datas['breadcrumb'] = $this->make_bread->output();
    $datas['title'] = "Manager des services";
    $this->load->view('services/service_collabo_update',$datas);  

       }

  public function delete($id){

    $this->Model->delete("rh_service_manager",array("SERVICE_MANAGER_ID"=>$id));
    $data['msg']='<div class="alert alert-success text-center"> Suppression avec succès</div>';
      
    $this->session->set_flashdata($data);
    redirect(base_url('equipes/Services/listing'));

    }

  function getOne(){

  $data['breadcrumb'] = $this->make_bread->output();
  $data['personnel'] = $this->Model->getList('rh_personnel_dgpc');
  $data['date'] = $this->Model->getList('rh_service_dgpc');  

  $table="rh_service_manager";
  $criteres['SERVICE_MANAGER_ID']=$this->uri->segment(4);
  $manag=$this->Model->getOne($table, $criteres,array('DESCRIPTION'));
  $data['manager']=$manag;

  $this->make_bread->add('Modifier', "getOne/".$criteres['SERVICE_MANAGER_ID'], 1);
  $data['breadcrumb'] = $this->make_bread->output();
  $this->load->view('services/service_personn_update',$data);

   
  }

  public function dater(){

           $id=$this->uri->segment(4);
           $idn = $this->input->post('idn');

            $description=$this->input->post('description');


            $array=array(
                
                'DESCRIPTION'=>$description,
                'IS_CHEF'=>$this->input->post('is_cppc')
              
              );
             //$this->Model->update('rh_service_manager',$array);

            //print_r($idn);
            //exit();

            $sav=$this->Model->update('rh_service_manager',array('SERVICE_MANAGER_ID'=>$idn),$array);


              
              $data['msg']='<div class="alert alert-success text-center"> Modification fait avec succès</div>';
          
              $this->session->set_flashdata($data);
              redirect(base_url('equipes/Services/listing/'));

    }   

}
?>