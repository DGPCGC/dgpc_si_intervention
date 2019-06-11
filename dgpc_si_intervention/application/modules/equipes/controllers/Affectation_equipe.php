<?php

 class Affectation_equipe extends CI_Controller
 {
  
  function __construct()
  {
    parent::__construct();
    $this->make_bread->add('Affectations', "equipes/Affectation_equipe", 0);
    $this->breadcrumb = $this->make_bread->output();
  }
  function index($id=NULL){
  	$cppc = $this->Model->getOne('rh_cppc',array('CPPC_ID'=>$id));
  	$manager=$this->Model->getOne('rh_cppc_manager',array('CPPC_ID'=>$id));
  	$nom_manager=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$manager['PERSONNEL_ID']));

  	$data['manager'] = $nom_manager;
  	$data['CPPC_NOM'] = $cppc['CPPC_NOM'];
  	$data['cppc_id'] = $id;
  	$data['title'] = "Affectations Equipes ".$cppc['CPPC_NOM'];
  	$data['equipe2'] =$this->Model->getList('rh_equipe_cppc',array('CPPC_ID'=>$id));
  	$data['breadcrumb'] = $this->make_bread->output();
  	$this->load->view('caserne/Affectation_equipe_View', $data);
  }
}
