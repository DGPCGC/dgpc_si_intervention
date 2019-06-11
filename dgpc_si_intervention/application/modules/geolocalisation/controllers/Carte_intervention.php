<?php 

	/**
	* 
	*/
	class Carte_intervention extends CI_Controller
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

    function index($bip=NULL){
      
     if($this->mylibrary->get_permission('New_Map/index') ==0){
      redirect(base_url());
     }



			$send_alarm=0;

			    if($bip!=NULL)
			    {
			       $send_alarm=1;

			    }

			$PROVINCE_ID = $this->input->post('PROVINCE_ID');
			$CPPC_ID = $this->input->post('CPPC_ID');
			$OUV=$this->input->post('OUV');
	        $INT=$this->input->post('INT');
	        $CLO=$this->input->post('CLO');
	        $ATT=$this->input->post('ATT');
	        $FAA=$this->input->post('FAA');
	        $CANAL_ID=$this->input->post('CANAL_ID');
	        $CAUSE_ID=$this->input->post('CAUSE_ID');
	        $COMMUNE_ID = $this->input->post('COMMUNE_ID');
	        $les_slide='';


	        $select_OUV='';
            $select_INT='';
            $select_CLO='';
            $select_ATT='';
            $select_FAA='';
            $nombre_mort =0;
		    $nombre_mort_dgpc =0;
		    $nombre_blesse =0;
		    $nombre_blesse_dgpc =0;

            $count_statut1=NULL;
	        $count_statut2=NULL;
	        $count_statut3=NULL;
	        $count_statut4=NULL;
	        $count_statut5=NULL;

			$tab_coordonne='-3.2587478,29.3658475';
			$center=9;
			$tab_Infos='';

			$criteres_deux= 'STATUT_ID = 2';

			if($CANAL_ID>0){
				 
				$criteres_deux.=' AND CANAL_ID = '.$CANAL_ID.' ';
			}

			if($CAUSE_ID>0){
				 
				$criteres_deux.=' AND CAUSE_ID = '.$CAUSE_ID.' ';
			}


			$communes=NULL;
			if($PROVINCE_ID>0){
				$communes = $this->Model->getList('ststm_communes',array('PROVINCE_ID'=>$PROVINCE_ID));
			 

				if($COMMUNE_ID>0){

					$criteres_deux.=' AND COMMUNE_ID = '.$COMMUNE_ID.' ';
					$commu = $this->Model->getOne('ststm_communes',array('COMMUNE_ID'=>$COMMUNE_ID));
			 
              $tab_coordonne=$commu['COMMUNE_LATITUDE'].','.$commu['COMMUNE_LONGITUDE'];
              $center=13;

				}else{

			 $ststm_province=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$PROVINCE_ID));

              $tab_coordonne=$ststm_province['PROVINCE_LATITUDE'].','.$ststm_province['PROVINCE_LONGITUDE'];
              $center=12;
			$criteres_deux.=' AND (COMMUNE_ID IN(';
			foreach ($communes as $key_communes) {
				# code...
				$criteres_deux.=$key_communes['COMMUNE_ID'].',';
			}
			$criteres_deux .= '**';
            $criteres_deux = str_replace(',**', ')', $criteres_deux);
			$criteres_deux.=')';

				}

			

			}

			// //echo "Requete : ".$criteres_deux;

			$last_ticket = $this->Model->getLast('tk_ticket',$criteres_deux,'TICKET_ID');
			$incidents = $this->Model->getIncidentIntervention($criteres_deux);


			

			$MarkerIcon=base_url().'assets/bootstrap/care/carered1.jpg';        
                  
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
            $les_images = '';
            if(!empty($image_blob)){
            $les_images = '<img src="data:image/jpeg;base64,'.base64_encode($image_blob['IMAGE_BLOB']) .'" width="150px" height="150px" alt="user image" title="image" download/>';
             }
           
           $les_videos ="";
            $video_blob = $this->Model->getLast('interv_odk_videos',array('TICKET_CODE'=>$incident['TICKET_CODE']),'VIDEO_ID');
           /* echo "<pre>";
            echo $incident['TICKET_CODE'].'-->';
            print_r(sizeof($video_blob));
            echo "</pre>";*/
            if(!empty($video_blob)){
             $ma_video = "data:video/mp4;base64,".base64_encode($video_blob['VIDEO_BLOB']);
             $les_videos ="<video controls width='150px' height='150px'><source src='".$ma_video."' type='video/mp4'></video>"; 
           }
            

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
                          <a target="_blank" href="'.base_url('geolocalisation/Carte_intervention/image/').$incident['TICKET_CODE'].'"> 
                              <i style="size:0.6em;">Voir '.$incident['nb_image'].' Image(s) et '.$incident['nb_video'].'Video(s)
                              </i></a><br>Dernière image<br>'.$les_images.'<br>Dernière vidéo<br>'.$les_videos.'
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>';  

              }   

          //  else{
          //   $tab_Infos = $tab_Infos .'0'. '<>' .''. '<>' .''. '<>' .''. '<>' .''. '<>' .'' . '<>'.''.'<>'.''.'<>'.'<>'.'<>'.'<>'.'<>'.'<>'.'<>'. '#';
          // }




			$data['ststm_provinces'] =$this->Model->getList('ststm_provinces',array());
			 
			$data['breadcrumb'] = $this->make_bread->output();
			$data['title'] = 'Carte des interventions';
			$data['sildes'] = '';
			 
			$data['zooms']=$center;
			$data['list_data'] = $tab_Infos;
			$data['centerCoord']=$tab_coordonne;
			$data['title'] = "Carte de couverture des incidents";
          
            $data['canals'] = $this->Model->getList('tk_canal',array(),'CANAL_DESCR','ASC');
            $data['causes'] = $this->Model->getList('tk_causes',array(),'CAUSE_DESCR','ASC');

            $data['CANAL_ID'] =$CANAL_ID;
            $data['CAUSE_ID'] =$CAUSE_ID;
 
            $data['nombre_mort'] =$nombre_mort;
            $data['nombre_mort_dgpc'] =$nombre_mort_dgpc;
            $data['nombre_blesse'] =$nombre_blesse;
            $data['nombre_blesse_dgpc'] =$nombre_blesse_dgpc;
            $data['sildes'] =$les_slide;
            $data['PROVINCE_ID']=$PROVINCE_ID;
            $data['COMMUNE_ID']=$COMMUNE_ID;
            $data['bip']=$send_alarm;
            $data['ststm_communes'] =$communes;


			$this->load->view('Carte_intervention_view',$data);
		}

		function Bruit_carte(){
      $bruit=0;

      $tst_tick=$this->Model->getList('tk_ticket',array('STATUT_ID'=>2,'NEW_TICKET'=>0));
    if(!empty($tst_tick)){
      $bruit=1;
      $datss=array('NEW_TICKET'=>1);
      $misj=$this->Model->update('tk_ticket',array('NEW_TICKET'=>0),$datss);
    }else{
      $bruit=0;
    }

    echo $bruit;

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