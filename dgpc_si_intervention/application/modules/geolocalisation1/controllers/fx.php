function map_cppc(){

          if($this->mylibrary->get_permission('Map/index') ==0){
          redirect(base_url());
          }

          $url = base_url();
          $elements = explode("/", $url);
          $indice = sizeof($elements);
          $nouveau_url = '';
          for ($i=0; $i < ($indice-2); $i++) { 
                 
          $nouveau_url .= $elements[$i].'/';}
          $tab_coordonne ="";
          $center=9;

          if($this->session->userdata('DGPC_CPPC_ID')==0){
          $tab_coordonne ="-3.3753007,29.3553828";
          }else{
          $USER_ID=$this->session->userdata('USER_ID');
          $rh_cppc=$this->Model->getOne('rh_cppc',array('USER_ID'=>$USER_ID));
          $tab_coordonne =$rh_cppc['LATITUDE'].",".$rh_cppc['LONGITUDE'];
          $center=11;
          }

          
          $tab_Infos=NULL;
          $PROVINCE_ID=$this->input->post('PROVINCE_ID');
          $caserne=NULL;
          $CPPC_ID=$this->input->post('CPPC_ID');
          $table_cppc=NULL;
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



          $criteresnew='';
          if(!empty($PROVINCE_ID) && empty($CPPC_ID)){

          $crit_cnl = " PROVINCE_ID IN (";
          foreach ($PROVINCE_ID as $key => $value) {
          $crit_cnl.= $value.',';
          $provice=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$value));
          $tab_coordonne=$provice['PROVINCE_LATITUDE'].','.$provice['PROVINCE_LONGITUDE'];
          $center=12;
          }
          $crit_cnl .= '**';
          $crit_cnl = str_replace(',**', ')', $crit_cnl);
          if(!empty($criteresnew)){
               $criteresnew .= " AND ".$crit_cnl;


          }else{
               $criteresnew .= $crit_cnl;
               }



          $caserne = $this->Model->getList('rh_cppc',$criteresnew);
          $MarkerIcon=base_url().'assets/bootstrap/hose/fert.jpg'; 
          $table_cppc='<table class="table table-striped table-bordered">';

          foreach ($caserne as $casernes) {

          $tk_ticket=$this->Model->getList('tk_ticket',array('CPPC_ID'=>$casernes['CPPC_ID']));
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

          $nbint=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM tk_ticket WHERE CPPC_ID="'.$casernes['CPPC_ID'].'";');

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
                        <td class="bg-primary text-center" colspan="8">'.$casernes['CPPC_NOM'].' <br><small><i>'.$casernes['CPPC_DESCR'].'</i></small></td>
                        <tr>
                        <tr>
                        <th colspan="2">Dégâts matériels</th>
                        <th colspan="4">Dégâts humains</th>
                        <th>Nombre d\'interventions</th>
                        <th>Equipes</th>
                        </tr>
                        <tr>
                        <td rowspan="2">CPPC</td>
                        <td rowspan="2">Population</td>
                        

                        <td colspan="2">CPPC</td>
                        <td colspan="2">Population</td>
                        <td rowspan="3"><h3><font style="float:right">'.$nbint['nb_peuple'].'</font></h3></td><td rowspan="3">';

                        if($lise_ekip){
                          foreach ($lise_ekip as $key_lise_ekip) {
                          # code...
                          $rh_equipe_membre_cppc=$this->Model->count_all_data('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$key_lise_ekip['EQUIPE_ID']));
                          $table_cppc.='<b><font color="blue">'.$key_lise_ekip['EQUIPE_NOM'].'</font> ('.$rh_equipe_membre_cppc.' personnes)</b><br>';
                        }
                        }else{
                          $table_cppc.='<b><font color="red">Aucune Équipe dans ce CPPC</font></b><br>';
                      
                        }

                        $table_cppc.='</td></tr>

                        <tr>
                        <td>Blessé</td>
                        <td>Mort</td>
                        <td>Blessé</td>
                        <td>Mort</td>
                        </tr>

                         <tr>
                        <td>'.$nb_dgm.'
                        </td>
                        <td>'.$nb_dgm2.'</td>

                        <td>'.$nb_dgpc_bless.'</td>
                        <td>'.$nb_dgpc_morts.'</td>
                        <td>'.$nb_peu_bless.'</td>
                        <td>'.$nb_pe_morts.'</td>
                       
                        </tr>
                        <tr>
                        <td colspan="8">Materiel quantité disponible : <b>'.$dispo.'</b></td>
                        </tr>
                        ';
                        

          $provice=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$casernes['PROVINCE_ID']));

          $tk_ticketone=$this->Model->getOne('tk_ticket',array('CPPC_ID'=>$casernes['CPPC_ID']));
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

          $table_cppc.='</table>';




          }

           $divaffich=0;



           if(!empty($CPPC_ID)){
            $divaffich=1;

            /**/

            $caserne = $this->Model->getList('rh_cppc',array());

            $criteresnew='';
            $crit_cnl = " CPPC_ID IN (";
            foreach ($CPPC_ID as $key => $value) {
            $crit_cnl.= $value.',';
             
            }
            $crit_cnl .= '**';
            $crit_cnl = str_replace(',**', ')', $crit_cnl);

            if(!empty($criteresnew)){
               $criteresnew .= " AND ".$crit_cnl;
               $tickets=$this->Model->getList('tk_ticket',$crit_cnl);
            }else{
               $criteresnew .= $crit_cnl;

            }
             

          $casernecondui = $this->Model->getList('rh_cppc',$criteresnew);
           
          $table_cppc='<table class="table table-striped table-bordered">';
         

          foreach ($casernecondui as $casernes) {

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
           
            $requete='SELECT *FROM tk_ticket WHERE CPPC_ID='.$casernes['CPPC_ID'].' AND ('.$condition.')';
            $tk1=$this->Model->getRequete($requete);
            //echo $requete;

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

          $nbint=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM tk_ticket WHERE CPPC_ID="'.$casernes['CPPC_ID'].'";');

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
            $MarkerIcon=base_url().'assets/bootstrap/care/caregreen.jpg';
          }
          if($key_tic['STATUT_ID']==2){
            $MarkerIcon=base_url().'assets/bootstrap/care/carered1.jpg';
          }
          if($key_tic['STATUT_ID']==3){
            $MarkerIcon=base_url().'assets/bootstrap/care/caregreee.jpg';
          }
          if($key_tic['STATUT_ID']==4){
            $MarkerIcon=base_url().'assets/bootstrap/care/carejaune.jpg';
          }
          if($key_tic['STATUT_ID']==5){
            $MarkerIcon=base_url().'assets/bootstrap/care/caredgpc2.jpg';
          }
          

          $tab_Infos = $tab_Infos . $casernes['CPPC_NOM'].'<>'.$key_tic['TICKET_DESCR']. '<>' . $key_tic['LATITUDE'] . '<>' . $key_tic['LONGITUDE'] . '<>' . $MarkerIcon .'<>'.$key_tic['TICKET_DECLARANT_TEL'].'<>N/A<>'.$provin['PROVINCE_NAME'].'<>'.$nb_peuple_blesse['nb_peuple'].'<>'.$nb_peuple_mort['nb_peuple'].'<>'.$nb_police_blesse['nb_peuple'].'<>'.$nb_police_mort['nb_peuple'].'<>'.$key_tic['TICKET_DESCR'].'<>'.$key_tic['DATE_INSERTION'].'<>'.$key_tic['TICKET_DECLARANT'].'&&';

          $tab_coordonne =$key_tic['LATITUDE'].",".$key_tic['LONGITUDE'];
          $center=12;
               
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
                        <td class="bg-primary text-center" colspan="8">'.$casernes['CPPC_NOM'].' <br><small><i>'.$casernes['CPPC_DESCR'].'</i></small></td>
                        <tr>
                        <tr>
                        <th colspan="2">Dégâts matériels</th>
                        <th colspan="4">Dégâts humains</th>
                        <th>Nombre d\'interventions</th>
                        <th>Equipes</th>
                        </tr>
                        <tr>
                        <td rowspan="2">CPPC</td>
                        <td rowspan="2">Population</td>
                        

                        <td colspan="2">CPPC</td>
                        <td colspan="2">Population</td>
                        <td rowspan="3"><h3><font style="float:right">'.$nbint['nb_peuple'].'</font></h3></td><td rowspan="3">';

                        if($lise_ekip){
                          foreach ($lise_ekip as $key_lise_ekip) {
                          # code...
                          $rh_equipe_membre_cppc=$this->Model->count_all_data('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$key_lise_ekip['EQUIPE_ID']));
                          $table_cppc.='<b><font color="blue">'.$key_lise_ekip['EQUIPE_NOM'].'</font> ('.$rh_equipe_membre_cppc.' personnes)</b><br>';
                        }
                        }else{
                          $table_cppc.='<b><font color="red">Aucune Équipe dans ce CPPC</font></b><br>';
                      
                        }

                        $table_cppc.='</td></tr>

                        <tr>
                        <td>Blessé</td>
                        <td>Mort</td>
                        <td>Blessé</td>
                        <td>Mort</td>
                        </tr>

                         <tr>
                        <td>'.$nb_dgm.'
                        </td>
                        <td>'.$nb_dgm2.'</td>

                        <td>'.$nb_dgpc_bless.'</td>
                        <td>'.$nb_dgpc_morts.'</td>
                        <td>'.$nb_peu_bless.'</td>
                        <td>'.$nb_pe_morts.'</td>
                       
                        </tr>
                        <tr>
                        <td colspan="8">Materiel quantité disponible : <b>'.$dispo.'</b></td>
                        </tr>
                        ';
                 

          
          }

          $table_cppc.='</table>';
            



          }

          

          if(!empty($CPPC_ID) && !empty($PROVINCE_ID)) {






            /********************/
            /************************/


            $divaffich=1;

            /**/

            
            $criteresnew='';
            $crit_cnl = " CPPC_ID IN (";
            foreach ($CPPC_ID as $key => $value) {
            $crit_cnl.= $value.',';
             
            }
            $crit_cnl .= '**';
            $crit_cnl = str_replace(',**', ')', $crit_cnl);

            if(!empty($criteresnew)){
               $criteresnew .= " AND ".$crit_cnl;
               $tickets=$this->Model->getList('tk_ticket',$crit_cnl);
            }else{
               $criteresnew .= $crit_cnl;

            }
             

          $casernecondui = $this->Model->getList('rh_cppc',$criteresnew);
          $caserne = $this->Model->getList('rh_cppc',$criteresnew);
           
          $table_cppc='<table class="table table-striped table-bordered">';
         

          foreach ($casernecondui as $casernes) {

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
           
            $requete='SELECT *FROM tk_ticket WHERE CPPC_ID='.$casernes['CPPC_ID'].' AND ('.$condition.')';
            $tk1=$this->Model->getRequete($requete);

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

          $nbint=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM tk_ticket WHERE CPPC_ID="'.$casernes['CPPC_ID'].'";');

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
            $MarkerIcon=base_url().'assets/bootstrap/care/caregreen.jpg';
          }
          if($key_tic['STATUT_ID']==2){
            $MarkerIcon=base_url().'assets/bootstrap/care/carered1.jpg';
          }
          if($key_tic['STATUT_ID']==3){
            $MarkerIcon=base_url().'assets/bootstrap/care/caregreee.jpg';
          }
          if($key_tic['STATUT_ID']==4){
            $MarkerIcon=base_url().'assets/bootstrap/care/carejaune.jpg';
          }
          if($key_tic['STATUT_ID']==5){
            $MarkerIcon=base_url().'assets/bootstrap/care/caredgpc2.jpg';
          }
          

          $tab_Infos = $tab_Infos . $casernes['CPPC_NOM'].'<>'.$key_tic['TICKET_DESCR']. '<>' . $key_tic['LATITUDE'] . '<>' . $key_tic['LONGITUDE'] . '<>' . $MarkerIcon .'<>'.$key_tic['TICKET_DECLARANT_TEL'].'<>N/A<>'.$provin['PROVINCE_NAME'].'<>'.$nb_peuple_blesse['nb_peuple'].'<>'.$nb_peuple_mort['nb_peuple'].'<>'.$nb_police_blesse['nb_peuple'].'<>'.$nb_police_mort['nb_peuple'].'<>'.$key_tic['TICKET_DESCR'].'<>'.$key_tic['DATE_INSERTION'].'<>'.$key_tic['TICKET_DECLARANT'].'&&';

          $tab_coordonne =$key_tic['LATITUDE'].",".$key_tic['LONGITUDE'];
          $center=12;
               
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
                        <td class="bg-primary text-center" colspan="8">'.$casernes['CPPC_NOM'].' <br><small><i>'.$casernes['CPPC_DESCR'].'</i></small></td>
                        <tr>
                        <tr>
                        <th colspan="2">Dégâts matériels</th>
                        <th colspan="4">Dégâts humains</th>
                        <th>Nombre d\'interventions</th>
                        <th>Equipes</th>
                        </tr>
                        <tr>
                        <td rowspan="2">CPPC</td>
                        <td rowspan="2">Population</td>
                        

                        <td colspan="2">CPPC</td>
                        <td colspan="2">Population</td>
                        <td rowspan="3"><h3><font style="float:right">'.$nbint['nb_peuple'].'</font></h3></td><td rowspan="3">';

                        if($lise_ekip){
                          foreach ($lise_ekip as $key_lise_ekip) {
                          # code...
                          $rh_equipe_membre_cppc=$this->Model->count_all_data('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$key_lise_ekip['EQUIPE_ID']));
                          $table_cppc.='<b><font color="blue">'.$key_lise_ekip['EQUIPE_NOM'].'</font> ('.$rh_equipe_membre_cppc.' personnes)</b><br>';
                        }
                        }else{
                          $table_cppc.='<b><font color="red">Aucune Équipe dans ce CPPC</font></b><br>';
                      
                        }

                        $table_cppc.='</td></tr>

                        <tr>
                        <td>Blessé</td>
                        <td>Mort</td>
                        <td>Blessé</td>
                        <td>Mort</td>
                        </tr>

                         <tr>
                        <td>'.$nb_dgm.'
                        </td>
                        <td>'.$nb_dgm2.'</td>

                        <td>'.$nb_dgpc_bless.'</td>
                        <td>'.$nb_dgpc_morts.'</td>
                        <td>'.$nb_peu_bless.'</td>
                        <td>'.$nb_pe_morts.'</td>
                       
                        </tr>
                        <tr>
                        <td colspan="8">Materiel quantité disponible : <b>'.$dispo.'</b></td>
                        </tr>
                        ';
                 

          
          }

          $table_cppc.='</table>';







            /*******************************/
            /******************************/







          }

          if(empty($CPPC_ID) && empty($PROVINCE_ID)) {

          $caserne = $this->Model->getList('rh_cppc',array());
          $MarkerIcon=base_url().'assets/bootstrap/hose/fert.jpg'; 
          $table_cppc='<table class="table table-striped table-bordered">';

          foreach ($caserne as $casernes) {

          $tk_ticket=$this->Model->getList('tk_ticket',array('CPPC_ID'=>$casernes['CPPC_ID']));
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

          $nbint=$this->Model->querysqlOne('SELECT COUNT(*)nb_peuple FROM tk_ticket WHERE CPPC_ID="'.$casernes['CPPC_ID'].'";');

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
                        <td class="bg-primary text-center" colspan="8">'.$casernes['CPPC_NOM'].' <br><small><i>'.$casernes['CPPC_DESCR'].'</i></small></td>
                        <tr>
                        <tr>
                        <th colspan="2">Dégâts matériels</th>
                        <th colspan="4">Dégâts humains</th>
                        <th>Nombre d\'interventions</th>
                        <th>Equipes</th>
                        </tr>
                        <tr>
                        <td rowspan="2">CPPC</td>
                        <td rowspan="2">Population</td>
                        

                        <td colspan="2">CPPC</td>
                        <td colspan="2">Population</td>
                        <td rowspan="3"><h3><font style="float:right">'.$nbint['nb_peuple'].'</font></h3></td><td rowspan="3">';

                        if($lise_ekip){
                          foreach ($lise_ekip as $key_lise_ekip) {
                          # code...
                          $rh_equipe_membre_cppc=$this->Model->count_all_data('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$key_lise_ekip['EQUIPE_ID']));
                          $table_cppc.='<b><font color="blue">'.$key_lise_ekip['EQUIPE_NOM'].'</font> ('.$rh_equipe_membre_cppc.' personnes)</b><br>';
                        }
                        }else{
                          $table_cppc.='<b><font color="red">Aucune Équipe dans ce CPPC</font></b><br>';
                      
                        }

                        $table_cppc.='</td></tr>

                        <tr>
                        <td>Blessé</td>
                        <td>Mort</td>
                        <td>Blessé</td>
                        <td>Mort</td>
                        </tr>

                         <tr>
                        <td>'.$nb_dgm.'
                        </td>
                        <td>'.$nb_dgm2.'</td>

                        <td>'.$nb_dgpc_bless.'</td>
                        <td>'.$nb_dgpc_morts.'</td>
                        <td>'.$nb_peu_bless.'</td>
                        <td>'.$nb_pe_morts.'</td>
                       
                        </tr>
                        <tr>
                        <td colspan="8">Materiel quantité disponible : <b>'.$dispo.'</b></td>
                        </tr>
                        ';
                        

          $provice=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$casernes['PROVINCE_ID']));

          $tk_ticketone=$this->Model->getOne('tk_ticket',array('CPPC_ID'=>$casernes['CPPC_ID']));
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

          $table_cppc.='</table>';
          }

          $data_onther['zooms'] = $center;
          $data_onther['list_data'] = $tab_Infos;
          $data_onther['centerCoord'] = $tab_coordonne;
          $data_onther['breadcrumb'] = $this->make_bread->output();
          $data_onther['title'] = "Carte de couverture CPPC";
          $data_onther['PROVINCE_ID']=$PROVINCE_ID;
          $data_onther['ststm_provinces']=$this->Model->getList('ststm_provinces',array());
          $data_onther['rh_cppc']=$caserne;
          $data_onther['CPPC_ID']=$CPPC_ID;

          $this->make_bread->add('Carte des CCPCs', "geolocalisation/Map/map_cppc", 0);
          $data_onther['breadcrumb'] = $this->make_bread->output();
          $data_onther['table_cppc']=$table_cppc;

          $data_onther['select_OUV']=$select_OUV;
          $data_onther['select_INT']=$select_INT;
          $data_onther['select_CLO']=$select_CLO;
          $data_onther['select_ATT']=$select_ATT;
          $data_onther['select_FAA']=$select_FAA;
          $data_onther['divaffich']=$divaffich;


 
        
          $this->load->view('Map_ccpc_View',$data_onther);
    }
x