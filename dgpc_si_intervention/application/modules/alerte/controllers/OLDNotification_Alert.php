<?php

 class Notification_Alert extends MY_Controller
 {
  
  function __construct()
  {
    parent::__construct();
    $this->make_bread->add('Notifications', "alerte/Notification_Alert", 0);
    $this->breadcrumb = $this->make_bread->output();
    $this->autho();
       }

  public function autho()
      {
      if(empty($this->session->userdata('DGPC_USER_EMAIL'))){
          redirect(base_url());
         }
      }

      function message(){
        $message_to_send = 'BONJOUR';
        $request=$this->notifications->send_sms('+25775628899',$message_to_send);
        print_r($request);
      }

      function select_personne()
  { 
    $commune=$_POST['COMMUNE'];
    
    $personne=$this->Model->getList('notif_personnel', array('COMMUNE_ID'=>$commune));
    $rst="";
    foreach ($personne as $value) {
     $rst.="<option value='".$value["PERSONNEL_ID"]."' selected>".$value["PERSONNEL_NOM"].' '.$value['PERSONNEL_PRENOM'].' ('.$value["PERSONNEL_TELEPHONE"].')'."</option>";
    }
    if($rst!=""){
    echo $rst;
    }else echo "<option value='0'>Aucun</option>";

  }

  public function select_partenaire()
  {
    $partenaires=$this->Model->getList('interv_partenaire');
    $liste_partenaires="";
    foreach ($partenaires as $value) {
     $liste_partenaires.="<option value='".$value["PARTENAIRE_ID"]."' selected>".$value["PARTENAIRE_DESCR"].' ('.$value["PARTENAIRE_TEL"].')'."</option>";
    }
    if($liste_partenaires!=""){
    echo $liste_partenaires;
    }else echo "<option value='0'>Aucun</option>";
  }

  function select_institution(){

    $institution=$this->Model->getList('notif_institution');
    $rst="";
    foreach ($institution as $value) {
     $rst.="<option value='".$value["INSTITUTION_ID"]."' selected>".$value["NOM_INSTITUTION"].' ('.$value["TELEPHONE"].')'."</option>";
    }
    if($rst!=""){
    echo $rst;
    }else echo "<option value='0'>Aucun</option>";
  }

 public function index(){
    if($_SERVER['REQUEST_METHOD']=='GET')
        {
          $code=$this->uri->segment(4);
          $data['ticket']=$this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$code));
          $data['communes']=$this->Model->getListOrder('ststm_communes',array(),'COMMUNE_NAME');
          $data['breadcrumb'] = $this->make_bread->output();
          $data['title'] = "Notification";
          $this->load->view('notification_view/Alerte_Notification_View', $data);
        }else{
        $this->form_validation->set_rules('MESSAGE', 'Message','required');
        $this->form_validation->set_rules('DESCR', 'Objet','required');
        $this->form_validation->set_rules('CATEGORIE[]', 'Categorie','required');
        $this->form_validation->set_rules('CHECK1[]', 'Check','required');
        $cat=$this->input->post('CATEGORIE[]');
        
        
        if($cat[0]==0 && count($cat) ==1){
          $this->form_validation->set_rules('PERSONNE[]', 'Personne','required|greater_than[0]',array("greater_than" => "sélectionner la personne valide"));
          $this->form_validation->set_rules('COMMUNE', 'Commune','required');
        }elseif($cat[0]==1 && count($cat) ==1){
          $this->form_validation->set_rules('INSTITUTION[]', 'Institution','required|greater_than[0]',array("greater_than" => "sélectionner l'institution valide"));
         }elseif($cat[0]==2 && count($cat) ==1){
          $this->form_validation->set_rules('PARTENAIRE[]', 'Partenaire','required|greater_than[0]',array("greater_than" => "sélectionner un partenaire valide"));
         }elseif($cat[0]==0 && $cat[1]==1 && count($cat)==2){
          $this->form_validation->set_rules('PERSONNE[]', 'Personne','required|greater_than[0]',array("greater_than" => "sélectionner la personne valide"));
          $this->form_validation->set_rules('COMMUNE', 'Commune','required');
          $this->form_validation->set_rules('INSTITUTION[]', 'Institution','required|greater_than[0]',array("greater_than" => "sélectionner l'institution valide"));
         }elseif($cat[0]==0 && $cat[1]==2 && count($cat)==2){
           $this->form_validation->set_rules('PERSONNE[]', 'Personne','required|greater_than[0]',array("greater_than" => "sélectionner la personne valide"));
           $this->form_validation->set_rules('COMMUNE', 'Commune','required');
           $this->form_validation->set_rules('PARTENAIRE[]', 'Partenaire','required|greater_than[0]',array("greater_than" => "sélectionner un partenaire valide"));
         }elseif($cat[0]==1 && $cat[1]==2 && count($cat)==2){
           $this->form_validation->set_rules('INSTITUTION[]', 'Institution','required|greater_than[0]',array("greater_than" => "sélectionner l'institution valide"));
           $this->form_validation->set_rules('PARTENAIRE[]', 'Partenaire','required|greater_than[0]',array("greater_than" => "sélectionner un partenaire valide"));
         }else{
          $this->form_validation->set_rules('COMMUNE', 'Commune','required');
          $this->form_validation->set_rules('PERSONNE[]', 'Personne','required|greater_than[0]',array("greater_than" => "sélectionner la personne valide"));
          $this->form_validation->set_rules('INSTITUTION[]', 'Institution','required|greater_than[0]',array("greater_than" => "sélectionner l'institution valide"));
          $this->form_validation->set_rules('PARTENAIRE[]', 'Partenaire','required|greater_than[0]',array("greater_than" => "sélectionner une partenaire valide"));
        }

        if ($this->form_validation->run() == FALSE) {

          $code=$this->uri->segment(4);
          $data['ticket']=$this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$code));
          $data['communes']=$this->Model->getList('ststm_communes');
          $data['breadcrumb'] = $this->make_bread->output();
          $data['error']="";
          $this->load->view('notification_view/Alerte_Notification_View', $data);         
         }else{
          $code=$this->uri->segment(4);
          $categorie=$this->input->post('CATEGORIE[]');
          $messages='';
          
          foreach ($categorie as $key => $value):
            
            if($value==0){
            $personne=$this->input->post('PERSONNE');
            $nbre=count($personne);
            $id="mem_personne:";
            for ($i=0; $i <$nbre ; $i++) { 
                       $id.=$personne[$i];
                  $infos_perso=$this->Model->getOne('notif_personnel',array('PERSONNEL_ID'=>$personne[$i]));
                  $infos_ticket=$this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$code));
             
            $datas = array(
                'OBJET_MESSAGE'=>$this->input->post('DESCR'),
                'MESSAGE'=>$this->input->post('MESSAGE'),
                'PERSONNEL_ID'=>$personne[$i],
                'TELEPHONE'=>$infos_perso['PERSONNEL_TELEPHONE'],
                'EMAIL'=>$infos_perso['PERSONNEL_EMAIL'],
                'COMMUNE_ID'=>$this->input->post('COMMUNE'),
                'IS_INSTITUTION'=>0,
                'TICKET_ID'=>$infos_ticket['TICKET_ID'],
                'USER_ID'=>$this->session->userdata('DGPC_USER_ID'),
                'DATE_MESSAGE'=>date('Y-m-d H-i-s'),
                      
          );
            $table='notif_message';
            $message_id=$this->Model->insert_last_id($table,$datas);
                        $CHECK=$this->input->post('CHECK1[]');
                        $sms=$CHECK[0]==1 and !isset($CHECK[1]);
                        $email=$CHECK[0]==2 and !isset($CHECK[1]);
                        if($sms){
                           $message_to_send = $this->input->post('MESSAGE');
                           $this->notifications->send_sms('+257'.$infos_perso['PERSONNEL_TELEPHONE'], $message_to_send);
                           //echo "SMS PRESONNEL :".$message_to_send.'</BR>';
                          
                        }else if($email){
                           $message_to_send = $this->input->post('MESSAGE');
                           $this->notifications->send_mail($infos_perso['PERSONNEL_EMAIL'],'DGPC - Population',array(),$message_to_send,array());
                         }else{
                           $message_to_send = $this->input->post('MESSAGE');
                           $this->notifications->send_mail($infos_perso['PERSONNEL_EMAIL'],'DGPC - Population',array(),$message_to_send,array());
                           $this->notifications->send_sms('+257'.$infos_perso['PERSONNEL_TELEPHONE'], $message_to_send);
                         }
                }
                $message='Populations';
            }

            if($value==1){
            $institution=$this->input->post('INSTITUTION[]');
            $nbre=count($institution);
            $id="mem_institution:";
            for ($i=0; $i <$nbre ; $i++) { 
                       $id.=$institution[$i];
                  $infos_inst=$this->Model->getOne('notif_institution',array('INSTITUTION_ID'=>$institution[$i]));
                  $infos_ticket=$this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$code));
             
            $data = array(
                'OBJET_MESSAGE'=>$this->input->post('DESCR'),
                'MESSAGE'=>$this->input->post('MESSAGE'),
                'INSTITUTION_ID'=>$institution[$i],
                'TELEPHONE'=>$infos_inst['TELEPHONE'],
                'EMAIL'=>$infos_inst['EMAIL'],
                'IS_INSTITUTION'=>1,
                'TICKET_ID'=>$infos_ticket['TICKET_ID'],
                'USER_ID'=>$this->session->userdata('DGPC_USER_ID'),
                'DATE_MESSAGE'=>date('Y-m-d H-i-s'),
                      
          );$table='notif_message';
            $message_id=$this->Model->insert_last_id($table,$data);
            $destina = $this->Model->getList('notif_institution',array('INSTITUTION_ID' => $institution[$i]));
                        $CHECK=$this->input->post('CHECK1[]');
                        $sms=$CHECK[0]==1 and !isset($CHECK[1]);
                        $email=$CHECK[0]==2 and !isset($CHECK[1]);
                        if($sms){
                           $message_to_send = $this->input->post('MESSAGE');
                           $this->notifications->send_sms('+257'.$infos_inst['TELEPHONE'], $message_to_send);
                           //echo "SMS INSTITUTION :".$message_to_send.'</BR>';
                        }else if($email){
                           $message_to_send = $this->input->post('MESSAGE');
                           $this->notifications->send_mail($infos_inst['EMAIL'],'DGPC - Institution',array(),$message_to_send,array());
                        }else{
                           $message_to_send = $this->input->post('MESSAGE');
                           $this->notifications->send_mail($infos_inst['EMAIL'],'DGPC - Institution',array(),$message_to_send,array());
                           $this->notifications->send_sms('+257'.$infos_inst['TELEPHONE'], $message_to_send);
                          }

             }
             $message='Institutions';
            }
            if($value==2){
              $partenaire=$this->input->post('PARTENAIRE');
            
            foreach ($partenaire as $key => $value) {
              $infos_part=$this->Model->getOne('interv_partenaire',array('PARTENAIRE_ID'=>$value));
              $infos_ticket=$this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$code));
              
              $datas = array(
                'OBJET_MESSAGE'=>$this->input->post('DESCR'),
                'MESSAGE'=>$this->input->post('MESSAGE'),
                'ID_PARTENAIRE'=>$value,
                'TELEPHONE'=>$infos_part['PARTENAIRE_TEL'],
                'EMAIL'=>$infos_part['PARTENAIRE_EMAIL'],
                'IS_INSTITUTION'=>2,
                'TICKET_ID'=>$infos_ticket['TICKET_ID'],
                'USER_ID'=>$this->session->userdata('DGPC_USER_ID'),
                'DATE_MESSAGE'=>date('Y-m-d H-i-s'),        
              );
              $table='notif_message';
              $message_id=$this->Model->insert_last_id($table,$datas);
              $CHECK=$this->input->post('CHECK1[]');
                        $sms=$CHECK[0]==1 and !isset($CHECK[1]);
                        $email=$CHECK[0]==2 and !isset($CHECK[1]);
                        if($sms){
                           $message_to_send = $this->input->post('MESSAGE');
                           $this->notifications->send_sms('+257'.$infos_part['PARTENAIRE_TEL'], $message_to_send);
                           //echo "SMS PARTENAIRE :".$message_to_send.'</BR>';
                        }else if($email){
                           $message_to_send = $this->input->post('MESSAGE');
                           $this->notifications->send_mail($infos_part['PARTENAIRE_EMAIL'],'DGPC - Partenaire',array(),$message_to_send,array());
                         }else{
                           $message_to_send = $this->input->post('MESSAGE');
                           $this->notifications->send_mail($infos_part['PARTENAIRE_EMAIL'],'DGPC - Partenaire',array(),$message_to_send,array());
                           $this->notifications->send_sms('+257'.$infos_part['PARTENAIRE_TEL'], $message_to_send);
                         }
                     }
                    $message='Partenaires';
              }
               $messages.=$message.",";
          endforeach;
          $messages.='//';
          $messages=str_replace(',//', '', $messages);
          $data['msg'] = "<div class='alert alert-success text-center'>Votre message est envoyé avec succès aux ".$messages." concerné(e)s. </div>";
          $this->session->set_flashdata($data);
          redirect(base_url().'alerte/Notification_Alert/liste');                
                 
        } 

      }
  }
 public function liste()
    {
      $notification=$this->Model->getList('notif_message');
      $tableaudata=array();
     foreach ($notification as $key => $value) {
  $institution=$this->Model->getOne('notif_institution',array('INSTITUTION_ID' =>$value['INSTITUTION_ID']));
  $personne=$this->Model->getOne('notif_personnel',array('PERSONNEL_ID'=>$value['PERSONNEL_ID']));
  $partenaire=$this->Model->getOne('interv_partenaire',array('PARTENAIRE_ID'=>$value['ID_PARTENAIRE']));
  $alert_notif=array();
  $alert_notif[]=$value['OBJET_MESSAGE'];
  $alert_notif[]=$value['MESSAGE'];
  if($personne){
    $alert_notif[]="<b>Population : </b>".$personne['PERSONNEL_NOM'].' '.$personne['PERSONNEL_PRENOM'];
    $alert_notif[]=$personne['PERSONNEL_TELEPHONE'];
    $alert_notif[]=$personne['PERSONNEL_EMAIL'];
  }if($institution){
    $alert_notif[]="<b>Institution : </b>".$institution['NOM_INSTITUTION'];
    $alert_notif[]=$institution['TELEPHONE'];
    $alert_notif[]=$institution['EMAIL'];
  }if($partenaire){
    $alert_notif[]="<b>Partenaire : </b>".$partenaire['PARTENAIRE_DESCR'];
    $alert_notif[]=$partenaire['PARTENAIRE_TEL'];
    $alert_notif[]=$partenaire['PARTENAIRE_EMAIL'];
  }
  $alert_notif[]=date('d/m/Y H:i:s',strtotime($value['DATE_MESSAGE']));
$tableaudata[]=$alert_notif;
              
             }
             //print_r($tableaudata);
            
      $template = array(
                    'table_open' => '<table id="mytable" class="table table-bordered table-stripped table-hover table-condensed">',
                    'table_close' => '</table>'
                );
                $this->table->set_template($template);
                $this->table->set_heading(array('Objet','Message','Catégories','Téléphone','Email','Date'));
                $data['alert_notif']=$tableaudata;
                $data['title']="Liste des alertes notifiées";
                $data['breadcrumb'] = $this->make_bread->output();
                $this->load->view('notification_view/Alerte_Notification_List_View',$data);
    }
    


}