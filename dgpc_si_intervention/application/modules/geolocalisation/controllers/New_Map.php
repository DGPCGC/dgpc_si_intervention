<?php 

	/**
	* 
	*/
	class New_Map extends CI_Controller
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

    function index(){
      
     if($this->mylibrary->get_permission('New_Map/index') ==0){
      redirect(base_url());
     }
     
			$PROVINCE_ID = $this->input->post('PROVINCE_ID');
			$CPPC_ID = $this->input->post('CPPC_ID');
			$OUV=$this->input->post('OUV');
	        $INT=$this->input->post('INT');
	        $CLO=$this->input->post('CLO');
	        $ATT=$this->input->post('ATT');
	        $FAA=$this->input->post('FAA');
	        $select_OUV='';
            $select_INT='';
            $select_CLO='';
            $select_ATT='';
            $select_FAA='';

            $count_statut1=NULL;
	        $count_statut2=NULL;
	        $count_statut3=NULL;
	        $count_statut4=NULL;
	        $count_statut5=NULL;

			$tab_coordonne='-3.2587478,29.3658475';
			$center=12;
			$tab_Infos='';

			$array[]='';
			$rh_cppc=NULL;
			$table_cppc='';
			$divaffich=0;

			if($PROVINCE_ID>0){

				$array['PROVINCE_ID'] =$PROVINCE_ID;
				$rh_cppc = $this->Model->getList('rh_cppc',$array);

			if($CPPC_ID>0){
					$divaffich=1;
					$criteresnew=' CPPC_ID = '.$CPPC_ID;

	          foreach ($rh_cppc as $casernes) {

	          $OUV=$this->input->post('OUV');
	          $INT=$this->input->post('INT');
	          $CLO=$this->input->post('CLO');
	          $ATT=$this->input->post('ATT');
	          $FAA=$this->input->post('FAA');

          $condition='';
          if(!isset($OUV) && !isset($INT) && !isset($CLO) && !isset($ATT) && !isset($FAA) ){
             
            $condition=' CPPC_ID='.$casernes['CPPC_ID'];

            $select_FAA='checked';
            $select_OUV='checked';
            $select_INT='checked';
            $select_CLO='checked';
            $select_ATT='checked';
          }

          if(isset($OUV)){
            
            $select_OUV='checked';
            $value=1;
            $crit_cnl = " STATUT_ID =1 ";
            $condition='';
            
            if(!empty($condition)){
               $condition .= " OR ".$crit_cnl;
               
            }else{
               $condition .= $crit_cnl;

            }
            }

            if(isset($INT)){
            
            $select_INT='checked';
            $value=2;
            $crit_cnl = " STATUT_ID =2 ";
             
            if(!empty($condition)){
               $condition .= " OR ".$crit_cnl;
               
            }else{
               $condition .= $crit_cnl;

            }
            }

            if(isset($CLO)){
            
            $select_CLO='checked';
            $value=2;
            $crit_cnl = " STATUT_ID =3 ";
             
            if(!empty($condition)){
               $condition .= " OR ".$crit_cnl;
               
            }else{
               $condition .= $crit_cnl;

            }
            }

            if(isset($ATT)){
            
            $select_ATT='checked';
            $value=2;
            $crit_cnl = " STATUT_ID =4 ";
             
            if(!empty($condition)){
               $condition .= " OR ".$crit_cnl;
               
            }else{
               $condition .= $crit_cnl;

            }
            }

            if(isset($FAA)){
            
            $select_FAA='checked';
            $value=2;
            $crit_cnl = " STATUT_ID =5 ";
             
            if(!empty($condition)){
               $condition .= " OR ".$crit_cnl;
               
            }else{
               $condition .= $crit_cnl;

            }
            }
           
            $requete='SELECT *FROM tk_ticket WHERE MODE_GET_INFO=0 AND CPPC_ID='.$CPPC_ID.' AND ('.$condition.')';
            $tk1=$this->Model->getRequete($requete);
           // echo $requete;

            $nb_dgm=0;
            $nb_dgm2=0;
            $nombrdgpc=0;
            $nombrpopul=0;
            $nombrdghum=0;
            $nombrdghum2=0;
            $nb_peu_bless=0;
            $nb_pe_morts=0;    
            $nb_dgpc_bless=0;
            $nb_dgpc_morts=0;

            $nbint=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM tk_ticket WHERE MODE_GET_INFO=0 AND CPPC_ID="'.$casernes['CPPC_ID'].'";');

            $count_statut1=$this->Model->querysqlOne('SELECT COUNT(*) statut_un FROM tk_ticket WHERE MODE_GET_INFO=0 AND STATUT_ID = 1 AND '.$criteresnew.' ');
            $count_statut2=$this->Model->querysqlOne('SELECT COUNT(*) statut_un FROM tk_ticket WHERE MODE_GET_INFO=0 AND STATUT_ID = 2 AND '.$criteresnew.' ');
            $count_statut3=$this->Model->querysqlOne('SELECT COUNT(*) statut_un FROM tk_ticket WHERE MODE_GET_INFO=0 AND STATUT_ID = 3 AND '.$criteresnew.' ');
            $count_statut4=$this->Model->querysqlOne('SELECT COUNT(*) statut_un FROM tk_ticket WHERE MODE_GET_INFO=0 AND STATUT_ID = 4 AND '.$criteresnew.' ');
            $count_statut5=$this->Model->querysqlOne('SELECT COUNT(*) statut_un FROM tk_ticket WHERE MODE_GET_INFO=0 AND STATUT_ID = 5 AND '.$criteresnew.' ');

             

          foreach ($tk1 as $key_tic) {
            # code... 


          $nb_peuple_blesses=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=0 AND `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_peu_bless=$nb_peu_bless+$nb_peuple_blesses['nb_peuple'];

          $nb_peuple_morts=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=1 AND `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_pe_morts=$nb_pe_morts+$nb_peuple_morts['nb_peuple'];

          $nb_police_blesses=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=0 AND `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_dgpc_bless=$nb_dgpc_bless+$nb_police_blesses['nb_peuple'];

          $nb_police_morts=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=1 AND `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_dgpc_morts=$nb_dgpc_morts+$nb_police_morts['nb_peuple'];

          $nb_matdgppc=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_materiel WHERE `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_dgm=$nb_dgm+$nb_matdgppc['nb_peuple'];

          $nb_matpopulation=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_materiel WHERE `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_dgm2=$nb_dgm2+$nb_matpopulation['nb_peuple'];
 
          $rh_cppc_manager=$this->Model->getOne('rh_cppc_manager',array('CPPC_ID'=>$casernes['CPPC_ID']));
          $rh_cppcx=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$casernes['CPPC_ID']));
          $provin=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$rh_cppcx['PROVINCE_ID']));
          $rh_personnel_dgpc=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$rh_cppc_manager['PERSONNEL_ID']));

          $nb_peuple_blesse=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=0 AND `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');

          $nb_peuple_mort=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=1 AND `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');

          $nb_police_blesse=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=0 AND `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');

          $nb_police_mort=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=1 AND `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');

           $MarkerIcon='';
          if($key_tic['STATUT_ID']==1){
            $MarkerIcon=base_url().'assets/bootstrap/care/carered1.jpg';
          }
          if($key_tic['STATUT_ID']==2){
            $MarkerIcon=base_url().'assets/bootstrap/care/carejaune.jpg';
          }
          if($key_tic['STATUT_ID']==3){
            $MarkerIcon=base_url().'assets/bootstrap/care/caregreen.jpg';
          }
          if($key_tic['STATUT_ID']==4){
            $MarkerIcon=base_url().'assets/bootstrap/care/caregreee.jpg';
          }
          if($key_tic['STATUT_ID']==5){
            $MarkerIcon=base_url().'assets/bootstrap/care/caredgpc2.jpg';
          }
          

           $nomcppc=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$CPPC_ID));

          $tab_Infos = $tab_Infos . $nomcppc['CPPC_NOM'].'<>'.$key_tic['TICKET_DESCR']. '<>' . $key_tic['LATITUDE'] . '<>' . $key_tic['LONGITUDE'] . '<>' . $MarkerIcon .'<>'.$key_tic['TICKET_DECLARANT_TEL'].'<>N/A<>'.$provin['PROVINCE_NAME'].'<>'.$nb_peuple_blesse['nb_peuple'].'<>'.$nb_peuple_mort['nb_peuple'].'<>'.$nb_police_blesse['nb_peuple'].'<>'.$nb_police_mort['nb_peuple'].'<>'.$key_tic['TICKET_DESCR'].'<>'.$key_tic['DATE_INSERTION'].'<>'.$key_tic['TICKET_DECLARANT'].'&&';

         // $tab_coordonne =$key_tic['LATITUDE'].",".$key_tic['LONGITUDE'];
          $center=12;
               
          }

          $dispo=0;
          $matdispo=$this->Model->querysqlOne('SELECT SUM(QUANTITE_DISPONIBLE) matdispo FROM interv_materiaux WHERE `CPPC_ID`="'.$casernes['CPPC_ID'].'"');
          if(empty($matdispo['matdispo'])){
           $dispo=0;
          }else{
            $dispo=$matdispo['matdispo'];
          }
















					 $table_cppc='<div class="table-responsive"><table id="mytables" class="table table-bordered table-stripped table-hover table-condensed table-responsive">
                             <thead>
                        <tr>
                        <th rowspan="3">CPPC</th>
                        <th  colspan="2">Dégâts matériels</th>
                        <th colspan="4">Dégâts humains</th>
                         
                        </tr>
                        <tr>
                         
                        <th rowspan="2">CPPC</th>
                        <th rowspan="2">Pop.</th>
                        

                        <th colspan="2">CPPC</th>
                        <th  colspan="2">Pop.</th>
                        </tr>

                        <tr>
                        
                        <th>Blessé</th>
                        <th>Mort</th>
                        <th>Blessé</th>
                        <th>Mort</th>
                         
                        </tr> </thead>';

          foreach ($rh_cppc as $casernes) {

          $tk_ticket=$this->Model->getList('tk_ticket',array('CPPC_ID'=>$casernes['CPPC_ID'],'MODE_GET_INFO'=>0));
          $nb_dgm=0;
          $nb_dgm2=0;
          $nombrdgpc=0;
          $nombrpopul=0;
          $nombrdghum=0;
          $nombrdghum2=0;
          $nb_peu_bless=0;
          $nb_pe_morts=0;    
          $nb_dgpc_bless=0;
          $nb_dgpc_morts=0;

          $nbint=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM tk_ticket WHERE MODE_GET_INFO=0 AND CPPC_ID="'.$casernes['CPPC_ID'].'";');

          foreach ($tk_ticket as $key_tic) {
            # code...       
          $nb_peuple_blesses=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=0 AND `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_peu_bless=$nb_peu_bless+$nb_peuple_blesses['nb_peuple'];

          $nb_peuple_morts=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=1 AND `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_pe_morts=$nb_pe_morts+$nb_peuple_morts['nb_peuple'];

          $nb_police_blesses=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=0 AND `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_dgpc_bless=$nb_dgpc_bless+$nb_police_blesses['nb_peuple'];

          $nb_police_morts=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=1 AND `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_dgpc_morts=$nb_dgpc_morts+$nb_police_morts['nb_peuple'];

          $nb_matdgppc=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_materiel WHERE `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_dgm=$nb_dgm+$nb_matdgppc['nb_peuple'];

          $nb_matpopulation=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_materiel WHERE `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_dgm2=$nb_dgm2+$nb_matpopulation['nb_peuple'];
               
          }

          $dispo=0;
          $matdispo=$this->Model->querysqlOne('SELECT SUM(QUANTITE_DISPONIBLE) matdispo FROM interv_materiaux WHERE `CPPC_ID`="'.$casernes['CPPC_ID'].'"');
          if(empty($matdispo['matdispo'])){
           $dispo=0;
          }else{
            $dispo=$matdispo['matdispo'];
          }

          

          $lise_ekip=$this->Model->getList('rh_equipe_cppc',array('CPPC_ID'=>$casernes['CPPC_ID']));

          $table_cppc.='<tr>
                          <td>'.$casernes['CPPC_NOM'].' <br>'.$nbint['nb_peuple'].' Intervention(s) , Materiels disponible '.$dispo.' ,  
                          ';

                          if($lise_ekip){
                          foreach ($lise_ekip as $key_lise_ekip) {
                          # code...
                          $rh_equipe_membre_cppc=$this->Model->count_all_data('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$key_lise_ekip['EQUIPE_ID']));
                          $table_cppc.='<b><font color="blue">'.$key_lise_ekip['EQUIPE_NOM'].'</font> ('.$rh_equipe_membre_cppc.' P)</b><br>';
                        }
                        }else{
                          $table_cppc.='<b><font color="red">Aucune</font></b><br>';
                      
                        }

                        $table_cppc.='</td>
                          <td><b style="float:right">'.$nb_dgm.'</b></td>
                          <td><b style="float:right">'.$nb_dgm2.'</b></td>

                          <td><b style="float:right">'.$nb_dgpc_bless.'</b></td>
                          <td><b style="float:right">'.$nb_dgpc_morts.'</b></td>

                          <td><b style="float:right">'.$nb_peu_bless.'</b></td>
                          <td><b style="float:right">'.$nb_pe_morts.'</b></td>
                          ';                           
                          $table_cppc.='</tr> ';
                        

          $provice=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$casernes['PROVINCE_ID']));

          $tk_ticketone=$this->Model->getOne('tk_ticket',array('CPPC_ID'=>$casernes['CPPC_ID'],'MODE_GET_INFO'=>0));
          $rh_cppc_manager=$this->Model->getOne('rh_cppc_manager',array('CPPC_ID'=>$casernes['CPPC_ID']));
          $rh_personnel_dgpc=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$rh_cppc_manager['PERSONNEL_ID']));

          $nb_peuple_blesse=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=0 AND `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$tk_ticketone['TICKET_CODE'].'";');

          $nb_peuple_mort=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=1 AND `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$tk_ticketone['TICKET_CODE'].'";');

          $nb_police_blesse=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=0 AND `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$tk_ticketone['TICKET_CODE'].'";');

          $nb_police_mort=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=1 AND `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$tk_ticketone['TICKET_CODE'].'";');

          $tab_coordonne =$casernes['LATITUDE'].",".$casernes['LONGITUDE'];
          $center=11;
          //  $MarkerIcon=base_url().'assets/bootstrap/hose/fert.jpg'; 


          // $tab_Infos = $tab_Infos . $casernes['CPPC_NOM'].'<>'.$casernes['CPPC_DESCR']. '<>' . $casernes['LATITUDE'] . '<>' . $casernes['LONGITUDE'] . '<>' . $MarkerIcon .'<>'.$casernes['CPPC_TEL'].'<>'.$casernes['CPPC_EMAIL'].'<>'.$provice['PROVINCE_NAME'].'<>'.$nb_peuple_blesse['nb_peuple'].'<>'.$nb_peuple_mort['nb_peuple'].'<>'.$nb_police_blesse['nb_peuple'].'<>'.$nb_police_mort['nb_peuple'].'<>'.$tk_ticketone['TICKET_DESCR'].'<>'.$casernes['DATE_INSERTION'].'<>'.$rh_personnel_dgpc['PERSONNEL_NOM']." ".$rh_personnel_dgpc['PERSONNEL_PRENOM'].'&&';
          }

          $table_cppc.='</table></div>';
      }



				}else{

			$provice=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$PROVINCE_ID));
            $tab_coordonne=$provice['PROVINCE_LATITUDE'].','.$provice['PROVINCE_LONGITUDE'];
            $center=12;
            
            
             $MarkerIcon=base_url().'assets/bootstrap/hose/fert.jpg'; 
          $table_cppc='<div class="table-responsive"><table id="mytables" class="table table-bordered table-stripped table-hover table-condensed table-responsive">
                             <thead>
                        <tr>
                        <th rowspan="3">CPPC</th>
                        <th  colspan="2">Dégâts matériels</th>
                        <th colspan="4">Dégâts humains</th>
                         
                        </tr>
                        <tr>
                         
                        <th rowspan="2">CPPC</th>
                        <th rowspan="2">Pop.</th>
                        

                        <th colspan="2">CPPC</th>
                        <th  colspan="2">Pop.</th>
                        </tr>

                        <tr>
                        
                        <th>Blessé</th>
                        <th>Mort</th>
                        <th>Blessé</th>
                        <th>Mort</th>
                         
                        </tr> </thead>';

          foreach ($rh_cppc as $casernes) {

          $tk_ticket=$this->Model->getList('tk_ticket',array('CPPC_ID'=>$casernes['CPPC_ID'],'MODE_GET_INFO'=>0));
          $nb_dgm=0;
          $nb_dgm2=0;
          $nombrdgpc=0;
          $nombrpopul=0;
          $nombrdghum=0;
          $nombrdghum2=0;
          $nb_peu_bless=0;
          $nb_pe_morts=0;    
          $nb_dgpc_bless=0;
          $nb_dgpc_morts=0;

          $nbint=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM tk_ticket WHERE MODE_GET_INFO=0 AND CPPC_ID="'.$casernes['CPPC_ID'].'";');

          foreach ($tk_ticket as $key_tic) {
            # code...       
          $nb_peuple_blesses=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=0 AND `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_peu_bless=$nb_peu_bless+$nb_peuple_blesses['nb_peuple'];

          $nb_peuple_morts=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=1 AND `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_pe_morts=$nb_pe_morts+$nb_peuple_morts['nb_peuple'];

          $nb_police_blesses=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=0 AND `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_dgpc_bless=$nb_dgpc_bless+$nb_police_blesses['nb_peuple'];

          $nb_police_morts=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=1 AND `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_dgpc_morts=$nb_dgpc_morts+$nb_police_morts['nb_peuple'];

          $nb_matdgppc=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_materiel WHERE `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_dgm=$nb_dgm+$nb_matdgppc['nb_peuple'];

          $nb_matpopulation=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_materiel WHERE `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_dgm2=$nb_dgm2+$nb_matpopulation['nb_peuple'];
               
          }

          $dispo=0;
          $matdispo=$this->Model->querysqlOne('SELECT SUM(QUANTITE_DISPONIBLE) matdispo FROM interv_materiaux WHERE `CPPC_ID`="'.$casernes['CPPC_ID'].'"');
          if(empty($matdispo['matdispo'])){
           $dispo=0;
          }else{
            $dispo=$matdispo['matdispo'];
          }

          

          $lise_ekip=$this->Model->getList('rh_equipe_cppc',array('CPPC_ID'=>$casernes['CPPC_ID']));

          $table_cppc.='<tr>
                          <td>'.$casernes['CPPC_NOM'].' <br>'.$nbint['nb_peuple'].' Intervention(s) , Materiels disponible '.$dispo.' ,  
                          ';

                          if($lise_ekip){
                          foreach ($lise_ekip as $key_lise_ekip) {
                          # code...
                          $rh_equipe_membre_cppc=$this->Model->count_all_data('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$key_lise_ekip['EQUIPE_ID']));
                          $table_cppc.='<b><font color="blue">'.$key_lise_ekip['EQUIPE_NOM'].'</font> ('.$rh_equipe_membre_cppc.' P)</b><br>';
                        }
                        }else{
                          $table_cppc.='<b><font color="red">Aucune</font></b><br>';
                      
                        }

                        $table_cppc.='</td>
                          <td><b style="float:right">'.$nb_dgm.'</b></td>
                          <td><b style="float:right">'.$nb_dgm2.'</b></td>

                          <td><b style="float:right">'.$nb_dgpc_bless.'</b></td>
                          <td><b style="float:right">'.$nb_dgpc_morts.'</b></td>

                          <td><b style="float:right">'.$nb_peu_bless.'</b></td>
                          <td><b style="float:right">'.$nb_pe_morts.'</b></td>
                          ';                           
                          $table_cppc.='</tr> ';
                        

          $provice=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$casernes['PROVINCE_ID']));

          $tk_ticketone=$this->Model->getOne('tk_ticket',array('CPPC_ID'=>$casernes['CPPC_ID'],'MODE_GET_INFO'=>0));
          $rh_cppc_manager=$this->Model->getOne('rh_cppc_manager',array('CPPC_ID'=>$casernes['CPPC_ID']));
          $rh_personnel_dgpc=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$rh_cppc_manager['PERSONNEL_ID']));

          $nb_peuple_blesse=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=0 AND `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$tk_ticketone['TICKET_CODE'].'";');

          $nb_peuple_mort=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=1 AND `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$tk_ticketone['TICKET_CODE'].'";');

          $nb_police_blesse=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=0 AND `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$tk_ticketone['TICKET_CODE'].'";');

          $nb_police_mort=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=1 AND `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$tk_ticketone['TICKET_CODE'].'";');

          $tab_coordonne =$casernes['LATITUDE'].",".$casernes['LONGITUDE'];
          $center=11;


          $tab_Infos = $tab_Infos . $casernes['CPPC_NOM'].'<>'.$casernes['CPPC_DESCR']. '<>' . $casernes['LATITUDE'] . '<>' . $casernes['LONGITUDE'] . '<>' . $MarkerIcon .'<>'.$casernes['CPPC_TEL'].'<>'.$casernes['CPPC_EMAIL'].'<>'.$provice['PROVINCE_NAME'].'<>'.$nb_peuple_blesse['nb_peuple'].'<>'.$nb_peuple_mort['nb_peuple'].'<>'.$nb_police_blesse['nb_peuple'].'<>'.$nb_police_mort['nb_peuple'].'<>'.$tk_ticketone['TICKET_DESCR'].'<>'.$casernes['DATE_INSERTION'].'<>'.$rh_personnel_dgpc['PERSONNEL_NOM']." ".$rh_personnel_dgpc['PERSONNEL_PRENOM'].'&&';
          }

          $table_cppc.='</table></div>';
      }



			}


		if(empty($CPPC_ID) && empty($PROVINCE_ID)) {

         $caserne = $this->Model->getList('rh_cppc',array());
          $MarkerIcon=base_url().'assets/bootstrap/hose/fert.jpg'; 
          $table_cppc='<div class="table-responsive"><table id="mytables" class="table table-bordered table-stripped table-hover table-condensed table-responsive">
                             <thead>
                        <tr>
                        <th rowspan="3">CPPC</th>
                        <th  colspan="2">Dégâts matériels</th>
                        <th colspan="4">Dégâts humains</th>
                         
                        </tr>
                        <tr>
                         
                        <th rowspan="2">CPPC</th>
                        <th rowspan="2">Pop.</th>
                        

                        <th colspan="2">CPPC</th>
                        <th  colspan="2">Pop.</th>
                        </tr>

                        <tr>
                        
                        <th>Blessé</th>
                        <th>Mort</th>
                        <th>Blessé</th>
                        <th>Mort</th>
                         
                        </tr> </thead>';

          foreach ($caserne as $casernes) {

          $tk_ticket=$this->Model->getList('tk_ticket',array('CPPC_ID'=>$casernes['CPPC_ID'],'MODE_GET_INFO'=>0));
          $nb_dgm=0;
          $nb_dgm2=0;
          $nombrdgpc=0;
          $nombrpopul=0;
          $nombrdghum=0;
          $nombrdghum2=0;
          $nb_peu_bless=0;
          $nb_pe_morts=0;    
          $nb_dgpc_bless=0;
          $nb_dgpc_morts=0;

          $nbint=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM tk_ticket WHERE MODE_GET_INFO=0 AND CPPC_ID="'.$casernes['CPPC_ID'].'";');

          foreach ($tk_ticket as $key_tic) {
            # code...       
          $nb_peuple_blesses=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=0 AND `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_peu_bless=$nb_peu_bless+$nb_peuple_blesses['nb_peuple'];

          $nb_peuple_morts=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=1 AND `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_pe_morts=$nb_pe_morts+$nb_peuple_morts['nb_peuple'];

          $nb_police_blesses=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=0 AND `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_dgpc_bless=$nb_dgpc_bless+$nb_police_blesses['nb_peuple'];

          $nb_police_morts=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=1 AND `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_dgpc_morts=$nb_dgpc_morts+$nb_police_morts['nb_peuple'];

          $nb_matdgppc=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_materiel WHERE `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_dgm=$nb_dgm+$nb_matdgppc['nb_peuple'];

          $nb_matpopulation=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_materiel WHERE `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$key_tic['TICKET_CODE'].'";');
          $nb_dgm2=$nb_dgm2+$nb_matpopulation['nb_peuple'];
               
          }

          $dispo=0;
          $matdispo=$this->Model->querysqlOne('SELECT SUM(QUANTITE_DISPONIBLE) matdispo FROM interv_materiaux WHERE `CPPC_ID`="'.$casernes['CPPC_ID'].'"');
          if(empty($matdispo['matdispo'])){
           $dispo=0;
          }else{
            $dispo=$matdispo['matdispo'];
          }

          

          $lise_ekip=$this->Model->getList('rh_equipe_cppc',array('CPPC_ID'=>$casernes['CPPC_ID']));

          $table_cppc.='<tr>
                          <td>'.$casernes['CPPC_NOM'].' <br>'.$nbint['nb_peuple'].' Intervention(s) , Materiels disponible '.$dispo.' ,  
                          ';

                          if($lise_ekip){
                          foreach ($lise_ekip as $key_lise_ekip) {
                          # code...
                          $rh_equipe_membre_cppc=$this->Model->count_all_data('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$key_lise_ekip['EQUIPE_ID']));
                          $table_cppc.='<b><font color="blue">'.$key_lise_ekip['EQUIPE_NOM'].'</font> ('.$rh_equipe_membre_cppc.' P)</b><br>';
                        }
                        }else{
                          $table_cppc.='<b><font color="red">Aucune</font></b><br>';
                      
                        }

                        $table_cppc.='</td>
                          <td><b style="float:right">'.$nb_dgm.'</b></td>
                          <td><b style="float:right">'.$nb_dgm2.'</b></td>

                          <td><b style="float:right">'.$nb_dgpc_bless.'</b></td>
                          <td><b style="float:right">'.$nb_dgpc_morts.'</b></td>

                          <td><b style="float:right">'.$nb_peu_bless.'</b></td>
                          <td><b style="float:right">'.$nb_pe_morts.'</b></td>
                          ';                           
                          $table_cppc.='</tr> ';
                        

          $provice=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$casernes['PROVINCE_ID']));

          $tk_ticketone=$this->Model->getOne('tk_ticket',array('CPPC_ID'=>$casernes['CPPC_ID'],'MODE_GET_INFO'=>0));
          $rh_cppc_manager=$this->Model->getOne('rh_cppc_manager',array('CPPC_ID'=>$casernes['CPPC_ID']));
          $rh_personnel_dgpc=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$rh_cppc_manager['PERSONNEL_ID']));

          $nb_peuple_blesse=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=0 AND `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$tk_ticketone['TICKET_CODE'].'";');

          $nb_peuple_mort=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=1 AND `CONCERNE_DGPC`=0 AND TICKET_CODE="'.$tk_ticketone['TICKET_CODE'].'";');

          $nb_police_blesse=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=0 AND `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$tk_ticketone['TICKET_CODE'].'";');

          $nb_police_mort=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM interv_odk_degat_humain WHERE STATUT_SANTE=1 AND `CONCERNE_DGPC`=1 AND TICKET_CODE="'.$tk_ticketone['TICKET_CODE'].'";');

          $tab_coordonne =$casernes['LATITUDE'].",".$casernes['LONGITUDE'];
          $center=11;


          $tab_Infos = $tab_Infos . $casernes['CPPC_NOM'].'<>'.$casernes['CPPC_DESCR']. '<>' . $casernes['LATITUDE'] . '<>' . $casernes['LONGITUDE'] . '<>' . $MarkerIcon .'<>'.$casernes['CPPC_TEL'].'<>'.$casernes['CPPC_EMAIL'].'<>'.$provice['PROVINCE_NAME'].'<>'.$nb_peuple_blesse['nb_peuple'].'<>'.$nb_peuple_mort['nb_peuple'].'<>'.$nb_police_blesse['nb_peuple'].'<>'.$nb_police_mort['nb_peuple'].'<>'.$tk_ticketone['TICKET_DESCR'].'<>'.$casernes['DATE_INSERTION'].'<>'.$rh_personnel_dgpc['PERSONNEL_NOM']." ".$rh_personnel_dgpc['PERSONNEL_PRENOM'].'&&';
          }

          $table_cppc.='</table></div>';
          }





         
			 
			 
			$data['zooms']=$center;
			$data['list_data'] = $tab_Infos;
			$data['divaffich']=$divaffich;
			$data['title']='Carte';
			$data['centerCoord']=$tab_coordonne;
			$data['PROVINCE_ID']=$PROVINCE_ID;
			$data['ststm_provinces']=$this->Model->getList('ststm_provinces',array());
			$data['rh_cppc']=$rh_cppc;
			$data['CPPC_ID'] = $CPPC_ID;
         	$data['table_cppc']=$table_cppc;
         	$data['select_OUV']=$select_OUV;
	        $data['select_INT']=$select_INT;
	        $data['select_CLO']=$select_CLO;
	        $data['select_ATT']=$select_ATT;
	        $data['select_FAA']=$select_FAA;
	         
	        $data['count_statut1']=$count_statut1;
	        $data['count_statut2']=$count_statut2;
	        $data['count_statut3']=$count_statut3;
	        $data['count_statut4']=$count_statut4;
	        $data['count_statut5']=$count_statut5;
	        $data['title'] = "Carte de couverture CPPC";
	        $data['breadcrumb'] = $this->make_bread->output();

			$this->load->view('New_Map_couverture_view',$data);
		}
	}
 ?>