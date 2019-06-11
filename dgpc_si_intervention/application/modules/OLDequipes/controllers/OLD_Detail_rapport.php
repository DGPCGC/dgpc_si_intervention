<?php

 class Detail_rapport extends CI_Controller
 {
  
  function __construct()
  {
    parent::__construct();
    $this->make_bread->add('Affectations', "equipes/Affectation_equipe", 0);
    $this->breadcrumb = $this->make_bread->output();
  }
  function index($info=NULL){

    $donne=explode(".", $info);
    $ticket_code=$donne[2];
    $data['title'] = "Detail rapport";
    //DGPC
    if ($donne[0]=='DGCP') {
      if ($donne[1]=='materiels') {
        $data['title'] = "Degat matériels DGPC (CODE TICKET ".$ticket_code.")";
        $degat_dgpc=$this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>1));



        $datas = array();
        foreach ($degat_dgpc as $row) {
            $sub_array = array();

            $mat=$this->Model->getOne('interv_materiaux',array('MATERIEL_ID'=>$row['MATERIEL_ENDO_CODE']));           
           
           
            $sub_array[] = $mat['MATERIEL_DESCR'];
            $cat=$this->Model->getOne('tk_causes',array('CAUSE_ID'=>$row['CAUSE_ID']));
            $sub_array[] = $cat['CAUSE_DESCR'];
            $cppc=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$row['CPPC_ID']));
            $sub_array[] = $cppc['CPPC_NOM'];
            
           

            $datas[] = $sub_array;
        }
        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped table-hover table-condensed table-responsive">',
            'table_close' => '</table>'
        );

        $this->table->set_heading('DESCRIPTION MATERIEL','CAS D\'INTERVENTION','CPPC');
        $this->table->set_template($template);
        $data['table'] = $datas;
         
      }

      if ($donne[1]=='Blesses') {

        $degat_dgpc_blesse=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>1,'STATUT_SANTE'=>0));
        $data['title'] = "Les blessés DGPC (CODE TICKET ".$ticket_code.")";
 $datas = array();
        foreach ($degat_dgpc_blesse as $row) {
            $sub_array = array();

            $sub_array[] = $row['NOM_PRENOM'];
            $sub_array[] = $row['DATE_NAISSANCE'];
            $sub_array[] = $row['SEXE'];
            
           

            $datas[] = $sub_array;
        }
        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped table-hover table-condensed table-responsive">',
            'table_close' => '</table>'
        );

        $this->table->set_heading('NOM ET PRENOM','DATE DE NAISSANCE','SEXE');
        $this->table->set_template($template);
        $data['table'] = $datas;

      }
      if ($donne[1]=='Morts') {
        
        $degat_dgpc_blesse=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>1,'STATUT_SANTE'=>1));
        $data['title'] = "Les morts DGPC (CODE TICKET ".$ticket_code.")";
 $datas = array();
        foreach ($degat_dgpc_blesse as $row) {
            $sub_array = array();

            $sub_array[] = $row['NOM_PRENOM'];
            $sub_array[] = $row['DATE_NAISSANCE'];
            $sub_array[] = $row['SEXE'];
            
           

            $datas[] = $sub_array;
        }
        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped table-hover table-condensed table-responsive">',
            'table_close' => '</table>'
        );

        $this->table->set_heading('NOM ET PRENOM','DATE DE NAISSANCE','SEXE');
        $this->table->set_template($template);
        $data['table'] = $datas;

      }
    }

    //RIVERAINS
    if ($donne[0]=='Riverains') {
      # code...
      if ($donne[1]=='materiels') {
        $data['title'] = "Degat matériels RIVERAINS (CODE TICKET ".$ticket_code.")";
        $degat_dgpc=$this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>0));



        $datas = array();
        $i=1;
        foreach ($degat_dgpc as $row) {
            $sub_array = array();

            $mat=$this->Model->getOne('tk_materiel_endomage',array('MATERIEL_ENDO_CODE'=>$row['MATERIEL_ENDO_CODE']));           
           
           
            $sub_array[] =  $i;
            
            $sub_array[] = $mat['MATERIEL_ENDO_DESCR'];
            
            $datas[] = $sub_array;
            $i++;
        }
        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped table-hover table-condensed table-responsive">',
            'table_close' => '</table>'
        );

        $this->table->set_heading('No','DESCRIPTION MATERIEL');
        $this->table->set_template($template);
        $data['table'] = $datas;
         $data['breadcrumb'] = $this->make_bread->output();
      }
       if ($donne[1]=='Blesses') {

        $degat_dgpc_blesse=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>0,'STATUT_SANTE'=>0));
        $data['title'] ="Les blessés RIVERAINS (CODE TICKET ".$ticket_code.")";
 $datas = array();
        foreach ($degat_dgpc_blesse as $row) {
            $sub_array = array();

            $sub_array[] = $row['NOM_PRENOM'];
            $sub_array[] = $row['DATE_NAISSANCE'];
            $sub_array[] = $row['SEXE'];
            
           

            $datas[] = $sub_array;
        }
        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped table-hover table-condensed table-responsive">',
            'table_close' => '</table>'
        );

        $this->table->set_heading('NOM ET PRENOM','DATE DE NAISSANCE','SEXE');
        $this->table->set_template($template);
        $data['table'] = $datas;

      }

      if ($donne[1]=='Morts') {
        
        $degat_dgpc_blesse=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>0,'STATUT_SANTE'=>1));
        $data['title'] = "Les morts RIVERAINS (CODE TICKET ".$ticket_code.")";
 $datas = array();
        foreach ($degat_dgpc_blesse as $row) {
            $sub_array = array();

            $sub_array[] = $row['NOM_PRENOM'];
            $sub_array[] = $row['DATE_NAISSANCE'];
            $sub_array[] = $row['SEXE'];
            
           

            $datas[] = $sub_array;
        }
        $template = array(
            'table_open' => '<table id="mytable" class="table table-bordered table-striped table-hover table-condensed table-responsive">',
            'table_close' => '</table>'
        );

        $this->table->set_heading('NOM ET PRENOM','DATE DE NAISSANCE','SEXE');
        $this->table->set_template($template);
        $data['table'] = $datas;

      }
    }
  	
  	
    $data['breadcrumb'] = $this->make_bread->output();
  	 $this->load->view('caserne/Detail_rapport_view', $data);
  }

}