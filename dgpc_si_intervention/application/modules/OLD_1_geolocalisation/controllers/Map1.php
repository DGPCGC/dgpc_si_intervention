<?php 

  class Map1 extends CI_Controller
  {
    
    function __construct()
    {
      parent::__construct();
      // $this->make_bread->add('Map couverture', "geolocalisation/Map", 0);
      $this->make_bread->add('Map Catastrophe', "geolocalisation/Map/map_cata", 0);
      $this->breadcrumb = $this->make_bread->output();
      $this->autho();
    }

    public function autho()
    {
		if(empty($this->session->userdata('DGPC_USER_EMAIL'))){
	      redirect(base_url());
	     }
    }

    function index(){
      
     if($this->mylibrary->get_permission('Map/index') ==0){
      redirect(base_url());
     }
     

      $criteres =array();

      $canal_id=$this->input->post('CANAL_ID');
      if($canal_id !=0)
        $criteres['CANAL_ID'] = $canal_id;

      $cause_id=$this->input->post('CAUSE_ID');
      if($cause_id !=0)
        $criteres['CAUSE_ID'] = $cause_id;

      $statut_id=$this->input->post('STATUT_ID');
      if($statut_id !=0)
        $criteres['STATUT_ID'] = $statut_id;

     
    $tab_coordonne = "";
    $center=10;
    $tab_Infos='';

    $incidents = $this->Model->getList('tk_ticket',$criteres);
    
    if(!empty($incidents)){
                    
       $MarkerIcon=base_url().'assets/bootstrap/images/icon.png'; 
      
                  
        foreach ($incidents as $incident) {
          $canal = $this->Model->getOne('tk_canal',array('CANAL_ID'=>$incident['CANAL_ID']));
          $cause = $this->Model->getOne('tk_causes',array('CAUSE_ID'=>$incident['CAUSE_ID']));
          $statut = $this->Model->getOne('tk_statuts',array('STATUT_ID'=>$incident['STATUT_ID']));
          
          $date_insertion = new DateTime($incident['DATE_INSERTION']);
          $date_insertion = $date_insertion->format('d/m/Y H:i');

           $tab_Infos = $tab_Infos . $incident['TICKET_ID'] . '<>' . str_replace("'", "\'", $incident['TICKET_DESCR']) . '<>' . $incident['LATITUDE'] . '<>' . $incident['LONGITUDE'] . '<>' . $MarkerIcon .'<>'.$incident['TICKET_CODE'].'<>'.str_replace("'", "\'",$incident['LOCALITE']).'<>'.$date_insertion.'<>'.$incident['TICKET_DECLARANT'].'('.$incident['TICKET_DECLARANT_TEL'].')'.'<>'.$canal['CANAL_DESCR'].'<>'.str_replace("'", "\'",$cause['CAUSE_DESCR']).'<>'.$statut['STATUT_DESCR'].'<>'.$statut['STATUT_COLOR'].'&&';
           }
          }else{
            $tab_Infos = $tab_Infos .'0'. '<>' .''. '<>' .''. '<>' .''. '<>' .''. '<>' .'' . '<>'.''.'<>'.''.'<>'.'<>'.'<>'.'<>'.'<>'.'<>'.'<>'. '#';
          }  

          $tab_coordonne ="-3.3896, 29.9256";
          $data_onther['zooms'] = $center;
          $data_onther['list_data'] = $tab_Infos;
          $data_onther['centerCoord'] = $tab_coordonne;
          $data_onther['breadcrumb'] = $this->make_bread->output();
          $data_onther['title'] = "Carte de couverture des incidents";
          
          $data_onther['canals'] = $this->Model->getList('tk_canal',array(),'CANAL_DESCR','ASC');
          $data_onther['causes'] = $this->Model->getList('tk_causes',array(),'CAUSE_DESCR','ASC');
          $data_onther['statuts'] = $this->Model->getList('tk_statuts',array(),'STATUT_DESCR','ASC');

          $data_onther['CANAL_ID'] =$canal_id;
          $data_onther['CAUSE_ID'] =$cause_id;
          $data_onther['STATUT_ID'] =$statut_id;

          $this->load->view('Map_Incident_View',$data_onther);
    }




    function result_search(){

       $commune=$this->input->post('commune');
       $CANAL_ID=$this->input->post('CANAL_ID');
       $CAUSE_ID=$this->input->post('CAUSE_ID');
       $PROVINCE_ID=$this->input->post('PROVINCE_ID');
       $DATE=$this->input->post('DATE');
       $infos1[]='';
       $infos2=NULL;
       $infos3=NULL;
       $infos4=NULL;
       $infos4=NULL;

       $criteres_all=array();

       if(!empty($commune)){
        foreach ($commune as $key => $value) {
            $infos1[]=$this->Model->getList('tk_ticket',array('COMMUNE_ID'=>$value));
        }
       }

       if(!empty($CANAL_ID)){
        foreach ($CANAL_ID as $key => $value) {
            $infos1[]=$this->Model->getList('tk_ticket',array('CANAL_ID'=>$value));
        }
       }

       if(!empty($CAUSE_ID)){
        foreach ($CAUSE_ID as $key => $value) {
             $infos1[]=$this->Model->getList('tk_ticket',array('CAUSE_ID'=>$value));
        }
       }

       if(!empty($DATE)){
             $infos1[]=$this->Model->getList('tk_ticket',array('DATE(DATE_INTERVENTION)'=>$DATE));
        
       }

      
        
        print_r($infos1);
    }


    public function ajouter_commune(){
        $id_prov=$this->input->post('id');
        $resultat='';

        foreach ($id_prov as $key => $value) {
          //
         //$commune=$this->Model->getListOrdered('ststm_communes','COMMUNE_NAME',array('PROVINCE_ID'=>$value));
         $ststm_communes=$this->Model->getList('ststm_communes',array('PROVINCE_ID'=>$value));
       
         $prvc=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$value));
      $resultat.='<optgroup label ="'.$prvc['PROVINCE_NAME'].'">';
      foreach ($ststm_communes as $key) {
        $resultat.="<option value='".$key['COMMUNE_ID']."'>".$key['COMMUNE_NAME']."</option>";
            }
            $resultat.='</optgroup>';
      }

      echo $resultat;
    }



    function enintervention(){
     if($this->mylibrary->get_permission('Map/enintervention') ==0){
      redirect(base_url());
     }

      $tab_coordonne = "";
      $tab_coordonne ="-3.3896, 29.9256";
      $ststm_communes=NULL;
      $center=10;
      $DATE=$this->input->post('DATE');

      $criteres =array();

      
      
      $criteres_un = 'STATUT_ID = 2';
     // print_r($criteres);

     // print_r($criteres);

     
     
    
    $tab_Infos='';
    $bruit=0;



      $commune=$this->input->post('commune');
       $CANAL_ID=$this->input->post('CANAL_ID');

       //print_r($CANAL_ID);
       $CAUSE_ID=$this->input->post('CAUSE_ID');
       $PROVINCE_ID=$this->input->post('PROVINCE_ID');
       $DATE=$this->input->post('DATE');
       $infos1[]='';
       $infos2=NULL;
       $infos3=NULL;
       $infos4=NULL;
       $infos4=NULL;

       $criteres_all=array();
      // $criteres_un='';

     
       if(!empty($CANAL_ID)){
       $crit_cnl = " tt.CANAL_ID IN (";
    
        foreach ($CANAL_ID as $key => $value) {
          $crit_cnl.= $value.',';
            //$infos1=$this->Model->getList('tk_ticket',array('CANAL_ID'=>$value,'STATUT_ID'=>2));
        }
        $crit_cnl .= '**';
        $crit_cnl = str_replace(',**', ')', $crit_cnl);

       
        if(!empty($criteres_un)){
           $criteres_un .= " AND ".$crit_cnl;

        }else{
           $criteres_un .= $crit_cnl;

        }
       }

      
       if(!empty($CAUSE_ID)){

        $crit_cnl1 = " tt.CAUSE_ID IN (";
    
        foreach ($CAUSE_ID as $key => $value) {
          $crit_cnl1.= $value.',';
            //$infos1=$this->Model->getList('tk_ticket',array('CANAL_ID'=>$value,'STATUT_ID'=>2));
        }
        $crit_cnl1 .= '**';
        $crit_cnl1 = str_replace(',**', ')', $crit_cnl1);

        if(!empty($criteres_un)){
          $criteres_un .=" AND ".$crit_cnl1;
        }else{
          $criteres_un .= $crit_cnl1;
        }

        
         
       }

         if(!empty($commune)){
         $crit_cnl2 = " tt.COMMUNE_ID IN (";
    
        foreach ($commune as $key => $value) {
          $crit_cnl2.= $value.',';
            //$infos1=$this->Model->getList('tk_ticket',array('CANAL_ID'=>$value,'STATUT_ID'=>2));
        }
        $crit_cnl2 .= '**';
        $crit_cnl2 = str_replace(',**', ')', $crit_cnl2);

        if(!empty($criteres_un)){
           $criteres_un .=" AND ".$crit_cnl2;
        }else{
           $criteres_un .= $crit_cnl2;
        }

       
       }

       if(!empty($DATE)){
             $crit_cnl3=" DATE(DATE_INTERVENTION) = ".$DATE;
             if(!empty($criteres_un)){
               $criteres_un.=" AND ".$crit_cnl3;
             }else{
               $criteres_un.=$crit_cnl3;
             }
           
       }
       

  /*      //echo $criteres_un;
       if(!empty($criteres_un)){
         $infos1=$this->Model->querysql("SELECT *FROM tk_ticket WHERE ".$criteres_un);
        
       }else{
        $infos1=$this->Model->querysql("SELECT *FROM tk_ticket");
       }
*/
        //echo "R : ".$criteres_un;

      
    $incidents = $this->Model->getIncidentIntervention($criteres_un);
    

    if(!empty($infos1)){
      $bruit=1;
    }
    //print_r($incidents);
    $nombre_mort =0;
    $nombre_mort_dgpc =0;
    $nombre_blesse =0;
    $nombre_blesse_dgpc =0;

    $les_slide = '';
    $last_ticket = $this->Model->getLast('tk_ticket',$criteres,'TICKET_ID');
    
    if(!empty($infos1)){
                    
        $MarkerIcon=base_url().'assets/bootstrap/images/icon.png';        
                  
        foreach ($incidents as $incident) {
          $nombre_mort += count($this->Model->getList('interv_odk_degat_humain',array('CONCERNE_DGPC'=>0,'TICKET_CODE'=>$incident['TICKET_CODE'])));
          $nombre_mort_dgpc += count($this->Model->getList('interv_odk_degat_humain',array('CONCERNE_DGPC'=>1,'TICKET_CODE'=>$incident['TICKET_CODE'])));
          $nombre_blesse += count($this->Model->getList('interv_odk_degat_materiel',array('CONCERNE_DGPC'=>0,'TICKET_CODE'=>$incident['TICKET_CODE'])));
          $nombre_blesse_dgpc += count($this->Model->getList('interv_odk_degat_materiel',array('CONCERNE_DGPC'=>1,'TICKET_CODE'=>$incident['TICKET_CODE'])));
          $canal = $this->Model->getOne('tk_canal',array('CANAL_ID'=>$incident['CANAL_ID']));
          $cause = $this->Model->getOne('tk_causes',array('CAUSE_ID'=>$incident['CAUSE_ID']));
          $statut = $this->Model->getOne('tk_statuts',array('STATUT_ID'=>$incident['STATUT_ID']));
          
          $date_insertion = new DateTime($incident['DATE_INSERTION']);
          $date_insertion = $date_insertion->format('d/m/Y H:i'); 

          $date_onsite = new DateTime($incident['DATE_INTERVENTION']);
          $date_onsite = ($incident['DATE_INTERVENTION'] != NULL)?$date_onsite->format('d/m/Y H:i'):'';

           $tab_Infos = $tab_Infos . $incident['TICKET_ID'] . '<>' . str_replace("'", "\'", $incident['TICKET_DESCR']) . '<>' . $incident['LATITUDE'] . '<>' . $incident['LONGITUDE'] . '<>' . $MarkerIcon .'<>'.$incident['TICKET_CODE'].'<>'.$incident['LOCALITE'].'<>'.$date_insertion.'<>'.$incident['TICKET_DECLARANT'].'('.$incident['TICKET_DECLARANT_TEL'].')'.'<>'.str_replace("'", "\'",$canal['CANAL_DESCR']).'<>'.str_replace("'", "\'",$cause['CAUSE_DESCR']).'<>'.$statut['STATUT_DESCR'].'<>'.$statut['STATUT_COLOR'].'<>'.$incident['CODE_EVENEMENT'].'&&';

          // La partie des images et video 
            $image_blob = $this->Model->getLast('interv_odk_images',array('TICKET_CODE'=>$incident['TICKET_CODE']),'IMAGE_ID');
            $les_images = '<img src="data:image/jpeg;base64,'.base64_encode($image_blob['IMAGE_BLOB']) .'" width="150px" height="150px" alt="user image" title="image" download/>';

            $video_blob = $this->Model->getLast('interv_odk_videos',array('TICKET_CODE'=>$incident['TICKET_CODE']),'VIDEO_ID');
             $ma_video = "data:video/mp4;base64,".base64_encode($video_blob['VIDEO_BLOB']);
             $les_videos ="<video controls width='150px' height='150px'><source src='".$ma_video."' type='video/mp4'></video>";
            

            $active = ($incident['TICKET_ID'] ==$last_ticket['TICKET_ID'])?'active':'';
            $les_slide .='<div class="item '.$active.'">
                <div class="panel panel-primary">
                  <div class="panel-heading">'.$incident['TICKET_DESCR'] .' ('.$incident['TICKET_CODE'].')</div>
                  <div class="panel-body">
                    <a href="#carousel-example-generic" role="button" data-slide="next">
                      <div class="row">
                        <div class="col-md-12">
                          <strong>'.$incident['TICKET_DESCR'].'</strong><br>
                          <a target="_blank" href="'.base_url('tickets/Tickets/detail/'.$incident['TICKET_CODE']).'">Fiche d\'intervention</a><br>
                          Code intervention:<b>'.$incident['TICKET_CODE'].'</b><br>
                          <font color="'.$statut['STATUT_COLOR'].'">Statut:<b>'.$statut['STATUT_DESCR'].'</b></font><br>
                          Localité:<b>'.$incident['LOCALITE'].'</b><br>
                          Date ouverture:<b>'.$date_insertion.'</b><br>
                          Date onsite:<b>'.$date_onsite.'</b><br>
                        </div>
                        <div class="col-md-12">
                          <a target="_blank" href="'.base_url('geolocalisation/Map/image/').$incident['TICKET_CODE'].'"> 
                              <i style="size:0.6em;">Voir '.$incident['nb_image'].' Image(s) et '.$incident['nb_video'].'Video(s)
                              </i></a><br>Dernière image<br>'.$les_images.'<br>Dernière vidéo<br>'.$les_videos.'
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>';     

           }
          }else{
            $tab_Infos = $tab_Infos .'0'. '<>' .''. '<>' .''. '<>' .''. '<>' .''. '<>' .'' . '<>'.''.'<>'.''.'<>'.'<>'.'<>'.'<>'.'<>'.'<>'.'<>'. '#';
          }  

         // echo $tab_Infos;

          $data_onther['zooms'] = $center;
          $data_onther['list_data'] = $tab_Infos;
          $data_onther['centerCoord'] = $tab_coordonne;
          $data_onther['breadcrumb'] = $this->make_bread->output();
          $data_onther['title'] = "Carte de couverture des incidents";
          
          $data_onther['canals'] = $this->Model->getList('tk_canal',array(),'CANAL_DESCR','ASC');
          $data_onther['causes'] = $this->Model->getList('tk_causes',array(),'CAUSE_DESCR','ASC');

          $data_onther['CANAL_ID'] ='';
          $data_onther['CAUSE_ID'] ='';
 
          $data_onther['nombre_mort'] =$nombre_mort;
          $data_onther['nombre_mort_dgpc'] =$nombre_mort_dgpc;
          $data_onther['nombre_blesse'] =$nombre_blesse;
          $data_onther['nombre_blesse_dgpc'] =$nombre_blesse_dgpc;
          $data_onther['sildes'] =$les_slide;
          $data_onther['ststm_communes']=$ststm_communes;
          $data_onther['COMMUNE_ID']='';
          $data_onther['PROVINCE_ID']=$PROVINCE_ID;
          $data_onther['DATE']=$DATE;
          $data_onther['bruit']=$bruit;

          $this->load->view('Map_EnIntervention1_View',$data_onther);
    }

    public function map_cppc(){
      if($this->mylibrary->get_permission('Map/index') ==0){
      redirect(base_url());
     }

    
      // $criteres =array();

      // $canal_id=$this->input->post('CANAL_ID');
      // if($canal_id !=0)
      //   $criteres['CANAL_ID'] = $canal_id;

      // $cause_id=$this->input->post('CAUSE_ID');
      // if($cause_id !=0)
      //   $criteres['CAUSE_ID'] = $cause_id;

      // $statut_id=$this->input->post('STATUT_ID');
      // if($statut_id !=0)
      //   $criteres['STATUT_ID'] = $statut_id;

     
    $tab_coordonne = "";
    $center=10;
    $tab_Infos='';

    $caserne = $this->Model->getList('rh_cppc',array());
    // print_r($caserne);
    // exit();
    
    if(!empty($caserne)){
                  
       $MarkerIcon=base_url().'assets/bootstrap/images/logo_fire.png'; 

      
                  
        foreach ($caserne as $casernes) {
           $provice=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$casernes['PROVINCE_ID']));

           $tab_Infos = $tab_Infos . $casernes['CPPC_NOM'].'<>'.$casernes['CPPC_DESCR']. '<>' . $casernes['LATITUDE'] . '<>' . $casernes['LONGITUDE'] . '<>' . $MarkerIcon .'<>'.$casernes['CPPC_TEL'].'<>'.$casernes['CPPC_EMAIL'].'<>'.$provice['PROVINCE_NAME'].'&&';
           }
          }else{
            $tab_Infos = $tab_Infos .'0'. '<>' .''. '<>' .''. '<>' .''. '<>' .''. '<>' .'' . '<>'.''.'<>'.'#';
          }  

          $tab_coordonne ="-3.3896, 29.9256";
          $data_onther['zooms'] = $center;
          $data_onther['list_data'] = $tab_Infos;
          $data_onther['centerCoord'] = $tab_coordonne;
          $data_onther['breadcrumb'] = $this->make_bread->output();
          $data_onther['title'] = "Carte de couverture CPPC";
        

          $this->load->view('Map_ccpc_View',$data_onther);

    }

    public function map_cata(){
      if($this->mylibrary->get_permission('Map/index') ==0){
      redirect(base_url());
     }

      
     


     $catastr=$this->Model->querysql('SELECT DISTINCT(USER_ODK) FROM odk_form');
     
     $localite=$this->Model->querysql('SELECT DISTINCT(LOCALITE) FROM odk_form');
     

      // $criteres =array();

      // $canal_id=$this->input->post('CANAL_ID');
      // if($canal_id !=0)
      //   $criteres['CANAL_ID'] = $canal_id;

      // $cause_id=$this->input->post('CAUSE_ID');
      // if($cause_id !=0)
      //   $criteres['CAUSE_ID'] = $cause_id;

      // $statut_id=$this->input->post('STATUT_ID');
      // if($statut_id !=0)
      //   $criteres['STATUT_ID'] = $statut_id;

     
    $tab_coordonne = "";
    $center=10;
    $tab_Infos='';
    $les_slide = '';

    if($_SERVER['REQUEST_METHOD']=='POST'){
         $check=$this->input->post('check');
         if($check==1){
            $agent=$this->input->post('AGENT');

            $catas = $this->Model->getList('odk_form',array('USER_ODK'=>$agent));
            $last_cata = $this->Model->getLast('odk_form',array('USER_ODK'=>$agent),'ID');

         }else if($check==2){
            $localite=$this->input->post('LOCALITE');
            $catas = $this->Model->getList('odk_form',array('LOCALITE'=>$localite));
            $last_cata = $this->Model->getLast('odk_form',array('LOCALITE'=>$localite),'ID');
         }
      }else{
        $catas = $this->Model->getList('odk_form',array());
        $last_cata = $this->Model->getLast('odk_form',array(),'ID');
      }

    

    
    // print_r($caserne);
    // exit();
    
    if(!empty($catas)){
                  
       $MarkerIcon=base_url().'assets/bootstrap/images/icon.png'; 

      
                  
        foreach ($catas as $cata) {
          if($last_cata['ID']==$cata['ID']){
            $bounced=0;
          }else{
            $bounced=1;
          }
           
           $tab_Infos = $tab_Infos .str_replace("'", "\'", $cata['DESCR_CATASTROPHE']).'<>'.str_replace("'", "", $cata['USER_ODK']). '<>' . $cata['LATITUDE'] . '<>' . $cata['LONGITUDE'] . '<>' . $MarkerIcon .'<>'.$cata['DATETIME'].'<>'.$bounced.'<>'.str_replace("'", "", $cata['LOCALITE']).'<>'.$cata['DATE_SAISIE'].'#';

            $active = ($cata['ID'] ==$last_cata['ID'])?'active':'';
            $les_slide .='<div class="item '.$active.'">
                <div class="panel panel-primary">
                  <div class="panel-heading">'.$cata['DESCR_CATASTROPHE'] .'</div>
                  <div class="panel-body">
                    <a href="#carousel-example-generic" role="button" data-slide="next">
                      <div class="row">
                        <div class="col-md-12">
                          <strong>'.$cata['DESCR_CATASTROPHE'].'</strong><br>      
                          Lieu :<b>'.$cata['LOCALITE'].'</b><br>
                          Agent :<b>'.$cata['USER_ODK'].'</b><br>
                          Date catastrophe :<b>'.$cata['DATETIME'].'</b><br>
                          Date déclaration :<b>'.$cata['DATE_SAISIE'].'</b><br>
                        </div>
                        
                      </div>
                    </a>
                  </div>
                </div>
              </div>';
           }
          }else{
$tab_Infos = $tab_Infos .'0'. '<>' .''. '<>' .''. '<>' .''. '<>' .''. '<>'.''.'<>'.'#';
          }  



          $tab_coordonne ="-3.3896, 29.9256";
          $data_onther['zooms'] = $center;
          $data_onther['list_data'] = $tab_Infos;
          $data_onther['centerCoord'] = $tab_coordonne;
          $data_onther['sildes'] =$les_slide;
          $data_onther['agent'] =$catastr;
          $data_onther['localite'] =$localite;
          // $this->make_bread->add('Map Catastrophe', "geolocalisation/Map/map_cata", 1);
          $data_onther['breadcrumb'] = $this->make_bread->output();
          $data_onther['title'] = "Carte de couverture catastrophes passées";


          //print_r($data_onther['list_data']);
        

          $this->load->view('Map_Cata_View',$data_onther);
    }

    public function image()
    {
      $TICKET_CODE = $this->uri->segment(4);
      $data['ticket'] = $this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$TICKET_CODE));
      $data['images'] = $this->Model->getList('interv_odk_images',array('TICKET_CODE'=>$TICKET_CODE));
      $data['videos'] = $this->Model->getList('interv_odk_videos',array('TICKET_CODE'=>$TICKET_CODE));
      $data['title'] = "Détail du ticket";

      $this->load->view('Map_Image_View',$data);
    }

    public function video()
    {
      $video_id = $this->uri->segment(4);

      $data['video'] = $this->Model->getOne('interv_odk_videos',array('VIDEO_ID'=>$video_id));
      $data['title'] = "La vidéo";

      $this->load->view('Map_Video_View',$data);
    }
  }

 ?>