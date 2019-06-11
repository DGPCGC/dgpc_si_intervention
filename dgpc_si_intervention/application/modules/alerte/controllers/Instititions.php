<?php

	/**
	 * 
	 */
	class Instititions extends CI_Controller
	{
		
		function __construct()
		{
			# code...
			parent::__construct();
		$this->make_bread->add('Instititions', "alerte/Instititions", 0);
      $this->breadcrumb = $this->make_bread->output();
      $this->autho();
    }

    public function autho()
    {
		if(empty($this->session->userdata('DGPC_USER_EMAIL'))){
	      redirect(base_url());
	     }
    }
		function index($info=''){
            $notif=$this->Model->getList('notif_institution');
            $data = array();
            

            foreach ($notif as $row) {
               $sub_array = array();
                      
               $sub_array[] = $row['NOM_INSTITUTION'];
               $sub_array[] = $row['TELEPHONE'];            
               $sub_array[] = $row['EMAIL'];
               $sub_array[] = $row['PERSONNEL_CONTACT'];
            

               $options = '<div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            ';
            
               $options .= "<li><a href='" . base_url('alerte/Instititions/Modifier/' . $row['INSTITUTION_ID']) . "'>
                                        Modifier</li>";
            //}
            

               $options .= "<li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete" . $row['INSTITUTION_ID'] . "'><font color='red'>Supprimer</font></button></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete" . $row['INSTITUTION_ID'] . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Supprimer :<b>" . $row['NOM_INSTITUTION']."</b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('alerte/Instititions/supprimer/' . $row['INSTITUTION_ID']) . "'>Supprimer</a>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    ";

               $sub_array[] = $options;

            $data[] = $sub_array;
        }
         $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped table-hover table-condensed table-responsive">',
            'table_close' => '</table>'
        );

        $this->table->set_heading('INSTITUTION','TELEPHONE','EMAIL','PERSONNE A CONTACTER','OPTIONS');
        $this->table->set_template($template);
        $data_onther['table'] = $data;

           $data_onther['breadcrumb'] = $this->make_bread->output();
           $data_onther['title'] = "Liste des institutions";
           $data_onther['info']=$info;
           $this->load->view('institutions_view/Instititions_List_view',$data_onther);
        }

	

    function addform(){
    	$data_onther['breadcrumb'] = $this->make_bread->output();
        $data_onther['title'] = "Nouvelle institition";
          
    	$this->load->view('institutions_view/Instititions_Add_view',$data_onther);
    }

    function add(){

    	$NOM_INSTITUTION=$this->input->post('NOM_INSTITUTION');
    	$TELEPHONE=$this->input->post('TELEPHONE');
    	$EMAIL=$this->input->post('EMAIL');
    	$PERSONNEL_CONTACT=$this->input->post('PERSONNEL_CONTACT');

    	$this->form_validation->set_rules('NOM_INSTITUTION','Nom de l\'institition','required|is_unique[notif_institution.NOM_INSTITUTION]');
    	$this->form_validation->set_rules('EMAIL','Email','required|is_unique[notif_institution.EMAIL]');
    	$this->form_validation->set_rules('TELEPHONE','Telephone','required|is_unique[notif_institution.TELEPHONE]');
    	$this->form_validation->set_rules('PERSONNEL_CONTACT','Personne a contacter','required');

    	if($this->form_validation->run()==FALSE){
    		$this->addform();
    	}else{

    		$array=array('NOM_INSTITUTION'=>$NOM_INSTITUTION,'TELEPHONE'=>$TELEPHONE,'EMAIL'=>$EMAIL,'PERSONNEL_CONTACT'=>$PERSONNEL_CONTACT);


    		$cre=$this->Model->create('notif_institution',$array);
    		if($cre){
                $info='<div class="alert alert-success text-center">Enregistrement reussi</div>';
    			$this->index($info);
    		}
    	}


    }

    function supprimer(){
    	$INSTITUTION_ID=$this->uri->segment(4);
    	$del=$this->Model->delete('notif_institution',array('INSTITUTION_ID'=>$INSTITUTION_ID));
    	if($del){
    		$info='<div class="alert alert-success text-center">Suppression reussie</div>';
                $this->index($info);
    	}
    }

    function Modifier(){

    	$data_onther['breadcrumb'] = $this->make_bread->output();
        $data_onther['title'] = "Modification";
        $INSTITUTION_ID=$this->uri->segment(4);
    	$list_insti=$this->Model->getOne('notif_institution',array('INSTITUTION_ID'=>$INSTITUTION_ID));
    	$data_onther['list_insti']=$list_insti;        
    	$this->load->view('institutions_view/Instititions_Edit_view',$data_onther);
    }

    function modif(){

    	
    	$NOM_INSTITUTION=$this->input->post('NOM_INSTITUTION');
    	$TELEPHONE=$this->input->post('TELEPHONE');
    	$EMAIL=$this->input->post('EMAIL');
    	$PERSONNEL_CONTACT=$this->input->post('PERSONNEL_CONTACT');
    	$INSTITUTION_ID=$this->input->post('INSTITUTION_ID');
    	

    	$this->form_validation->set_rules('NOM_INSTITUTION','Nom de l\'institition','required');
    	$this->form_validation->set_rules('EMAIL','Email','required');
    	$this->form_validation->set_rules('TELEPHONE','Telephone','required');
    	$this->form_validation->set_rules('PERSONNEL_CONTACT','Personne a contacter','required');

    	if($this->form_validation->run()==FALSE){

		$list_insti=$this->Model->getOne('notif_institution',array('INSTITUTION_ID'=>$INSTITUTION_ID));
    	$data_onther['list_insti']=$list_insti;        
    	$this->load->view('institutions_view/Instititions_Edit_view',$data_onther);
    	}else{

    		$array=array('NOM_INSTITUTION'=>$NOM_INSTITUTION,'TELEPHONE'=>$TELEPHONE,'EMAIL'=>$EMAIL,'PERSONNEL_CONTACT'=>$PERSONNEL_CONTACT);
    		$cre=$this->Model->update('notif_institution',array('INSTITUTION_ID'=>$INSTITUTION_ID),$array);
    		if($cre){
    			$info='<div class="alert alert-success text-center">Modification reussie</div>';
                $this->index($info);
    		}
    	}	
    }

	}
 ?>