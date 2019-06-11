<?php 

	/**
	 * 
	 */
	class Cppc_Intervantion extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();

       }


		public function index()
		{
        
        $nombreetat= $this->Model->getList('rh_cppc');
        $data['titre']= "Nombre d\'interventions";
        $data['stitre']= "";
        $data['ytitre']= "Nombre";
        $data['nombreintervention']= "";
        $data['nombreblesse']="";
        $data['nombremort']="";
        $data['Pnombreblesse']="";
        $data['Pnombremort']="";
        
        $ttotalble = 0;
        $ttotalmort = 0;
        $tPtotalble = 0;
        $tPtotalmort = 0;

       $annee= $this->input->post('annee');
       $mois= $this->input->post('mois');
       $trimestre=$this->input->post('trimestre');
       $cond_mois= array();
       $cond_annee= array();
       $cond_trim=array();

        if($trimestre == 1)
        {
           $data['trim_s']= '1'; 
           $cond_trim = 'MONTH(DATE_INTERVENTION) BETWEEN 1 AND 3'; 
            $tri='1 èr trimestre';
        }

        if($trimestre == 2)
        {
            $data['trim_s']= '2';
            $cond_trim = 'MONTH(DATE_INTERVENTION) BETWEEN 4 AND 6';
            $tri='2è trimestre';
        }


         if($trimestre == 3)
        {
            $data['trim_s']= '3';
            $cond_trim = 'MONTH(DATE_INTERVENTION) BETWEEN 7 AND 9';
            $tri='3è trimestre';
        }

         if($trimestre == 4)
        {
          $data['trim_s']= '4';
          $cond_trim = 'MONTH(DATE_INTERVENTION) BETWEEN 10 AND 12';
          $tri='4è trimestre';
        }



      if($annee == "" && $mois == ""  && $trimestre=="")
        {

      $annees=date('Y');
      $max_mois = $this->Model->getRequete('SELECT MAX(DATE_FORMAT(DATE_INTERVENTION,"%m")) as max_month FROM tk_ticket WHERE DATE_INTERVENTION LIKE "%'.$annees.'%"  order by max_month DESC');
      $mois_max=0;
      foreach ($max_mois as $key => $value)
       {
         
        $mois_max=$value['max_month'];

       }

      $data['mois_s']= "";
      $data['year_s']=$annees;
      $cond_annee= "DATE_INTERVENTION LIKE '%$annees%'";
      // $cond_mois= "DATE_INTERVENTION LIKE '%-$mois_max-%'";
      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INTERVENTION) = '".$annees."'",'MONTH(DATE_INTERVENTION)');
      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INTERVENTION)');


       }



    elseif($annee != "" && $mois == ""  && $trimestre=="")
     {  
 
      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INTERVENTION) = '".$annee."'",'MONTH(DATE_INTERVENTION)');

      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INTERVENTION)');
      
      $cond_annee= "DATE_INTERVENTION LIKE '%$annee%'";
      $data['year_s']= $annee;



      }


    elseif($annee != ""  && $trimestre!="" && $mois == "")
     {

     
      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INTERVENTION) = '".$annee."'",'MONTH(DATE_INTERVENTION)');

      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INTERVENTION)');
      
      $cond_annee= "DATE_INTERVENTION LIKE '%$annee%'";
      $data['year_s']= $annee;


      }


    elseif($annee != ""  && $trimestre=="" && $mois != "")
     {

     
      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INTERVENTION) = '".$annee."'",'MONTH(DATE_INTERVENTION)');

      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INTERVENTION)');
      
      $cond_annee= "DATE_INTERVENTION LIKE '%$annee%'";
      $cond_mois= "DATE_INTERVENTION LIKE '%-$mois-%'";
      $data['year_s']= $annee;
      $data['mois_s']= $mois;


      }


    elseif($annee != ""  && $trimestre!="" && $mois != "")
     {

     
      $data['moiss']= $this->Model->getListDistinct2('tk_ticket',"YEAR(DATE_INTERVENTION) = '".$annee."'",'MONTH(DATE_INTERVENTION)');

      $data['year']= $this->Model->getListDistinct2('tk_ticket',array(),'YEAR(DATE_INTERVENTION)');
      
      $cond_annee= "DATE_INTERVENTION LIKE '%$annee%'";
      $cond_mois= array();
      $data['year_s']= $annee;
      $data['mois_s']= ' ';


      }

        $totalintervention = 0;

        foreach ($nombreetat as $key)
         {

          $ticket=$this->Model->getList2('tk_ticket',array('CPPC_ID'=>$key['CPPC_ID']),$cond_annee,$cond_trim,$cond_mois);
          $totalintervention = $totalintervention + sizeof($ticket);

        	$totalble = 0;
        	$totalmort = 0;
        	$Ptotalble = 0;
        	$Ptotalmort = 0;


        	foreach ($ticket as $value)
           {

           $nbr_blesse=$this->Model->record_countcriteres('interv_odk_degat_humain',array('TICKET_CODE'=>$value['TICKET_CODE'],'STATUT_SANTE'=>0,'CONCERNE_DGPC'=>0),array(),array(),array(),array());
           $nbr_mort=$this->Model->record_countcriteres('interv_odk_degat_humain',array('TICKET_CODE'=>$value['TICKET_CODE'],'STATUT_SANTE'=>1,'CONCERNE_DGPC'=>0),array(),array(),array(),array());
           $nbr_poli_bl=$this->Model->record_countcriteres('interv_odk_degat_humain',array('TICKET_CODE'=>$value['TICKET_CODE'],'STATUT_SANTE'=>0,'CONCERNE_DGPC'=>1),array(),array(),array(),array());

           $nbr_poli_mort=$this->Model->record_countcriteres('interv_odk_degat_humain',array('TICKET_CODE'=>$value['TICKET_CODE'],'STATUT_SANTE'=>1,'CONCERNE_DGPC'=>1),array(),array(),array(),array());

        		$totalble +=$nbr_blesse;
        		$totalmort +=$nbr_mort;
        		$Ptotalble +=$nbr_poli_bl;
        		$Ptotalmort +=$nbr_poli_mort;
        	}

        	$data['nombreintervention'] .="{y: ".sizeof($ticket).",name:'".$key['CPPC_NOM']."',key:'".$key['CPPC_NOM']."'},";
        	$data['nombreblesse'] .="{y: ".$totalble.",name:'".$key['CPPC_NOM']."',key:'".$key['CPPC_NOM']."'},";
        	$data['nombremort'] .="{y: ".$totalmort.",name:'".$key['CPPC_NOM']."',key:'".$key['CPPC_NOM']."'},";
        	$data['Pnombreblesse'] .="{y: ".$Ptotalble.",name:'".$key['CPPC_NOM']."',key:'".$key['CPPC_NOM']."'},";
        	$data['Pnombremort'] .="{y: ".$Ptotalmort.",name:'".$key['CPPC_NOM']."',key:'".$key['CPPC_NOM']."'},";

            $ttotalble += $totalble;
            $ttotalmort += $totalmort;
            $tPtotalble += $Ptotalble;
            $tPtotalmort += $Ptotalmort;

            $data['ttotalble']=$ttotalble;
            $data['ttotalmort']=$ttotalmort;
            $data['tPtotalble']=$tPtotalble;
            $data['tPtotalmort']=$tPtotalmort;

        }

      $data['totalinterv']=$totalintervention ;
      $data['title'] = "Nombre d'interventions vs dégâts ";
      $this->load->view('Intervantion_Cppc_View_New',$data);
		}

	
		
	}