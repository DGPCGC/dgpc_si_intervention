<?php

 class Rapport_Intervation extends MY_Controller
 {
  
  function __construct()
  {
    parent::__construct();
    $this->make_bread->add('Suivi', "reporting/Rapport_Intervation/index", 0);
    $this->breadcrumb = $this->make_bread->output();
  }


   
  public function index(){

    
    $tk_causes = $this->Model->getList('tk_causes');
   

    $resultat=array();

    $homme_blesse= $this->Model->getDegatHumain(array('hm.STATUT_SANTE'=>0,'hm.SEXE'=>'Homme'))['nbHumain'];

    $femme_blesse= $this->Model->getDegatHumain(array('hm.STATUT_SANTE'=>0,'hm.SEXE'=>'Femme'))['nbHumain'];

    $homme_mort= $this->Model->getDegatHumain(array('hm.STATUT_SANTE'=>1,'hm.SEXE'=>'Homme'))['nbHumain'];
    $femme_mort= $this->Model->getDegatHumain(array('hm.STATUT_SANTE'=>1,'hm.SEXE'=>'Femme'))['nbHumain'];
 
   $data["table"] ="<table id='mytable' class='table table-hover table-bordered table-condensed table-striped'>
                  <thead>
                     <tr>
                        <th><center>Incidents </center></th>
                        <th colspan='4'><center>Dégats materiel</center></th>
                        <th colspan='6'><center>Dégats Humains </center></th>
                        <th></th>
                      </tr>
                   </thead>
                      <tr>
                        <td></td>
                        <td ><strong>Maison<br>détruites<br>(nombre)</strong></td>
                        <td><strong>Route/Pont<br>endomagés<br>(Oui/Non)</strong></td>
                        <td><strong>Champs<br>endommagés<br>(Nombre)</strong></td>
                        <td><strong>Vehicule<br>endommagés<br>(Nombre)</strong></td>
                        <td><strong>Autres(Nombre)</strong></td>
                        <td colspan='3'><strong>Blessés<br>(Nombre)</strong></td>
                        <td colspan='3'><strong>Déces<br>(Nombre)</strong></td>
                        <td><strong>Menage<br>affectés</strong></td>
                      </tr>
                      <tr>
                        <td colspan='6'></td>
                        <td><strong>M</strong></td>
                        <td><strong>F</strong></td>
                        <td><strong>T</strong></td>
                        <td><strong>M</strong></td>
                        <td><strong>F</strong></td>
                        <td><strong>T</strong></td>
                        <td></td>
                     </tr>
                     <tr> 
                        <td colspan='6'></td>   
                        
                        <td>".$homme_blesse."</td>
                        <td>".$femme_blesse."</td>

                        <td>".($femme_blesse+$homme_blesse)."</td>    

                        <td>".$homme_mort."</td>
                        <td>".$femme_mort."</td>
                        <td>".($homme_mort+$femme_mort)."</td>
                        <td></td>
                        
                    </tr>";

    foreach ($tk_causes as $cause) {

      //$nombre_bl= $this->Model->count_all_data('interv_odk_degat_humain',$critere = array('CAUSE_CODE' =>$value['CAUSE_CODE'],'STATUT_SANTE'=>'1'));
      $nombre_bl = $this->Model->getDegatHumain(array('tk.CAUSE_ID'=>$cause['CAUSE_ID'], 'hm.STATUT_SANTE'=>0))['nbHumain'];

      $nombre_mort= $this->Model->getDegatHumain(array('tk.CAUSE_ID'=>$cause['CAUSE_ID'], 'hm.STATUT_SANTE'=>1))['nbHumain'];
      

     // $voiture=$this->Model->getOne('interv_odk_degat_materiel',array('CAUSE_CODE' =>$value['CAUSE_CODE']));

      $voiture_end= $this->Model->getDegatMateriel(array('tk.CAUSE_ID'=>$cause['CAUSE_ID'],'mat.MATERIEL_ENDO_CODE'=>'4'))['nbMat'];
     //$m_endomg=$this->Model->getOne('interv_odk_degat_materiel',array('CAUSE_CODE' =>$value['CAUSE_CODE']));

  

      $maison_endom= $this->Model->getDegatMateriel(array('tk.CAUSE_ID'=>$cause['CAUSE_ID'],'mat.MATERIEL_ENDO_CODE'=>'1'))['nbMat'];

      //$pont_endomg=$this->Model->getOne('interv_odk_degat_materiel',array('CAUSE_CODE' =>$value['CAUSE_CODE']));

      $pont_endom= $this->Model->getDegatMateriel(array('tk.CAUSE_ID'=>$cause['CAUSE_ID'],'mat.MATERIEL_ENDO_CODE'=>'2'))['nbMat'];


    if ($pont_endom==0) {

        $pont_endom='Non';
     }

    else {
       
        $pont_endom='Oui ('.$pont_endom.')';

    } 


    $champs_endom= $this->Model->getDegatMateriel(array('tk.CAUSE_ID'=>$cause['CAUSE_ID'],'mat.MATERIEL_ENDO_CODE'=>'3'))['nbMat'];
    $autres= $this->Model->getDegatMateriel(array('tk.CAUSE_ID'=>$cause['CAUSE_ID'],'mat.MATERIEL_ENDO_CODE'=>'5'))['nbMat'];
     

    $m_aff= $this->Model->menageAffectCause($cause['CAUSE_ID'])['nbMenage'];

    $data["table"] .= '
                    <tbody>
                      <tr>
                        <td><strong>'.$cause["CAUSE_DESCR"].'</strong></td>
                        <td >'.$maison_endom.'</td>
                        <td>'.$pont_endom.'</td>
                        <td>'.$champs_endom.'</td>
                        <td>'.$voiture_end.'</td>
                        <td>'.$autres.'</td>
                        <td colspan="3"><strong>'.$nombre_bl.'</strong></td>
                        <td colspan="3"><strong>'.$nombre_mort.'</strong></td>
                        <td>'.$m_aff.'</td>  
                      </tr> ';
    
}

    $data["table"] .= "</tbody></table>";
   // $this->make_bread->add('Actif', "reporting/Rapport_Intervation/", 0);
    $data['breadcrumb'] = $this->make_bread->output();
    $this->load->view('rapport_inter',$data);

} 
  

  }