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
     $trimestre=$this->input->post('trimestre');
     $cond_mois= array();
     $cond_annee= array();
     $cond_cppc= array();
     $cond_trim=array();

    if($annee != "" && $mois == "" && $cppc == "" && $trimestre=="")
     {
     
 
      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INSERTION) = '".$annee."'",'MONTH(DATE_INSERTION)');

      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INSERTION)');
      
      $cond_annee= "DATE_INSERTION LIKE '%$annee%'";
      $cond_mois= array();
      $cond_cppc= array();
      $data['year_s']= $annee;
    
     }

    elseif($annee != "" && $mois != "" && $cppc == "" && $trimestre=="")
     {

      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INSERTION) = '".$annee."'",'MONTH(DATE_INSERTION)');

      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INSERTION)');
      
      $cond_annee= "DATE_INSERTION LIKE '%$annee%'";
      $cond_mois= "DATE_INSERTION LIKE '%-$mois-%'";
      $cond_cppc= array();
      $data['year_s']= $annee;
      $data['mois_s']= $mois;
    
     }


    elseif($annee != "" && $mois != "" && $cppc != "" && $trimestre=="")
     {


      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INSERTION) = '".$annee."'",'MONTH(DATE_INSERTION)');

      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INSERTION)');
      
      $cond_annee= "DATE_INSERTION LIKE '%$annee%'";
      $cond_mois= "DATE_INSERTION LIKE '%-$mois-%'";
      $cond_cppc= "CPPC_ID = '$cppc'";

      $data['year_s']= $annee;
      $data['mois_s']= $mois;

    
     }



    elseif($annee != "" && $mois == "" && $cppc != "" && $trimestre=="")
     {

      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INSERTION) = '".$annee."'",'MONTH(DATE_INSERTION)');

      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INSERTION)');
      
      $cond_annee= "DATE_INSERTION LIKE '%$annee%'";
      $cond_cppc= "CPPC_ID = '$cppc'"; 
      $cond_mois= array();

      $data['year_s']= $annee;
      $data['mois_s']= $mois;

    
     }


    elseif($annee == "" && $mois == "" && $cppc != "" && $trimestre=="")
     {

      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INSERTION) = '".$annee."'",'MONTH(DATE_INSERTION)');
      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INSERTION)');

      $cond_annee= array();
      $cond_cppc= "CPPC_ID = '$cppc'"; 
      $cond_mois= array();

      $data['year_s']= $annee;
      $data['mois_s']= $mois;

    
     }



    elseif($annee == "" && $mois != "" && $cppc != "" && $trimestre=="")
     {

      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INSERTION) = '".$annee."'",'MONTH(DATE_INSERTION)');

      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INSERTION)');
      $cond_mois= array();
      $cond_annee= array();
      $cond_cppc= "CPPC_ID = '$cppc'"; 

      $data['year_s']= $annee;
      $data['mois_s']= $mois;
    
     }



    elseif($annee == "" && $mois != "" && $cppc == "" && $trimestre=="")
     {

      $cond_mois= "DATE_INSERTION LIKE '%-$mois-%'";
      $annees=date('Y');
      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INSERTION) = '".$annees."'",'MONTH(DATE_INSERTION)');
      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INSERTION)');
      $cond_annee= "DATE_INSERTION LIKE '%$annees%'";
      $data['year_s']= $annees;
      $data['mois_s']= $mois;
      
    
     }


    elseif($annee != "" && $mois == "" && $cppc == "" && $trimestre!="")
     {

      if($trimestre == 1)
      {
         $data['trim_s']= '1'; 
         $cond_trim = 'MONTH(DATE_INSERTION) BETWEEN 1 AND 3'; 
      }

      if($trimestre == 2)
      {
          $data['trim_s']= '2';
          $cond_trim = 'MONTH(DATE_INSERTION) BETWEEN 4 AND 6';
      }


       if($trimestre == 3)
      {
          $data['trim_s']= '3';
          $cond_trim = 'MONTH(DATE_INSERTION) BETWEEN 7 AND 9';
      }

       if($trimestre == 4)
      {
        $data['trim_s']= '4';
        $cond_trim = 'MONTH(DATE_INSERTION) BETWEEN 10 AND 12';
      }

      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INSERTION) = '".$annee."'",'MONTH(DATE_INSERTION)');
      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INSERTION)');
      $cond_annee= "DATE_INSERTION LIKE '%$annee%'";
      $data['year_s']= $annee;
 
      
    
     }


    elseif($annee != "" && $mois == "" && $cppc != "" && $trimestre!="")
     {

      if($trimestre == 1)
      {
         $data['trim_s']= '1'; 
         $cond_trim = 'MONTH(DATE_INSERTION) BETWEEN 1 AND 3'; 
      }

      if($trimestre == 2)
      {
          $data['trim_s']= '2';
          $cond_trim = 'MONTH(DATE_INSERTION) BETWEEN 4 AND 6';
      }


       if($trimestre == 3)
      {
          $data['trim_s']= '3';
          $cond_trim = 'MONTH(DATE_INSERTION) BETWEEN 7 AND 9';
      }

       if($trimestre == 4)
      {
        $data['trim_s']= '4';
        $cond_trim = 'MONTH(DATE_INSERTION) BETWEEN 10 AND 12';
      }

      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INSERTION) = '".$annee."'",'MONTH(DATE_INSERTION)');
      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INSERTION)');
      $cond_annee= "DATE_INSERTION LIKE '%$annee%'";
      $cond_cppc= "CPPC_ID = '$cppc'"; 
      $data['year_s']= $annee;
      
    
     }


    elseif($annee != "" && $mois != "" && $cppc == "" && $trimestre!="")
     {


      if($trimestre == 1)
      {
         $data['trim_s']= '1'; 
         $cond_trim = 'MONTH(DATE_INSERTION) BETWEEN 1 AND 3'; 
      }

      if($trimestre == 2)
      {
          $data['trim_s']= '2';
          $cond_trim = 'MONTH(DATE_INSERTION) BETWEEN 4 AND 6';
      }


       if($trimestre == 3)
      {
          $data['trim_s']= '3';
          $cond_trim = 'MONTH(DATE_INSERTION) BETWEEN 7 AND 9';
      }

       if($trimestre == 4)
      {
        $data['trim_s']= '4';
        $cond_trim = 'MONTH(DATE_INSERTION) BETWEEN 10 AND 12';
      }

      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INSERTION) = '".$annee."'",'MONTH(DATE_INSERTION)');
      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INSERTION)');
      $cond_annee= "DATE_INSERTION LIKE '%$annee%'";
      $data['year_s']= $annee;
      $data['mois_s']= "";
      
    
     }


      elseif($annee != "" && $mois != "" && $cppc != "" && $trimestre!="")
     {


      if($trimestre == 1)
      {
         $data['trim_s']= '1'; 
         $cond_trim = 'MONTH(DATE_INSERTION) BETWEEN 1 AND 3'; 
      }

      if($trimestre == 2)
      {
          $data['trim_s']= '2';
          $cond_trim = 'MONTH(DATE_INSERTION) BETWEEN 4 AND 6';
      }


       if($trimestre == 3)
      {
          $data['trim_s']= '3';
          $cond_trim = 'MONTH(DATE_INSERTION) BETWEEN 7 AND 9';
      }

       if($trimestre == 4)
      {
        $data['trim_s']= '4';
        $cond_trim = 'MONTH(DATE_INSERTION) BETWEEN 10 AND 12';
      }

      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INSERTION) = '".$annee."'",'MONTH(DATE_INSERTION)');
      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INSERTION)');
      $cond_annee= "DATE_INSERTION LIKE '%$annee%'";
      $cond_cppc= "CPPC_ID = '$cppc'"; 
      $data['year_s']= $annee;
      $data['mois_s']= "";

      
    
     }




    elseif($annee == "" && $mois == "" && $cppc != "" && $trimestre!="")
     {

      $annees=date('Y');

      $max_mois = $this->Model->getRequete('SELECT MAX(DATE_FORMAT(DATE_INSERTION,"%m")) as max_month FROM tk_ticket WHERE DATE_INSERTION LIKE "%'.$annees.'%"  order by max_month DESC');
      $mois_max=0;
      foreach ($max_mois as $key => $value)
       {
         
         $mois_max=$value['max_month'];

       }

     
      $data['year_s']=$annees;
      $data['mois_s']= $mois_max;
      $cond_annee= "DATE_INSERTION LIKE '%$annees%'";
      $cond_mois= "DATE_INSERTION LIKE '%-$mois_max-%'";
      $data['titre']="Rapport sur les types d'incidents ";
      $cond_cppc= "CPPC_ID = '$cppc'"; 
      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INSERTION) = '".$annees."'",'MONTH(DATE_INSERTION)');

      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INSERTION)');

   

    
     }




     elseif($annee == "" && $mois == "" && $cppc == "" && $trimestre=="")
     {

      $annees=date('Y');
      $max_mois = $this->Model->getRequete('SELECT MAX(DATE_FORMAT(DATE_INSERTION,"%m")) as max_month FROM tk_ticket WHERE DATE_INSERTION LIKE "%'.$annees.'%"  order by max_month DESC');
      $mois_max=0;
      foreach ($max_mois as $key => $value)
       {
         
         $mois_max=$value['max_month'];

       }

      $data['mois_s']= $mois_max;
      $data['year_s']=$annees;
      $cond_annee= "DATE_INSERTION LIKE '%$annees%'";
      $cond_mois= "DATE_INSERTION LIKE '%-$mois_max-%'";
      $data['titre']="Rapport sur les types d'incidents ";
      $cond_cppc= array(); 
      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INSERTION) = '".$annees."'",'MONTH(DATE_INSERTION)');

      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INSERTION)');

    
     }





     foreach ($incidents as $key => $value)

      {

      $nbr=$this->Model->record_countcriteres('tk_ticket',array('CATEGORIE_ID'=>$value['CATEGORIE_ID']),$cond_annee,$cond_mois,$cond_cppc,$cond_trim);
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
    $data['incid_total'] = number_format($data['incid_total'],0,"."," ");
    $this->load->view("Reporting_Type_Incident_View",$data);



  }
 

}