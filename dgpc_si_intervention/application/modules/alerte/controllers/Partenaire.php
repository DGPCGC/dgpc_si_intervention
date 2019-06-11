<?php 

	/**
	 * 
	 */
	class Partenaire extends CI_Controller
	{
		
		function __construct()
		{
			# code...
			parent::__construct();
		$this->autho();
       
    }
    
    public function autho()
      {
      if(empty($this->session->userdata('DGPC_USER_EMAIL'))){
          redirect(base_url());
         }
      }

		function liste(){

			$this->make_bread->add('Partenaires', "alerte/Partenaire/liste", 0);
    		$data['breadcrumb'] = $this->make_bread->output();
    		$data['title']='Liste des partenaires';
    		$data['liste_partenaire']=$this->Model->getList('interv_partenaire',array());
			$this->load->view('partenaire_view/Partenaire_List_view',$data);
		}

		function add_data(){

			$this->make_bread->add('Partenaires', "alerte/Partenaire/add_data", 0);
    		$data['breadcrumb'] = $this->make_bread->output();
    		$data['title']='Nouveau partenaire';
			$this->load->view('partenaire_view/Partenaire_Add_view',$data);
		}

		function add(){

		    $this->form_validation->set_rules('PARTENAIRE_CODE', 'Code', 'required',array('required'=>'Champ code du partenaire est obligatoire'));
	        $this->form_validation->set_rules('PARTENAIRE_EMAIL','Email','required|valid_email|is_unique[interv_partenaire.PARTENAIRE_EMAIL]',array('required'=>'Champ Email du partenaire est obligatoire','valid_email'=>'Email non valide','is_unique'=>'Email existe déjà'));
	        $this->form_validation->set_rules('PARTENAIRE_DESCR', 'Description', 'required',array('required'=>'Champ description du partenaire est obligatoire'));
	        $this->form_validation->set_rules('PARTENAIRE_TEL', 'Télephone', 'required|is_unique[interv_partenaire.PARTENAIRE_TEL]',array('is_unique'=>'Ce numéro de télephone existe déjà','required'=>'Champ télephone du partenaire est obligatoire'));
	         
        if ($this->form_validation->run() == FALSE) {
            $this->make_bread->add('Partenaires', "alerte/Partenaire/add_data", 0);
    		$data['breadcrumb'] = $this->make_bread->output();
    		$data['title']='Nouveau partenaire';
			$this->load->view('partenaire_view/Partenaire_Add_view',$data);
        }else{
            $array_equipe = array(
                                'PARTENAIRE_CODE'=>$this->input->post('PARTENAIRE_CODE'),
                                'PARTENAIRE_DESCR'=>$this->input->post('PARTENAIRE_DESCR'),
                                'PARTENAIRE_TEL'=>$this->input->post('PARTENAIRE_TEL'),                                
                                'PARTENAIRE_EMAIL'=>$this->input->post('PARTENAIRE_EMAIL')
                                );
            $caserne_id = $this->Model->insert_last_id('interv_partenaire',$array_equipe);

            $msg = "<font color='red'>Le partenaire <b>".$this->input->post('PARTENAIRE_DESCR')."</b> n'a pas été enregistré.</font>";
            if($caserne_id >0){
              
              $msg = "<font color='green'> Le partenaire <b>".$this->input->post('PARTENAIRE_DESCR')."</b> a été enregistré.</font>";
              $donne['msg'] =$msg;
              $this->session->set_flashdata($donne);

              redirect(base_url().'alerte/Partenaire/liste');
            }

        	}
		}

		 function delete(){
		 	$PARTENAIRE_ID=$this->uri->segment(4);
		 	$dl=$this->Model->delete('interv_partenaire',array('PARTENAIRE_ID'=>$PARTENAIRE_ID));
		 	$msg = "<font color='red'>Le partenaire <b>".$this->input->post('PARTENAIRE_DESCR')."</b> est supprimé.</font>";
            if($dl){
           	$msg = "<font color='red'>Le partenaire <b>".$this->input->post('PARTENAIRE_DESCR')."</b> est supprimé.</font>";
          
              $donne['msg'] =$msg;
              $this->session->set_flashdata($donne);

              redirect(base_url().'alerte/Partenaire/liste');
		 }
		 }

		 function updateform(){
		 	$PARTENAIRE_ID=$this->uri->segment(4);
		 	$data['partenaire_data']=$this->Model->getOne('interv_partenaire',array('PARTENAIRE_ID'=>$PARTENAIRE_ID));
		 	$this->make_bread->add('Partenaires', "alerte/Partenaire/updateform/".$PARTENAIRE_ID, 0);
    		$data['breadcrumb'] = $this->make_bread->output();
    		$data['title']='Modification du partenaire';
		 	$this->load->view('partenaire_view/Partenaire_Edit_view',$data);
		 }

		 function update(){

		 	$PARTENAIRE_ID=$this->input->post('PARTENAIRE_ID');

		 	$this->form_validation->set_rules('PARTENAIRE_CODE', 'Code', 'required',array('required'=>'Champ code du partenaire est obligatoire'));
	        $this->form_validation->set_rules('PARTENAIRE_EMAIL','Email','required|valid_email',array('required'=>'Champ Email du partenaire est obligatoire','valid_email'=>'Email non valide'));
	        $this->form_validation->set_rules('PARTENAIRE_DESCR', 'Description', 'required',array('required'=>'Champ description du partenaire est obligatoire'));
	        $this->form_validation->set_rules('PARTENAIRE_TEL', 'Télephone', 'required',array('required'=>'Champ télephone du partenaire est obligatoire'));
	         
        if ($this->form_validation->run() == FALSE) {
			$PARTENAIRE_ID=$this->input->post('PARTENAIRE_ID');
		 	$data['partenaire_data']=$this->Model->getOne('interv_partenaire',array('PARTENAIRE_ID'=>$PARTENAIRE_ID));
		 	$this->make_bread->add('Partenaires', "alerte/Partenaire/updateform/".$PARTENAIRE_ID, 0);
    		$data['breadcrumb'] = $this->make_bread->output();
    		$data['title']='Modification du partenaire';
		 	$this->load->view('partenaire_view/Partenaire_Edit_view',$data);

        }else{
            $array_equipe = array(
                                'PARTENAIRE_CODE'=>$this->input->post('PARTENAIRE_CODE'),
                                'PARTENAIRE_DESCR'=>$this->input->post('PARTENAIRE_DESCR'),
                                'PARTENAIRE_TEL'=>$this->input->post('PARTENAIRE_TEL'),                                
                                'PARTENAIRE_EMAIL'=>$this->input->post('PARTENAIRE_EMAIL')
                                );
            $caserne_id = $this->Model->update('interv_partenaire',array('PARTENAIRE_ID'=>$PARTENAIRE_ID),$array_equipe);

            $msg = "<font color='red'>Le partenaire <b>".$this->input->post('PARTENAIRE_DESCR')."</b> n'a pas été modifié.</font>";
            if($caserne_id >0){
              
              $msg = "<font color='green'> Le partenaire <b>".$this->input->post('PARTENAIRE_DESCR')."</b> a été modifié.</font>";
              $donne['msg'] =$msg;
              $this->session->set_flashdata($donne);

              redirect(base_url().'alerte/Partenaire/liste');
            }

        	}

		 }
	}
 ?>