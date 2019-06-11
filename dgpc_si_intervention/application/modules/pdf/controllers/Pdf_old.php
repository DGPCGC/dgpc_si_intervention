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
            $personnel=$this->mylibrary->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$intervention['PERSONNEL_ID']));
           
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Row(array(utf8_decode($equipe),utf8_decode($intervention['COMMENTAIRE']),utf8_decode($personnel['PERSONNEL_NOM'].' '.$personnel['PERSONNEL_PRENOM'])));

          }

      }else{
        $pdf->SetTextColor(58, 100, 100);
        $pdf->Cell(190,5,utf8_decode('Pas de données'),0,1,'C');
      }
      $pdf->Ln(5);


      // $pdf->SetFont('Arial','B',10);
      // $pdf->SetTextColor(0, 0, 0);
      // $pdf->Cell(190,5,utf8_decode('Informations terrains'),0,1,'L');
      // $pdf->SetWidths(array(62,62,68));
      // $pdf->SetFont('Arial','B',8);
      // $pdf->SetTextColor(58, 100, 100);
      // $pdf->Row(array(utf8_decode('Constant'),utf8_decode('Utilisateur'),utf8_decode('Collecté(s)')));
      // if(!empty($intervention_terrains)){
      //     foreach ($intervention_terrains as $terrain) {
      //        $user = $this->mylibrary->getOne('admin_users',array('USER_ODK'=>$terrain['USER_SEND'])); 
      //       $user_id=$user['USER_NOM'].' '.$user['USER_PRENOM'];
      //       $date_sbm = new DateTime($terrain['DATE_SBMS_ODK']);
      //       $d=$date_sbm->format('d/m/Y H:i');

      //       $pdf->SetTextColor(0, 0, 0);
      //       $pdf->Row(array(utf8_decode($terrain['CONSTANT_TERRAIN']),utf8_decode($user_id),utf8_decode($d)));

      //     }

      // }else{

      //   $pdf->SetTextColor(58, 100, 100);
      //   $pdf->Cell(190,5,utf8_decode('Pas de données'),0,1,'C');
      // }
      // $pdf->Ln(5);



      $pdf->SetFont('Arial','B',10);
      $pdf->SetTextColor(0, 0, 0);
      $pdf->Cell(190,5,utf8_decode('Dégats Humains'),0,1,'L');
      $pdf->SetWidths(array(51,47,47,47));
      $pdf->SetFont('Arial','B',8);
      $pdf->SetTextColor(58, 100, 100);
      $pdf->Row(array(utf8_decode('Nom & Prénom'),utf8_decode('IDENTIFICATION'),utf8_decode('Date Naissance'),utf8_decode('Statut')));
      if(!empty($degat_humain)){
          foreach ($degat_humain as $dg_humain) {
            $stat=($dg_humain['STATUT_SANTE'] ==1)?'Mort':'Blessé';

            $pdf->SetTextColor(0, 0, 0);
            $pdf->Row(array(utf8_decode($dg_humain['NOM_PRENOM']),utf8_decode($dg_humain['IDENTIFICATION']),utf8_decode($dg_humain['DATE_NAISSANCE']),utf8_decode($stat)));

          }

      }else{
        $pdf->SetTextColor(58, 100, 100);
        $pdf->Cell(190,5,utf8_decode('Pas de données'),0,1,'C');
      }
      $pdf->Ln(5);


      $pdf->SetFont('Arial','B',10);
      $pdf->SetTextColor(0, 0, 0);
      $pdf->Cell(190,5,utf8_decode('Dégats Matériels'),0,1,'L');
      $pdf->SetWidths(array(50,92,50));
      $pdf->SetFont('Arial','B',8);
      $pdf->SetTextColor(58, 100, 100);
      $pdf->Row(array(utf8_decode('Code Matériel'),utf8_decode('Commentaire'),utf8_decode('Date insertion')));
      if(!empty($degat_materiel)){
          foreach ($degat_materiel as $dg_materiel) {
            
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Row(array(utf8_decode($dg_materiel['MATERIEL_DESCR']),utf8_decode($dg_materiel['COMMENTAIRE']),utf8_decode($dg_materiel['DATE_INSERTION'])));

          }

      }else{
        $pdf->SetTextColor(58, 100, 100);
        $pdf->Cell(190,5,utf8_decode('Pas de données'),0,1,'C');
      }
      $pdf->Ln(5);

      $pdf->SetFont('Arial','B',10);
      $pdf->SetTextColor(0, 0, 0);
      $pdf->Cell(190,5,utf8_decode('Dégat Humain DGPC'),0,1,'L');
      $pdf->SetWidths(array(48,48,48,48));
      $pdf->SetFont('Arial','B',8);
      $pdf->SetTextColor(58, 100, 100);
      $pdf->Row(array(utf8_decode('Nom & Prénom'),utf8_decode('Matricule'),utf8_decode('Date Naissance'),utf8_decode('Statut')));
      if(!empty($degat_humain_dg)){
          foreach ($degat_humain_dg as $dg_humain_dgpc) {
            $stat_dgpc=($dg_humain_dgpc['STATUT_SANTE'] ==1)?'Mort':'Blessé';

            $pdf->SetTextColor(0, 0, 0);
            $pdf->Row(array(utf8_decode($dg_humain_dgpc['NOM_PRENOM']),utf8_decode($dg_humain_dgpc['IDENTIFICATION']),utf8_decode($dg_humain_dgpc['DATE_NAISSANCE']),utf8_decode($stat_dgpc)));

          }

      }else{
        $pdf->SetTextColor(58, 100, 100);
        $pdf->Cell(190,5,utf8_decode('Pas de données'),0,1,'C');
      }
      $pdf->Ln(5);


      $pdf->SetFont('Arial','B',10);
      $pdf->SetTextColor(0, 0, 0);
      $pdf->Cell(190,5,utf8_decode('Dégats matériel DGPC'),0,1,'L');
      $pdf->SetWidths(array(50,92,50));
      $pdf->SetFont('Arial','B',8);
      $pdf->SetTextColor(58, 100, 100);
      $pdf->Row(array(utf8_decode('Matériel'),utf8_decode('Commentaire'),utf8_decode('Date insertion')));
      if(!empty($degat_materiel_dgpc)){
          foreach ($degat_materiel_dgpc as $dg_materiel_dgpc) {
            
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Row(array(utf8_decode($dg_materiel_dgpc['MATERIEL_DESCR']),utf8_decode($dg_materiel_dgpc['COMMENTAIRE']),utf8_decode($dg_materiel_dgpc['DATE_INSERTION'])));

          }

      }else{
        $pdf->SetTextColor(58, 100, 100);
        $pdf->Cell(190,5,utf8_decode('Pas de données'),0,1,'C');
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


     
      
     


      $pdf->Output('fiche_intervation.pdf','I');

    }

    
}
