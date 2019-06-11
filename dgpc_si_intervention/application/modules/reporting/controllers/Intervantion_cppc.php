<?php 

	/**
	 * 
	 */
	class Intervantion_cppc extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
		    $this->make_bread->add('Nombre d\'intervations vs dégâts', "reporting/Intervantion_cppc", 0);
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
        
        $nombreetat= $this->Model->getList('rh_cppc');
        $data['titre']= "Nombre d\'intervetions";
        $data['stitre']= "";
        $data['ytitre']= "Nombre";
        $data['nombreintervention']= "";
        $data['nombreblesse']="";
        $data['nombremort']="";
        $data['Pnombreblesse']="";
        $data['Pnombremort']="";
        if ($this->input->post('YEAR')== NULL) {
			$YEAR = date('Y');
			}
			else{
			$YEAR = $this->input->post('YEAR');
			}
            $ttotalble = 0;
            $ttotalmort = 0;
            $tPtotalble = 0;
            $tPtotalmort = 0;
        foreach ($nombreetat as $key) {
        	$listeinterv = $this->Model->getRequete('SELECT DISTINCT (tk.TICKET_CODE) AS ticket, ( SELECT COUNT(STATUT_SANTE) FROM interv_odk_degat_humain WHERE STATUT_SANTE = 0 AND CONCERNE_DGPC = 0 AND TICKET_CODE = tk.TICKET_CODE ) AS Blesse, ( SELECT COUNT(STATUT_SANTE) FROM interv_odk_degat_humain WHERE STATUT_SANTE = 1 AND CONCERNE_DGPC = 0 AND TICKET_CODE = tk.TICKET_CODE ) AS Mort, ( SELECT COUNT(STATUT_SANTE) FROM interv_odk_degat_humain WHERE STATUT_SANTE = 0 AND CONCERNE_DGPC = 1 AND TICKET_CODE = tk.TICKET_CODE ) AS PBlesse, ( SELECT COUNT(STATUT_SANTE) FROM interv_odk_degat_humain WHERE STATUT_SANTE = 1 AND CONCERNE_DGPC = 1 AND TICKET_CODE = tk.TICKET_CODE ) AS PMort FROM `tk_ticket` tk where tk.CPPC_ID='.$key['CPPC_ID'].' AND DATE_INTERVENTION IS NOT NULL and tk.DATE_INTERVENTION LIKE "%'.$YEAR.'%"');
        	$totalble = 0;
        	$totalmort = 0;
        	$Ptotalble = 0;
        	$Ptotalmort = 0;
        	foreach ($listeinterv as $value) {
        		$totalble +=$value['Blesse'];
        		$totalmort +=$value['Mort'];
        		$Ptotalble +=$value['PBlesse'];
        		$Ptotalmort +=$value['PMort'];
        	}

        	$nombreinterventions=$this->Model->getRequeteOne('SELECT count(TICKET_ID) as nombreinterventions FROM `tk_ticket` WHERE DATE_INTERVENTION IS NOT NULL AND CPPC_ID = '.$key['CPPC_ID'].' ');
        	$data['nombreintervention'] .="{y: ".$nombreinterventions['nombreinterventions'].",name:'".$key['CPPC_NOM']."',key:'".$key['CPPC_NOM']."'},";
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

        $totalinterv=$this->Model->getRequeteOne('SELECT count(TICKET_ID) as tnombreinterventions FROM `tk_ticket` WHERE DATE_INTERVENTION IS NOT NULL');
        $data['totalinterv']=$totalinterv['tnombreinterventions'];

        
	    $year = $this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(DATE_INTERVENTION,"%Y") as yea FROM tk_ticket tk WHERE tk.DATE_INTERVENTION IS NOT NULL  order by yea DESC');
	    $data['data_annee'] = $year;
	    $data['lesnombres'] = array();
	    // $data['periodes'] =$periode;
        $data['breadcrumb'] = $this->make_bread->output();
        $data['title'] = "Nombre d'intervetions vs dégâts ";
          $this->load->view('Intervantion_Cppc_View',$data);
		}

		public function filtre()
		{
		
		$nombreetat= $this->Model->getList('rh_cppc');
        $data['titre']= "Nombre d\'intervetions";
        $data['stitre']= "";
        $data['ytitre']= "Nombre";
        $data['nombreintervention']= "";
        $data['nombreblesse']="";
        $data['nombremort']="";
        $data['Pnombreblesse']="";
        $data['Pnombremort']="";
        $MOIS = $this->input->post('MOIS');


        if ($this->input->post('YEAR')== NULL) {
			$YEAR = date('Y');
			}

			else{
			
			if ($this->input->post('MOIS')== NULL) {
				$YEAR = $this->input->post('YEAR');

		}
			else{
				if ($this->input->post('MOIS')<10) {
				$NMOIS= '0'.$this->input->post('MOIS');
				}
				else{
				$NMOIS= $this->input->post('MOIS');
				}
				$YEAR = $this->input->post('YEAR') .'-'. $NMOIS;
			}
			}
            $ttotalble = 0;
            $ttotalmort = 0;
            $tPtotalble = 0;
            $tPtotalmort = 0;
        foreach ($nombreetat as $key) {
        	$listeinterv = $this->Model->getRequete('SELECT DISTINCT
    (tk.TICKET_CODE) AS ticket,
    (SELECT COUNT(STATUT_SANTE) FROM interv_odk_degat_humain WHERE STATUT_SANTE = 0 AND CONCERNE_DGPC = 0 AND TICKET_CODE = tk.TICKET_CODE) AS Blesse,
(SELECT COUNT(STATUT_SANTE) FROM interv_odk_degat_humain WHERE STATUT_SANTE = 1 AND CONCERNE_DGPC = 0 AND TICKET_CODE = tk.TICKET_CODE) AS Mort,
(SELECT COUNT(STATUT_SANTE) FROM interv_odk_degat_humain WHERE STATUT_SANTE = 0 AND CONCERNE_DGPC = 1 AND TICKET_CODE = tk.TICKET_CODE) AS PBlesse,
(SELECT COUNT(STATUT_SANTE) FROM interv_odk_degat_humain WHERE STATUT_SANTE = 1 AND CONCERNE_DGPC = 1 AND TICKET_CODE = tk.TICKET_CODE) AS PMort
FROM
    `tk_ticket` tk
WHERE
    tk.CPPC_ID = '.$key['CPPC_ID'].' and tk.DATE_INTERVENTION LIKE "%'.$YEAR.'%" ');
        	$totalble = 0;
        	$totalmort = 0;
        	$Ptotalble = 0;
        	$Ptotalmort = 0;
        	foreach ($listeinterv as $value) {
        		$totalble +=$value['Blesse'];
        		$totalmort +=$value['Mort'];
        		$Ptotalble +=$value['PBlesse'];
        		$Ptotalmort +=$value['PMort'];
        	}

        	$nombreinterventions=$this->Model->getRequeteOne('SELECT count(TICKET_ID) as nombreinterventions FROM `tk_ticket` WHERE `DATE_INTERVENTION` LIKE "%'.$YEAR.'%" AND CPPC_ID = '.$key['CPPC_ID'].' ');
        	$data['nombreintervention'] .="{y: ".$nombreinterventions['nombreinterventions'].",name:'".$key['CPPC_NOM']."',key:'".$key['CPPC_NOM']."'},";
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

        $totalinterv=$this->Model->getRequeteOne('SELECT count(TICKET_ID) as tnombreinterventions FROM `tk_ticket` WHERE DATE_INTERVENTION IS NOT NULL and `DATE_INTERVENTION` LIKE "%'.$YEAR.'%"');
        $data['totalinterv']=$totalinterv['tnombreinterventions'];


        $YEAR = $this->input->post('YEAR');
	    $year = $this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(DATE_INTERVENTION,"%Y") as yea FROM tk_ticket tk WHERE tk.DATE_INTERVENTION IS NOT NULL  order by yea DESC');

	    $moi = $this->Model->getRequete('SELECT DISTINCT(MONTH(DATE_INTERVENTION)) as moi from tk_ticket WHERE YEAR(DATE_INTERVENTION) = '.$YEAR.' order by moi DESC');
	    $data['data_annee'] = $year;
	    $data['lesnombres'] = $moi;
        $data['breadcrumb'] = $this->make_bread->output();
        $data['title'] = "Nombre d'intervetions vs dégâts ";
        $data['YEAR'] = $this->input->post('YEAR');
        $data['MOIS'] = $this->input->post('MOIS');

          $this->load->view('Intervantion_Cppc_View',$data);
		}

		

	}