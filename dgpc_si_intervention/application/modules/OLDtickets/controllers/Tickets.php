<?php

 class Tickets extends MY_Controller
 {
 	
 	function __construct()
 	{
 	  parent::__construct();
    $this->load->model("Model_Demande");
    $this->make_bread->add('Interventions', "tickets/Tickets", 0);
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
      if($this->mylibrary->get_permission('Tickets/index') ==0){
          redirect(base_url());
         }

      $data['title'] = "Nouveau Ticket d'intervention";
      $data['categories'] = $this->Model->getListOrder('tk_categories',array(),'CATEGORIE_DESCR');
      $data['canals'] = $this->Model->getListOrder('tk_canal',array(),'CANAL_DESCR');
      $data['causes'] = $this->Model->getListOrder('tk_causes',array(),'CAUSE_DESCR');
      $data['provinces'] = $this->Model->getListOrder('ststm_provinces',array(),'PROVINCE_NAME');
      $data['cppcs'] = $this->Model->getListOrder('rh_cppc',array(),'CPPC_NOM');
      //$this->layout($data);
      $data['breadcrumb'] = $this->make_bread->output();

      $this->load->view('ticket/Ticket_Nouveau_View',$data);
    }

    public function save()
    {
       $this->form_validation->set_rules('CANAL_ID', 'Canal', 'required');
       $this->form_validation->set_rules('COMMUNE_ID', 'Commune', 'required');
       $this->form_validation->set_rules('CATEGORIE_ID', 'Catégorie', 'required');
       $this->form_validation->set_rules('TICKET_DECLARANT_TEL', 'Déclarant Tel.', 'required');
       $this->form_validation->set_rules('TICKET_DECLARANT', 'Déclarant', 'required');
       $this->form_validation->set_rules('CAUSE_ID', 'Cause', 'required');
       $this->form_validation->set_rules('LOCALITE', 'Localité', 'required');
       $this->form_validation->set_rules('CPPC_ID', 'CPPC', 'required');
       $this->form_validation->set_rules('TICKET_DESCR', 'Déscription', 'required');
       
       $info_cause=$this->Model->getOne('tk_causes',array('CAUSE_ID'=>$this->input->post('CAUSE_ID')));

        if ($this->form_validation->run() == FALSE) {
            
            //$this->page = "Ticket_Nouveau_View";
            $data['title'] = "Neauveau Ticket d'intervention";
            $data['canals'] = $this->Model->getListOrder('tk_canal',array(),'CANAL_DESCR');
            $data['causes'] = $this->Model->getListOrder('tk_causes',array(),'CAUSE_DESCR');
            $data['categories'] = $this->Model->getListOrder('tk_categories',array(),'CATEGORIE_DESCR');
            $data['provinces'] = $this->Model->getListOrder('ststm_provinces',array(),'PROVINCE_NAME');
            $data['cppcs'] = $this->Model->getListOrder('rh_cppc',array(),'CPPC_NOM');

            $data['breadcrumb'] = $this->make_bread->output();
            $this->load->view('ticket/Ticket_Nouveau_View',$data);

    	  }else if($info_cause['CAUSE_CODE']=="AUTR"){
              $data['title'] = "Neauveau Ticket d'intervention";
              $data['breadcrumb'] = $this->make_bread->output();

              $check=$this->Model->checkvalue('tk_causes',array('CAUSE_CODE'=>$this->input->post('CODE')));
              if($check==1){
                 $data['message']='<div class="alert alert-danger text-center">ECHEC! ce nouveau code de la cause exist deja.</div>';
                $this->session->set_flashdata($data);
               $this->load->view('ticket/Ticket_Nouveau_View',$data); 
              }else{
                $cause_id = $this->Model->insert_last_id('tk_causes',array('CAUSE_DESCR'=>$this->input->post('AUTRE'),'CAUSE_CODE'=>$this->input->post('CODE'),'CATEGORIE_ID'=>$this->input->post('CATEGORIE_ID')));
                $array_ticket = array(
                                'CANAL_ID'=>$this->input->post('CANAL_ID'),
                                'COMMUNE_ID'=>$this->input->post('COMMUNE_ID'),
                                'TICKET_DECLARANT_TEL'=>$this->input->post('TICKET_DECLARANT_TEL'),
                                'TICKET_DECLARANT'=>$this->input->post('TICKET_DECLARANT'),
                                'CAUSE_ID'=>$cause_id,
                                'LOCALITE'=>$this->input->post('LOCALITE'),
                                'TICKET_DESCR'=>$this->input->post('TICKET_DESCR'),
                                'COMMENTAIRE'=>$this->input->post('COMMENTAIRE'),
                                'NOMBRE_MORT'=>$this->input->post('NOMBRE_MORT'),
                                'NOMBRE_BLESSE'=>$this->input->post('NOMBRE_BLESSE'),
                                'CATEGORIE_ID'=>$this->input->post('CATEGORIE_ID'),
                                'CPPC_ID'=>$this->input->post('CPPC_ID'),
                                'CODE_EVENEMENT'=>'GDPC_',
                                'TICKET_CODE'=>'GDPC_',
                                'LATITUDE'=>-1,
                                'LONGITUDE'=>-1,
                                'STATUT_ID'=>1,
                                'USER_ID'=>$this->session->userdata('DGPC_USER_ID')
                                );
            $ticket_id = $this->Model->insert_last_id('tk_ticket',$array_ticket);

            $msg = "<font color='red'>Cet Ticket d'intervention n'a pas été enregistré.</font>";
            if($ticket_id >0){
              $code_tkt = ''.$ticket_id;
              
              $categorie = $this->Model->getOne('tk_categories',array('CATEGORIE_ID'=>$this->input->post('CATEGORIE_ID')));
              $cause = $this->Model->getOne('tk_causes',array('CAUSE_ID'=>$this->input->post('CAUSE_ID')));

              $code_tkt_int = $ticket_id.$categorie['CATEGORIE_CODE'].'_'.$cause['CAUSE_CODE'].$this->input->post('NOMBRE_MORT').$this->input->post('NOMBRE_BLESSE');

              $array_update = array('CODE_EVENEMENT'=>$code_tkt_int,'TICKET_CODE'=>$code_tkt);
              $this->Model->update_table('tk_ticket',array('TICKET_ID'=>$ticket_id),$array_update);

             //$msg = "<font color='green'> Cet évenement <b>".$this->input->post('TICKET_DESCR')."</b> a été enregistré.</font>";
              $id_notif_caserne=$this->input->post('CPPC_ID');
              $localite_notif=$this->input->post('LOCALITE');
              $tk_code_notif=$code_tkt;


              $notificat=$this->notification($id_notif_caserne,$localite_notif,$tk_code_notif);
             
                $msg = "<font color='green'> Cet évenement <b>".$this->input->post('TICKET_DESCR')."</b> a été enregistré.</font>";
             

            }

            $donne['msg'] =$msg;
            $this->session->set_flashdata($donne);

            redirect(base_url().'tickets/Tickets/liste');
              }
             
        }else{
            $array_ticket = array(
                                'CANAL_ID'=>$this->input->post('CANAL_ID'),
                                'COMMUNE_ID'=>$this->input->post('COMMUNE_ID'),
                                'TICKET_DECLARANT_TEL'=>$this->input->post('TICKET_DECLARANT_TEL'),
                                'TICKET_DECLARANT'=>$this->input->post('TICKET_DECLARANT'),
                                'CAUSE_ID'=>$this->input->post('CAUSE_ID'),
                                'LOCALITE'=>$this->input->post('LOCALITE'),
                                'TICKET_DESCR'=>$this->input->post('TICKET_DESCR'),
                                'COMMENTAIRE'=>$this->input->post('COMMENTAIRE'),
                                'NOMBRE_MORT'=>$this->input->post('NOMBRE_MORT'),
                                'NOMBRE_BLESSE'=>$this->input->post('NOMBRE_BLESSE'),
                                'CATEGORIE_ID'=>$this->input->post('CATEGORIE_ID'),
                                'CPPC_ID'=>$this->input->post('CPPC_ID'),
                                'CODE_EVENEMENT'=>'GDPC_',
                                'TICKET_CODE'=>'GDPC_',
                                'LATITUDE'=>-1,
                                'LONGITUDE'=>-1,
                                'STATUT_ID'=>1,
                                'USER_ID'=>$this->session->userdata('DGPC_USER_ID')
                                );
            $ticket_id = $this->Model->insert_last_id('tk_ticket',$array_ticket);

            $msg = "<font color='red'>Cet Ticket d'intervention n'a pas été enregistré.</font>";
            if($ticket_id >0){
              $code_tkt =$ticket_id;
              
              $categorie = $this->Model->getOne('tk_categories',array('CATEGORIE_ID'=>$this->input->post('CATEGORIE_ID')));
              $cause = $this->Model->getOne('tk_causes',array('CAUSE_ID'=>$this->input->post('CAUSE_ID')));

              $code_tkt_int = $ticket_id.$categorie['CATEGORIE_CODE'].'_'.$cause['CAUSE_CODE'].$this->input->post('NOMBRE_MORT').$this->input->post('NOMBRE_BLESSE');

              $array_update = array('CODE_EVENEMENT'=>$code_tkt_int,'TICKET_CODE'=>$code_tkt);
              $this->Model->update_table('tk_ticket',array('TICKET_ID'=>$ticket_id),$array_update);

              //Teddy traitement
              // $id_caserne=$this->input->post('CPPC_ID');
              // $equipes=$this->Model->get
              $id_notif_caserne=$this->input->post('CPPC_ID');
              $localite_notif=$this->input->post('LOCALITE');
              $NOTIFIE_DAHMI = $this->input->post('NOTIFIE_DAHMI');       
       
            $notificat=$this->notification($id_notif_caserne,$localite_notif,$code_tkt,$NOTIFIE_DAHMI);
            
              $msg = "<font color='green'> Cet évenement <b>".$this->input->post('TICKET_DESCR')."</b> a été enregistré.</font>";
           
             
            }

            $donne['msg'] =$msg;
            $this->session->set_flashdata($donne);

            redirect(base_url().'tickets/Tickets/liste');
        }
    }

    public function notification($cppc_id,$localite_notif,$tk_code,$NOTIFIE_DAHMI){
        $statut_notif = 0;

        //Notifier Manager Equipe 
        
           $manager = $this->Model->getOne('rh_cppc_manager',array('CPPC_ID'=>$cppc_id));
           $personnel_chef = $this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$manager['PERSONNEL_ID'])); 
           
           if(!empty($personnel_chef)){
              $msg_manager = "Cher(e), ".$personnel_chef['PERSONNEL_NOM']." ".$personnel_chef['PERSONNEL_PRENOM']." vous êtes appeler à intervenir à un incident dans la localité de ".$localite_notif.". Le code d'intervention est ".$tk_code."; Merci";
              $subjet = "Appel à une intervention";
              $this->notifications->smtp_mail($personnel_chef['PERSONNEL_EMAIL'],$subjet,NULL,$msg_manager,NULL);
              $this->notifications->send_sms('+257'.$personnel_chef['PERSONNEL_TELEPHONE'],$msg_manager);
            }

        //Notifie DHAMI
        if($this->input->post('CAUSE_ID') == 14){
           $membre_dhami = $this->Model->getMembreDHAMI();

           foreach ($membre_dhami as $membre) {
              $msg_dhami = "Cher(e), ".$membre['PERSONNEL_NOM']." ".$membre['PERSONNEL_PRENOM']." vous êtes appeler à intervenir à un incident dans la localité de ".$localite_notif.". Le code d'intervention est ".$tk_code."; Merci";
             $this->notifications->smtp_mail($membre['PERSONNEL_EMAIL'],$subjet,NULL,$msg_dhami,NULL);
             $this->notifications->send_sms('+257'.$membre['PERSONNEL_TELEPHONE'],$msg_dhami);
           }
        }

        //Notifier Membres de l'Equipe
        $equipe_sur_horaire=$this->Model->getEquipeHoraire(date('H'),$cppc_id);
        
        if(!empty($equipe_sur_horaire)){
          $membres=$this->Model->getList('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$equipe_sur_horaire['EQUIPE_ID']));
          
          foreach($membres as $membre){
            $collaborateur =$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$membre['PERSONEL_ID']));
            $email=$collaborateur['PERSONNEL_EMAIL'];

            $msg_intervention = "Cher(e), ".$collaborateur['PERSONNEL_NOM']." ".$collaborateur['PERSONNEL_PRENOM']." vous êtes appeler à intervenir à un incident dans la localité de ".$localite_notif.". Le code d'intervention est ".$tk_code."; Merci";
            $subjet = "Appel à une intervention";
            
            $commentaire='Aller Faire une intervention';

            $array =  array(
                      'EQUIPE_ID'=>$equipe_sur_horaire['EQUIPE_ID'],
                      'COMMENTAIRE'=>$commentaire,
                      'TICKET_CODE'=>$tk_code,
                      'PERSONNEL_ID'=>$membre['PERSONEL_ID'],
                      'USER_ID'=>$this->session->userdata('DGPC_USER_ID')
                      );
           $intertvention_id = $this->Model->create('interv_intervenants',$array);
           $ticket = $this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$tk_code));

           $array_notification = array(
                                    'TICKET_ID'=>$ticket['TICKET_ID'],
                                    'MESSAGE_TEL'=>$msg_intervention,
                                    'EQUIPE_ID'=>$equipe_sur_horaire['EQUIPE_ID'],
                                    'TELEPHONE'=>$collaborateur['PERSONNEL_TELEPHONE']);

            $intertvention_id = $this->Model->create('interv_notification',$array_notification);  

            $this->notifications->smtp_mail($email,$subjet,NULL,$msg_intervention,NULL);
            $this->notifications->send_sms('+257'.$collaborateur['PERSONNEL_TELEPHONE'],$msg_intervention);
          
          }

          $statut_notif = 1;
        }
       return $statut_notif;
    }
    public function notification_appui($cppc_id,$localite_notif,$tk_code,$appuis){
       
          $ap=explode("|", $appuis);
          foreach ($ap as $k => $v) {
            # code...
            $equipe_sur_horaire=$this->Model->getEquipeHoraire(date('H'),$v);

                $statut_notif = 0;
       if(!empty($equipe_sur_horaire)){
          $membres=$this->Model->getList('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$equipe_sur_horaire['EQUIPE_ID']));
          
          foreach($membres as $membre){
            $collaborateur =$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$membre['PERSONEL_ID']));
            $email=$collaborateur['PERSONNEL_EMAIL'];

            $msg_intervention = "Cher(e), ".$collaborateur['PERSONNEL_NOM']." ".$collaborateur['PERSONNEL_PRENOM']." vous êtes appeler à intervenir à un incident dans la localité de ".$localite_notif.". Le code d'intervention est ".$tk_code."; Merci";
            $subjet = "Appel à une intervention";
            $this->notifications->smtp_mail($email,$subjet,NULL,$msg_intervention,NULL);

            $this->notifications->send_sms('+257'.$collaborateur['PERSONNEL_TELEPHONE'],$msg_intervention);

            $commentaire='Aller Faire une intervention';

            $array =  array(
                      'EQUIPE_ID'=>$equipe_sur_horaire['EQUIPE_ID'],
                      'COMMENTAIRE'=>$commentaire,
                      'TICKET_CODE'=>$tk_code,
                      'PERSONNEL_ID'=>$membre['PERSONEL_ID'],
                      'USER_ID'=>$this->session->userdata('DGPC_USER_ID'),
                      'IS_APPUI'=>1
                      );
           $intertvention_id = $this->Model->create('interv_intervenants',$array);
           $ticket = $this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$tk_code));

           $array_notification = array(
                                    'TICKET_ID'=>$ticket['TICKET_ID'],
                                    'MESSAGE_TEL'=>$msg_intervention,
                                    'EQUIPE_ID'=>$equipe_sur_horaire['EQUIPE_ID'],
                                    'TELEPHONE'=>$collaborateur['PERSONNEL_TELEPHONE']);

            $intertvention_id = $this->Model->create('interv_notification',$array_notification);            
          }

          $statut_notif = 1;
        }

            

          }
          return $statut_notif;
       
    }
    public function getCommune()
    {
      //TROUVER COMMUNE
      $PROVINCE_ID = $this->input->post('PROVINCE_ID');
      $prov=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$PROVINCE_ID));
      $COMMUNE_ID = $this->input->post('COMMUNE_ID');
      $communes =$this->Model->getListOrder('ststm_communes',array('PROVINCE_ID'=>$PROVINCE_ID),'COMMUNE_NAME');
     
      $mes_communes = "<select class='form-control' name='COMMUNE_ID'><option value=''> - Sélectionner -</option>";
      if(!empty($communes)){
        foreach ($communes as $commune) {
          if($commune['COMMUNE_ID'] == $COMMUNE_ID){
          $mes_communes .= "<option value='".$commune['COMMUNE_ID']."' selected>".$commune['COMMUNE_NAME']."</option>";
        }else{
          $mes_communes .= "<option value='".$commune['COMMUNE_ID']."'>".$commune['COMMUNE_NAME']."</option>";
        }
        }
      }
      
      $mes_communes .= "</select>";
      // TROUVER CPPC
      $cppc=$this->Model->getList('rh_cppc');
      $option="<option value=''>--Selectionner--</option>";
      $opt="<h4 style='color:red'>choisir Appui</h4><table>";
      $id_cppc=0;
    foreach ($cppc as $key) {
      # code...
      if($key['PROVINCE_ID']==$PROVINCE_ID){
        $option.="<option value='".$key['CPPC_ID']."' selected>".$key['CPPC_NOM']."</option>";
        $id_cppc=$key['CPPC_ID'];
      }else{
      $option.="<option value='".$key['CPPC_ID']."'>".$key['CPPC_NOM']."</option>";
      }
      if($key['PROVINCE_ID']!=$PROVINCE_ID){
      $opt.="<tr><td><input type='checkbox' name='tout[]'' value='".$key['CPPC_ID']."' class='tout' id='' ></td><td>".$key['CPPC_NOM']."</td><p></tr>";
      }
    }
    $opt.="</table>";

    // TROUVER MATERIEL ET EQUIPE
     $id=$id_cppc;

      $mat=$this->Model->getListOrder('interv_materiaux',array('CPPC_ID'=>$id),'MATERIEL_DESCR');
      $equipe=$this->Model->getListOrder('rh_equipe_cppc',array('CPPC_ID'=>$id),'EQUIPE_NOM');

      $result="<h4>Liste des equipes et effectif disponible</h4><table class='table table-bordered  table-responsive'><th>EQUIPE</th><th>EFFECTIF</th>";
      foreach ($equipe as $key) {
        $membre=$this->Model->getList('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$key['EQUIPE_ID']));
       $result.="<tr><td>".$key['EQUIPE_NOM']."</td><td><a hre='#' data-toggle='modal' data-target='#mydelete" . $key['EQUIPE_ID']. "'>".sizeof($membre)."</a></td></tr>";
       $mb="";
        $i=1;
foreach ($membre as $val) {
  $personnel=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$val['PERSONEL_ID']));
   // $mb.="<tr><td>".$personnel['PERSONNEL_NOM']."</td><td>".$personnel['PERSONNEL_PRENOM']."</td><td>".$personnel['PERSONNEL_TELEPHONE']."</td></tr>";

    $mb.="<h4>Liste des membre de l'equipe ".$key['EQUIPE_NOM']."</h4> $i. ".$personnel['PERSONNEL_NOM']." ".$personnel['PERSONNEL_PRENOM']." ".$personnel['PERSONNEL_TELEPHONE']." <p>";

     $i++;
}
        $result.="
                  
                                    <div class='modal fade' id='mydelete" .$key['EQUIPE_ID']. "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    " .$mb . "
                                                </div>

                                                <div class='modal-footer'>
                                                   
                                                </div>

                                            </div>
                                        </div>
                                    </div>";
      }

      $result.="</table><h4>Liste des materiels disponibles</h4><table class='table table-bordered  table-responsive'><th>MATERIEL</th><th>CATEGORIE</th><th>ETAT</th>";
      foreach ($mat as $value) {
        $categorie=$this->Model->getOne('tk_categories',array('CATEGORIE_ID'=>$value['CATEGORIE_ID']));
        $cause=$this->Model->getOne('tk_causes',array('CAUSE_ID'=>$value['CAUSE_ID']));
        $etat=$this->Model->getOne('interv_etat_materiaux',array('ETAT_ID'=>$value['ETAT']));

        $result.="<tr><td>".$value['MATERIEL_DESCR']."</td><td>".$cause['CAUSE_DESCR']."</td><td>".$etat['DESCRIPTION']."</td></tr>";
      }
      $result.="</table>";

      // echo $result;

      echo $mes_communes."|".$option."|".$result."|".$id_cppc."|".$prov['PROVINCE_NAME'];
    }
    
    public function liste()
    {
        $cppc = $this->uri->segment(4);
       
        $critere_array = array();
        if($cppc == 'cppc' && $this->session->userdata('DGPC_CPPC_ID') >0){
          $critere_array['tkt.CPPC_ID']=$this->session->userdata('DGPC_CPPC_ID');
        } 
       
        $fetch_tickets = $this->Model->getListeticke($critere_array);

        // print_r($fetch_tickets);
        $is_standard = $this->mylibrary->verify_standard_dgpc($this->session->userdata('DGPC_USER_ID'));
        $liste_tkt = array();
        foreach ($fetch_tickets as $row) {
            $sub_array = NULL;
            $macppc = $this->Model->getOne('rh_cppc',array('CPPC_ID'=>$row->CPPC_ID));
            $chef_equipe= $this->Model->getChefEquipe($row->TICKET_CODE);
           
            $sub_array[] = $row->TICKET_CODE; 
            
            $date_ouvert = new DateTime($row->DATE_INSERTION);
            $date_ferme = new DateTime($row->DATE_CLOTURE);

            $diff_heure =0;
            if(!empty($row->DATE_CLOTURE))
              {
                 $date_diff = $date_ouvert->diff($date_ferme);
                 $diff_heure = $date_diff->format('%m')*30*24+$date_diff->format('%d')*24+$date_diff->format('%H')." Heure(s)";
              }

            $sub_array[] = $row->DATE_INSERTION;
            $sub_array[] = !empty($row->DATE_CLOTURE)?$row->DATE_CLOTURE."<br>".$diff_heure:"-";
            //$sub_array[] = $row->DATE_CLOTURE."(".$date_diff->format('%m')*30+$date_diff->format('%d').") jours";

            $sub_array[] = $row->TICKET_DESCR;
            $sub_array[] = $row->CAUSE_DESCR;
            $sub_array[] = $row->COMMUNE_NAME.'/'.$row->LOCALITE;
            $sub_array[] = "<a href='#' data-toggle='modal' 
                                  data-target='#mydeclarant" . $row->TICKET_ID . "'><i class='fa fa-user'> ".$row->TICKET_DECLARANT."</i></a>
                                   
                                    <div class='modal fade' id='mydeclarant" . $row->TICKET_ID . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                  <ul class='list-group'>
                                                    <li class='list-group-item'> Déclarant <b>" . $row->TICKET_DECLARANT . "</b></li>
                                                    <li class='list-group-item'> Télephone <b>" . $row->TICKET_DECLARANT_TEL . "</b></li>
                                                  </ul>
                                                </div>

                                                <div class='modal-footer'>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Fermer</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    ";

            //$sub_array[] = $row->CPPC_NOM;  
            $sub_array[] = "<a href='#' data-toggle='modal' 
                                  data-target='#macppc" . $row->TICKET_ID . "'><i class='fa fa-home'> ".$row->CPPC_NOM."</i></a>
                                   
                                    <div class='modal fade' id='macppc" . $row->TICKET_ID . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                  <ul class='list-group'>
                                                    <li class='list-group-item'> Cppc Nom <b>" . $macppc['CPPC_NOM'] . "</b></li>
                                                    <li class='list-group-item'> Email <b>" . $macppc['CPPC_EMAIL'] . "</b></li>
                                                    <li class='list-group-item'> Télephone <b>" . $macppc['CPPC_TEL'] . "</b></li>
                                                  </ul>
                                                </div>

                                                <div class='modal-footer'>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Fermer</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    ";
            $sub_array[] = "<font color='".$row->STATUT_COLOR."'>".$row->STATUT_DESCR."</font>";         
            
            $sub_array[] = empty($chef_equipe)?"":"<a href='#' data-toggle='modal' 
                                  data-target='#mychef" . $row->TICKET_ID . "'><i class='fa fa-user'> ".$chef_equipe['PERSONNEL_NOM']." ".$chef_equipe['PERSONNEL_PRENOM']."</i></a>
                                   
                                    <div class='modal fade' id='mychef" . $row->TICKET_ID . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                  <ul class='list-group'>
                                                    <li class='list-group-item'> Email <b>" . $chef_equipe['PERSONNEL_EMAIL'] . "</b></li>
                                                    <li class='list-group-item'> Télephone <b>" . $chef_equipe['PERSONNEL_TELEPHONE'] . "</b></li>
                                                    <li class='list-group-item'> Grade & Fonction <b>" . $chef_equipe['GRADE'] . " && ".$chef_equipe['FONCTION']."</b></li>
                                                  </ul>
                                                </div>

                                                <div class='modal-footer'>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Fermer</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    ";         

            $options = '<div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            ';
            $options .= "<li><a href='" . base_url('alerte/Notification_Alert/index/' . $row->TICKET_CODE) . "'> Alerte</a></li>";
            $options .= "<li><a href='" . base_url('tickets/Tickets/dashboard/' . $row->TICKET_CODE) . "'> Détail</a></li>";
            $options .= "<li><a href='" . base_url('tickets/Tickets/fausse_alerte/' . $row->TICKET_CODE) . "'>
                                        Fausse alerte</a></li>";
            $options .= "<li><a href='" . base_url('tickets/Tickets/cloturer/' . $row->TICKET_CODE) . "'>Cloturer</a></li>";
            if($is_standard == 1 || ($this->session->userdata('DGPC_USER_ID') == $row->USER_ID)){
              $options .= "<li><a href='" . base_url('tickets/Tickets/Modifier/' . $row->TICKET_ID) . "'>
                                        Modifier</li>";
            }                          
            
            if($row->STATUT_ID == 3){
            $options .= "<li><a href='" . base_url('tickets/Tickets/detail/' . $row->TICKET_CODE) . "'>
                                        Rapport</li>";
            }
            
            
            if($is_standard == 1 || $this->session->userdata('DGPC_USER_ID') == $row->USER_ID){
              $options .= "<li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete" . $row->TICKET_ID . "'><font color='red'>Supprimer</font></button></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete" . $row->TICKET_ID . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Supprimer :<b>" . $row->TICKET_DESCR . "</b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('tickets/Tickets/supprimer/' . $row->TICKET_CODE) . "'>Supprimer</a>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    ";
                    }
            $sub_array[] = $options;

            $liste_tkt[] = $sub_array;
        }
        $data['liste_ticket'] = $liste_tkt;
        
        $template = array(
            'table_open' => '<table id="table_ticket" class="table table-bordered table-stripped table-hover table-condensed">',
            'table_close' => '</table>'
        );
        $this->table->set_heading('CODE INTERV.','OUVERT A','FERME A','DESCRIPTION', 'CAUSE', 'LOCALITE','DECLARANT', 'CPPC', 'STATUT','CHEF EQUIPE','OPTIONS');
        $this->table->set_template($template);

        $data['title'] = "Les Tickets d'intervention";
        $data['breadcrumb'] = $this->make_bread->output();

        if($cppc == 'cppc'){
           $this->load->view('ticket/Ticket_Liste_Macppc_View', $data);          
        }else{
           $this->load->view('ticket/Ticket_Liste_View', $data);
        }
        
    }


    public function modifier()
    {
      if($this->mylibrary->get_permission('Tickets/modifier') ==0){
          redirect(base_url());
         }

      $ticket_id = $this->uri->segment(4);
      $data_ticket=$this->Model->getOne('tk_ticket',array('TICKET_ID'=>$ticket_id));
      $data['title'] = "Modifier un Ticket d'intervention";
      $data['canals'] = $this->Model->getListOrder('tk_canal',array(),'CANAL_DESCR');
      $data['causes'] = $this->Model->getListOrder('tk_causes',array(),'CAUSE_DESCR');
      $data['provinces'] = $this->Model->getListOrder('ststm_provinces',array(),'PROVINCE_NAME');
      $data['ticket'] =$data_ticket;
      $data['commune']=$this->Model->getOne('ststm_communes',array('COMMUNE_ID'=>$data_ticket['COMMUNE_ID']));


      $data['categories'] = $this->Model->getListOrder('tk_categories',array(),'CATEGORIE_DESCR');
      $data['cppcs'] = $this->Model->getListOrder('rh_cppc',array(),'CPPC_NOM');
      
      $data['breadcrumb'] = $this->make_bread->output();

      $this->load->view('ticket/Ticket_Modifier_View',$data);
    }

    public function save_modification()
    {
      $this->form_validation->set_rules('CANAL_ID', 'Canal', 'required');
       $this->form_validation->set_rules('COMMUNE_ID', 'Commune', 'required');
       $this->form_validation->set_rules('TICKET_DECLARANT_TEL', 'Déclarant Tel.', 'required');
       $this->form_validation->set_rules('CATEGORIE_ID', 'Catégorie', 'required');
       $this->form_validation->set_rules('TICKET_DECLARANT', 'Déclarant', 'required');
       $this->form_validation->set_rules('CAUSE_ID', 'Cause', 'required');
       $this->form_validation->set_rules('CPPC_ID', 'DGPC Provinciale', 'required');
       $this->form_validation->set_rules('LOCALITE', 'Localité', 'required');
       $this->form_validation->set_rules('TICKET_DESCR', 'Déscription', 'required');
       $this->form_validation->set_rules('CPPC_ID', 'DGPC Provinciale', 'required');
       
        $TICKET_ID = $this->uri->segment(4);

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Neauveau Ticket d'intervention";
            $data['canals'] = $this->Model->getListOrder('tk_canal',array(),'CANAL_DESCR','ASC');
            $data['causes'] = $this->Model->getListOrder('tk_causes',array(),'CAUSE_DESCR','ASC');
            $data['provinces'] = $this->Model->getListOrder('ststm_provinces',array(),'PROVINCE_NAME','ASC');
            $data['categories'] = $this->Model->getListOrder('tk_categories',array(),'CATEGORIE_DESCR','ASC');
            $data['casernes'] = $this->Model->getListOrder('rh_cppc',array(),'CPPC_NOM','ASC');
            
            $data['ticket'] = $this->Model->getOne('tk_ticket',array('TICKET_ID'=>$TICKET_ID));      
            $data['breadcrumb'] = $this->make_bread->output();

            $this->load->view('ticket/Ticket_Modifier_View',$data); 
        }else{
           
            $array_ticket = array(
                                'CANAL_ID'=>$this->input->post('CANAL_ID'),
                                'COMMUNE_ID'=>$this->input->post('COMMUNE_ID'),
                                'TICKET_DECLARANT_TEL'=>$this->input->post('TICKET_DECLARANT_TEL'),
                                'TICKET_DECLARANT'=>$this->input->post('TICKET_DECLARANT'),
                                'CAUSE_ID'=>$this->input->post('CAUSE_ID'),
                                'CPPC_ID'=>$this->input->post('CPPC_ID'),
                                'LOCALITE'=>$this->input->post('LOCALITE'),
                                'TICKET_DESCR'=>$this->input->post('TICKET_DESCR'),
                                'COMMENTAIRE'=>$this->input->post('COMMENTAIRE'),
                                'NOMBRE_MORT'=>$this->input->post('NOMBRE_MORT'),
                                'NOMBRE_BLESSE'=>$this->input->post('NOMBRE_BLESSE'),
                                'CATEGORIE_ID'=>$this->input->post('CATEGORIE_ID')
                                );
            $msg = "<font color='red'>Cet Ticket d'intervention n'a pas été enregistré.</font>";

            if($this->Model->update_table('tk_ticket',array('TICKET_ID'=>$TICKET_ID),$array_ticket)){
              $msg = "<font color='green'> Le ticket <b>".$this->input->post('TICKET_DESCR')."</b> a été modifié.</font>";
            }
            $donne['msg'] =$msg;
            $this->session->set_flashdata($donne);

            redirect(base_url().'tickets/Tickets/liste');
        }
    }
    
    // public function detail()
    // {
    //   $ticket_code =$this->uri->segment(4);

    //   $ticket = $this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$ticket_code));

    //   $data['interventions'] = $this->Model->getList('interv_intervenants',array('TICKET_CODE'=>$ticket['TICKET_CODE']));      
     
    //   $data['degat_humain'] = $this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>0));
    //   $data['degat_humain_dg'] = $this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>1));
    //   $data['degat_materiel'] = $this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>0));
    //   $data['degat_materiel_dgpc'] = $this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>1));
    //   $data['interv_partenaire'] = $this->Model->getList('interv_odk_partenaire',array('TICKET_CODE'=>$ticket['TICKET_CODE']));
    //   $data['ticket'] = $ticket;

    //   $data['title'] = "Détail d'un Ticket d'intervention";
    //   $data['breadcrumb'] = $this->make_bread->output();
      
    //   if (!empty($this->uri->segment(5))) {
    //     if ($this->uri->segment(5)==1) {
    //       $this->load->view('ticket/Ticket_Detail_Cppc_View',$data);
    //     }else{
    //       $this->load->view('ticket/Ticket_Detail_Dgpc_View',$data);
    //     }
         
    //   }else{
    //      $this->load->view('ticket/Ticket_Detail_View',$data);
    //   }
    // }

    public function detail()
    {
      $ticket_code =$this->uri->segment(4);

      $ticket = $this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$ticket_code));
    $data['latitude']=$ticket['LATITUDE'];
    $data['longitude']=$ticket['LONGITUDE'];
    $data['categorie_mat']=$this->Model->getOne('tk_categories',array('CATEGORIE_ID'=>$ticket['CATEGORIE_ID']));

      $data['interventions'] = $this->Model->getList('interv_intervenants',array('TICKET_CODE'=>$ticket['TICKET_CODE']));   
  
   $degat_dgpc=$this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>1));
      $degat_riverain=$this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>0));

      $degat_dgpc_blesse=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>1,'STATUT_SANTE'=>0));
      $degat_riverain_blesse=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>0,'STATUT_SANTE'=>0));

      $degat_dgpc_mort=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>1,'STATUT_SANTE'=>1));
      $degat_riverain_mort=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>0,'STATUT_SANTE'=>1));

        
        $serie_blesse="{name: 'Humains Blessés ', data: [".sizeof($degat_dgpc_blesse).",".sizeof($degat_riverain_blesse)."]}";
        $serie_mort="{name: 'Humains Morts ', data: [".sizeof($degat_dgpc_mort).",".sizeof($degat_riverain_mort)."]}";
 
      $serie_dgpc="";
      $serie_riverain="";
      $i=0;
      $j=0;
      $nb=0;
      $nb1=0;
      foreach ($degat_dgpc as $key) {
        $mat=$this->Model->getOne('interv_materiaux',array('MATERIEL_ID'=>$key['MATERIEL_ENDO_CODE']));
        if($i==0){
        $serie_dgpc.="{name: '(materiel) ".trim($mat['MATERIEL_DESCR'])." ', data: [".$key['NOMBRE'].",0]}";
      }
      else{
        $serie_dgpc.=",{name: ' (materiel)".trim($mat['MATERIEL_DESCR'])." ', data: [".$key['NOMBRE'].",0]}";
      }
       $i++; 
       $nb+=$key['NOMBRE'];
      }
      foreach ($degat_riverain as $val) {
        $mat1=$this->Model->getOne('tk_materiel_endomage',array('MATERIEL_ENDO_CODE'=>$val['MATERIEL_ENDO_CODE']));
        if($j==0){
        $serie_riverain.="{name: '(materiel)".trim($mat1['MATERIEL_ENDO_DESCR'])." ', data: [0,".$val['NOMBRE']."]}";
      }else{
        $serie_riverain.=",{name: '(materiel)".trim($mat1['MATERIEL_ENDO_DESCR'])." ', data: [0,".$val['NOMBRE']."]}";
      }
        $j++;
         $nb1+=$val['NOMBRE'];
      }

      if($i==0){$serie_dgpc.="{name: 'materiels gdpc', data: [0,0]}"; }
      if($j==0){$serie_riverain.="{name: 'materiels riverain', data: [0,0]}"; }

      $serie="[".$serie_dgpc.",".$serie_riverain.",".$serie_blesse.",".$serie_mort."]";
       // echo $serie; exit();
     $data['series'] =$serie;
      $data['total_materiel_dgpc'] =$nb;
      $data['total_materiel_riverain'] =$nb1;
      $data['total_blesse_dgpc'] =sizeof($degat_dgpc_blesse);
      $data['total_blesse_riverain'] =sizeof($degat_riverain_blesse);
      $data['total_blesse'] =sizeof($degat_dgpc_blesse)+sizeof($degat_riverain_blesse);
      $data['total_mort_dgpc'] =sizeof($degat_dgpc_mort);
      $data['total_mort_riverain'] =sizeof($degat_riverain_mort);
      $data['total_mort'] =sizeof($degat_dgpc_mort)+sizeof($degat_riverain_mort);
    
    
     
      $data['degat_humain'] = $this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>0));
      $data['degat_humain_dg'] = $this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>1));
      $data['degat_materiel'] = $this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>0));
      $data['degat_materiel_dgpc'] = $this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>1));
      $data['interv_partenaire'] = $this->Model->getList('interv_odk_partenaire',array('TICKET_CODE'=>$ticket['TICKET_CODE']));
      $data['ticket'] = $ticket;

      $data['title'] = "Détail d'un Ticket d'intervention";
      $data['breadcrumb'] = $this->make_bread->output();
      
      if (!empty($this->uri->segment(5))) {
        if ($this->uri->segment(5)==1) {
          $this->load->view('ticket/Ticket_Detail_Cppc_View',$data);
        }else{
          $this->load->view('ticket/Ticket_Detail_Dgpc_View',$data);
        }
         
      }else{
      $this->load->view('ticket/Ticket_Detail_View',$data);
     //$this->load->view('ticket/Map_View_Capture',$data);
         
      }
    }

    public function supprimer()
    {  
      if($this->mylibrary->get_permission('Tickets/modifier') ==0){
          redirect(base_url());
         }

      $ticket_code =$this->uri->segment(4);

      $ticket = $this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$ticket_code));
      $interventions = $this->Model->getList('interv_intervenants',array('TICKET_CODE'=>$ticket['TICKET_CODE']));      
     // $intervention_terrains = $this->Model->getList('interv_intervention_histo',array('TICKET_CODE'=>$ticket['TICKET_CODE']));
      
       $msg = '';
      if(!empty($ticket)){
        if(empty($interventions)){
          $this->Model->delete('tk_ticket',array('TICKET_CODE'=>$ticket_code));
          $msg = "<font color='green'>L'évenement <b>".$ticket['TICKET_DESCR']."</b> a été supprimé</font>";
        }else{
          $msg = "<font color='red'>Pour supprimer l'évenement <b>".$ticket['TICKET_DESCR']."</b> commencer à supprimer l'(les) intervention(s) y relatif ainsi que l'(les) information(s) recolté(es) au terrain.</font>"; 
        }
      }else{
        $msg = "<font color='red'>Le Ticket d'intervention que vous voulez n'existe plus.</font>";        
      }
      $donne['msg'] =$msg;
      $this->session->set_flashdata($donne);

      redirect(base_url().'tickets/Tickets/liste');
    }

    public function infoCause(){
      $id=$_POST['id'];

      $cause=$this->Model->getOne('tk_causes',array('CAUSE_ID'=>$id));

     if ($cause['CAUSE_CODE']=="AUTR"){
      echo 1;
     }else echo 0;
    }
    public function materiaux(){
      $id=$_POST['id'];
      if(isset($_POST['CATEGORIE_ID'])){ $CATEGORIE_ID=$_POST['CATEGORIE_ID']; }else{$CATEGORIE_ID=0;}
      if(isset($_POST['CAUSE_ID'])){ 
        $CAUSE_ID=$_POST['CAUSE_ID'];
        $cause=$this->Model->getOne('tk_causes',array('CAUSE_ID'=>$CAUSE_ID));
        $titre="Liste des materiels disponibles pour <b>".$cause['CAUSE_DESCR']."</b>";
         }else{
          $CAUSE_ID=0;
          $titre="Liste des materiels relatives</b>";
         }
      

      // $mat=$this->Model->getListOrder('interv_materiaux',array('CPPC_ID'=>$id,'CATEGORIE_ID'=>$CATEGORIE_ID),'MATERIEL_DESCR');
      $mat=$this->Model->getListOrder('interv_materiaux',array('CPPC_ID'=>$id,'CAUSE_ID'=>$CAUSE_ID),'MATERIEL_DESCR');
      $equipe=$this->Model->getListOrder('rh_equipe_cppc',array('CPPC_ID'=>$id),'EQUIPE_NOM');

      $result="<h4>Liste des equipes et effectif disponible</h4><table class='table table-bordered  table-responsive'><th>EQUIPE</th><th>EFFECTIF</th>";
      foreach ($equipe as $key) {
        $membre=$this->Model->getList('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$key['EQUIPE_ID']));
       $result.="<tr><td>".$key['EQUIPE_NOM']."</td><td><a hre='#' data-toggle='modal' data-target='#mydelete" . $key['EQUIPE_ID']. "'>".sizeof($membre)."</a></td></tr>";
       $mb="";
        $i=1;
foreach ($membre as $val) {
  $personnel=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$val['PERSONEL_ID']));
   // $mb.="<tr><td>".$personnel['PERSONNEL_NOM']."</td><td>".$personnel['PERSONNEL_PRENOM']."</td><td>".$personnel['PERSONNEL_TELEPHONE']."</td></tr>";

    $mb.="<h4>Liste des membre de l'equipe ".$key['EQUIPE_NOM']."</h4> $i. ".$personnel['PERSONNEL_NOM']." ".$personnel['PERSONNEL_PRENOM']." ".$personnel['PERSONNEL_TELEPHONE']." <p>";

     $i++;
}
        $result.="
                  
                                    <div class='modal fade' id='mydelete" .$key['EQUIPE_ID']. "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    " .$mb . "
                                                </div>

                                                <div class='modal-footer'>
                                                   
                                                </div>

                                            </div>
                                        </div>
                                    </div>";
      }

      $result.="</table><h4>".$titre."</h4><table class='table table-bordered  table-responsive'><th>MATERIEL</th><th>CATEGORIE</th><th>ETAT</th>";
      foreach ($mat as $value) {
        $cause=$this->Model->getOne('tk_causes',array('CAUSE_ID'=>$value['CAUSE_ID']));
        $etat=$this->Model->getOne('interv_etat_materiaux',array('ETAT_ID'=>$value['ETAT']));

        $result.="<tr><td>".$value['MATERIEL_DESCR']."</td><td>".$cause['CAUSE_DESCR']."</td><td>".$etat['DESCRIPTION']."</td></tr>";
      }
      if (sizeof($mat)==0) {
        $result.="<tr><td colspan='3'><center style='color:red'>Aucun resultat</center></td></tr>";
      }
      $result.="</table>";

      echo $result;
    }
    public function cloturer()
    {
      $TICKET_CODE = $this->uri->segment(4);
      
      $msg = "<div class='alert alert-danger'>Error, Opération echoué</div>";
      if($this->Model->update_table('tk_ticket',array('TICKET_CODE'=>$TICKET_CODE),array('STATUT_ID'=>3,'DATE_CLOTURE'=>date('Y-m-d H:i:s')))){
        $msg = "<div class='alert alert-success'>Opération effectué</div>";        
      }
      $info['msg'] = $msg;
      $this->session->set_flashdata($info);
      redirect(base_url('tickets/Tickets/liste'));
    }

    public function fausse_alerte()
    {
      $TICKET_CODE = $this->uri->segment(4);
      
      $msg = "<div class='alert alert-danger'>Error, Opération echoué</div>";
      if($this->Model->update_table('tk_ticket',array('TICKET_CODE'=>$TICKET_CODE),array('STATUT_ID'=>5))){
        $msg = "<div class='alert alert-success'>Opération effectué</div>";        
      }
      $info['msg'] = $msg;
      $this->session->set_flashdata($info);
      redirect(base_url('tickets/Tickets/liste'));
    }
    public function get_interventions1($collabo_id)
    {  
       $interventions = $this->Model->mes_intervention($collabo_id);
       
       $mes_intervention = array();
       foreach ($interventions as $intervention) {
          $array = NULL;
          $array[]=$intervention['TICKET_CODE'];
          $array[]=$intervention['DATE_INSERTION'];
          $array[]=$intervention['TICKET_DESCR'];
          $array[]=$intervention['TICKET_DECLARANT'];
          $array[]=$intervention['CAUSE_DESCR'];
          $array[]=$intervention['CPPC_NOM'];
          $array[]=$intervention['COMMUNE_NAME'].'/'.$intervention['LOCALITE'];
          $array[]="<font color='".$intervention['STATUT_COLOR']."'>".$intervention['STATUT_DESCR']."</font>";
                     
          $mes_intervention[] = $array;
       }
       $data['interventions'] = $mes_intervention;
        $template = array(
            'table_open' => '<table id="table_interventions" class="table table-bordered table-stripped table-hover table-condensed">',
            'table_close' => '</table>'
               );
          $this->table->set_heading('CODE INTERVENTION', 'DATE','DESCRIPTION','DECLARANT','CAUSE','CPPC','LOCALITE','STATUT');
          $this->table->set_template($template);
          $data['breadcrumb'] = $this->make_bread->output();
          $data['title'] = "Les interventions faites";
          $this->load->view('ticket/Ticket_collabo_Interventions_View', $data);
    }
    public function get_interventions()
    {  
       $interventions = $this->Model->mes_intervention($this->session->userdata('DGPC_PERSONNEL_ID'));
       
       $mes_intervention = array();
       foreach ($interventions as $intervention) {
          $array = NULL;
          $array[]=$intervention['TICKET_CODE'];
          $array[]=$intervention['DATE_INSERTION'];
          $array[]=$intervention['TICKET_DESCR'];
          $array[]=$intervention['TICKET_DECLARANT'];
          $array[]=$intervention['CAUSE_DESCR'];
          $array[]=$intervention['CPPC_NOM'];
          $array[]=$intervention['COMMUNE_NAME'].'/'.$intervention['LOCALITE'];
          $array[]="<font color='".$intervention['STATUT_COLOR']."'>".$intervention['STATUT_DESCR']."</font>";
                     
          $mes_intervention[] = $array;
       }
       $data['interventions'] = $mes_intervention;
        $template = array(
            'table_open' => '<table id="table_interventions" class="table table-bordered table-stripped table-hover table-condensed">',
            'table_close' => '</table>'
               );
          $this->table->set_heading('CODE INTERVENTION', 'DATE','DESCRIPTION','DECLARANT','CAUSE','CPPC','LOCALITE','STATUT');
          $this->table->set_template($template);
          $data['breadcrumb'] = $this->make_bread->output();
          $data['title'] = "Mes interventions";
          $this->load->view('ticket/Ticket_Mes_Interventions_View', $data);
    }
    
        public function dashboard()
    {
      $ticket_code =$this->uri->segment(4);
      $data['ticket_code'] =$this->uri->segment(4);

      $ticket = $this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$ticket_code));
      $CPPC=$ticket['CPPC_ID'];
      $data['manger'] =$this->Model->getRequeteOne("SELECT rh_cppc_manager.PERSONNEL_ID, MAX(rh_cppc_manager.CPPC_MANAGER_ID), rh_personnel_dgpc.GRADE, rh_personnel_dgpc.FONCTION, rh_personnel_dgpc.PERSONNEL_NOM, rh_personnel_dgpc.PERSONNEL_PRENOM FROM rh_cppc_manager JOIN rh_personnel_dgpc ON rh_cppc_manager.PERSONNEL_ID=rh_personnel_dgpc.PERSONNEL_ID WHERE CPPC_ID=".$CPPC." GROUP BY PERSONNEL_ID");

       $data['image'] =$this->Model->getRequeteOne("SELECT IMAGE_BLOB FROM interv_odk_images WHERE TICKET_CODE = $ticket_code ORDER BY IMAGE_ID DESC");
       $data['video'] =$this->Model->getRequeteOne("SELECT VIDEO_BLOB FROM interv_odk_videos WHERE TICKET_CODE = $ticket_code ORDER BY VIDEO_ID DESC");

       $data['materiel_dgpcs'] = $this->Model->getRequete("SELECT mat.MATERIEL_DESCR,SUM(imat.NOMBRE) as nb_NOMBRE FROM interv_odk_degat_materiel as imat JOIN interv_materiaux as mat ON imat.MATERIEL_ENDO_CODE = mat.MATERIEL_CODE WHERE imat.CONCERNE_DGPC=1 AND imat.TICKET_CODE = $ticket_code GROUP BY imat.TICKET_CODE,mat.MATERIEL_ID");
       
       $data['materiel_riverains'] = $this->Model->getRequete("SELECT mat.MATERIEL_ENDO_DESCR,SUM(imat.NOMBRE) as nb_NOMBRE FROM interv_odk_degat_materiel as imat JOIN tk_materiel_endomage as mat ON imat.MATERIEL_ENDO_CODE = mat.MATERIEL_ENDO_CODE WHERE imat.CONCERNE_DGPC=0 AND imat.TICKET_CODE = $ticket_code GROUP BY imat.TICKET_CODE,mat.MATERIEL_ENDO_ID");
       /*
       echo "<pre>";
       print_r($data['materiel_riverains']);
       echo "</pre>";*/

      $data['interventions'] = $this->Model->getList('interv_intervenants',array('TICKET_CODE'=>$ticket['TICKET_CODE']));      
     $data['canal'] = $this->Model->getOne('tk_canal',array('CANAL_ID'=>$ticket['CANAL_ID']));

     $data['cppc'] = $this->Model->getOne('rh_cppc',array('CPPC_ID'=>$ticket['CPPC_ID']));
     $data['tiquet_cppc'] = $this->Model->getList('tk_ticket',array('CPPC_ID'=>$ticket['CPPC_ID']));
     $data['mort'] = $this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'STATUT_SANTE'=>1));
     $data['blesse'] = $this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'STATUT_SANTE'=>0));
     $data['equipe_intervenant'] = $this->Model->getListDistinct('interv_intervenants',array('TICKET_CODE'=>$ticket['TICKET_CODE']),'EQUIPE_ID');
     $data['membre_intervenant'] = $this->Model->getList('interv_intervenants',array('TICKET_CODE'=>$ticket['TICKET_CODE']));
     $data['interv_materiaux'] = $this->Model->getList('interv_materiaux',array('CPPC_ID'=>$ticket['CPPC_ID'],'CATEGORIE_ID'=>$ticket['CATEGORIE_ID'])); 
     $data['materieles'] = $this->Model->getList('interv_materiaux',array('CPPC_ID'=>$ticket['CPPC_ID'])); 
     $data['categorie_mat'] = $this->Model->getOne('tk_categories',array('CATEGORIE_ID'=>$ticket['CATEGORIE_ID'])); 
     $data['stutut_ticket'] = $this->Model->getOne('tk_statuts',array('STATUT_ID'=>$ticket['STATUT_ID']));
     $stutut_ticket= $this->Model->getOne('tk_statuts',array('STATUT_ID'=>$ticket['STATUT_ID']));
      $data['degat_humain'] = $this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>0));
      $data['degat_humain_dg'] = $this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>1));
      $data['degat_materiel'] = $this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>0));
      $data['degat_materiel_dgpc'] = $this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>1));
      $data['interv_partenaire'] = $this->Model->getList('interv_odk_partenaire',array('TICKET_CODE'=>$ticket['TICKET_CODE']));
      $data['ticket'] = $ticket;

//DEGA MATERIEL
      $degat_dgpc=$this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>1));
      $degat_riverain=$this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>0));

      $degat_dgpc_blesse=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>1,'STATUT_SANTE'=>0));
      $degat_riverain_blesse=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>0,'STATUT_SANTE'=>0));

      $degat_dgpc_mort=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>1,'STATUT_SANTE'=>1));
      $degat_riverain_mort=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>0,'STATUT_SANTE'=>1));
      $mat_total=sizeof($degat_dgpc)+sizeof($degat_riverain);
      $mort_total=sizeof($degat_dgpc_mort)+sizeof($degat_riverain_mort);
      $blesse_total=sizeof($degat_dgpc_blesse)+sizeof($degat_riverain_blesse);
        $serie_dgpc="{name: 'Materiels(".$mat_total.")', data: [".sizeof($degat_dgpc).",".sizeof($degat_riverain)."]}";
        // echo sizeof($degat_riverain);exit();
        $data['total_mat'] =sizeof($degat_dgpc)+sizeof($degat_riverain);
        $serie_blesse="{name: 'Blessés(".$blesse_total.")', data: [".sizeof($degat_dgpc_blesse).",".sizeof($degat_riverain_blesse)."]}";
        $serie_mort="{name: 'Morts(".$mort_total.")', data: [".sizeof($degat_dgpc_mort).",".sizeof($degat_riverain_mort)."]}";
 
      // $serie_dgpc="";
      $serie_riverain="";
      $i=0;
      $j=0;
      $nb=0;
      $nb1=0;
      // foreach ($degat_dgpc as $key) {
      //   $mat=$this->Model->getOne('interv_materiaux',array('MATERIEL_ID'=>$key['MATERIEL_ENDO_CODE']));
      //   if($i==0){
      //   $serie_dgpc.="{name: '(materiel) ".trim($mat['MATERIEL_DESCR'])." ', data: [".$key['NOMBRE'].",0]}";
      // }
      // else{
      //   $serie_dgpc.=",{name: ' (materiel)".trim($mat['MATERIEL_DESCR'])." ', data: [".$key['NOMBRE'].",0]}";
      // }
      //  $i++; 
      //  $nb+=$key['NOMBRE'];
      // }
      // foreach ($degat_riverain as $val) {
      //   $mat1=$this->Model->getOne('tk_materiel_endomage',array('MATERIEL_ENDO_CODE'=>$val['MATERIEL_ENDO_CODE']));
      //   if($j==0){
      //   $serie_riverain.="{name: '(materiel)".trim($mat1['MATERIEL_ENDO_DESCR'])." ', data: [0,".$val['NOMBRE']."]}";
      // }else{
      //   $serie_riverain.=",{name: '(materiel)".trim($mat1['MATERIEL_ENDO_DESCR'])." ', data: [0,".$val['NOMBRE']."]}";
      // }
      //   $j++;
      //    $nb1+=$val['NOMBRE'];
      // }

      // if($i==0){$serie_dgpc.="{name: 'materiels gdpc', data: [0,0]}"; }
      // if($i==0){$serie_dgpc.="{name: 'materiels', data: [0,0]}"; }
      // if($j==0){$serie_riverain.="{name: 'materiels riverain', data: [0,0]}"; }

      // $serie="[".$serie_dgpc.",".$serie_riverain.",".$serie_blesse.",".$serie_mort."]";
      $serie="[".$serie_dgpc.",".$serie_blesse.",".$serie_mort."]";
       // echo $serie; exit(); 
      $data['series'] =$serie;
      $data['total_materiel_dgpc'] =$nb;
      $data['total_materiel_riverain'] =$nb1;
      $data['total_blesse_dgpc'] =sizeof($degat_dgpc_blesse);
      $data['total_blesse_riverain'] =sizeof($degat_riverain_blesse);
      $data['total_blesse'] =sizeof($degat_dgpc_blesse)+sizeof($degat_riverain_blesse);
      $data['total_mort_dgpc'] =sizeof($degat_dgpc_mort);
      $data['total_mort_riverain'] =sizeof($degat_riverain_mort);
      $data['total_mort'] =sizeof($degat_dgpc_mort)+sizeof($degat_riverain_mort);

//DEGA HUMAIN
      // $degat_dgpc_blesse=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>1,'STATUT_SANTE'=>0));
      // $degat_riverain_blesse=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>0,'STATUT_SANTE'=>0));

      // $degat_dgpc_mort=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>1,'STATUT_SANTE'=>1));
      // $degat_riverain_mort=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>0,'STATUT_SANTE'=>1));

        
      //   $serie_blesse="{name: ' Blessés ', data: [".sizeof($degat_dgpc_blesse).",".sizeof($degat_riverain_blesse)."]}";
      //   $serie_mort="{name: ' Morts ', data: [".sizeof($degat_dgpc_mort).",".sizeof($degat_riverain_mort)."]}";
 
      // $serie1="[".$serie_blesse.",".$serie_mort."]";
      // // echo $serie1;exit();
      //  $data['series1'] =$serie1;
      //   $data['total_humain'] =sizeof($degat_dgpc_blesse)+sizeof($degat_riverain_blesse)+sizeof($degat_dgpc_mort)+sizeof($degat_riverain_mort);

      
      $data['latitude'] = $ticket['LATITUDE'];
      $data['longitude'] = $ticket['LONGITUDE'];
      if($ticket['LATITUDE']==-1){
        $commune=$this->Model->getOne('ststm_communes',array('COMMUNE_ID'=>$ticket['COMMUNE_ID']));
        $data['latitude'] = $commune['COMMUNE_LATITUDE'];
      $data['longitude'] = $commune['COMMUNE_LONGITUDE'];
      }
      $data['ouverture_tiquet'] =$ticket['DATE_INSERTION'];
      $data['cloture_tiquet'] =$ticket['DATE_CLOTURE'];
      if ($ticket['DATE_CLOTURE']==NULL) {
        $data['cloture_tiquet'] =date('Y-m-d h:i:s');
      }
     $datetime1 = new DateTime($data['cloture_tiquet']);
      $datetime2 = new DateTime($data['ouverture_tiquet']);
      $interval = $datetime1->diff($datetime2);
      // print_r($interval) ;exit();
      $data['dure']= $interval->format('%a jours %h heures %i minutes %s secondes');
      // $data['dure']= $interval;
// echo $elapsed;exit();
      if ($ticket['DATE_CLOTURE']==NULL) {
        $data['cloture'] ="<b style='color: ".$stutut_ticket['STATUT_COLOR']."'>Ticket ".$stutut_ticket['STATUT_DESCR']."</b>";
      }
      $data['title'] = "Ticket d'intervention";

//---------RAPPORT CPPC DETAIL -----------------
      $cppcs = $this->Model->getOne('rh_cppc',array('CPPC_ID'=>$CPPC));
      $ticket = $this->Model->getList('tk_ticket',array('CPPC_ID'=>$CPPC));
      $data['equipe'] =$this->Model->getList('rh_equipe_cppc',array('CPPC_ID'=>$CPPC));
      $data['equipe2'] =$this->Model->getList('rh_equipe_cppc',array('CPPC_ID'=>$CPPC));
$nb=0;
$nb1=0;
$serie_materiel="";
     $nombre_materiel=0;
      foreach ($ticket as $value) {

        $dega_humain_blesse=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$value['TICKET_CODE'],'STATUT_SANTE'=>0));
        $dega_humain_mort=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$value['TICKET_CODE'],'STATUT_SANTE'=>1));

        $nb+=sizeof($dega_humain_blesse);
        $nb1+=sizeof($dega_humain_mort);
        $dega_materiel=$this->Model->getSommes('interv_odk_degat_materiel',array('TICKET_CODE'=>$value['TICKET_CODE'],'CONCERNE_DGPC'=>1),'NOMBRE','MATERIEL_ENDO_CODE','MATERIEL_ENDO_CODE');
        $n=0;
        foreach ($dega_materiel as $key) {
          $mater=$this->Model->getOne('interv_materiaux',array('MATERIEL_ID'=>$key['MATERIEL_ENDO_CODE']));
         
         // $serie_materiel.="{name: '".trim($mater['MATERIEL_DESCR'])."', data: [0,0,".$key['NOMBRE']."]},";
       $nombre_materiel+=$key['NOMBRE'];
        }
      }
      $serie_materiel="{name: 'Materiels($nombre_materiel)', data: [0,0,".$nombre_materiel."]}";
      //  $serie_materiel.="|";
      // $serie_materiel= str_replace(",|", "", $serie_materiel);
         // echo $serie_materiel;exit();sizeof($ticket)
      $serie_intervention="{name: 'interventions(".sizeof($ticket).")', data: [".sizeof($ticket).",0,0]}";
      $serie_blesse="{name: 'Blessés($nb)', data: [0,".$nb.",0]}";
        $serie_mort="{name: 'Morts($nb1)', data: [0,".$nb1.",0]}";
 


      // $data['series1'] = "[{name: 'intervention ', data: [11]},{name: 'Blessés ', data: [4]},{name: 'Morts ', data: [2]},{name: 'Motopompes ', data: [2]},{name: 'Autres', data: [5]}]";
      $data['series1'] = "[".$serie_intervention.",".$serie_blesse.",".$serie_mort.",".$serie_materiel."]";
          // echo "[".$serie_intervention.",".$serie_blesse.",".$serie_mort.",".$serie_materiel."]";exit();
      $data['nb'] =$nb;
      $data['cppc1'] =$CPPC;
      $data['mt'] =$nb1;
      
      $data['materiel'] =$this->Model->getList('interv_materiaux',array('CPPC_ID'=>$CPPC));
      $data['ticket1'] =$ticket;
      $data['cppc_n'] = $cppcs['CPPC_NOM'];
      $data['latitude1'] = $cppcs['LATITUDE'];
      $data['longitude1'] = $cppcs['LONGITUDE'];

      //DEGA MATERIEL
      // $degat=$this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket_code,'CONCERNE_DGPC'=>1));

      //---------RAPPORT CPPC CYCLE INTERENTION1-----------------

     /* $tk = $this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$ticket_code));

         // $data['cat'] = "'DATE INTERVENTION:','DATE SORTI CPPC:','DATE ARRIVER SITE:','DATE DEPART LIEU:','DATE RETOURT CASERNE:','DATE CLOTURE:'";
       $data['DATE_INSERTION'] = $tk['DATE_INSERTION'];
       $data['DATE_INTERVENTION'] = $tk['DATE_INTERVENTION'];
       $data['DATE_SORTIE_CPPC'] = $tk['DATE_SORTIE_CPPC'];
       $data['DATE_ARRIVE_SITE'] = $tk['DATE_ARRIVE_SITE'];
       $data['DATE_DEPART_LIEUX'] = $tk['DATE_DEPART_LIEUX'];
       $data['DATE_RETOUR_CASERNE'] = $tk['DATE_RETOUR_CASERNE'];
       $data['DATE_CLOTURE'] = $tk['DATE_CLOTURE'];
       $data['srie'] = "{name:'cycle', data:[0,0,0,1,2,1,0]}"; */


         //---------RAPPORT CPPC CYCLE INTERENTION2-----------------

      $tk = $this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$ticket_code));
      $datetime1 = new DateTime($tk['DATE_INSERTION']);
      $date_ouvert = empty($tk['DATE_INSERTION'])?'':$datetime1->format('d/m/Y H:i');

      $datetime2 = new DateTime($tk['DATE_INTERVENTION']);
      $datetime3 = new DateTime($tk['DATE_SORTIE_CPPC']);
      $datetime4 = new DateTime($tk['DATE_ARRIVE_SITE']);
      $date_on_site = empty($tk['DATE_ARRIVE_SITE'])?'':$datetime4->format('d/m/Y H:i');

      $datetime5 = new DateTime($tk['DATE_DEPART_LIEUX']);
      $datetime6 = new DateTime($tk['DATE_RETOUR_CASERNE']);
      $date_back = empty($tk['DATE_RETOUR_CASERNE'])?'':$datetime6->format('d/m/Y H:i');

      $datetime7 = new DateTime($tk['DATE_CLOTURE']);
      $date_cloture = empty($tk['DATE_CLOTURE'])?'':$datetime7->format('d/m/Y H:i');
      // $interval = $datetime1->diff($datetime2);
      $data['dure']= $interval->format('%a jours %h heures %i minutes %s secondes');

      $dure1=$datetime2->diff($datetime1);
      $dure1=$dure1->format('%a')*24*60+$dure1->format('%h')*60+$dure1->format('%i');

      $dure1 = !empty($tk['DATE_INTERVENTION'])?$dure1:0;

       $dure2=$datetime4->diff(new DateTime($tk['DATE_INSERTION']));
       $dure2=$dure2->format('%a')*24*60+$dure2->format('%h')*60+$dure2->format('%i');
      
       $dure2 = !empty($tk['DATE_ARRIVE_SITE'])?$dure2:0;

      $dure3=$datetime7->diff($datetime1);
      $dure3=$dure3->format('%a')*24*60+$dure3->format('%h')*60+$dure3->format('%i');
      
      $dure3 = !empty($tk['DATE_SORTIE_CPPC'])?$dure3:0;

      $dure4=$datetime5->diff($datetime1);
      $dure4=$dure4->format('%a')*24*60+$dure4->format('%h')*60+$dure4->format('%i');
      
      $dure4 = !empty($tk['DATE_RETOUR_CASERNE'])?$dure4:0;
    

       $dure5=$datetime6->diff($datetime1);
       $dure5=$dure5->format('%a')*24+$dure5->format('%h');
       
       $dure5 = !empty($tk['DATE_RETOUR_CASERNE'] && $tk['DATE_DEPART_LIEUX'])?$dure5:0;

       $dure6=$datetime7->diff($datetime1);
      // $dure6=$dure6->format('%a')*1440+$dure6->format('%h');
      $dure6=0;

      $data['ticket_code']=$ticket_code;

       $data['DATE_INTERVENTION'] = $tk['DATE_INSERTION'];
       $data['DATE_SORTIE_CPPC'] = $tk['DATE_SORTIE_CPPC'];
       $data['DATE_ARRIVE_SITE'] = $tk['DATE_ARRIVE_SITE'];
       $data['DATE_DEPART_LIEUX'] = $tk['DATE_DEPART_LIEUX'];
       $data['DATE_RETOUR_CASERNE'] = $tk['DATE_RETOUR_CASERNE'];
       $data['DATE_CLOTURE'] = $tk['DATE_CLOTURE'];
      // $data['srie'] = "{name:'cycle', data:[0,".$dure1.",".$dure2.",".$dure3.",".$dure4.",".$dure5.",".$dure6."]}";

        $data['serie_progression'] = "[['Ouvert <br>".$date_ouvert."',".$dure1."],['On site <br>".$date_on_site."',".$dure2."],['Fermé <br> ".$date_cloture."',".$dure3."],['Retour vers cppc <br> ".$date_back."',".$dure5."]]"; 

    //---------RAPPORT CPPC CYCLE INTERENTION2-----------------
      $ticket = $this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$ticket_code));
      // $h=explode(" ", $ticket['DATE_INTERVENTION']);
      // $m=explode(":", $h[1]);
      // $min=$m[0];
       $date_ouverture = new DateTime($ticket['DATE_INTERVENTION']);
      if ($ticket['DATE_INTERVENTION']) {
        $ouv=$ticket['DATE_INTERVENTION'];
        // $ouv_val=10;
        $ouv_val=5;
      }else{
        $ouv="NULL DATE";
         $ouv_val=0;
      }
      if ($ticket['DATE_SORTIE_CPPC']) {
        $sort=$ticket['DATE_SORTIE_CPPC'];

        
      $date_sorti = new DateTime($ticket['DATE_SORTIE_CPPC']);
      if($date_sorti>$date_ouverture){
      $diff_sorti = $date_sorti->diff($date_ouverture);

      // $dure= $diff->format('%a jours %h heures %i minutes %s secondes');
      $dure_sorti= $diff_sorti->format('%a')*24*60;
      $dure_sorti1= $diff_sorti->format('%h')*60;
      $dure_sorti2= $diff_sorti->format('%i');
      // echo $dure1;exit();
        $sortie_val=$dure_sorti+$dure_sorti1+$dure_sorti2;
      }else{$sortie_val=0;}
      }else{
        $sort="NULL DATE";
         $sortie_val=0;
      }
      if ($ticket['DATE_ARRIVE_SITE']) {
        $arri=$ticket['DATE_ARRIVE_SITE'];
$date_arrive = new DateTime($ticket['DATE_ARRIVE_SITE']);
if($date_arrive>$date_ouverture){
      $diff_arrive = $date_arrive->diff($date_ouverture);

      // $dure= $diff->format('%a jours %h heures %i minutes %s secondes');
      $dure_arrive= $diff_arrive->format('%a')*24*60;
      $dure_arrive1= $diff_arrive->format('%h')*60;
      $dure_arrive2= $diff_arrive->format('%i');
      // echo $dure1;exit();
        // $sortie_val=$dure_sorti+$dure_sorti1;
        $arri_val=$dure_arrive+$dure_arrive1+$dure_arrive2;
      }else{$arri_val=0;}
      }else{
        $arri="NULL DATE";
         $arri_val=0;
      }
      if ($ticket['DATE_DEPART_LIEUX']) {
        $dep=$ticket['DATE_DEPART_LIEUX'];

        $date_depart = new DateTime($ticket['DATE_DEPART_LIEUX']);
         if($date_depart>$date_ouverture){
      $diff_depart = $date_depart->diff($date_ouverture);


      // $dure= $diff->format('%a jours %h heures %i minutes %s secondes');
      $dure_depart= $diff_depart->format('%a')*24*60;
      $dure_depart1= $diff_depart->format('%h')*60;
      $dure_depart2= $diff_depart->format('%i');
      
        $dep_val=$dure_depart+$dure_depart1+$dure_depart2;
      }else{$dep_val=0;}
      }else{
        $dep="NULL DATE";
         $dep_val=0;
      }
        if ($ticket['DATE_RETOUR_CASERNE']) {
        $ret=$ticket['DATE_RETOUR_CASERNE'];

        $date_retour = new DateTime($ticket['DATE_RETOUR_CASERNE']);
         if($date_retour>$date_ouverture){
      $diff_retour = $date_retour->diff($date_ouverture);

      // $dure= $diff->format('%a jours %h heures %i minutes %s secondes');
      $dure_retour= $diff_retour->format('%a')*24*60;
      $dure_retour1= $diff_retour->format('%h')*60;
      $dure_retour2= $diff_retour->format('%i');
      
        $ret_val=$dure_retour+$dure_retour1+$dure_retour2;
      }else{$ret_val=0;}
      }else{
        $ret="NULL DATE";
         $ret_val=0;
      }
       if ($ticket['DATE_CLOTURE']) {
        $clot=$ticket['DATE_CLOTURE'];

        $date_cloture = new DateTime($ticket['DATE_CLOTURE']);
         if($date_cloture>$date_ouverture){
      $diff_cloture= $date_cloture->diff($date_ouverture);

      // $dure= $diff->format('%a jours %h heures %i minutes %s secondes');
      $dure_cloture= $diff_cloture->format('%a')*24*60;
      $dure_cloture1= $diff_cloture->format('%h')*60;
      $dure_cloture2= $diff_cloture->format('%i');
      
        $clot_val=$dure_cloture+$dure_cloture1+$dure_cloture2;

      }else{$clot_val=0;}
      }else{
        $clot="NULL DATE";
         $clot_val=0;
      }
     //  $data['ouverture']="Ouverture( ".$ouv.") ";
     //  $data['ouverture_val']=$ouv_val;
     //  $data['sortie']="Sorti(".$sort.")";
     //  $data['sortie_val']=$sortie_val;
     //  $data['arriver']="Arriver(".$arri.")";
     //  $data['arriver_val']=$arri_val;
     //  $data['depart']="Départ(".$dep.")";
     //  $data['depart_val']=$dep_val;
     // $data['retour']="Retour(".$ret.")";
     // $data['retour_val']=$ret_val;
     // $data['cloture']="cloture(".$clot.")";
     // $data['cloture_val']=$clot_val;

      $data['ouverture']="( ".$ouv.") ";
      $data['ouverture_val']=$ouv_val;
      $data['sortie']="(".$sort.")";
      $data['sortie_val']=$sortie_val;
      $data['arriver']="(".$arri.")";
      $data['arriver_val']=$arri_val;
      $data['depart']="(".$dep.")";
      $data['depart_val']=$dep_val;
     $data['retour']="(".$ret.")";
     $data['retour_val']=$ret_val;
     $data['cloture']="(".$clot.")";
     $data['cloture_val']=$clot_val;
     
    // echo $tk['DATE_INTERVENTION'];exit();
      $data['breadcrumb'] = $this->make_bread->output();


          // echo $ticket['LATITUDE']."|".$ticket['LONGITUDE']; exit();
      $this->load->view('ticket/Ticket_Dashboard_View',$data);
    }
      public function categorie_materiaux(){
       $PROVINCE_ID = $this->input->post('PROVINCE_ID');
       $CATEGORIE_ID = $this->input->post('CATEGORIE_ID');

       // TROUVER CPPC
      $cppc=$this->Model->getList('rh_cppc');
      $option="<option value=''>--Selectionner--</option>";
      $id_cppc=0;
    foreach ($cppc as $key) {
      # code...
      if($key['PROVINCE_ID']==$PROVINCE_ID){
        $option.="<option value='".$key['CPPC_ID']."' selected>".$key['CPPC_NOM']."</option>";
        $id_cppc=$key['CPPC_ID'];
      }else{
      $option.="<option value='".$key['CPPC_ID']."'>".$key['CPPC_NOM']."</option>";
      }
    }

    // TROUVER MATERIEL ET EQUIPE
     $id=$id_cppc;

      $mat=$this->Model->getListOrder('interv_materiaux',array('CPPC_ID'=>$id,'CATEGORIE_ID'=>$CATEGORIE_ID),'MATERIEL_DESCR');
      $mat1=$this->Model->getListOrder('interv_materiaux',array('CPPC_ID'=>$id),'MATERIEL_DESCR');
      $equipe=$this->Model->getListOrder('rh_equipe_cppc',array('CPPC_ID'=>$id),'EQUIPE_NOM');

      $ap1="<table>";
      $ap="";
      foreach ($cppc as $ke) {
       $ap.="<input type='checkbox' name='tout' value='".$ke['CPPC_ID']."' class='tout'   ></td><td>".$ke['CPPC_NOM'] ;
       
      }
       $ap.="</table";

      $result="<h4>Liste des equipes et effectif disponible </h4>

      <table class='table table-bordered  table-responsive'><th>EQUIPE</th><th>EFFECTIF</th>";
      foreach ($equipe as $key) {
        $membre=$this->Model->getList('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$key['EQUIPE_ID']));
       $result.="<tr><td>".$key['EQUIPE_NOM']."</td><td><a hre='#' data-toggle='modal' data-target='#mydelete" . $key['EQUIPE_ID']. "'>".sizeof($membre)."</a></td></tr>";
       $mb="";
        $i=1;
foreach ($membre as $val) {
  $personnel=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$val['PERSONEL_ID']));
   // $mb.="<tr><td>".$personnel['PERSONNEL_NOM']."</td><td>".$personnel['PERSONNEL_PRENOM']."</td><td>".$personnel['PERSONNEL_TELEPHONE']."</td></tr>";

    $mb.="<h4>Liste des membre de l'equipe ".$key['EQUIPE_NOM']."</h4> $i. ".$personnel['PERSONNEL_NOM']." ".$personnel['PERSONNEL_PRENOM']." ".$personnel['PERSONNEL_TELEPHONE']." <p>";

     $i++;
}
        $result.="
                  
                                    <div class='modal fade' id='mydelete" .$key['EQUIPE_ID']. "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    " .$mb . "
                                                </div>

                                                <div class='modal-footer'>
                                                   
                                                </div>

                                            </div>
                                        </div>
                                    </div>";
      }

$result1="";
foreach ($mat1 as $value) {
        $categorie=$this->Model->getOne('tk_categories',array('CATEGORIE_ID'=>$value['CATEGORIE_ID']));
        $etat=$this->Model->getOne('interv_etat_materiaux',array('ETAT_ID'=>$value['ETAT']));

        $result1.="<tr><td>".$value['MATERIEL_DESCR']."</td><td>".$categorie['CATEGORIE_DESCR']."</td><td>".$etat['DESCRIPTION']."</td></tr>";
      }

      $result.="</table>
      
      <h4>Liste des materiels relatives</h4>

 <div class='modal fade' id='plus_materiel'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                <table class='table table-bordered  table-responsive'><th>MATERIEL</th><th>CATEGORIE</th><th>ETAT</th>
                                                    " .$result1 . "</table>
                                                </div>

                                                <div class='modal-footer'>
                                                   
                                                </div>

                                            </div>
                                        </div>
                                    </div>

      <table class='table table-bordered  table-responsive'><th>MATERIEL</th><th>CATEGORIE</th><th>ETAT</th>";
      foreach ($mat as $value) {
        $categorie=$this->Model->getOne('tk_categories',array('CATEGORIE_ID'=>$value['CATEGORIE_ID']));
        $etat=$this->Model->getOne('interv_etat_materiaux',array('ETAT_ID'=>$value['ETAT']));

        $result.="<tr><td>".$value['MATERIEL_DESCR']."</td><td>".$categorie['CATEGORIE_DESCR']."</td><td>".$etat['DESCRIPTION']."</td></tr>";
      }
      $result.="</table><a href='' id='' data-toggle='modal' data-target='#plus_materiel' class='btn btn-success'>Tous les materiels diaponibles</a>";
      echo $result;
    }

    public function getcordone(){
      $id_commune=$_POST['COMMUNE_ID'];
      $commune=$this->Model->getOne('ststm_communes',array('COMMUNE_ID'=>$id_commune));

      echo $commune['COMMUNE_LATITUDE']."|".$commune['COMMUNE_LONGITUDE'];
    }


     public function image(){
    
     
        $img = $_POST['image_data'];
    $code_img=$_POST['code_image'];
        $fileName = $code_img.".png";
        $filteredData=substr($img, strpos($img, ",")+1);
        $unencodedData=base64_decode($filteredData);
      
        $rep=FCPATH.'image_rapport/'.$fileName;
        
        file_put_contents($rep, $unencodedData);
        //echo 'Good';
    }

    function actualisation(){
      $actualisation=0;

      $tst_tick=$this->Model->getList('tk_ticket',array('ACTUALISATION_LISTE'=>0));
    if(!empty($tst_tick)){
      $actualisation=1;
      $datss=array('ACTUALISATION_LISTE'=>1);
      $misj=$this->Model->update('tk_ticket',array('ACTUALISATION_LISTE'=>0),$datss);
    }else{
      $actualisation=0;
    }

    echo $actualisation;

    }



    function actualisation_liste(){
      $actua=0;

      $tst_tick=$this->Model->getList('tk_ticket',array('ACTUALISATION_LISTE'=>0));
    if(!empty($tst_tick)){
      $actua=1;
      $datss=array('ACTUALISATION_LISTE'=>1);
      $misj=$this->Model->update('tk_ticket',array('ACTUALISATION_LISTE'=>0),$datss);
    }else{
      $actua=0;
    }

    echo $actua;

    }




    function actualisation_details($code_ticket){

      //$code_ticket=8;
      $actua=0;

      $degathumain=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$code_ticket,'IS_RELOAD'=>0));
      $degat_materiel=$this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$code_ticket,'IS_RELOAD'=>0));
    if(!empty($degathumain) || !empty($degat_materiel)){
      $actua=1;
      $datss=array('IS_RELOAD'=>1);
      $misj=$this->Model->update('interv_odk_degat_humain',array('TICKET_CODE'=>$code_ticket),$datss);
      $misj=$this->Model->update('interv_odk_degat_materiel',array('TICKET_CODE'=>$code_ticket),$datss);
    }else{
      $actua=0;
    }

    echo $actua;

    }
 }