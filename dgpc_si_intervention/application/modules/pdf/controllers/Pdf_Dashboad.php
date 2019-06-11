<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pdf_Dashboad extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->model('ghislain_model');
        // $this->load->model('roles_model');
        // $this->load->library("MbxLibrary");
    }
    public function dateToFrench($date, $format) 
{
    $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    $french_days = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');
    $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
    return str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date) ) ) );
}

    public function print($code){
    	 include 'pdfinclude/fpdf/mc_table.php';
      include 'pdfinclude/fpdf/pdf_config.php';
     // include 'pdfincludes/fpdf/pdf.php';
      $ticket=$this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$code));
      $stutut_ticket = $this->Model->getOne('tk_statuts',array('STATUT_ID'=>$ticket['STATUT_ID']));

      $lien_sauvegarder = FCPATH.'upload/ted';
      
        if(!is_dir($lien_sauvegarder)){
         mkdir($lien_sauvegarder,0777,TRUE); 
        }
      //$this->fpdf->Image('logo.jpg',10,6);
      $pdf = new PDF_CONFIG('L', 'mm', 'A4' ); 
    
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(180,10,utf8_decode("(Code ticket: ".$code.") ".$stutut_ticket['STATUT_DESCR']),0,1,'L');
$pdf->Ln(5); 
$pdf->SetFont('Arial','',12);

 $pdf->SetFillColor('230,230,230');
 $pdf->Cell(275,8,$this->dateToFrench("now" ,"l j F Y h:i:s"),0,1,'C',true);
 $pdf->Cell(270,2,"",0,1,'C');
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(40,20,utf8_decode(''),1);
$pdf->SetXY( 10, 35);
$pdf->Cell(40,10,utf8_decode("DESCRIPTION"),0,0,'L');

$pdf->Cell(110,10,utf8_decode("DECLARANT"),1,1,'L');
$pdf->Cell(40,10,utf8_decode(""),0,0,'L');
$pdf->Cell(30,10,utf8_decode("INDIVIDU"),1,0,'L');
$pdf->Cell(25,10,utf8_decode("TELEPHONE"),1,0,'L');
$pdf->Cell(25,10,utf8_decode("CANAL"),1,0,'L');
$pdf->Cell(30,10,utf8_decode("DECLARANTION"),1,1,'L');

 $categorie_mat = $this->Model->getOne('tk_categories',array('CATEGORIE_ID'=>$ticket['CATEGORIE_ID']));
  $canal= $this->Model->getOne('tk_canal',array('CANAL_ID'=>$ticket['CANAL_ID'])); 
$pdf->Cell(40,20,utf8_decode(''),1,0,'L');
$pdf->SetXY( 10, 55);
$pdf->MultiCell(40,10,utf8_decode($categorie_mat['CATEGORIE_DESCR'].'/'.$ticket['TICKET_DESCR']),0);
$pdf->SetXY( 50, 55);
$pdf->Cell(30,20,utf8_decode(''),1,0,'L');
$pdf->SetXY( 50, 55);
$pdf->MultiCell(30,10,utf8_decode($ticket['TICKET_DECLARANT']),0);
$pdf->SetXY( 80, 55);
$pdf->Cell(25,20,utf8_decode(''),1,0,'L');
$pdf->SetXY( 80, 55);
$pdf->MultiCell(25,10,utf8_decode($ticket['TICKET_DECLARANT_TEL']),0);
$pdf->SetXY( 105, 55);
$pdf->Cell(25,20,utf8_decode(''),1,0,'L');
$pdf->SetXY( 105, 55);
$pdf->MultiCell(25,10,utf8_decode($canal['CANAL_DESCR']),0);
$pdf->SetXY( 130, 55);
$pdf->Cell(30,20,utf8_decode(''),1,0,'L');
$pdf->SetXY( 130, 55);
$pdf->MultiCell(30,10,utf8_decode("Blessé(s):".$ticket['NOMBRE_BLESSE']." , Mort(s):" .$ticket['NOMBRE_MORT']),0);
 $pdf->SetXY( 170, 35);
$pdf->Cell(45,10,utf8_decode('DATE OUVERTURE:'),1,0,'L');
$ouverture_tiquet=$ticket['DATE_INSERTION'];
      $cloture_tiquet=$ticket['DATE_CLOTURE'];
      if ($cloture_tiquet==NULL) {
        $cloture_tiquet =date('Y-m-d h:i:s');
      }
       $datetime1 = new DateTime($cloture_tiquet);
      $datetime2 = new DateTime($ouverture_tiquet);
      $interval = $datetime1->diff($datetime2);
      // print_r($interval) ;exit();
      $dure= $interval->format('%a jours %h heures %i minutes %s secondes');
$pdf->Cell(70,10,utf8_decode($ouverture_tiquet),1,1,'L');
$pdf->SetXY( 170, 45);

$pdf->Cell(45,10,utf8_decode('DATE FERMETURE:'),1,0,'L');
$pdf->Cell(70,10,utf8_decode($cloture_tiquet),1,1,'L');
$pdf->SetXY( 170, 55);
$pdf->Cell(45,10,utf8_decode('DUREE:'),1,0,'L');
$pdf->Cell(70,10,utf8_decode($dure),1,1,'L');

$pdf->SetXY( 10, 80);

$pdf->Cell(160,20,utf8_decode(''),1,0,'L');
$pdf->Cell(60,10,utf8_decode(''),1,0,'L');
$pdf->Cell(55,10,utf8_decode(''),1,0,'L');
$pdf->SetXY( 10, 80);
$pdf->MultiCell(160,10,utf8_decode('CPPC'),0);
$pdf->SetXY( 175, 80);
$pdf->MultiCell(55,10,utf8_decode('DEGATS HUMAINS'),0,'C');
$pdf->SetXY( 230, 80);
$pdf->MultiCell(55,10,utf8_decode('DEGATS HUMAINS'),0,'C');
$pdf->SetXY( 170, 90);
$pdf->Cell(30,10,utf8_decode(''),1,0,'L');
$pdf->Cell(30,10,utf8_decode(''),1,0,'L');
$pdf->Cell(27.5,10,utf8_decode(''),1,0,'L');
$pdf->Cell(27.5,10,utf8_decode(''),1,0,'L');
$pdf->SetXY( 170,90);
$pdf->MultiCell(30,10,utf8_decode('BLESSES REELS'),0,'C');
$pdf->SetXY( 200,90);
$pdf->MultiCell(30,10,utf8_decode('MORTS REELS'),0,'C');
$pdf->SetXY( 227.5,90);
$pdf->MultiCell(30,10,utf8_decode('RIVERAIN'),0,'C');
$pdf->SetXY( 255,90);
$pdf->MultiCell(30,10,utf8_decode('DGPC'),0,'C');
$blesse = $this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'STATUT_SANTE'=>0));
$mort= $this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$ticket['TICKET_CODE'],'STATUT_SANTE'=>1));
$ticket_code=$ticket['TICKET_CODE'];
 $materiel_riverains = $this->Model->getRequete("SELECT mat.MATERIEL_ENDO_DESCR,SUM(imat.NOMBRE) as nb_NOMBRE FROM interv_odk_degat_materiel as imat JOIN tk_materiel_endomage as mat ON imat.MATERIEL_ENDO_CODE = mat.MATERIEL_ENDO_CODE WHERE imat.CONCERNE_DGPC=0 AND imat.TICKET_CODE = $ticket_code GROUP BY imat.TICKET_CODE,mat.MATERIEL_ENDO_ID");
 $materiel_dgpcs = $this->Model->getRequete("SELECT mat.MATERIEL_DESCR,SUM(imat.NOMBRE) as nb_NOMBRE FROM interv_odk_degat_materiel as imat JOIN interv_materiaux as mat ON imat.MATERIEL_ENDO_CODE = mat.MATERIEL_CODE WHERE imat.CONCERNE_DGPC=1 AND imat.TICKET_CODE = $ticket_code GROUP BY imat.TICKET_CODE,mat.MATERIEL_ID");
 $manger =$this->Model->getRequeteOne("SELECT rh_cppc_manager.PERSONNEL_ID, MAX(rh_cppc_manager.CPPC_MANAGER_ID), rh_personnel_dgpc.GRADE, rh_personnel_dgpc.FONCTION, rh_personnel_dgpc.PERSONNEL_NOM, rh_personnel_dgpc.PERSONNEL_PRENOM FROM rh_cppc_manager JOIN rh_personnel_dgpc ON rh_cppc_manager.PERSONNEL_ID=rh_personnel_dgpc.PERSONNEL_ID WHERE CPPC_ID=".$ticket['CPPC_ID']." GROUP BY PERSONNEL_ID");

 $cppc= $this->Model->getOne('rh_cppc',array('CPPC_ID'=>$ticket['CPPC_ID']));
$pdf->Cell(160,10,utf8_decode(''),1,0,'L');
$pdf->Cell(30,10,utf8_decode(''),1,0,'L');
$pdf->Cell(30,10,utf8_decode(''),1,0,'L');
$pdf->Cell(27.5,10,utf8_decode(''),1,0,'L');
$pdf->Cell(27.5,10,utf8_decode(''),1,0,'L');
$pdf->SetXY( 170,100);
$pdf->MultiCell(30,10,utf8_decode(sizeof($blesse)),0,'C');
$pdf->SetXY( 200,100);
$pdf->MultiCell(30,10,utf8_decode(sizeof($mort)),0,'C');
$pdf->SetXY( 227.5,100);
$pdf->MultiCell(30,10,utf8_decode(sizeof($materiel_riverains)),0,'C');
$pdf->SetXY( 255,100);
$pdf->MultiCell(30,10,utf8_decode(sizeof($materiel_dgpcs)),0,'C');
$pdf->SetXY( 10,100);
$pdf->MultiCell(150,10,utf8_decode($cppc['CPPC_NOM']." ( Responsable: ".$manger['GRADE']." ".$manger['PERSONNEL_PRENOM']." ".strtoupper($manger['PERSONNEL_NOM'])."  <<".$manger['FONCTION'].">>)"),0,'L');
$pdf->Ln(10); 
$pdf->SetXY( 95,115);
$path=FCPATH.'uploads/'.$code.'.png';
// echo $path;exit();
		  if(file_exists($path)){
			$pdf->Image(base_url().'uploads/'.$code.'.png',95,115,90,70);
		  }
 
 $pdf->MultiCell(95,70,utf8_decode(''),1,'C');
// $pdf->Cell(70,70,utf8_decode(''),1,0,'L');

$pdf->Output();


    }
    public function saveImage($code){
    	$data = str_replace(' ', '+', $_POST['bin_data']);
$data = base64_decode($data);
$fileName = 'uploads/'.$code.'.png';
$im = imagecreatefromstring($data);
 
if ($im !== false) {
    // Save image in the specified location
    imagepng($im, $fileName);
    imagedestroy($im);
    echo "Saved successfully";
}
else {
    echo 'An error occurred.';
}
    }
}
?>
