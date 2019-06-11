
<?php

 class Intervention extends MY_Controller
 {
  
  function __construct()
  {
  parent::__construct();
    $this->make_bread->add('Intervention', "tickets/Intervention", 0);
    $this->breadcrumb = $this->make_bread->output();
    $this->autho();
    }

  public function autho()
    {
    if(empty($this->session->userdata('DGPC_USER_EMAIL'))){
        redirect(base_url());
       }
    }
  public function validerData()
  {
    $ticket_code = $this->uri->segment(4);

    $array_data = array('IS_VALIDE'=>1);

    $this->Model->update('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket_code),$array_data);
    $this->Model->update('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket_code),$array_data);
    $this->Model->update('tk_ticket',array('TICKET_CODE'=>$ticket_code),array('STATUT_ID'=>4));

    redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
  }


    public function retournTerrain()
    {
      $ticket_code = $this->uri->segment(4);

      $ticket =$this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$ticket_code));

      $data['materiaux'] =$this->Model->getList('interv_materiaux');
      $data['materiaux_riv'] =$this->Model->getList('tk_materiel_endomage');
      $data['partenaires'] =$this->Model->getList('interv_partenaire');
      $data['collaborateurs'] =$this->Model->getList('rh_personnel_dgpc');

      $data['interventions'] = $this->Model->getList('interv_intervenants',array('TICKET_CODE'=>$ticket['TICKET_CODE']));      
     
      $data['degat_humain'] = $this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>0));
      $data['degat_humain_dg'] = $this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>1));
      $data['degat_materiel'] = $this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>0));
      $data['degat_materiel_dgpc'] = $this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>1));
      $data['interv_partenaire'] = $this->Model->getList('interv_odk_partenaire',array('TICKET_CODE'=>$ticket['TICKET_CODE']));
      $data['ticket'] = $ticket;
      
      /*
      echo "<pre>";
      print_r($data['degat_materiel_dgpc']);
      print_r($ticket['CPPC_ID']);
      echo "</pre>"; */
      
      $data['title'] = "Information d'une intervention";
      $data['breadcrumb'] = $this->make_bread->output();
      $this->load->view('intervention/Ajouter_Information_Intervention_View',$data);
    }

    public function degat_humain()
    {
      $this->form_validation->set_rules('NOM', 'Nom', 'required');
      $this->form_validation->set_rules('PRENOM', 'Prénom', 'required');
        
        $ticket_code = $this->uri->segment(4);

        if ($this->form_validation->run() == FALSE) {
           redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
        }else{
            $array = array(
                          'NOM_PRENOM'=>$this->input->post('NOM').' '.$this->input->post('PRENOM'),
                          'IDENTIFICATION'=>$this->input->post('IDENTIFICATION'),
                          'STATUT_SANTE'=>$this->input->post('STATUT_SANTE'),
                          'DATE_NAISSANCE'=>$this->input->post('DATE_NAISSANCE'),
                          'TICKET_CODE'=>$ticket_code,
                          'USER_ODK'=>$this->session->userdata('DGPC_USER_ODK'),                          
                          'SEVERITE'=>$this->input->post('SEVERITE')
                          );
        $infos_id  = $this->Model->insert_last_id('interv_odk_degat_humain',$array);

        $msg = "<font color='red'>Ce dégat n'a pas été enregistré</font>";
        if($infos_id>0)
          $msg = "<font color='green'>Ce dégat a été enregistré</font>";

        $donne['msg'] = $msg;
        $this->session->set_flashdata($donne);

        redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
        }

    }

    public function supprimer_degat_humain()
    {
        $DEGAT_HUMAIN_ID = $this->uri->segment(4);
        $ticket_code = $this->uri->segment(5);
        
        $msg = "<font color='red'>Ce dégat n'a pas été supprimé</font>";
        if($this->Model->delete('interv_odk_degat_humain',array('DEGAT_HUMAIN_ID'=>$DEGAT_HUMAIN_ID)))
          {
            $msg = "<font color='green'>Ce dégat a été supprimée</font>";
          }

        $donne['msg'] = $msg;
        $this->session->set_flashdata($donne);

        redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
    }
       
    

    public function degat_matariel()
    {
      $this->form_validation->set_rules('MATERIEL_ID', 'Matériel', 'required');
        
        $ticket_code = $this->uri->segment(4);

        if ($this->form_validation->run() == FALSE) {
           redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
        }else{
            $array = array(
                          'MATERIEL_ENDO_CODE'=>$this->input->post('MATERIEL_ID'),
                          'COMMENTAIRE'=>$this->input->post('COMMENTAIRE'),
                          'NOMBRE'=>$this->input->post('NOMBRE'),
                          'TICKET_CODE'=>$ticket_code,
                          'USER_ODK'=>$this->session->userdata('DGPC_USER_ODK')
                          );
        $infos_id  = $this->Model->insert_last_id('interv_odk_degat_materiel',$array);

        $msg = "<font color='red'>Ce dégat matériel n'a pas été enregistré</font>";
        if($infos_id>0)
          $msg = "<font color='green'>Ce dégat matériel a été enregistré</font>";

        $donne['msg'] = $msg;
        $this->session->set_flashdata($donne);

        redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
        }
    }

    public function supprimer_degat_materiel()
    {
        $DEGAT_MATERIEL_ID = $this->uri->segment(4);
        $ticket_code = $this->uri->segment(5);
        
        $msg = "<font color='red'>Ce dégat n'a pas été supprimé</font>";
        if($this->Model->delete('interv_odk_degat_materiel',array('DEGAT_MATERIEL_ID'=>$DEGAT_MATERIEL_ID)))
          {
            $msg = "<font color='green'>Ce dégat a été supprimée</font>";
          }

        $donne['msg'] = $msg;
        $this->session->set_flashdata($donne);

        redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
    }

    public function degat_humain_dgpc()
    {
      $this->form_validation->set_rules('PERSONNEL_ID', '`Personnel', 'required');
      $ticket_code = $this->uri->segment(4);
      
      $collaborateur =$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID' =>$this->input->post('PERSONNEL_ID')));
        if ($this->form_validation->run() == FALSE) {
           redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
        }else{
            $array = array(
                          'NOM_PRENOM'=>$collaborateur['PERSONNEL_NOM'].' '.$collaborateur['PERSONNEL_PRENOM'],
                          'STATUT_SANTE'=>$this->input->post('STATUT_SANTE'),
                          'SEVERITE'=>$this->input->post('SEVERITE'),
                          'IDENTIFICATION'=>$collaborateur['PERSONNEL_MATRICULE'],
                          'DATE_NAISSANCE'=>$collaborateur['DATE_NAISSANCE'],
                          'TICKET_CODE'=>$ticket_code,
                          'CONCERNE_DGPC'=>1,
                          'USER_ODK'=>$this->session->userdata('DGPC_USER_ODK')
                          );
        $infos_id  = $this->Model->insert_last_id('interv_odk_degat_humain',$array);

        $msg = "<font color='red'>Ce dégat humain n'a pas été enregistré</font>";
        if($infos_id>0)
          $msg = "<font color='green'>Ce dégat humain a été enregistré</font>";

        $donne['msg'] = $msg;
        $this->session->set_flashdata($donne);

        redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
        }
    }

    public function supprimer_degat_humain_dgpc()
    {
        $DEGAT_HUMAIN_ID = $this->uri->segment(4);
        $ticket_code = $this->uri->segment(5);
        
        $msg = "<font color='red'>Ce dégat humain n'a pas été supprimé</font>";
        if($this->Model->delete('interv_odk_degat_humain_dgpc',array('DEGAT_HUMAIN_ID'=>$DEGAT_HUMAIN_ID)))
          {
            $msg = "<font color='green'>Ce dégat humain a été supprimée</font>";
          }

        $donne['msg'] = $msg;
        $this->session->set_flashdata($donne);

        redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
    }

    public function degat_matariel_dgpc()
    {
      $this->form_validation->set_rules('MATERIEL_ID', 'Matériel', 'required');
        
        $ticket_code = $this->uri->segment(4);
        $materiel = $this->Model->getOne('interv_materiaux', array('MATERIEL_ID' => $this->input->post('MATERIEL_ID')));

        if ($this->form_validation->run() == FALSE) {
           redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
        }else{
            $ticket = $this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$ticket_code));
            $array = array(
                          'MATERIEL_ENDO_CODE'=>$this->input->post('MATERIEL_ID'),
                          'NOMBRE'=>$this->input->post('NOMBRE'),
                          'COMMENTAIRE'=>$this->input->post('COMMENTAIRE'),                         
                          'TICKET_CODE'=>$ticket_code,
                          'CONCERNE_DGPC'=>1,
                          'USER_ODK'=>$this->session->userdata('DGPC_USER_ODK'),
                          'DATE_INSERTION'=>date('Y-m-d H:i:s'),
                          'IS_VALIDE'=>1
                          //'CAUSE_CODE'=>$this->Model->getOne('tk_causes',array('CAUSE_ID'=>$ticket['CAUSE_ID']))['CAUSE_CODE']
                          );
        $infos_id  = $this->Model->insert_last_id('interv_odk_degat_materiel',$array);

        $msg = "<font color='red'>Ce dégat matériel n'a pas été enregistré</font>";
        if($infos_id>0)
          $msg = "<font color='green'>Ce dégat matériel a été enregistré</font>";

        $donne['msg'] = $msg;
        $this->session->set_flashdata($donne);

        redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
        }
    }

    public function supprimer_degat_materiel_dgpc()
    {
        $DEGAT_MATERIEL_ID = $this->uri->segment(4);
        $ticket_code = $this->uri->segment(5);
        
        $msg = "<font color='red'>Ce dégat n'a pas été supprimé</font>";
        if($this->Model->delete('interv_odk_degat_materiel',array('DEGAT_MATEREIL_ID'=>$DEGAT_MATERIEL_ID)))
          {
            $msg = "<font color='green'>Ce dégat a été supprimée</font>";
          }

        $donne['msg'] = $msg;
        $this->session->set_flashdata($donne);

        redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
    }

    public function interv_partenaire()
    {
      $this->form_validation->set_rules('PARTENAIRE_ID', 'Partenaire', 'required');
        
        $ticket_code = $this->uri->segment(4);
        $partenaire = $this->Model->getOne('interv_partenaire', array('PARTENAIRE_ID' => $this->input->post('PARTENAIRE_ID')));

        if ($this->form_validation->run() == FALSE) {
           redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
        }else{
            $array = array(
                          'PARTENAIRE_CODE'=>$partenaire['PARTENAIRE_CODE'],
                          'COMMENTAIRE'=>$this->input->post('COMMENTAIRE'),
                          'MATERIEL_DESCR'=>$this->input->post('MATERIEL_DESCR'),
                          'TICKET_CODE'=>$ticket_code,
                          'USER_ODK'=>$this->session->userdata('DGPC_USER_ODK')
                          );
        $infos_id  = $this->Model->insert_last_id('interv_odk_partenaire',$array);

        $msg = "<font color='red'>Cette présence du partenaire n'a pas été enregistré</font>";
        if($infos_id>0)
          $msg = "<font color='green'>Cette présence du partenaire a été enregistré</font>";

        $donne['msg'] = $msg;
        $this->session->set_flashdata($donne);

        redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
        }
    }
    
    public function interv_partenaire_supprimer()
    {
        $INTERV_PARTENAIRE_ID = $this->uri->segment(4);
        $ticket_code = $this->uri->segment(5);
        
        $msg = "<font color='red'>Cette présence du partenaire n'a pas été supprimé</font>";
        if($this->Model->delete('interv_odk_partenaire',array('INTERV_PARTENAIRE_ID'=>$INTERV_PARTENAIRE_ID)))
          {
            $msg = "<font color='green'>Cette présence du partenaire a été supprimée</font>";
          }

        $donne['msg'] = $msg;
        $this->session->set_flashdata($donne);

        redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
    }

    public function add_temp_action()
    {
        $this->form_validation->set_rules('DATE_ARRIVEE', 'Date sur site', 'required');
        $this->form_validation->set_rules('DATE_RETOUR', 'Date retour', 'required');
        
        $ticket_code = $this->uri->segment(4);
        if ($this->form_validation->run() == FALSE) {
           redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
        }else{

          $date_arrive = $this->input->post('DATE_ARRIVEE');
          $heure = $this->input->post('HEURE');
          $munite = $this->input->post('MINUTE');
          $arrive = $date_arrive.' '.$heure.':'.$munite;

          $date_retour = $this->input->post('DATE_RETOUR');
          $heure1 = $this->input->post('HEURE1');
          $munite1 = $this->input->post('MINUTE1');

          $retour = $date_retour.' '.$heure1.':'.$munite1;

          $array = array(
                       'DATE_ARRIVE_SITE'=>$arrive,
                       'DATE_RETOUR_CASERNE'=>$retour
                       );
           $msg = "<font color='red'>Cet ticket <b>".$ticket_code."</b> n'a pas été modifié</font>";

          if($this->Model->update_table('tk_ticket',array('TICKET_CODE'=>$ticket_code),$array))
           {
            $msg = "<font color='green'>Cet ticket <b>".$ticket_code."</b> a été modifié</font>";
           }
           $donne['msg'] = $msg;
           $this->session->set_flashdata($donne);

           redirect(base_url().'tickets/Intervention/retournTerrain/'.$ticket_code);
        }
    }

    public function valider_transmission(){
      $tkt_code=$this->uri->segment(4);
      $checked=$this->input->post('VALIDER');
      $commentaire=$this->input->post('OBSERVATION');
      if ($checked==1) {
        $statut_rapp=1;
        $statut_histo=3;

        $niv_rapp=2;
        $niv_histo=1;

        $array_rapport=array(
          'TICKET_CODE'=>$tkt_code,
          'STATUT'=>1,
          'USER_ID'=>$this->session->userdata('DGPC_USER_ID'),
          'NIVEAU_ID'=>2,
        );
        $id_rap=$this->Model->insert_last_id('transm_rapport',$array_rapport);
      }else{
        
        $statut_histo=2;
        $niv_histo=1;
        $id_rap=0;
      }
        

        $array_rapport_histo=array(
          'TICKET_CODE'=>$tkt_code,
          'STATUT'=>$statut_histo,
          'COMMENTAIRE'=>$commentaire,
          'USER_ID'=>$this->session->userdata('DGPC_USER_ID'),
          'NIVEAU_ID'=>$niv_histo
        );
        $check=$this->Model->checkvalue('transm_rapport_histo',array('TICKET_CODE'=>$tkt_code,'USER_ID'=>$this->session->userdata('DGPC_USER_ID'),'STATUT'=>2,'NIVEAU_ID'=>1));
        if ($check==TRUE) {
          $update=$this->Model->update('transm_rapport_histo',array('TICKET_CODE'=>$tkt_code,'NIVEAU_ID'=>1),$array_rapport_histo);
          $id_rap2=1;
        }else{
          $id_rap2=$this->Model->insert_last_id('transm_rapport_histo',$array_rapport_histo);
        }
        if($id_rap2>0 and 0<$id_rap){
          $msg = "<font color='green'>Le rapport a été bien transmis au superieur hierarchique</font>";
          
          
          
        }else{
          $msg = "<font color='green'>Le rapport reste encours de validation...</font>";
        }
        $donne['msg'] = $msg;
        $this->session->set_flashdata($donne);
        redirect(base_url('tickets/Tickets/detail/'.$tkt_code));
        
           

      }

      // public function rapport_ticket(){
      //   $niv=$this->uri->segment(4);
      //   if ($niv==1) {
      //     $tik_rapp=$this->Model->getList('transm_rapport',array('NIVEAU_ID'=>2,'STATUT'=>1));
      //     $nm='CPPC';
      //   }else if ($niv==2) {
      //     $tik_rapp=$this->Model->getList('transm_rapport',array('NIVEAU_ID'=>3,'STATUT'=>1));
      //     $nm='DGPC';
      //   }else{
      //     $tik_rapp=array();
      //     $nm='';
      //   }
        
      //   $resultat=array();
      //   foreach ($tik_rapp as $tick) {
      //     $info_tik=$this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$tick['TICKET_CODE']));
      //     $statut = $this->Model->getOne('tk_statuts', array('STATUT_ID' => $info_tik['STATUT_ID']));
      //       $canal = $this->Model->getOne('tk_canal', array('CANAL_ID' => $info_tik['CANAL_ID']));
      //       $cause = $this->Model->getOne('tk_causes', array('CAUSE_ID' => $info_tik['CAUSE_ID']));
      //       $commune = $this->Model->getOne('ststm_communes', array('COMMUNE_ID' => $info_tik['COMMUNE_ID']));
      //       $caserne = $this->Model->getOne('rh_cppc', array('CPPC_ID' => $info_tik['CPPC_ID']));
      //     $data=null;
      //     $data[]=$info_tik['CODE_EVENEMENT'];
      //     $data[]=$info_tik['TICKET_CODE'];
      //     $data[]=$info_tik['TICKET_DESCR'];
      //     $data[]=$cause['CAUSE_DESCR'];
      //     $data[]=$info_tik['TICKET_DECLARANT'];
      //     $data[]=$statut['STATUT_DESCR'];
      //     $new_date = new DateTime($info_tik['DATE_INSERTION']);
      //     $data[]=$new_date->format('d/m/Y');
      //     $data[]=$caserne['CPPC_NOM'];
      //     $data[]='<div class="dropdown ">
      //               <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Action
      //               <span class="caret"></span></a>
      //               <ul class="dropdown-menu dropdown-menu-right">
      //                   <li><a href='.base_url("tickets/Tickets/detail/".$info_tik['TICKET_CODE']).'/'.$niv.'>Details</li>
                                
      //               </ul>
      //             </div>';
      //     $resultat[]=$data;
      //   }

      //   $template=array(
      //   'table_open'=>'<table id="mytable" class="table table-bordered table-stripped table-hover table-condensed table-responsive">',
      //   '<table_close'=>'</table>'
      //   );
        
      //   $this->table->set_heading('CODE TICKET','CODE INTERV','DESCR','CAUSE','DECLARANT','STATUT','DATE','CPPC','OPTIONS');
      //   $this->table->set_template($template);
   
      //   $data['table']=$resultat;
      //   $data['title'] = "Liste des tickets à valider ".$nm;
      //   $data['breadcrumb'] = $this->make_bread->output();
      //   $this->load->view('tickets/intervention/Liste_ticket_rapport_View', $data);
   
      // }

      
      public function rapport_ticket(){
        $niv=$this->uri->segment(4);
        if ($niv==1) {
          $tik_rapp=$this->Model->getList('transm_rapport',array('NIVEAU_ID'=>2,'STATUT'=>1));
          $tik_rapps=$this->Model->getList('transm_rapport',array('NIVEAU_ID'=>2,'STATUT'=>3));
          $nm='CPPC';
        }else if ($niv==2) {
          $tik_rapp=$this->Model->getList('transm_rapport',array('NIVEAU_ID'=>3,'STATUT'=>1));
      $tik_rapps=$this->Model->getList('transm_rapport',array('NIVEAU_ID'=>2,'STATUT'=>3));
          $nm='DGPC';
        }else{
          $tik_rapp=array();
      $tik_rapps=array();
          $nm='';
        }
        
        $resultat=array();
        foreach ($tik_rapp as $tick) {
          $info_tik=$this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$tick['TICKET_CODE']));
          $statut = $this->Model->getOne('tk_statuts', array('STATUT_ID' => $info_tik['STATUT_ID']));
            $canal = $this->Model->getOne('tk_canal', array('CANAL_ID' => $info_tik['CANAL_ID']));
            $cause = $this->Model->getOne('tk_causes', array('CAUSE_ID' => $info_tik['CAUSE_ID']));
            $commune = $this->Model->getOne('ststm_communes', array('COMMUNE_ID' => $info_tik['COMMUNE_ID']));
            $caserne = $this->Model->getOne('rh_cppc', array('CPPC_ID' => $info_tik['CPPC_ID']));
          $data=null;
          $data[]=$info_tik['CODE_EVENEMENT'];
          $data[]=$info_tik['TICKET_CODE'];
          $data[]=$info_tik['TICKET_DESCR'];
          $data[]=$cause['CAUSE_DESCR'];
          $data[]=$info_tik['TICKET_DECLARANT'];
          $data[]=$statut['STATUT_DESCR'];
          $new_date = new DateTime($info_tik['DATE_INSERTION']);
          $data[]=$new_date->format('d/m/Y');
          $data[]=$caserne['CPPC_NOM'];
          $data[]="<a target='_blank' href='".base_url('pdf/Pdf/intervation/'.$info_tik['TICKET_CODE'])."'>PDF</a>";
          $data[]='<div class="dropdown ">
                    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Action
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href='.base_url("tickets/Tickets/detail/".$info_tik['TICKET_CODE']).'/'.$niv.'>Details</li>
                                
                    </ul>
                  </div>';
          $resultat[]=$data;
        }

        $template=array(
        'table_open'=>'<table id="mytable" class="table table-bordered table-stripped table-hover table-condensed table-responsive">',
        '<table_close'=>'</table>'
        );
        
        $this->table->set_heading('CODE TICKET','CODE INTERV','DESCR','CAUSE','DECLARANT','STATUT','DATE','CPPC','PDF','OPTIONS');
        $this->table->set_template($template);
    
    
    
    //Tableau ticket deja valider
    $table='<table id="mytb" class="table table-bordered table-stripped table-hover table-condensed table-responsive">
      <tr>
        <th>CODE TICKET</th>
        <th>CODE INTERV</th>
        <th>DESCR</th>
        <th>CAUSE</th>
        <th>DECLARANT</th>
        <th>STATUT</th>
        <th>DATE</th>
        <th>CPPC</th>
        <th>PDF</th>
        
      </tr>';
    
        foreach ($tik_rapps as $tick) {
          $info_tik=$this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$tick['TICKET_CODE']));
          $statut = $this->Model->getOne('tk_statuts', array('STATUT_ID' => $info_tik['STATUT_ID']));
            $canal = $this->Model->getOne('tk_canal', array('CANAL_ID' => $info_tik['CANAL_ID']));
            $cause = $this->Model->getOne('tk_causes', array('CAUSE_ID' => $info_tik['CAUSE_ID']));
            $commune = $this->Model->getOne('ststm_communes', array('COMMUNE_ID' => $info_tik['COMMUNE_ID']));
            $caserne = $this->Model->getOne('rh_cppc', array('CPPC_ID' => $info_tik['CPPC_ID']));
      $new_date = new DateTime($info_tik['DATE_INSERTION']);
          
          $table.="<tr>
      <td>".$info_tik['CODE_EVENEMENT']."</td>
      <td>".$info_tik['TICKET_CODE']."</td>
      <td>".$info_tik['TICKET_DESCR']."</td>
      <td>".$cause['CAUSE_DESCR']."</td>
      <td>".$info_tik['TICKET_DECLARANT']."</td>
      <td>".$statut['STATUT_DESCR']."</td>
      <td>".$new_date->format('d/m/Y')."</td>
      <td>".$caserne['CPPC_NOM']."</td>
       <td><a target='_blank' href='".base_url('pdf/Pdf/intervation/'.$info_tik['TICKET_CODE'])."'>PDF</a>;
      </tr>";
        
        }
    $table.="</table>";

        
    
    $data['tables']=$table;
        $data['table']=$resultat;
        $data['title'] = "Liste des tickets à valider ".$nm;
        $data['breadcrumb'] = $this->make_bread->output();
        $this->load->view('tickets/intervention/Liste_ticket_rapport_View', $data);
   
      }

      public function valider_transmission_cppc(){
      $tkt_code=$this->uri->segment(4);
      $checked=$this->input->post('VALIDER');
      $commentaire=$this->input->post('OBSERVATION');
      if ($checked==1) {
        $statut_rapp=1;
        $niv_rapp=3;

        $statut_histo=3;
        $niv_histo=2;

        $array_rapport=array(
          'TICKET_CODE'=>$tkt_code,
          'STATUT'=>$statut_rapp,
          'USER_ID'=>$this->session->userdata('DGPC_USER_ID'),
          'NIVEAU_ID'=>$statut_histo,
        );
        $id_rap=$this->Model->insert_last_id('transm_rapport',$array_rapport);
        $this->Model->update('transm_rapport',array('NIVEAU_ID'=>2,'TICKET_CODE'=>$tkt_code),array('STATUT'=>3));

      }else{
        
        $statut_histo=2;
        $niv_histo=2;
        $id_rap=0;
      }
        

        $array_rapport_histo=array(
          'TICKET_CODE'=>$tkt_code,
          'STATUT'=>$statut_histo,
          'COMMENTAIRE'=>$commentaire,
          'USER_ID'=>$this->session->userdata('DGPC_USER_ID'),
          'NIVEAU_ID'=>$niv_histo
        );
        $check=$this->Model->checkvalue('transm_rapport_histo',array('TICKET_CODE'=>$tkt_code,'USER_ID'=>$this->session->userdata('DGPC_USER_ID'),'STATUT'=>2,'NIVEAU_ID'=>2));
        if ($check==TRUE) {
          $update=$this->Model->update('transm_rapport_histo',array('TICKET_CODE'=>$tkt_code,'NIVEAU_ID'=>2),$array_rapport_histo);
          $id_rap2=1;
        }else{
          $id_rap2=$this->Model->insert_last_id('transm_rapport_histo',$array_rapport_histo);
        }
        if($id_rap2>0 and 0<$id_rap){
          $msg = "<font color='green'>Le rapport a été bien transmis au superieur hierarchique</font>";
          
          
        }else{
          $msg = "<font color='green'>Le rapport reste encours de validation...</font>";
        }
        $donne['msg'] = $msg;
        $this->session->set_flashdata($donne);
        redirect(base_url('tickets/Tickets/detail/'.$tkt_code.'/1'));
        
           

      }

      public function valider_transmission_dgpc(){
      $tkt_code=$this->uri->segment(4);
      $checked=$this->input->post('VALIDER');
      $commentaire=$this->input->post('OBSERVATION');
      if ($checked==1) {
        $statut_rapp=1;
        $niv_rapp=3;

        $statut_histo=3;
        $niv_histo=3;

        $array_rapport=array(
          'TICKET_CODE'=>$tkt_code,
          'STATUT'=>$statut_rapp,
          'USER_ID'=>$this->session->userdata('DGPC_USER_ID'),
          'NIVEAU_ID'=>$statut_histo,
        );
        //$id_rap=$this->Model->insert_last_id('transm_rapport',$array_rapport);
        $id_rap=1;
        $this->Model->update('transm_rapport',array('NIVEAU_ID'=>3,'TICKET_CODE'=>$tkt_code),array('STATUT'=>3));

      }else{
        
        $statut_histo=2;
        $niv_histo=3;
        $id_rap=0;
      }
        

        $array_rapport_histo=array(
          'TICKET_CODE'=>$tkt_code,
          'STATUT'=>$statut_histo,
          'COMMENTAIRE'=>$commentaire,
          'USER_ID'=>$this->session->userdata('DGPC_USER_ID'),
          'NIVEAU_ID'=>$niv_histo
        );
        $check=$this->Model->checkvalue('transm_rapport_histo',array('TICKET_CODE'=>$tkt_code,'USER_ID'=>$this->session->userdata('DGPC_USER_ID'),'STATUT'=>2,'NIVEAU_ID'=>3));
        if ($check==TRUE) {
          $update=$this->Model->update('transm_rapport_histo',array('TICKET_CODE'=>$tkt_code,'NIVEAU_ID'=>3),$array_rapport_histo);
          $id_rap2=1;
        }else{
          $id_rap2=$this->Model->insert_last_id('transm_rapport_histo',$array_rapport_histo);
        }
        if($id_rap2>0 and 0<$id_rap){
          $msg = "<font color='green'>Le rapport a été bien archivé</font>";
          
          
        }else{
          $msg = "<font color='green'>Le rapport reste encours de validation...</font>";
        }
        $donne['msg'] = $msg;
        $this->session->set_flashdata($donne);
        redirect(base_url('tickets/Tickets/detail/'.$tkt_code.'/2'));
        
           

      }

      //public funv
    
}