<?php 

	/**
	 * 
	 */
	class Dashboard extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
		    $this->make_bread->add('Tableau de Bord', "reporting/Dashboard", 0);
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
		    $month = $this->input->post('MOIS');

            $my_month = '';
		    $lesMois = $this->Model->getMois();
		         $i =0;
		        foreach ($lesMois as $mois) {
		           $date = $mois['mois'].'-'.date('d');
		           $une_date = new DateTime($date);
		           $periode[$une_date->format('Y-m')] = $une_date->format('M/Y');
		           
		           if($i<1) 
		             $my_month= $une_date->format('Y-m');
		           $i++;
		        }

		    $month_year = !empty($month)?$my_month:$month;
            

		  $les_causes = $this->Model->getList('tk_causes');
          $array_cause = '';
		  foreach ($les_causes as $cause) {
		  	$tickets = $this->Model->getDate('tk_ticket',"DATE_INSERTION LIKE '%$month_year%'",array('CAUSE_ID'=>$cause['CAUSE_ID']));
		  	$array_cause .="{name:'".str_replace("'", "\'", $cause['CAUSE_DESCR'])."[".count($tickets)."]',y:".count($tickets)."},"; 
		  }

		  $array_cause .="//";
		  $array_cause = str_replace(',//', '', $array_cause);


		  $les_canaux = $this->Model->getList('tk_canal');
          $array_canal = '';
		  foreach ($les_canaux as $canal) {
		  	$tickets = $this->Model->getDate('tk_ticket',"DATE_INSERTION LIKE '%$month_year%'",array('CANAL_ID'=>$canal['CANAL_ID']));
		  	$array_canal .="{name:'".str_replace("'", "\'", $canal['CANAL_DESCR'])."[".count($tickets)."]',y:".count($tickets)."},"; 
		  }

		  $array_canal .="//";
		  $array_canal = str_replace(',//', '', $array_canal);
		  /*Les effets des tickets*/
          
		  $causes = $this->Model->getList('tk_causes');
          
          $array_effet_mort = "{name:'Mort',data:[";
          $array_effet_blesse = "{name:'Bléssé(e)s',data:[";
          $category ='';

		  foreach ($causes as $cause) {
		  	$cause_descr = str_replace("'", "\'", $cause['CAUSE_DESCR']);
		  	$category .="'".$cause_descr."',";
		  	$effet = $this->Model->sum_effet_tk('tk_ticket',"DATE_INSERTION LIKE '%$month_year%'",array('CAUSE_ID'=>$cause['CAUSE_ID']));
            
             $nb_mrt= ($effet['nb_mort'] >0)?$effet['nb_mort']:0;
             $nb_bls= ($effet['nb_blesse']>0)?$effet['nb_blesse']:0;

		  	$array_effet_mort .= $nb_mrt.","; 
		  	$array_effet_blesse .= $nb_bls.","; 
		  }

		  $category .="//";
		  $category = str_replace(',//', '', $category);

		  $array_effet_blesse .="//";
		  $array_effet_blesse = str_replace(',//', ']}', $array_effet_blesse);

		  $array_effet_mort .="//";
		  $array_effet_mort = str_replace(',//', ']}', $array_effet_mort);

		  $data['category'] = $category;
		  $data['effets'] = $array_effet_blesse.','.$array_effet_mort;
          
          $data['serieCanal'] = $array_canal;
          $data['serieCause'] = $array_cause;

          //Le rapport des nombres de morts & blessés par type
          
          $types = $this->Model->getList('tk_categories');

          $typ_effet_mort = "{name:'Mort',data:[";
          $typ_effet_blesse = "{name:'Bléssé(e)s',data:[";
          $category_typ ='';

		  foreach ($types as $type) {
		  	$category_typ .="'".str_replace("'", "\'", $type['CATEGORIE_DESCR'])."',";
		  	$effet = $this->Model->sum_effet_tk('tk_ticket',"DATE_INSERTION LIKE '%$month_year%'",array('CATEGORIE_ID'=>$type['CATEGORIE_ID']));
            
             $nb_mrt= ($effet['nb_mort'] >0)?$effet['nb_mort']:0;
             $nb_bls= ($effet['nb_blesse']>0)?$effet['nb_blesse']:0;

		  	$typ_effet_mort .= $nb_mrt.","; 
		  	$typ_effet_blesse .= $nb_bls.","; 
		  }
		  $category_typ .="//";
		  $category_typ = str_replace(',//', '', $category_typ);

		  $typ_effet_blesse .="//";
		  $typ_effet_blesse = str_replace(',//', ']}', $typ_effet_blesse);

		  $typ_effet_mort .="//";
		  $typ_effet_mort = str_replace(',//', ']}', $typ_effet_mort);

		  $data['category_typ'] = $category_typ;
		  $data['effets_type'] = $typ_effet_blesse.','.$typ_effet_mort;

		  //Dégats Humains et materiels cote DGPC
		   
          $typ_dgpc_mort = "{name:'Mort',key:1,data:[";
          $typ_dgpc_blesse = "{name:'Bléssé(e)s',key:0,data:[";
          
		  foreach ($types as $type) {
		  	$effet_mort = $this->Model->sum_effet_tk_dgpc(array('dhd.STATUT_SANTE'=>1,'dhd.CONCERNE_DGPC'=>1,'tt.CATEGORIE_ID'=>$type['CATEGORIE_ID']));
		  	$effet_blesse = $this->Model->sum_effet_tk_dgpc(array('dhd.STATUT_SANTE'=>0,'dhd.CONCERNE_DGPC'=>1,'tt.CATEGORIE_ID'=>$type['CATEGORIE_ID']));
            
            $nb_mrt= ($effet_mort['nb_info'] >0)?$effet_mort['nb_info']:0;
            $nb_bls= ($effet_blesse['nb_info']>0)?$effet_blesse['nb_info']:0;

		  	$typ_dgpc_mort .= $nb_mrt.","; 
		  	$typ_dgpc_blesse .= $nb_bls.","; 
		  }
		  
		  $typ_dgpc_blesse .="//";
		  $typ_dgpc_blesse = str_replace(',//', ']}', $typ_dgpc_blesse);

		  $typ_dgpc_mort .="//";
		  $typ_dgpc_mort = str_replace(',//', ']}', $typ_dgpc_mort);

		  $data['effets_dgpc'] = $typ_dgpc_blesse.','.$typ_dgpc_mort;
          
		  $data['breadcrumb'] = $this->make_bread->output();
          $data['title'] = "Tableau de bord";
          $data['periodes'] =$periode;
          $data['MOIS'] =$month_year;
          
          $this->load->view('Dashboard_View',$data);
		}

		public function get_humain_dgpc()
		{
		
		}

	}