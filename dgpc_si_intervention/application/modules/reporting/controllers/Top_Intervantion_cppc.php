<?php 

	/**
	 * 
	 */
	class Top_Intervantion_cppc extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
		    $this->make_bread->add('Tableau de Bord', "Reporting/Dashboard", 0);
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
        
        // if ($this->input->post('YEAR')== NULL) {
			$YEAR = date('Y');
			// }
			// else{
			// $YEAR = $this->input->post('YEAR');
			// }
        $nombreetat= $this->Model->getRequete('SELECT DISTINCT (tk.CPPC_ID) AS CPPC_ID, (SELECT CPPC_NOM FROM rh_cppc WHERE CPPC_ID = tk.CPPC_ID) AS CPPC_NOM, (SELECT COUNT(TICKET_ID) FROM tk_ticket WHERE CPPC_ID = tk.CPPC_ID) AS Ninterv FROM `tk_ticket` tk WHERE tk.DATE_INTERVENTION LIKE '.'\'%'.''.$YEAR.'%\''.' order by Ninterv DESC limit 5');
        
		$TOP = 5;	
        $data['stitre']= "";
        $data['ytitre']= "Nombre";
        $data['nombreintervention']= "";
        $totalinterv = 0;
        foreach ($nombreetat as $key) {
        	$nombreinterventions=$this->Model->count_all_data('tk_ticket', array('CPPC_ID'=>$key['CPPC_ID'], 'DATE_INTERVENTION IS NOT NULL'));
        	$data['nombreintervention'] .="{y: ".$nombreinterventions.",name:'".$key['CPPC_NOM']."',key:'".$key['CPPC_NOM']."'},";
        	$totalinterv += $nombreinterventions;
        }

        $data['breadcrumb'] = $this->make_bread->output();
        $data['title'] = "Meilleur (ou mauvaise) perfomances";
        $year = $this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(DATE_INTERVENTION,"%Y") as yea FROM tk_ticket tk WHERE tk.DATE_INTERVENTION IS NOT NULL order by yea DESC');
        
        $data['data_annee'] = $year;
        $data['data_mois'] = array();
        $data['TY'] = $this->input->post('TY');
        $data['YEAR'] = $this->input->post('YEAR');
        $data['MOI'] = $this->input->post('MOI');
        $data['TRI'] = NULL;
        $data['ORD'] = 'ASC';
        $data['nombre'] = 5;
        $data['titre']= "Nombre d\'interventions";
        $data['labelt']="Intervetions";

        $data['totalinterv']=$totalinterv;
        
          $this->load->view('TopIntervantion_Cppc_View',$data);
		}

		public function filtre()
		{

			$TY = $this->input->post('TY');
			$nombre = $this->input->post('nombre');
			$ORD = $this->input->post('ORD');
			if ($this->input->post('YEAR')== NULL) {
			$YEAR = date('Y');
			}
			else{
			$YEAR = $this->input->post('YEAR');
			}

			if ($TY==1) {

			$nombreetat= $this->Model->getRequete('SELECT DISTINCT(tk.CPPC_ID) AS CPPC_ID, (SELECT CPPC_NOM FROM rh_cppc WHERE CPPC_ID = tk.CPPC_ID) AS CPPC_NOM, (SELECT COUNT(TICKET_ID) FROM tk_ticket WHERE CPPC_ID = tk.CPPC_ID) AS Ninterv FROM `tk_ticket` tk where tk.DATE_INTERVENTION LIKE '.'\'%'.''.$YEAR.'%\''.' order by Ninterv '.$ORD.' limit '.$nombre.'');

		$TOP = $nombre;	
        $data['stitre']= "";
        $data['ytitre']= "Nombre";
        $data['nombreintervention']= "";
        $totalinterv = 0;
        foreach ($nombreetat as $key) {
        	$data['nombreintervention'] .="{y: ".$key['Ninterv'].",name:'".$key['CPPC_NOM']."',key:'".$key['CPPC_NOM']."'},";
        $totalinterv += $key['Ninterv'];
        }
        


        $data['totalinterv']=$totalinterv;

        $data['YEAR'] = $this->input->post('YEAR');
        $data['MOI'] = $this->input->post('MOI');
        $data['TRI'] = NULL;
        $data['ORD'] = $ORD;
        $data['nombre'] = $nombre;
        $data['titre']= "Nombre d\'interventions";
        $data['labelt']="Intervetions";

			}
			elseif ($TY==2) {

			$nombreetat= $this->Model->getRequete('SELECT DISTINCT (tk.CPPC_ID) AS CPPC_ID, cp.CPPC_NOM, (SELECT count(STATUT_SANTE) FROM interv_odk_degat_humain WHERE CONCERNE_DGPC = 0 and STATUT_SANTE = 0 AND TICKET_CODE in (SELECT DISTINCT(TICKET_CODE) AS TICKET_CODE FROM tk_ticket WHERE CPPC_ID = tk.CPPC_ID AND DATE_INTERVENTION LIKE '.'\'%'.''.$YEAR.'%\''.' ) ) as civilb FROM `tk_ticket` tk JOIN rh_cppc cp ON cp.CPPC_ID = tk.CPPC_ID ORDER by civilb '.$ORD.' LIMIT '.$nombre.'');

		$TOP = $nombre;	
        $data['stitre']= "";
        $data['ytitre']= "Nombre";
        $data['nombreintervention']= "";
        $totalinterv = 0;
        foreach ($nombreetat as $key) {
        	$data['nombreintervention'] .="{y: ".$key['civilb'].",name:'".$key['CPPC_NOM']."',key:'".$key['CPPC_NOM']."'},";
        
        $totalinterv += $key['civilb'];
    }
        $data['totalinterv']=$totalinterv;
        $data['YEAR'] = $this->input->post('YEAR');
        $data['MOI'] = $this->input->post('MOI');
        $data['TRI'] = NULL;
        $data['ORD'] = $ORD;
        $data['nombre'] = $nombre;
        if ($ORD="ASC") {
        	$data['titre']= "".$TOP."  CPPC ayant eu beaucoup de blesse civile en ".$YEAR."";
        }
        else{
        	$data['titre']= "".$TOP."  CPPC ayant eu moins de blesse civile en ".$YEAR."";
        }
        
        $data['labelt']="Nombre de blessée civile";

			}
			elseif ($TY==3) {
			
			$nombreetat= $this->Model->getRequete('SELECT DISTINCT (tk.CPPC_ID) AS CPPC_ID, cp.CPPC_NOM, (SELECT count(STATUT_SANTE) FROM interv_odk_degat_humain WHERE CONCERNE_DGPC = 0 and STATUT_SANTE = 1 AND TICKET_CODE in (SELECT DISTINCT(TICKET_CODE) AS TICKET_CODE FROM tk_ticket WHERE CPPC_ID = tk.CPPC_ID AND DATE_INTERVENTION LIKE '.'\'%'.''.$YEAR.'%\''.' ) ) as civilb FROM `tk_ticket` tk JOIN rh_cppc cp ON cp.CPPC_ID = tk.CPPC_ID ORDER by civilb '.$ORD.' LIMIT '.$nombre.'');

		$TOP = $nombre;	
        $data['stitre']= "";
        $data['ytitre']= "Nombre";
        $data['nombreintervention']= "";
        $totalinterv = 0;
        foreach ($nombreetat as $key) {
        	$data['nombreintervention'] .="{y: ".$key['civilb'].",name:'".$key['CPPC_NOM']."',key:'".$key['CPPC_NOM']."'},";
        $totalinterv += $key['civilb'];
    }
        $data['totalinterv']=$totalinterv;
        $data['YEAR'] = $this->input->post('YEAR');
        $data['MOI'] = $this->input->post('MOI');
        $data['TRI'] = NULL;
        $data['ORD'] = $ORD;
        $data['nombre'] = $nombre;
        if ($ORD="ASC") {
        	$data['titre']= "".$TOP."  CPPC ayant eu beaucoup de morts civile en ".$YEAR."";
        }
        else{
        	$data['titre']= "".$TOP."  CPPC ayant eu moins de morts civile en ".$YEAR."";
        }
        
        $data['labelt']="Nombre de morts civile";

			}
			elseif ($TY==4) {

			$nombreetat= $this->Model->getRequete('SELECT DISTINCT (tk.CPPC_ID) AS CPPC_ID, cp.CPPC_NOM, (SELECT count(STATUT_SANTE) FROM interv_odk_degat_humain WHERE CONCERNE_DGPC = 1 and STATUT_SANTE = 0 AND TICKET_CODE in (SELECT DISTINCT(TICKET_CODE) AS TICKET_CODE FROM tk_ticket WHERE CPPC_ID = tk.CPPC_ID AND DATE_INTERVENTION LIKE '.'\'%'.''.$YEAR.'%\''.' ) ) as civilb FROM `tk_ticket` tk JOIN rh_cppc cp ON cp.CPPC_ID = tk.CPPC_ID ORDER by civilb '.$ORD.' LIMIT '.$nombre.'');

		$TOP = $nombre;	
        $data['stitre']= "";
        $data['ytitre']= "Nombre";
        $data['nombreintervention']= "";
        $totalinterv = 0;
        foreach ($nombreetat as $key) {
        	$data['nombreintervention'] .="{y: ".$key['civilb'].",name:'".$key['CPPC_NOM']."',key:'".$key['CPPC_NOM']."'},";
        $totalinterv += $key['civilb'];
    }
        $data['totalinterv']=$totalinterv;
        $data['YEAR'] = $this->input->post('YEAR');
        $data['MOI'] = $this->input->post('MOI');
        $data['TRI'] = NULL;
        $data['ORD'] = $ORD;
        $data['nombre'] = $nombre;
        if ($ORD="ASC") {
        	$data['titre']= "".$TOP."  CPPC ayant eu beaucoup de policiers blessée  en ".$YEAR."";
        }
        else{
        	$data['titre']= "".$TOP."  CPPC ayant eu moins de policiers blessée  en ".$YEAR."";
        }
        
        $data['labelt']="Nombre de policiers blessée ";

			}
			elseif ($TY==5) {
			
			$nombreetat= $this->Model->getRequete('SELECT DISTINCT (tk.CPPC_ID) AS CPPC_ID, cp.CPPC_NOM, (SELECT count(STATUT_SANTE) FROM interv_odk_degat_humain WHERE CONCERNE_DGPC = 1 and STATUT_SANTE = 1 AND TICKET_CODE in (SELECT DISTINCT(TICKET_CODE) AS TICKET_CODE FROM tk_ticket WHERE CPPC_ID = tk.CPPC_ID AND DATE_INTERVENTION LIKE '.'\'%'.''.$YEAR.'%\''.' ) ) as civilb FROM `tk_ticket` tk JOIN rh_cppc cp ON cp.CPPC_ID = tk.CPPC_ID ORDER by civilb '.$ORD.' LIMIT '.$nombre.'');

		$TOP = $nombre;	
        $data['stitre']= "";
        $data['ytitre']= "Nombre";
        $data['nombreintervention']= "";
        $totalinterv = 0;
        foreach ($nombreetat as $key) {
        	$data['nombreintervention'] .="{y: ".$key['civilb'].",name:'".$key['CPPC_NOM']."',key:'".$key['CPPC_NOM']."'},";
        $totalinterv += $key['civilb'];
        }
        $data['totalinterv']=$totalinterv;
        $data['YEAR'] = $this->input->post('YEAR');
        $data['MOI'] = $this->input->post('MOI');
        $data['TRI'] = NULL;
        $data['ORD'] = $ORD;
        $data['nombre'] = $nombre;
        if ($ORD="ASC") {
        	$data['titre']= "".$TOP."  CPPC ayant eu beaucoup de policiers morts  en ".$YEAR."";
        }
        else{
        	$data['titre']= "".$TOP."  CPPC ayant eu moins de policiers morts  en ".$YEAR."";
        }
        
        $data['labelt']="Nombre de policiers morts ";
			}

			// }
		$data['breadcrumb'] = $this->make_bread->output();
        $data['title'] = "Nombre d\'intervention";
        $year = $this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(DATE_INTERVENTION,"%Y") as yea FROM tk_ticket tk WHERE tk.DATE_INTERVENTION IS NOT NULL order by yea DESC');
        $data['data_annee'] = $year;
        $data['data_mois'] = array();
        $data['TY'] = $this->input->post('TY');
        
          $this->load->view('TopIntervantion_Cppc_View',$data);

			
			
		}

		

	}