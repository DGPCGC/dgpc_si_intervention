
<?php

 class Horaire extends MY_Controller
 {
 	
 	function __construct()
 	{
 	  parent::__construct();
    // $this->load->model("Model_Demande");
    // $this->make_bread->add('Interventions', "tickets/Tickets", 0);
 	$this->make_bread->add('Horaires', "equipes/Horaire/list", 0);
    $this->breadcrumb = $this->make_bread->output(); 	
    $this->autho();
    }

    public function autho()
    {
    if(empty($this->session->userdata('DGPC_USER_EMAIL'))){
        redirect(base_url());
       }
    }

 	public function index(){

 		// $data['equipe']=$this->Model->getList('horaire_equipe');
   //      $data['heure']=$this->Model->getList('horaire_heure');
   //      $data['jours']=$this->Model->getList('horaire_jours');
 		   $data['cppc']=$this->Model->getList('rh_cppc');

 		$data['title']='Horaire des Equipes';
 		$data['breadcrumb'] = $this->make_bread->output();
 		$this->load->view('equipes/horaire/Horaire_New_View',$data);
 	}

 	public function add(){
 	   $this->form_validation->set_rules('EQUIPE_ID', 'Equipe', 'required',array('required'=>'Completer ce champs svp'));
       $this->form_validation->set_rules('CPPC_ID', 'CPPC', 'required',array('required'=>'Completer ce champs svp'));
       $this->form_validation->set_rules('TRANCHE', 'Tranche', 'required',array('required'=>'Completer ce champs svp'));
       $this->form_validation->set_rules('EQUIPE_ID_SECOUR', 'Equipe secour', 'required',array('required'=>'Completer ce champs svp'));

        if ($this->form_validation->run() == FALSE) {
           
            $data['title'] = "Horaire des Eqipes";
            $data['cppc']=$this->Model->getList('rh_cppc');

 			$data['EQUIPE_ID']=$this->input->post('EQUIPE_ID');
            $data['HEURE_ID']=$this->input->post('CPPC_ID');
            $data['TRANCHE']=$this->input->post('TRANCHE');
 			$data['EQUIPE_ID_SECOUR']=$this->input->post('EQUIPE_ID_SECOUR');
 			$data['breadcrumb'] = $this->make_bread->output();
 			$this->load->view('equipes/horaire/Horaire_New_View',$data);

        }else{
        	$equipe=$this->input->post('EQUIPE_ID');
            $tranche=$this->input->post('TRANCHE');
            $equipe_secour=$this->input->post('EQUIPE_ID_SECOUR');
            if($tranche==1){
                $array=array(
                    'DESCRIPTION'=>'00h-08h',
                    'EQUIPE_ID'=>$equipe,
                    'EQUIPE_SECOUR_ID'=>$equipe_secour,
                    'HEURE_DEBUT'=>0,
                    'HEURE_FIN'=>8,
                    );
                $tranche_test='00h-08h';
            }else if($tranche==2){
                 $array=array(
                    'DESCRIPTION'=>'08h-16h',
                    'EQUIPE_ID'=>$equipe,
                    'EQUIPE_SECOUR_ID'=>$equipe_secour,
                    'HEURE_DEBUT'=>8,
                    'HEURE_FIN'=>16,
                    );
                 $tranche_test='08h-16h';
            }else if($tranche==3){
                $array=array(
                    'DESCRIPTION'=>'16h-24h',
                    'EQUIPE_ID'=>$equipe,
                    'EQUIPE_SECOUR_ID'=>$equipe_secour,
                    'HEURE_DEBUT'=>16,
                    'HEURE_FIN'=>24,
                    );
                $tranche_test='16h-24h';
            }

          /*  $check_value=$this->Model->checkvalue('horaire_equipe',array('DESCRIPTION'=>$tranche_test));
            if ($check_value==TRUE) {
                $msg="<div class='alert alert-danger'>Une equipe existe déjà à cette heure</div>";
            }else{ */
                $save=$this->Model->create('horaire_equipe',$array);
                if($save){
                    $msg="<div class='alert alert-success'>Enregistrement reussi!</div>";
                }else{
                    $msg="<div class='alert alert-danger'>Echec!</div>";
                }
          //  }
            

          
        	
        	$donne['msg'] =$msg;
            $this->session->set_flashdata($donne);
            redirect(base_url().'equipes/Horaire');

        	
        	
        }

 	}

    public function list(){

        $horaire=$this->Model->getList('horaire_equipe');

        foreach ($horaire as $horaires) {
            
            $nom_equipe=$this->Model->getOne('rh_equipe_cppc',array('EQUIPE_ID'=>$horaires['EQUIPE_ID'],'IS_ACTIVE'=>1));
            $cppc=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$nom_equipe['CPPC_ID']));
            $nom_equipe_secour=$this->Model->getOne('rh_equipe_cppc',array('EQUIPE_ID'=>$horaires['EQUIPE_SECOUR_ID'],'IS_ACTIVE'=>1));

            $data=Null;
            $data[]=$cppc['CPPC_NOM'];            
            $data[]=$horaires['DESCRIPTION'];            
            $data[]=$nom_equipe['EQUIPE_NOM'];
            $data[]=$nom_equipe_secour['EQUIPE_NOM'];
            if($this->mylibrary->verify_is_admin() ==1){
              $data[]='<div class="dropdown ">
                    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Action
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        
                        <li><a href='.base_url("equipes/Horaire/delete/").$horaires["HORAIRE_ID"].'><font color="red">supprimer</a></li>
                    
                                  
                     
                    </ul>
                  </div>';
             }     
            $resultat[]=$data;
            }
       
        $template=array(
        'table_open'=>'<table id="mytable" class="table table-bordered table-stripped table-hover table-condensed table-responsive">',
        '<table_close'=>'</table>'
        );
        if($this->mylibrary->verify_is_admin() ==1){ 
          $this->table->set_heading('CPPC','Tranche','Equipe principale','Equipe de secour','Action');
        }else{
          $this->table->set_heading('CPPC','Tranche','Equipe principale','Equipe de secour');
        }
        $this->table->set_template($template);
        $data['table']=$resultat;

        $data['title']='Horaire des Equipes';
        $data['breadcrumb'] = $this->make_bread->output();
        $this->load->view('equipes/horaire/Horaire_Liste_View',$data);

    }

    function select_team(){
        $id_equipe=$this->input->post('equipe');
        $id_cppc=$this->Model->getOne('rh_equipe_cppc',array('EQUIPE_ID'=>$id_equipe));

        // $other_team=$this->Model->getList('interv_equipe',array('CASERNE_ID'=>$caserne['CASERNE_ID']));

        $cppc_id=$id_cppc['CPPC_ID'];
        $other_team=$this->Model->querysql("SELECT * FROM rh_equipe_cppc WHERE CPPC_ID='$cppc_id' AND EQUIPE_ID !='$id_equipe'");
        
        $hmtl="<option>-- Sélectionner --</option>";
        foreach ($other_team as $key => $value) {
            $hmtl.="<option value='".$value['EQUIPE_ID']."'>".$value['EQUIPE_NOM']."</option>";
        }
        echo $hmtl;
    }
    function select_team_caserne(){
        $id_cppc=$this->input->post('cppc');
        $equipe=$this->Model->getList('rh_equipe_cppc',array('CPPC_ID'=>$id_cppc));

        $hmtl="<option>-- Sélectionner --</option>";
        foreach ($equipe as $key => $value) {
            $hmtl.="<option value='".$value['EQUIPE_ID']."'>".$value['EQUIPE_NOM']."</option>";
        }
        echo $hmtl;
    }

    public function delete($id){
        $delete=$this->Model->delete('horaire_equipe',array('HORAIRE_ID'=>$id));
        if($update){
            $msg="<div class='alert alert-success'>Suppression reussie!</div>";
        }else{
            $msg="<div class='alert alert-danger'>Echec!</div>";
        }
            $donne['msg'] =$msg;
            $this->session->set_flashdata($donne);
            redirect(base_url().'equipes/Horaire/list');
    }


    public function odk_form(){
    	if($_SERVER['REQUEST_METHOD']=='GET'){
    		$data['msg']='';
	    	$this->make_bread->add('Nouvelle', "equipes/Horaire/odk_form", 0);
	        $data['breadcrumb'] = $this->make_bread->output();
	    	$this->load->view('odk/Odk_add_View',$data);
    	}else{
    		 $this->form_validation->set_rules('DESCRIPTION','','trim|required',array('required'=>'<font size="2"> La déscription est obligatoire </font>'));
    		 $this->form_validation->set_rules('AGENT','','trim|required',array('required'=>'<font size="2"> L\'agent est obligatoire </font>'));
    		 $this->form_validation->set_rules('LOCALITE','','trim|required',array('required'=>'<font size="2"> La localité est obligatoire </font>'));

    		 $this->form_validation->set_rules('DATE','','trim|required',array('required'=>'<font size="2"> La Date est obligatoire </font>'));
		    $this->form_validation->set_rules('LONGITUDE','','trim|required',array('required'=>'<font size="2"> La longitude est obligatoire </font>'));
		    $this->form_validation->set_rules('LAT','','trim|required',array('required'=>'<font size="2"> La latitude est obligatoire </font>'));

		    // $this->form_validation->set_rules('LAT','','trim|required|matches[NEW_PASSWORD]',array('required'=>'La confirmation du nouveau mot de passe est obligatoire'),array('matches[NEW_PASSWORD]'=>'La confirmation du nouveau mot de passe et le nouveau mot de passe sont uniforme'));
		       if($this->form_validation->run()==TRUE)
		           {	

		           	// $user_odk=$this->Model->getOne('admin_users',array('USER_EMAIL'=>$this->session->userdata('DGPC_USER_EMAIL')));
		           	$date=new DateTime($this->input->post('DATE'));
		           	$vr_date=$date->format('Y-m-d');
		           	

		           	$data=array(
		           	'LOCALITE'=>$this->input->post('LOCALITE'),
		           	'DESCR_CATASTROPHE'=>$this->input->post('DESCRIPTION'),
		           	'USER_ODK'=>$this->input->post('AGENT'),
		           	'LATITUDE'=>$this->input->post('LAT'),
		           	'LONGITUDE'=>$this->input->post('LONGITUDE'),
		           	'DATETIME'=>$vr_date
		           	);
		           	$insrt=$this->Model->create('odk_form',$data);
		           	if($insrt){
		           		$data['msg']="<div class='alert alert-success'>Enregistrement reussi!</div>";

		           	}else{
		           		$data['msg']="<div class='alert alert-danger'>Echec!</div>";
		           	}
		            
		           }else{
		           	$data['msg']='';
	    			
		           }

		           $this->make_bread->add('Nouvelle', "equipes/Horaire/odk_form", 0);
	        	   $data['breadcrumb'] = $this->make_bread->output();
	    		   $this->load->view('odk/Odk_add_View',$data);
    	
		    }
		}

		public function list_Odk_cata(){
			$catastrophe=$this->Model->getList('odk_form');
		        foreach ($catastrophe as $catastrophes) {
		        	$data=Null;
                    $data[]=$catastrophes['DESCR_CATASTROPHE'];
                    $data[]=$catastrophes['LOCALITE'];
                    $data[]=$catastrophes['LATITUDE'];
                    $data[]=$catastrophes['LONGITUDE'];
                    $data[]=$catastrophes['USER_ODK'];
                    $data[]=$catastrophes['DATETIME'];
                    $data[]='<div class="dropdown ">
                    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Action
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href='.base_url("equipes/Horaire/update_cata/").$catastrophes["ID"].'>Modifier</li>
                        <li><a href='.base_url("equipes/Horaire/deletecata/").$catastrophes["ID"].'><font color="red">supprimer</a></li>
                    
                                  
                     
                    </ul>
                  </div>';
                  // $data[]= "<li><a href='#' >Supprimer</font></button></li></ul>
                  //                  </div>
                                    
                  //                   ";

                    $resultat[]=$data;

		        }

		      $template=array(
	        'table_open'=>'<table id="mytable" class="table table-bordered table-stripped table-hover table-condensed table-responsive">',
	        '<table_close'=>'</table>'
	        );
	        
	        $this->table->set_heading('Déscription','Localité','Latitude','Longitude','Saisi par','Date','Action');
	        $this->table->set_template($template);
	        $data['table']=$resultat;
	        $this->make_bread->add('Liste catastrophes', "equipes/Horaire/list_Odk_cata", 0);
	        $data['breadcrumb'] = $this->make_bread->output();
	        $this->load->view('odk/Odk_List_View',$data);
		}

        
        public function deletecata(){

            $idincident =$this->uri->segment(4);
      $incident = $this->Model->getOne('odk_form',array('ID'=>$idincident));
      // $interventions = $this->Model->getList('interv_intervention',array('ID'=>$incident['ID']));      
      // $intervention_terrains = $this->Model->getList('interv_intervention_histo',array('ID'=>$incident['ID']));
      
       $msg = '';
      // if(!empty($incident)){
        // if(empty($interventions) && empty($intervention_terrains)){
          $this->Model->delete('odk_form',array('ID'=>$idincident));
          $msg = "<font color='green'>La catastrophes <b>".$incident['DESCR_CATASTROPHE']."</b> a été supprimé</font>";
        // }else{
        //   $msg = "<font color='red'>Pour supprimer l'évenement <b>".$incident['TICKET_DESCR']."</b> commencer à supprimer l'(les) intervention(s) y relatif ainsi que l'(les) information(s) recolté(es) au terrain.</font>"; 
        // }
      // }else{
      //   $msg = "<font color='red'>Le Ticket d'intervention que vous voulez n'existe plus.</font>";        
      // }
      $donne['msg'] =$msg;
      $this->session->set_flashdata($donne);

      redirect(base_url().'equipes/Horaire/list_Odk_cata');
        }

		public function update_cata($id){
			$id=$id;
			if($_SERVER['REQUEST_METHOD']=='GET'){
			$data['cata']=$this->Model->getOne('odk_form',array('ID'=>$id));		
    		$data['msg']='';
	    	$this->make_bread->add('Détail', "equipes/Horaire/update_cata/".$id, 0);
	        $data['breadcrumb'] = $this->make_bread->output();
	    	$this->load->view('odk/Odk_update_View',$data);
    		}else{
    		 $this->form_validation->set_rules('DESCRIPTION','','trim|required',array('required'=>'<font size="2"> La déscription est obligatoire </font>'));
    		 $this->form_validation->set_rules('AGENT','','trim|required',array('required'=>'<font size="2"> L\'agent est obligatoire </font>'));
    		 $this->form_validation->set_rules('LOCALITE','','trim|required',array('required'=>'<font size="2"> La localité est obligatoire </font>'));

    		 $this->form_validation->set_rules('DATE','','trim|required',array('required'=>'<font size="2"> La Date est obligatoire </font>'));
		    $this->form_validation->set_rules('LONGITUDE','','trim|required',array('required'=>'<font size="2"> La longitude est obligatoire </font>'));
		    $this->form_validation->set_rules('LAT','','trim|required',array('required'=>'<font size="2"> La latitude est obligatoire </font>'));
		    // $this->form_validation->set_rules('LAT','','trim|required|matches[NEW_PASSWORD]',array('required'=>'La confirmation du nouveau mot de passe est obligatoire'),array('matches[NEW_PASSWORD]'=>'La confirmation du nouveau mot de passe et le nouveau mot de passe sont uniforme'));
		       if($this->form_validation->run()==TRUE)
		           {	

		           	$date=new DateTime($this->input->post('DATE'));
		           	$vr_date=$date->format('Y-m-d');
		           	

		           	$data=array(
		           	'LOCALITE'=>$this->input->post('LOCALITE'),
		           	'DESCR_CATASTROPHE'=>$this->input->post('DESCRIPTION'),
		           	'USER_ODK'=>$this->input->post('AGENT'),
		           	'LATITUDE'=>$this->input->post('LAT'),
		           	'LONGITUDE'=>$this->input->post('LONGITUDE'),
		           	'DATETIME'=>$vr_date
		           	);
		           	$insrt=$this->Model->update('odk_form',array('ID'=>$id),$data);
		           	if($insrt){
		           		$data['msg']="<div class='alert alert-success'>Modification reussie!</div>";


		           	}else{
		           		$data['msg']="<div class='alert alert-danger'>Echec!</div>";
		           	}
		            
		           }else{
		           	$data['msg']='';
	    			
		           }
		           $data['cata']=$this->Model->getOne('odk_form',array('ID'=>$id));
		           $this->make_bread->add('Détail', "equipes/Horaire/update_cata/".$id, 0);
	        	   $data['breadcrumb'] = $this->make_bread->output();
	    		   $this->load->view('odk/Odk_update_View',$data);
    	
		    }
		}

		public function rapport(){

		if($_SERVER['REQUEST_METHOD']=='POST'){
         $check=$this->input->post('check');
         if($check==1){
            $agent=$this->input->post('AGENT');
            if(empty($agent)){
            	$catastr=$this->Model->querysql('SELECT DISTINCT(USER_ODK) FROM odk_form');
            }else{
            	$catastr = $this->Model->getList('odk_form',array('USER_ODK'=>$agent));
            }
            
            $finales=array();
            $finales_date=array();
            
         }else if($check==2){
            $localites=$this->input->post('LOCALITE');
            $catastr = $this->Model->getList('odk_form',array('LOCALITE'=>$localites));
      		$finales=array();
      		$finales_date=array();
         }
      }else{
      	$catastr=$this->Model->querysql('SELECT DISTINCT(USER_ODK) FROM odk_form');
      	$localite=$this->Model->querysql('SELECT DISTINCT(LOCALITE) FROM odk_form');
      	$donnee_rapp='';
			foreach($localite as $localites){
				$nbre_2=count($this->Model->getList('odk_form',array('LOCALITE'=>$localites['LOCALITE'])));

				$donnee_rapp.="{name:'".$localites['LOCALITE']."',y:".$nbre_2."},";
				// {name: 'Chrome',y: 61.41,}, {name: 'Internet Explorer',y: 11.84}

			}
			$donnee_rapp.='@';
			$finales=str_replace(',@', '', $donnee_rapp);

		$par_date=$this->Model->querysql('SELECT DISTINCT(DATETIME) FROM odk_form');
		$donnee_par_date='';
			foreach($par_date as $par_dates){
				$nbre_date=count($this->Model->getList('odk_form',array('DATETIME'=>$par_dates['DATETIME'])));

				$donnee_par_date.="{name:'".$par_dates['DATETIME']."',y:".$nbre_date."},";
				// {name: 'Chrome',y: 61.41,}, {name: 'Internet Explorer',y: 11.84}

			}
			$donnee_par_date.='@';
			$finales_date=str_replace(',@', '', $donnee_par_date);



      	
      }


			
			$donnee='';
			foreach($catastr as $catastrs){
				$nbre=count($this->Model->getList('odk_form',array('USER_ODK'=>$catastrs['USER_ODK'])));
				$donnee.="['".$catastrs['USER_ODK']."',".$nbre."],";

			}
			$donnee.='@';
			$finale=str_replace(',@', '', $donnee);



			
			
		
			
			$data['finale']=$finale;
			$data['rapp_loca']=$finales;
			$data['rapp_par_date']=$finales_date;
			// exit();
			
			

			$data['agent']=$this->Model->querysql('SELECT DISTINCT(USER_ODK) FROM odk_form');
     		$data['localite']=$this->Model->querysql('SELECT DISTINCT(LOCALITE) FROM odk_form');
			$b=$this->make_bread->add('Rapport', "equipes/Horaire/rapport", 2);
	        $data['breadcrumb'] = $this->make_bread->output();
			$this->load->view('odk/Odk_Rapport_View',$data);
		}

 }