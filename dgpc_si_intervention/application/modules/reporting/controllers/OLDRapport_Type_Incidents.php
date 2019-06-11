<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rapport_Type_Incidents extends CI_Controller
{

  public function __construct() {
        parent::__construct();
         
      }

  
  function index()
  {


     $data['datas']="[";
     $data['incid_total'] = 0;
     $incidents=$this->Model->getList('tk_categories');
     $data['cppc']= $this->Model->getList('rh_cppc',array());
     $annee= $this->input->post('annee');
     $mois= $this->input->post('mois');
     $cppc= $this->input->post('CPPC_ID');
     $data['date_max']= date('Y');
     $data['date_min']= date('Y') - 2;
     $data['annee']= "";
     $cond_mois= array();
     $cond_annee= array();
     $cond_cppc= array();


    if($annee != "" && $mois == "" && $cppc == "")
     {
     
 

      
      $data['titre']="Rapport de ".$annee;
      $cond_annee= "DATE_INSERTION LIKE '%$annee%'";
      $cond_mois= array();
      $cond_cppc= array();
      $data['annee']= $annee;
    
     }

    elseif($annee != "" && $mois != "" && $cppc == "")
     {


      
      $data['titre']="Rapport de ".$annee.", Mois de ".$mois;
      $cond_annee= "DATE_INSERTION LIKE '%$annee%'";
      $cond_mois= "DATE_INSERTION LIKE '%-$mois-%'";
      $cond_cppc= array();
      $data['annee']= $annee;
    
     }


    elseif($annee != "" && $mois != "" && $cppc != "")
     {

      
      $data['annee']= $annee;
      $cppcs=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$cppc));
      $data['titre']="Rapport de ".$annee.", Mois de ".$mois." pour le cppc".$cppcs['CPPC_DESCR'];
      $cond_annee= "DATE_INSERTION LIKE '%$annee%'";
      $cond_mois= "DATE_INSERTION LIKE '%-$mois-%'";
      $cond_cppc= "CPPC_ID = '$cppc'"; 

    
     }



    elseif($annee != "" && $mois == "" && $cppc != "")
     {

 
      $cppcs=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$cppc));
      $data['titre']="Rapport de ".$annee.", pour le cppc ".$cppcs['CPPC_DESCR'];
      $cond_annee= "DATE_INSERTION LIKE '%$annee%'";
      $cond_cppc= "CPPC_ID = '$cppc'"; 
      $cond_mois= array();

    
     }


    elseif($annee == "" && $mois == "" && $cppc != "")
     {


      $cppcs=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$cppc));
      $data['titre']="Rapport  pour le cppc ".$cppcs['CPPC_DESCR'];
      $cond_annee= array();
      $cond_cppc= "CPPC_ID = '$cppc'"; 
      $cond_mois= array();

    
     }



    elseif($annee == "" && $mois != "" && $cppc != "")
     {

     
      $cppcs=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$cppc));
      $data['titre']="Rapport  pour le cppc ".$cppcs['CPPC_DESCR'];
      $cond_mois= array();
      $cond_annee= array();
      $cond_cppc= "CPPC_ID = '$cppc'"; 
    
     }


     elseif($annee == "" && $mois == "" && $cppc == "")
     {
      $annee=date('Y');
      $data['annee']=$annee;
      $cond_annee= "DATE_INSERTION LIKE '%$annee%'";
      $data['titre']="Rapport sur les types d'incidents ";
      $cond_cppc= array(); 
      $cond_mois= array();

    
     }


     foreach ($incidents as $key => $value)

      {

      $nbr=$this->Model->record_countcriteres('tk_ticket',array('CATEGORIE_ID'=>$value['CATEGORIE_ID']),$cond_annee,$cond_mois,$cond_cppc);
      if($nbr>0)
      {

       $data['incid_total'] = $data['incid_total'] + $nbr;

       $var=str_replace("'", "\'", $value['CATEGORIE_DESCR']);
       $data['datas'].="{name:'".$var."',y:".$nbr.",key:".$value['CATEGORIE_ID']."},";

      }

       }

    $data['title']="";
    $data['datas'].="]";
    $data['CPPC_ID']= $this->input->post('CPPC_ID');
    $data['mois']= $this->input->post('mois');
    $data['annee']=$annee;
    $data['incid_total'] = number_format($data['incid_total'],0,"."," ");
    $this->load->view("Reporting_Type_Incident_View",$data);



  }
 

}