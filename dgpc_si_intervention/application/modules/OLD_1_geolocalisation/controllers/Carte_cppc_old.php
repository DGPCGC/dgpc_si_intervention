<?php 
	/**
	 * 
	 */
	class Carte_cppc extends CI_Controller
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

      $chk1=$this->input->post('chk1');
      $chk2=$this->input->post('chk2');
      $PROVINCE_ID=$this->input->post('PROVINCE_ID');
      $COMMUNE_ID=$this->input->post('COMMUNE_ID');
      $tk_ticket=NULL;

      $checked='';
      $checked2='';

          $tab_coordonne = "";
           $tab_coordonne='-3.3895294,29.925254';
          $center=9;
          $tab_Infos='';
          $etat=0;
          $tab_itineraires='';
            $url = base_url();
            $elements = explode("/", $url);

            $indice = sizeof($elements);

            $nouveau_url = '';
               for ($i=0; $i < ($indice-2); $i++) { 
                   # code...
                $nouveau_url .= $elements[$i].'/';}

                // $this->make_bread->add('Carte CPPC', "hierarchie/Map_organe/", 1);
                // $data_other['breadcrumb'] = $this->make_bread->output(); 

                $requete='';
                $nb_cppc=0;
                $nb_tick=0;

                if(!(isset($chk1)) && !(isset($chk2))){
        $checked='checked';
        $checked2='checked';


        //echo "checked true et checked2 true";
        $requete='SELECT rh_cppc.CPPC_ID, rh_cppc.LATITUDE,
              rh_cppc.LONGITUDE,
              rh_cppc.CPPC_DESCR,
              rh_cppc.PROVINCE_ID,
              "CPPC" AS CPPC 
              FROM rh_cppc

               union 
              select tk_ticket.TICKET_ID, 
              tk_ticket.LATITUDE,
              tk_ticket.LONGITUDE,
              tk_ticket.TICKET_DESCR,
              tk_ticket.COMMUNE_ID,
              "TICK" as TICK
              from tk_ticket';
              $etat=1;
          $nb_cppc=$this->Model->count_all_data('rh_cppc',array());   
          $nb_tick=$this->Model->count_all_data('tk_ticket',array());
          $tk_ticket=$this->Model->getList('tk_ticket',array());    
      }

      /******  cas II *****/

      if(isset($chk1) && !(isset($chk2))){
        $checked='checked';
        $checked2='';
        //echo "checked true et checked2 false";
        


              if($PROVINCE_ID>0){

          if($COMMUNE_ID>0){

            $requete='SELECT rh_cppc.CPPC_ID, rh_cppc.LATITUDE,
              rh_cppc.LONGITUDE,
              rh_cppc.CPPC_DESCR,
              rh_cppc.PROVINCE_ID,
              "CPPC" AS CPPC 
              FROM rh_cppc where rh_cppc.PROVINCE_ID="'.$PROVINCE_ID.'"

               union 
              select tk_ticket.TICKET_ID, 
              tk_ticket.LATITUDE,
              tk_ticket.LONGITUDE,
              tk_ticket.TICKET_DESCR,
              tk_ticket.COMMUNE_ID,
              "TICK" as TICK
              from tk_ticket  where tk_ticket.COMMUNE_ID="'.$COMMUNE_ID.'"
              ';

              $cord_prov2=$this->Model->getOne('ststm_communes',array('COMMUNE_ID'=>$COMMUNE_ID));
              $tab_coordonne=$cord_prov2['COMMUNE_LATITUDE'].','.$cord_prov2['COMMUNE_LONGITUDE'];
              $center=11;
                
          $nb_cppc=$this->Model->count_all_data('rh_cppc',array('PROVINCE_ID'=>$PROVINCE_ID));    
          //$nb_tick=$this->Model->count_all_data('tk_ticket',array('COMMUNE_ID'=>$COMMUNE_ID));
          $tk_ticket=$this->Model->getList('tk_ticket',array('COMMUNE_ID'=>0));


          }else{

            $requete='SELECT rh_cppc.CPPC_ID, rh_cppc.LATITUDE,
              rh_cppc.LONGITUDE,
              rh_cppc.CPPC_DESCR,
              rh_cppc.PROVINCE_ID,
              "CPPC" AS CPPC 
              FROM rh_cppc where rh_cppc.PROVINCE_ID="'.$PROVINCE_ID.'"
              ';

              $cord_prov=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$PROVINCE_ID));
              $tab_coordonne=$cord_prov['PROVINCE_LATITUDE'].','.$cord_prov['PROVINCE_LONGITUDE'];
              $center=10;

          $nb_cppc=$this->Model->count_all_data('rh_cppc',array('PROVINCE_ID'=>$PROVINCE_ID));    
          //$nb_tick=$this->Model->count_all_data('tk_ticket',array());
          $tk_ticket=$this->Model->getList('tk_ticket',array('COMMUNE_ID'=>0));



          }

        }else{

           $requete='SELECT rh_cppc.CPPC_ID, rh_cppc.LATITUDE,
              rh_cppc.LONGITUDE,
              rh_cppc.CPPC_DESCR,
              rh_cppc.PROVINCE_ID,
              "CPPC" AS CPPC 
              FROM rh_cppc';
              $nb_cppc=$this->Model->count_all_data('rh_cppc',array());   
          //$nb_tick=$this->Model->count_all_data('tk_ticket',array()); 
              $tk_ticket=$this->Model->getList('tk_ticket',array('COMMUNE_ID'=>0));


        }
        $etat=2;

         
      }








      if(!isset($chk1) && (isset($chk2))){
        $checked='';
        $checked2='checked';
        //echo "checked false et checked2 true";

        if($PROVINCE_ID>0){

          if($COMMUNE_ID>0){

            $requete='SELECT tk_ticket.TICKET_ID,
                 tk_ticket.LATITUDE,
                 tk_ticket.LONGITUDE,
                 tk_ticket.TICKET_DESCR,
                 tk_ticket.COMMUNE_ID,
                 "TICK" as CPPC from 
                   tk_ticket,
                   ststm_communes,
                   ststm_provinces 
                 where ststm_communes.COMMUNE_ID=tk_ticket.COMMUNE_ID
                   and ststm_communes.PROVINCE_ID=ststm_provinces.PROVINCE_ID
                 and ststm_provinces.PROVINCE_ID="'.$PROVINCE_ID.'" and tk_ticket.COMMUNE_ID="'.$COMMUNE_ID.'"  ';
              $cord_prov=$this->Model->getOne('ststm_communes',array('COMMUNE_ID'=>$COMMUNE_ID));
              $tab_coordonne=$cord_prov['COMMUNE_LATITUDE'].','.$cord_prov['COMMUNE_LONGITUDE'];
              $center=11;
              $nb_tick=$this->Model->count_all_data('tk_ticket',array('COMMUNE_ID'=>$COMMUNE_ID));  
              $tk_ticket=$this->Model->getList('tk_ticket',array('COMMUNE_ID'=>$COMMUNE_ID));


          }else{

            $requete='SELECT tk_ticket.TICKET_ID,
                 tk_ticket.LATITUDE,
                 tk_ticket.LONGITUDE,
                 tk_ticket.TICKET_DESCR,
                 tk_ticket.COMMUNE_ID,
                 "TICK" as CPPC from 
                   tk_ticket,
                   ststm_communes,
                   ststm_provinces 
                 where ststm_communes.COMMUNE_ID=tk_ticket.COMMUNE_ID
                   and ststm_communes.PROVINCE_ID=ststm_provinces.PROVINCE_ID
                 and ststm_provinces.PROVINCE_ID="'.$PROVINCE_ID.'" ';
              $cord_prov=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$PROVINCE_ID));
              $tab_coordonne=$cord_prov['PROVINCE_LATITUDE'].','.$cord_prov['PROVINCE_LONGITUDE'];
              $center=10;

              $nb_tick=$this->Model->count_all_data('tk_ticket',array()); 

              $tk_ticket=$this->Model->getList('tk_ticket',array());

          }

          

        }else{

          $requete='SELECT tk_ticket.TICKET_ID, 
              tk_ticket.LATITUDE,
              tk_ticket.LONGITUDE,
              tk_ticket.TICKET_DESCR,
              tk_ticket.COMMUNE_ID,
              "TICK" as CPPC
              from tk_ticket
              ';

              //$nb_cppc=$this->Model->count_all_data('rh_cppc',array());   
          $nb_tick=$this->Model->count_all_data('tk_ticket',array()); 
          $tk_ticket=$this->Model->getList('tk_ticket',array());


        }
        
        $etat=3;



      }

      if((isset($chk1)) && (isset($chk2))){
        $checked='checked';
        $checked2='checked';
        //echo "checked true et checked2 true";

        if($PROVINCE_ID>0){

          if($COMMUNE_ID>0){

            $requete='SELECT rh_cppc.CPPC_ID, rh_cppc.LATITUDE,
              rh_cppc.LONGITUDE,
              rh_cppc.CPPC_DESCR,
              rh_cppc.PROVINCE_ID,
              "CPPC" AS CPPC 
              FROM rh_cppc where rh_cppc.PROVINCE_ID="'.$PROVINCE_ID.'"

               union 
              select tk_ticket.TICKET_ID, 
              tk_ticket.LATITUDE,
              tk_ticket.LONGITUDE,
              tk_ticket.TICKET_DESCR,
              tk_ticket.COMMUNE_ID,
              "TICK" as TICK
              from tk_ticket  where tk_ticket.COMMUNE_ID="'.$COMMUNE_ID.'"
              ';

              $cord_prov2=$this->Model->getOne('ststm_communes',array('COMMUNE_ID'=>$COMMUNE_ID));
              $tab_coordonne=$cord_prov2['COMMUNE_LATITUDE'].','.$cord_prov2['COMMUNE_LONGITUDE'];
              $center=11;
              $nb_cppc=$this->Model->count_all_data('rh_cppc',array('PROVINCE_ID'=>$PROVINCE_ID));
              $nb_tick=$this->Model->count_all_data('tk_ticket',array('COMMUNE_ID'=>$COMMUNE_ID));    
            $tk_ticket=$this->Model->getList('tk_ticket',array('COMMUNE_ID'=>$COMMUNE_ID));


          }else{

            $requete='SELECT rh_cppc.CPPC_ID, rh_cppc.LATITUDE,
              rh_cppc.LONGITUDE,
              rh_cppc.CPPC_DESCR,
              rh_cppc.PROVINCE_ID,
              "CPPC" AS CPPC 
              FROM rh_cppc where rh_cppc.PROVINCE_ID="'.$PROVINCE_ID.'"

               union 
              select tk_ticket.TICKET_ID, 
              tk_ticket.LATITUDE,
              tk_ticket.LONGITUDE,
              tk_ticket.TICKET_DESCR,
              tk_ticket.COMMUNE_ID,
              "TICK" as TICK
              from tk_ticket  where tk_ticket.COMMUNE_ID<>""
              ';

              $cord_prov=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$PROVINCE_ID));
              $tab_coordonne=$cord_prov['PROVINCE_LATITUDE'].','.$cord_prov['PROVINCE_LONGITUDE'];
              $center=10;
              $nb_cppc=$this->Model->count_all_data('rh_cppc',array('PROVINCE_ID'=>$PROVINCE_ID));
              $nb_tick=$this->Model->count_all_data('tk_ticket',array());   
          
              $tk_ticket=$this->Model->getList('tk_ticket',array());

          }

        }else{

          $requete='SELECT rh_cppc.CPPC_ID, rh_cppc.LATITUDE,
              rh_cppc.LONGITUDE,
              rh_cppc.CPPC_DESCR,
              rh_cppc.PROVINCE_ID,
              "CPPC" AS CPPC 
              FROM rh_cppc

               union 
              select tk_ticket.TICKET_ID, 
              tk_ticket.LATITUDE,
              tk_ticket.LONGITUDE,
              tk_ticket.TICKET_DESCR,
              tk_ticket.COMMUNE_ID,
              "TICK" as TICK
              from tk_ticket';
              $nb_cppc=$this->Model->count_all_data('rh_cppc',array());
              $nb_tick=$this->Model->count_all_data('tk_ticket',array());   
                $tk_ticket=$this->Model->getList('tk_ticket',array());


        }
        $etat=1;
      }

                $liste_realisation=NULL;
               
                $communes=null;
                $collines=null;
                $sous_collines=null;
                
        $liste_realisation=$this->Model->getListRequest($requete);
        //echo "etat : ".$etat;
               
 
      if(!empty($liste_realisation)){

                 $MarkerIcon='';   
                 $icon='';
                 
                 $compteur=0;

        foreach ($liste_realisation as $key => $info_inc) {


            if($info_inc['CPPC']=='CPPC'){
            $MarkerIcon = $url.'leaflet/icons/arch.png';
                $icon=$url.'leaflet/icons/arch.png';
              
            }
            if($info_inc['CPPC']=='TICK'){
            $MarkerIcon = $url.'leaflet/icons/acupuncture.png';
                $icon=$url.'leaflet/icons/arch.png';
              
            }

                $MarkerFixe = true;
                 $compteur++;

                if($etat==1){

                  $tab_Infos = $tab_Infos . $info_inc['CPPC_ID'] . '<>' . str_replace("'", "", $info_inc['CPPC_DESCR']) . '<>' . $info_inc['LATITUDE'] . '<>' . $info_inc['LONGITUDE'] . '<>' . $MarkerIcon . '<>' . $MarkerFixe .'<>'.$icon.'<>'.$compteur.'<>'.'#';

                }

                if($etat==2){
                  $tab_Infos = $tab_Infos . $info_inc['CPPC_ID'] . '<>' . str_replace("'", "", $info_inc['CPPC_DESCR']) . '<>' . $info_inc['LATITUDE'] . '<>' . $info_inc['LONGITUDE'] . '<>' . $MarkerIcon . '<>' . $MarkerFixe .'<>'.$icon.'<>'.$compteur.'<>'.'#';
                }

                if($etat==3){
                  $tab_Infos = $tab_Infos . $info_inc['TICKET_ID'] . '<>' . str_replace("'", "", $info_inc['TICKET_DESCR']) . '<>' . $info_inc['LATITUDE'] . '<>' . $info_inc['LONGITUDE'] . '<>' . $MarkerIcon . '<>' . $MarkerFixe .'<>'.$compteur.'<>'.'#';
                }

                 $tab_itineraires.='['.$info_inc['LATITUDE'].','.$info_inc['LONGITUDE'].'],';

                   

              
            }

        }else{
            $tab_Infos = $tab_Infos .'0'. '<>' .''. '<>' .''. '<>' .'' . '<>'.''.'<>'.''.'<>' .''. '<>'. '#';
         } 

      
      if($tab_itineraires!="")
      {

          $tab_itineraires.=$tab_itineraires.'#';

       $tab_itineraires=str_replace(",#", "", $tab_itineraires);
      }

        $data_other['zooms']=$center;
        $data_other['listdata']=$tab_Infos;
        $data_other['coordCenter']=$tab_coordonne;
        $data_other['checked']=$checked;
        $data_other['checked2']=$checked2;
        $data_other['itineraires'] = $tab_itineraires;
        $data_other['ststm_provinces']=$this->Model->getList('ststm_provinces',array());
        $data_other['PROVINCE_ID']=$PROVINCE_ID;
        $data_other['COMMUNE_ID']=$COMMUNE_ID;
        $data_other['nb_cppc']=$nb_cppc;
        $data_other['nb_tick']=$nb_tick;
        $data_other['tk_ticket']=$tk_ticket;
    $this->load->view('Carte_cppc_view',$data_other);
    }
	}
 ?>