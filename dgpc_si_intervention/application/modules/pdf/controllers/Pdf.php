<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pdf extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->model('ghislain_model');
        // $this->load->model('roles_model');
        // $this->load->library("MbxLibrary");
    }

    public function test(){
      include 'pdfinclude/fpdf/mc_table.php';
      include 'pdfinclude/fpdf/pdf_config.php';
      $pdf = new PDF_CONFIG('P','mm','A4');
      $pdf->addPage();
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(190,5,utf8_decode('TESTghfghgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhghgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhghgfhgfhfghgfh'),1,1,'L');
      $pdf->MultiCell(117,6,'TESTghfghgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhghgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhgfhghgfhgfhfghgfh',1,'J',0);
      $pdf->Cell(190,5,utf8_decode('TEST'),1,1,'C');
      $pdf->Ln(5);

      $pdf->Cell(96,5,utf8_decode('statut'),1,0,'L');
      $pdf->Cell(48,5,utf8_decode('statut'),1,0,'L');
      $pdf->Cell(48,5,utf8_decode('statut'),1,1,'L');
      $pdf->SetWidths(array(48,48,48,48));
      $pdf->SetFont('Arial','B',8);
      $pdf->SetTextColor(58, 100, 100);
      $pdf->Row(array(utf8_decode('Statut'),utf8_decode('Canal'),utf8_decode('Cause'),utf8_decode('Enregistré par')));
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFont('Arial','',8);
      $pdf->Row(array(utf8_decode('1'),utf8_decode('2'),utf8_decode('3'),utf8_decode('4')));
      $pdf->Ln(5);

      $pdf->Output('tets.pdf','I');

    }


    public function intervation(){

      include 'pdfinclude/fpdf/mc_table.php';
      include 'pdfinclude/fpdf/pdf_config.php';


      $ticket_code =$this->uri->segment(4);
      // $ticket_code='DGPC_8';

      $ticket = $this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$ticket_code));
      $date_inter = new DateTime($ticket['DATE_INSERTION']);
      $date_new=$date_inter->format('d/m/Y');
      $commune=$this->mylibrary->getOne('ststm_communes',array('COMMUNE_ID'=>$ticket['COMMUNE_ID']))['COMMUNE_NAME'];
      $statut=$this->mylibrary->getOne('tk_statuts',array('STATUT_ID'=>$ticket['STATUT_ID']))['STATUT_DESCR'];
      $canal=$this->mylibrary->getOne('tk_canal',array('CANAL_ID'=>$ticket['CANAL_ID']))['CANAL_DESCR'];
      $cause=$this->mylibrary->getOne('tk_causes',array('CAUSE_ID'=>$ticket['CAUSE_ID']))['CAUSE_DESCR'];
      $user = $this->mylibrary->getOne('admin_users',array('USER_ID'=>$ticket['USER_ID']));
      $ident_user=$user['USER_NOM'].' '.$user['USER_PRENOM']; 




      $interventions= $this->Model->getList('interv_intervenants',array('TICKET_CODE'=>$ticket['TICKET_CODE']));       

      // $intervention_terrains = $this->Model->getList('interv_intervention_histo',array('TICKET_CODE'=>$ticket['TICKET_CODE']));

      $degat_humain = $this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>0));
      $degat_humain_dg = $this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>1));
      $degat_materiel = $this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>0));
      $degat_materiel_dgpc = $this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>1));
      $interv_partenaire = $this->Model->getList('interv_odk_partenaire',array('TICKET_CODE'=>$ticket['TICKET_CODE']));
      // $data['ticket = $ticket;

      // $title = "Détail d'un Ticket d'intervention";
		$cloture =$ticket['DATE_CLOTURE'];
		  if ($cloture==NULL) {
			$cloture =date('Y-m-d h:i:s');
		  }
		 $datetime1 = new DateTime($ticket['DATE_INSERTION']);
      $datetime2 = new DateTime($ticket['DATE_CLOTURE']);
      $interval = $datetime1->diff($datetime2);
      $dure= $interval->format('%a jours %h heures %i minutes %s secondes');

      

      $pdf = new PDF_CONFIG('P','mm','A4');
      $pdf->addPage();
      $pdf->SetFont('Arial','',12);
      
      $pdf->Cell(190,5,utf8_decode('FICHE D\'INTERVENTION'),0,1,'C');
      $pdf->Ln(5);

      $pdf->Cell(80,5,utf8_decode('Evenement : '),0,0,'R');
      $pdf->Cell(80,5,utf8_decode($ticket['TICKET_DESCR']),0,1,'C');
      $pdf->Ln();

      $pdf->SetWidths(array(48,48,48,48));
      $pdf->SetFont('Arial','B',8);
      $pdf->SetX(10);
      // $pdf->SetFillColor(195,195,195);
      $pdf->SetTextColor(58, 100, 100);
      $pdf->Row(array(utf8_decode('Code intervention'),utf8_decode('Déscription'),utf8_decode('Date déclarée'),utf8_decode('Déclaré par')));
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFont('Arial','',8);
      $pdf->Row(array(utf8_decode($ticket['TICKET_CODE']),utf8_decode($ticket['TICKET_DESCR']),utf8_decode($date_new),utf8_decode($ticket['TICKET_DECLARANT'].'('.$ticket['TICKET_DECLARANT_TEL'].')')));
	   
	  $pdf->SetFont('Arial','B',8);
      $pdf->SetTextColor(58, 100, 100);
      $pdf->Row(array(utf8_decode('Date ouverture'),utf8_decode('Date fermeture'),utf8_decode('Durée')));
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFont('Arial','',8);
      $pdf->Row(array(utf8_decode($ticket['DATE_INSERTION']),utf8_decode($cloture),utf8_decode($dure)));
	   
	   
      $pdf->SetFont('Arial','B',8);
      $pdf->SetTextColor(58, 100, 100);
      $pdf->Row(array(utf8_decode('Latitude'),utf8_decode('Longitude'),utf8_decode('Localité'),utf8_decode('Commune')));
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFont('Arial','',8);
      $pdf->Row(array(utf8_decode($ticket['LATITUDE']),utf8_decode($ticket['LONGITUDE']),utf8_decode($ticket['LOCALITE']),utf8_decode($commune)));

      $pdf->SetFont('Arial','B',8);
      $pdf->SetTextColor(58, 100, 100);
      $pdf->Row(array(utf8_decode('Statut'),utf8_decode('Canal'),utf8_decode('Cause'),utf8_decode('Enregistré par')));
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFont('Arial','',8);
      $pdf->Row(array(utf8_decode($statut),utf8_decode($canal),utf8_decode($cause),utf8_decode($ident_user)));
      $pdf->Ln(5);


		  $pdf->SetFont('Arial','B',10);
		  $pdf->Cell(190,5,utf8_decode('Intervenants'),0,1,'L');
		  $pdf->SetWidths(array(62,65,65));
		  $pdf->SetFont('Arial','B',8);
		  $pdf->SetTextColor(58, 100, 100);
		  $pdf->Row(array(utf8_decode('Equipe principale'),utf8_decode('Personnel'),utf8_decode('Commentaire')));
		  if(!empty($interventions)){
			  foreach ($interventions as $intervention) {
				$equipe=$this->mylibrary->getOne('rh_equipe_cppc',array('EQUIPE_ID'=>$intervention['EQUIPE_ID']))['EQUIPE_NOM'];
				$equipe_id=$intervention['EQUIPE_ID'];
				$personnel=$this->Model->querysql("SELECT * FROM rh_equipe_membre_cppc join rh_personnel_dgpc on rh_equipe_membre_cppc.PERSONEL_ID=rh_personnel_dgpc.PERSONNEL_ID where rh_equipe_membre_cppc.EQUIPE_ID='$equipe_id'");
				//$personnel=$this->Model->getList('rh_personnel_dgpc',array('PERSONNEL_ID'=>$intervention['PERSONNEL_ID']));
				$list_personnel="";
				foreach($personnel as $personnels){
					$list_personnel.=$personnels['PERSONNEL_NOM'].' '.$personnels['PERSONNEL_PRENOM'].',';
				}
			   
				$pdf->SetTextColor(0, 0, 0);
				$pdf->Row(array(utf8_decode($equipe),utf8_decode($list_personnel),utf8_decode($intervention['COMMENTAIRE'])));

			  }

		  }else{
			$pdf->SetTextColor(58, 100, 100);
			$pdf->Cell(190,5,utf8_decode('Pas de données'),0,1,'C');
		  }
		  $pdf->Ln(5);
		  $path=FCPATH.'image_rapport/'.$this->uri->segment(4).'.png';
		  if(file_exists($path)){
			$pdf->Image(base_url().'image_rapport/'.$this->uri->segment(4).'.png');
		  }else{
			 $pdf->Cell(190,5,utf8_decode('Aucun Rapport pour ce ticket'),0,1,'C');
		  }
		 
		  
		  $pdf->Ln(5);
		  


 
	  

		  $pdf->SetFont('Arial','B',10);
		  $pdf->SetTextColor(0, 0, 0);
		  $pdf->Cell(190,5,utf8_decode('Présence de(s) partenaire(s)'),0,1,'L');
		  $pdf->SetWidths(array(50,50,92));
		  $pdf->SetFont('Arial','B',8);
		  $pdf->SetTextColor(58, 100, 100);
		  $pdf->Row(array(utf8_decode('Partenaire'),utf8_decode('Matériel'),utf8_decode('Commentaire')));
		  if(!empty($interv_partenaire)){
			  foreach ($interv_partenaire as $partenaire) {
				$partenaire_data=$this->mylibrary->getOne('interv_partenaire',array('PARTENAIRE_CODE'=>$partenaire['PARTENAIRE_CODE']))['PARTENAIRE_DESCR'];
				
				$pdf->SetTextColor(0, 0, 0);
				$pdf->Row(array(utf8_decode($partenaire_data),utf8_decode($partenaire['MATERIEL_DESCR']),utf8_decode($partenaire['COMMENTAIRE'])));

			  }

		  }else{
			$pdf->SetTextColor(58, 100, 100);
			$pdf->Cell(190,5,utf8_decode('Pas de données'),0,1,'C');
		  }
		  $pdf->Ln(5);

      $niv_observation=$this->Model->getList('transm_rapport_histo',array('TICKET_CODE'=>$ticket_code));
      if(!empty($niv_observation)){
        $pdf->SetFont('Arial','B',10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(190,5,utf8_decode('Observation'),0,1,'L');
        $i=1;
        foreach ($niv_observation as $niv_observations) {
          if($niv_observations['NIVEAU_ID']==1){
            $titre='Chef d\'équipe';
          }else if ($niv_observations['NIVEAU_ID']==2) {
            $titre='Chef CPPC';
          }else if ($niv_observations['NIVEAU_ID']==3) {
            $titre='Chef DGPC';
          }
          $pdf->SetFont('Arial','',8);
          $pdf->Cell(190,5,$i.'. '.utf8_decode($titre),0,1,'L');
          $pdf->MultiCell(117,6,utf8_decode($niv_observations['COMMENTAIRE']),0,'J',0);
          $i++;
        }
        
      }


     
      
     


      $pdf->Output('fiche_intervation.pdf','I');

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
          $id_cppc=$this->session->userdata('DGPC_CPPC_ID');
          $email=$this->Model->querysqlone("SELECT * FROM rh_cppc_manager JOIN rh_personnel_dgpc on rh_cppc_manager.PERSONNEL_ID=rh_personnel_dgpc.PERSONNEL_ID WHERE CPPC_ID='$id_cppc' ORDER BY rh_cppc_manager.CPPC_MANAGER_ID DESC");
          // print_r($email);
          // die();
          $email=$email['PERSONNEL_EMAIL'];
          if(!empty($email)){
            $this->pdf_send_to_mail($tkt_code,$email);
          }
          
          
          
          
        }else{
          $msg = "<font color='green'>Le rapport reste encours de validation...</font>";
        }
        $donne['msg'] = $msg;
        $this->session->set_flashdata($donne);
        redirect(base_url('tickets/Tickets/detail/'.$tkt_code));
        
           

      }



 public function pdf_send_to_mail($tkt_code,$email){

      include 'pdfinclude/fpdf/mc_table.php';
      include 'pdfinclude/fpdf/pdf_config.php';


      $ticket_code =$tkt_code;
      // $ticket_code='DGPC_8';

      $ticket = $this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$ticket_code));
      $date_inter = new DateTime($ticket['DATE_INSERTION']);
      $date_new=$date_inter->format('d/m/Y');
      $commune=$this->mylibrary->getOne('ststm_communes',array('COMMUNE_ID'=>$ticket['COMMUNE_ID']))['COMMUNE_NAME'];
      $statut=$this->mylibrary->getOne('tk_statuts',array('STATUT_ID'=>$ticket['STATUT_ID']))['STATUT_DESCR'];
      $canal=$this->mylibrary->getOne('tk_canal',array('CANAL_ID'=>$ticket['CANAL_ID']))['CANAL_DESCR'];
      $cause=$this->mylibrary->getOne('tk_causes',array('CAUSE_ID'=>$ticket['CAUSE_ID']))['CAUSE_DESCR'];
      $user = $this->mylibrary->getOne('admin_users',array('USER_ID'=>$ticket['USER_ID']));
      $ident_user=$user['USER_NOM'].' '.$user['USER_PRENOM']; 




      $interventions= $this->Model->getList('interv_intervenants',array('TICKET_CODE'=>$ticket['TICKET_CODE']));       

      // $intervention_terrains = $this->Model->getList('interv_intervention_histo',array('TICKET_CODE'=>$ticket['TICKET_CODE']));

      $degat_humain = $this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>0));
      $degat_humain_dg = $this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>1));
      $degat_materiel = $this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>0));
      $degat_materiel_dgpc = $this->Model->getList('interv_odk_degat_materiel',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'CONCERNE_DGPC'=>1));
      $interv_partenaire = $this->Model->getList('interv_odk_partenaire',array('TICKET_CODE'=>$ticket['TICKET_CODE']));
      // $data['ticket = $ticket;

      // $title = "Détail d'un Ticket d'intervention";
    $cloture =$ticket['DATE_CLOTURE'];
      if ($cloture==NULL) {
      $cloture =date('Y-m-d h:i:s');
      }
     $datetime1 = new DateTime($ticket['DATE_INSERTION']);
      $datetime2 = new DateTime($ticket['DATE_CLOTURE']);
      $interval = $datetime1->diff($datetime2);
      $dure= $interval->format('%a jours %h heures %i minutes %s secondes');

      

      $pdf = new PDF_CONFIG('P','mm','A4');
      $pdf->addPage();
      $pdf->SetFont('Arial','',12);
      
      $pdf->Cell(190,5,utf8_decode('FICHE D\'INTERVENTION'),0,1,'C');
      $pdf->Ln(5);

      $pdf->Cell(80,5,utf8_decode('Evenement : '),0,0,'R');
      $pdf->Cell(80,5,utf8_decode($ticket['TICKET_DESCR']),0,1,'C');
      $pdf->Ln();

      $pdf->SetWidths(array(48,48,48,48));
      $pdf->SetFont('Arial','B',8);
      $pdf->SetX(10);
      // $pdf->SetFillColor(195,195,195);
      $pdf->SetTextColor(58, 100, 100);
      $pdf->Row(array(utf8_decode('Code intervention'),utf8_decode('Déscription'),utf8_decode('Date déclarée'),utf8_decode('Déclaré par')));
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFont('Arial','',8);
      $pdf->Row(array(utf8_decode($ticket['TICKET_CODE']),utf8_decode($ticket['TICKET_DESCR']),utf8_decode($date_new),utf8_decode($ticket['TICKET_DECLARANT'].'('.$ticket['TICKET_DECLARANT_TEL'].')')));
     
    $pdf->SetFont('Arial','B',8);
      $pdf->SetTextColor(58, 100, 100);
      $pdf->Row(array(utf8_decode('Date ouverture'),utf8_decode('Date fermeture'),utf8_decode('Durée')));
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFont('Arial','',8);
      $pdf->Row(array(utf8_decode($ticket['DATE_INSERTION']),utf8_decode($cloture),utf8_decode($dure)));
     
     
      $pdf->SetFont('Arial','B',8);
      $pdf->SetTextColor(58, 100, 100);
      $pdf->Row(array(utf8_decode('Latitude'),utf8_decode('Longitude'),utf8_decode('Localité'),utf8_decode('Commune')));
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFont('Arial','',8);
      $pdf->Row(array(utf8_decode($ticket['LATITUDE']),utf8_decode($ticket['LONGITUDE']),utf8_decode($ticket['LOCALITE']),utf8_decode($commune)));

      $pdf->SetFont('Arial','B',8);
      $pdf->SetTextColor(58, 100, 100);
      $pdf->Row(array(utf8_decode('Statut'),utf8_decode('Canal'),utf8_decode('Cause'),utf8_decode('Enregistré par')));
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFont('Arial','',8);
      $pdf->Row(array(utf8_decode($statut),utf8_decode($canal),utf8_decode($cause),utf8_decode($ident_user)));
      $pdf->Ln(5);


      $pdf->SetFont('Arial','B',10);
      $pdf->Cell(190,5,utf8_decode('Intervenants'),0,1,'L');
      $pdf->SetWidths(array(62,65,65));
      $pdf->SetFont('Arial','B',8);
      $pdf->SetTextColor(58, 100, 100);
      $pdf->Row(array(utf8_decode('Equipe principale'),utf8_decode('Personnel'),utf8_decode('Commentaire')));
      if(!empty($interventions)){
        foreach ($interventions as $intervention) {
        $equipe=$this->mylibrary->getOne('rh_equipe_cppc',array('EQUIPE_ID'=>$intervention['EQUIPE_ID']))['EQUIPE_NOM'];
        $equipe_id=$intervention['EQUIPE_ID'];
        $personnel=$this->Model->querysql("SELECT * FROM rh_equipe_membre_cppc join rh_personnel_dgpc on rh_equipe_membre_cppc.PERSONEL_ID=rh_personnel_dgpc.PERSONNEL_ID where rh_equipe_membre_cppc.EQUIPE_ID='$equipe_id'");
        //$personnel=$this->Model->getList('rh_personnel_dgpc',array('PERSONNEL_ID'=>$intervention['PERSONNEL_ID']));
        $list_personnel="";
        foreach($personnel as $personnels){
          $list_personnel.=$personnels['PERSONNEL_NOM'].' '.$personnels['PERSONNEL_PRENOM'].',';
        }
         
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Row(array(utf8_decode($equipe),utf8_decode($list_personnel),utf8_decode($intervention['COMMENTAIRE'])));

        }

      }else{
      $pdf->SetTextColor(58, 100, 100);
      $pdf->Cell(190,5,utf8_decode('Pas de données'),0,1,'C');
      }
      $pdf->Ln(5);
      $path=FCPATH.'image_rapport/'.$this->uri->segment(4).'.png';
      if(file_exists($path)){
      $pdf->Image(base_url().'image_rapport/'.$this->uri->segment(4).'.png');
      }else{
       $pdf->Cell(190,5,utf8_decode('Aucun Rapport pour ce ticket'),0,1,'C');
      }
     
      
      $pdf->Ln(5);
      


 
    

      $pdf->SetFont('Arial','B',10);
      $pdf->SetTextColor(0, 0, 0);
      $pdf->Cell(190,5,utf8_decode('Présence de(s) partenaire(s)'),0,1,'L');
      $pdf->SetWidths(array(50,50,92));
      $pdf->SetFont('Arial','B',8);
      $pdf->SetTextColor(58, 100, 100);
      $pdf->Row(array(utf8_decode('Partenaire'),utf8_decode('Matériel'),utf8_decode('Commentaire')));
      if(!empty($interv_partenaire)){
        foreach ($interv_partenaire as $partenaire) {
        $partenaire_data=$this->mylibrary->getOne('interv_partenaire',array('PARTENAIRE_CODE'=>$partenaire['PARTENAIRE_CODE']))['PARTENAIRE_DESCR'];
        
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Row(array(utf8_decode($partenaire_data),utf8_decode($partenaire['MATERIEL_DESCR']),utf8_decode($partenaire['COMMENTAIRE'])));

        }

      }else{
      $pdf->SetTextColor(58, 100, 100);
      $pdf->Cell(190,5,utf8_decode('Pas de données'),0,1,'C');
      }
      $pdf->Ln(5);

      $niv_observation=$this->Model->getList('transm_rapport_histo',array('TICKET_CODE'=>$ticket_code));
      if(!empty($niv_observation)){
        $pdf->SetFont('Arial','B',10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(190,5,utf8_decode('Observation'),0,1,'L');
        $i=1;
        foreach ($niv_observation as $niv_observations) {
          if($niv_observations['NIVEAU_ID']==1){
            $titre='Chef d\'équipe';
          }else if ($niv_observations['NIVEAU_ID']==2) {
            $titre='Chef CPPC';
          }else if ($niv_observations['NIVEAU_ID']==3) {
            $titre='Chef DGPC';
          }
          $pdf->SetFont('Arial','',8);
          $pdf->Cell(190,5,$i.'. '.utf8_decode($titre),0,1,'L');
          $pdf->MultiCell(117,6,utf8_decode($niv_observations['COMMENTAIRE']),0,'J',0);
          $i++;
        }
        
      }
      $lien_sauvegarder = FCPATH.'image_rapport/sendmail';
        if(!is_dir($lien_sauvegarder)){
         mkdir($lien_sauvegarder,0777,TRUE); 
        }

      $pdf->Output(''.$lien_sauvegarder.'/Rapport_Ticket'.$ticket_code.'.pdf','F');
      $pdfname=$lien_sauvegarder.'/Rapport_Ticket'.$ticket_code.'.pdf';
      $attachmentss=array($pdfname);
      $mail_dest=$email;
      //$mail_dest='teddywalter2016@gmail.com';
      $message_to_send="Cher CPPC veuillez trouver ci joint le rapport d'intervention qui a été transmis.";
      // $this->notifications->send_mail(array("mail"=>"nocmediabox@mediabox.bi","name"=>"DGPC - Transmission Rapport"),$mail_dest,"Service de contrôle Senelec",array(),$msgmaildirect,$attachmentss);

      $this->notifications->send_mail($mail_dest,'DGPC - Rapport Transmission',array(),$message_to_send,$attachmentss);

      //$this->index();

    }
    
}
