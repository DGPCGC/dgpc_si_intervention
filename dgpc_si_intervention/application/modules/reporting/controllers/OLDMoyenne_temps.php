<?php

 class Moyenne_temps extends MY_Controller
 {
  
  function __construct()
  {
    parent::__construct();
    $this->make_bread->add('Suivi', "reporting/Rapport_Intervation/index", 0);
    $this->breadcrumb = $this->make_bread->output();
  }


   
  public function index(){

  	  $data['cate']= $data["tickets"]="";
      $data['cppc']= $this->Model->getList('rh_cppc',array());
  	  if($this->input->post('cppc') == null && $this->input->post('annee') == null && $this->input->post('trimestre') == null && $this->input->post('mois') == null && $this->input->post('statut') == null){
  	  $annee= date('Y');
  	  $mois = date('m');
  	  if($mois < 4){
         $data['trim_s']= '1';  
  	  }else if($mois < 7 && $mois > 3){
          $data['trim_s']= '2';
  	  }else if($mois < 10 && $mois > 6){
          $data['trim_s']= '3';
  	  }else if($mois > 9){
          $data['trim_s']= '4';
  	  }

  	  $data['mois_trim']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INTERVENTION) = '".$annee."'",'MONTH(DATE_INTERVENTION)');

      $data['mois']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INTERVENTION) = '".$annee."'",'MONTH(DATE_INTERVENTION)');

  	  $data['year_s']= date('Y');
  	  $data['mois_s']= date('m'); 
      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INTERVENTION)');
      $data['statut']= $this->Model->getList('tk_statuts',array());

      $m= date('Y-m');
      $ticket= $this->Model->getList('tk_ticket',"DATE_INTERVENTION LIKE '%$m%'");

      if($ticket != null){
      foreach ($ticket as $k) {
      	  if($k['DATE_DEPART_LIEUX'] != NULL && $k['DATE_INTERVENTION'] != NULL){
             $depart= new DateTime($k['DATE_DEPART_LIEUX']);
             $int= new DateTime($k['DATE_INTERVENTION']);

      	  $diff= $depart->diff($int);
      	  if($diff->days > 0){
             $hour= $diff->h + ($diff->days*24);
      	  }else{
      	  	 $hour= $diff->h;
      	  }
      	  if($hour > 0){
                $hour_diff= $hour;
      	  }else{
      	  	  $hour_diff= 0;
      	  }
        }else{
             $hour_diff= 0;
        }

        $cppc= $this->Model->getOne('rh_cppc',array('CPPC_ID'=>$k['CPPC_ID']));
        if($cppc['CPPC_NOM'] != null){
      	   $data['cate'] .="'".$cppc['CPPC_NOM']."',";
      	   $data['tickets'] .= $hour_diff.",";
        }
      }
      }
 
      $data['year_s']= date('Y');
      $data['mois_s']= date('m');

      $data['cate'].= ",//";
      $data['cate']= str_replace(",//", "", $data['cate']);
      $data['tickets'].= ",//";
      $data['tickets']= str_replace(",//", "", $data['tickets']);

      }else{
      	  $data['statut_s']= "";
      	  $data['year_s']= "";
      	  $data['mois_s']= "";
      	  $data['trim_s'] = "";
      	  $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INTERVENTION)');
          $data['statut']= $this->Model->getList('tk_statuts',array());
      	  $annee= $this->input->post('annee');
      	  
      	  $cond_annee= date('Y');
      	  $cond_trim= array();
      	  $cond_mois= array();
      	  $cond_statut= array();
      	  if($this->input->post('annee') != null){
      	  	 $a= $this->input->post('annee');
             $cond_annee = "DATE_INTERVENTION LIKE '%$a%'";
             $data['year_s']= $this->input->post('annee');
             $data['mois']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INTERVENTION) = '".$annee."'",'MONTH(DATE_INTERVENTION)');

             $data['mois_trim']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INTERVENTION) = '".$annee."'",'MONTH(DATE_INTERVENTION)');
      	  }
      	  if($this->input->post('trimestre') != null){
      	  	 if($this->input->post('trimestre') == '1'){
               $cond_trim = 'MONTH(DATE_INTERVENTION) BETWEEN 1 AND 3';
             }else if($this->input->post('trimestre') == '2'){
               $cond_trim = 'MONTH(DATE_INTERVENTION) BETWEEN 4 AND 6';
             }else if($this->input->post('trimestre') == '3'){
               $cond_trim = 'MONTH(DATE_INTERVENTION) BETWEEN 7 AND 9';
             }else if($this->input->post('trimestre') == '4'){
               $cond_trim = 'MONTH(DATE_INTERVENTION) BETWEEN 10 AND 12';
             }
             $data['trim_s']= $this->input->post('trimestre');

             $data['mois_trim']= $this->Model->getListDistinct2('tk_ticket',$cond_trim,'MONTH(DATE_INTERVENTION)');
      	  }
      	  if($this->input->post('mois') != null){
             $cond_mois = "MONTH(DATE_INTERVENTION) = ".$this->input->post('mois');
             $data['mois_s']= $this->input->post('mois');
      	  }
      	  if($this->input->post('statut') != null){
             $cond_statut = array('STATUT_ID'=>$this->input->post('statut'));
             $data['statut_s']= $this->input->post('statut');
      	  }
          //print_r($cond_mois);

      if($this->input->post('cppc') == null){

      $ticket= $this->Model->getList_cond4('tk_ticket',$cond_annee,$cond_trim,$cond_mois,$cond_statut);

      if($ticket != null){
      foreach ($ticket as $k) {

          //print_r($k['CPPC_ID']);

      	  if($k['DATE_DEPART_LIEUX'] != NULL && $k['DATE_INTERVENTION'] != NULL){
             $depart= new DateTime($k['DATE_DEPART_LIEUX']);
             $int= new DateTime($k['DATE_INTERVENTION']);

      	  $diff= $depart->diff($int);
      	  if($diff->days > 0){
             $hour= $diff->h + ($diff->days*24);
      	  }else{
      	  	 $hour= $diff->h;
      	  }
      	  if($hour > 0){
                $hour_diff= $hour;
      	  }else{
      	  	  $hour_diff= 0;
      	  }
        }else{
            $hour_diff= 0;
        }

        $cppc= $this->Model->getOne('rh_cppc',array('CPPC_ID'=>$k['CPPC_ID']));
        if($cppc['CPPC_NOM'] != null){
           $data['cate'] .="'".$cppc['CPPC_NOM']."',";
           $data['tickets'] .= $hour_diff.",";
        }
      }
      }
      }else{
      	//print_r($this->input->post('cppc'));
      	  foreach($this->input->post('cppc') as $key => $value) {
             
            //$m= date('Y-m');
            //$ticket= $this->Model->getList('tk_ticket',"DATE_INTERVENTION LIKE '%$m%'");

      	  	  $ka= $this->Model->getList_cond5('tk_ticket',$cond_annee,$cond_trim,$cond_mois,$cond_statut,array('CPPC_ID'=>$value));
              foreach($ka as $k){
                  if($k['DATE_DEPART_LIEUX'] != NULL && $k['DATE_INTERVENTION'] != NULL){

             $depart= new DateTime($k['DATE_DEPART_LIEUX']);
             $int= new DateTime($k['DATE_INTERVENTION']);

          $diff= $depart->diff($int);
          if($diff->days > 0){
             $hour= $diff->h + ($diff->days*24);
          }else{
             $hour= $diff->h;
          }
          if($hour > 0){
                $hour_diff= $hour;
          }else{
              $hour_diff= 0;
          }
        }else{
           $hour_diff= 0;
        }
          $cppc= $this->Model->getOne('rh_cppc',array('CPPC_ID'=>$k['CPPC_ID']));
             $data['cate'] .="'".$cppc['CPPC_NOM']."',";
             $data['tickets'] .= $hour_diff.",";

              }
      	  }
      }
      }
      $data['title']="Moyenne de temps";
      $this->load->view('Moyenne_temps_view',$data);
  }

  public function get_trimestry(){
      $annee= $this->input->post('annee');
      $mois= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INTERVENTION) = '".$annee."'",'MONTH(DATE_INTERVENTION)');
      $data = "<option value=''>-sélectionner-</option>";
      $data.= "<option value='1'>1<sup>er</sup> trimestre</option>";

      foreach($mois as $m){
     if($m['year'] > 3){
     $data.= "<option value='2'>2<sup>ème</sup> trimestre</option>";
     }
     if($m['year'] > 6){
     $data.= "<option value='3'>3<sup>ème</sup> trimestre</option>";
     }
     if($m['year'] > 9){
     $data.= "<option value='4'>4<sup>ème</sup> trimestre</option>";
     }
    }
    echo $data;
  }

  public function get_mois(){

  }

  public function get_mois2(){
  	
  }
}