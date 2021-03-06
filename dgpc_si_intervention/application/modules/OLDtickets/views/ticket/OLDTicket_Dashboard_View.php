<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
<script type="text/javascript">
function compZero(nombre) {
    return nombre < 10 ? '0' + nombre : nombre;
}

function date_heure() {
    const infos = new Date();

    //Heure
    

    //Date
    const mois = new Array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
    const jours = new Array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
    document.getElementById('date_heure').innerHTML = '<b>' + jours[infos.getDay()] + ' ' + infos.getDate() + ' ' + mois[infos.getMonth()] + ' ' + infos.getFullYear() + ' '+compZero(infos.getHours()) + ' : ' + compZero(infos.getMinutes()) + ': ' + compZero(infos.getSeconds())+'</b>';

    // document.getElementById('date_heure').innerHTML += compZero(infos.getHours()) + ' : ' + compZero(infos.getMinutes()) + ': ' + compZero(infos.getSeconds())+'</b>';
}

window.onload = function() {
   setInterval("date_heure()", 1000); //Actualisation de l'heure
};
</script>
</head>
<body>
    <div class="container-fluid" style="background-color: white">
        <!-- <div id="wrapper"> -->
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 5px" id="navp">
                <!-- /.navbar-top-links -->
                <?php include VIEWPATH.'includes/menu_principal.php' ?>
                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->
            <!-- <div id="page-wrapper"> -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                                <?=$breadcrumb ?> 
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-10 col-md-10">                                  
                                   <h4 class=""> <b style="color: <?=$stutut_ticket['STATUT_COLOR']?>">Ticket <?=$stutut_ticket['STATUT_DESCR']?></b></h4>
                                   <center><div  id="date_heure"  class="col-lg-12 bg-primary"></div></center>
                              <table class='table table-bordered  table-responsive' style="font-size: 12px">
                        
                        <tr><th>DATE OUVERTURE:</th><td> <?=$ouverture?></td><th>DATE FERMETURE:</th><td> <?=$cloture?></td><th>DUREE</th><td> <?=$dure?></td></tr>
                        <!-- <tr><td><?=$ouverture?></td><td><?=$cloture?></td><td><?=$dure?></td></tr> -->

                      </table>  
                                </div>
                                <div class="col-lg-2 col-md-2" style="padding-bottom: 3px">
                                    <?php include 'menu_ticket.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12  jumbotron jumbotron-fluid" style="padding: 5px">
                    <!-- MODAL MATERIEL -->
                    <?php
                    $mat="";
                    $i=1;
                    foreach ($interv_materiaux as $value) {
                        $cat=$this->Model->getOne('tk_categories',array('CATEGORIE_ID'=>$value['CATEGORIE_ID']));
                      $mat.="<tr><td>".$i."</td><td>".$value['MATERIEL_DESCR']."</td><td>".$cat['CATEGORIE_DESCR']."</td></tr>";
                       $i++;
                    }
                    ?>
                    <div class='modal fade' id='materiel'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>

                                        <div class='modal-body'>
                                          <h3>MATERIELS DE CATEGORIE <?=strtoupper($categorie_mat['CATEGORIE_DESCR'])?></h3>
                                            <table id="materielCat" class='table table-bordered  table-responsive'>
                                              <thead><tr><th>No</th><th>MATERIEL</th><th>CATEGORIE</th></tr></thead><tbody><?=$mat?></tbody>
                                            </table>
                                        </div>

                                        <div class='modal-footer'>
                                            
                                            <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    <!-- MODAL MATERIEL -->
                        <!-- MODAL MATERIEL total-->
                    <?php
                    $mat="";
                    $i=1;
                    foreach ($materieles as $value) {
                        $cat=$this->Model->getOne('tk_categories',array('CATEGORIE_ID'=>$value['CATEGORIE_ID']));
                      $mat.="<tr><td>".$i."</td><td>".$value['MATERIEL_DESCR']."</td><td>".$cat['CATEGORIE_DESCR']."</td></tr>";
                       $i++;
                    }
                    ?>
                    <div class='modal fade' id='materieles'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>

                                        <div class='modal-body'>
                                          <h3>LISTES DES MATERIELS DISPONIBLES</h3>
                                            <table id="materiel_categorie1" class='table table-bordered  table-responsive'>
                                              <thead><tr><th>No</th><th>MATERIEL</th><th>CATEGORIE</th></tr></thead><tbody><?=$mat?></tbody>
                                            </table>
                                        </div>

                                        <div class='modal-footer'>
                                            
                                            <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    <!-- MODAL MEMBRE -->
                    <?php
                    $mem="";
                    $i=1;
                    foreach ($membre_intervenant as $value) {
                      $personnel=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$value['PERSONNEL_ID']));
                      $mem.="<tr><td>".$i."</td><td>".$personnel['PERSONNEL_NOM']."</td><td>".$personnel['PERSONNEL_PRENOM']."</td><td>".$personnel['PERSONNEL_TELEPHONE']."</td></tr>";
                       $i++;
                    }
                    ?>
                    <div class='modal fade' id='membre'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>

                                        <div class='modal-body'>
                                            <table class='table table-bordered  table-responsive'>
                                              <tr><th>No</th><th>NOM</th><th>PRENOM</th><th>TELEPHONE</th></tr><?=$mem?>
                                            </table>
                                        </div>

                                        <div class='modal-footer'>
                                            
                                            <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    <!-- MODAL MEMBRE -->
                    <!-- MODAL EQUIPE -->
                    <?php
                    $equi="<table id='table_equipe' class='table table-bordered  table-responsive'>";
                    $i=1;
                    foreach ($equipe_intervenant as $value) {
                      $equipe_membre=$this->Model->getList('interv_intervenants',array('TICKET_CODE'=>$ticket_code,'EQUIPE_ID'=>$value['EQUIPE_ID']));
                      // echo sizeof($equipe_membre);
                      $equipe=$this->Model->getOne('rh_equipe_cppc',array('EQUIPE_ID'=>$value['EQUIPE_ID']));
                      $equi.="<thead><tr><th colspan='4'><center>".$equipe['EQUIPE_NOM']."</center></th></tr>";
                      $equi.="<tr><th>NOM</th><th>PRENOM</th><th>TELEPHONE</th><th>FONCTION</th></tr></thead>";
                      foreach ($equipe_membre as $val) {
                        # code...
                      
                      
                      $mbrs=$this->Model->getRequeteOne("SELECT* FROM interv_intervenants JOIN rh_personnel_dgpc ON interv_intervenants.PERSONNEL_ID=rh_personnel_dgpc.PERSONNEL_ID WHERE interv_intervenants.PERSONNEL_ID=".$val['PERSONNEL_ID']." ORDER BY PERSONNEL_NOM ASC");
                      
                      // foreach ($mbrs as $key) {
                        $equi.="<tr><td>".$mbrs['PERSONNEL_NOM']."</td><td>".$mbrs['PERSONNEL_PRENOM']."</td><td>".$mbrs['PERSONNEL_TELEPHONE']."</td><td>".$mbrs['FONCTION']."</td></tr>";
                        # code...
                        // }
                      }
                      // print_r($mbrs);
                       // $i++;

                    }
                    $equi.="</table>";
                    ?>
                    <div class='modal fade' id='equipe'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>

                                        <div class='modal-body'>
                                          <h3>EQUIPES INTERVENANTS</h3>
                                            <!-- <table class='table table-bordered  table-responsive'> -->
                                              <?=$equi?>
                                            <!-- </table> -->
                                        </div>

                                        <div class='modal-footer'>
                                            
                                            <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    <!-- MODAL EQUIPE -->
                    <?php
                      $materiel_riv = "";
                      $i =1;

                      foreach ($materiel_riverains as $materiel) {
                        $materiel_riv .= "<tr><td>".$i."</td><td>".$materiel['MATERIEL_ENDO_DESCR']."</td><td>".$materiel['nb_NOMBRE']."</td></tr>";
                        $i ++;
                      }
                    ?>
                    <div class='modal fade' id='mat_rivrain'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>

                                        <div class='modal-body'>
                                          <h3>Matériels Riverains</h3>
                                            <table id='mort_persone' class='table table-bordered  table-responsive'>
                                              <thead><tr><th>No</th><th>MATERIEL</th><th>NOMBRE</th></tr></thead>
                                              <tbody><?=$materiel_riv?></tbody>
                                            </table>
                                        </div>

                                        <div class='modal-footer'>
                                            
                                            <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                      <!-- MODAL EQUIPE -->
                    <?php
                      $materiel_dgpc = "";
                      $i =1;

                      foreach ($materiel_dgpcs as $materiel) {
                        $materiel_dgpc .= "<tr><td>".$i."</td><td>".$materiel['MATERIEL_DESCR']."</td><td>".$materiel['nb_NOMBRE']."</td></tr>";
                        $i ++;
                      }
                    ?>
                    <div class='modal fade' id='mat_dgpc'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>

                                        <div class='modal-body'>
                                          <h3>Matériels DGPC</h3>
                                            <table id='mort_persone' class='table table-bordered  table-responsive'>
                                              <thead><tr><th>No</th><th>MATERIEL</th><th>NOMBRE</th></tr></thead>
                                              <tbody><?=$materiel_dgpc?></tbody>
                                            </table>
                                        </div>

                                        <div class='modal-footer'>
                                            
                                            <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                      <!-- MODAL MORT -->
                    <?php
                    $mrt="";
                    $i=1;
                    foreach ($mort as $value) {
                      if ($value['CONCERNE_DGPC']==0) {
                        $is_dgpc="NON";
                      }
                      if ($value['CONCERNE_DGPC']==1) {
                        $is_dgpc="OUI";
                      }
                      $mrt.="<tr><td>".$i."</td><td>".$value['NOM_PRENOM']."</td><td>".$is_dgpc."</td></tr>";
                      $i++;
                    }
                    ?>
                    <div class='modal fade' id='mort'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>

                                        <div class='modal-body'>
                                          <h3>LISTE DES MORTS</h3>
                                            <table id='mort_persone' class='table table-bordered  table-responsive'>
                                              <thead><tr><th>No</th><th>NOM & PRENOM</th><th>PERSONNEL DGPC?</th></tr></thead><tbody><?=$mrt?></tbody>
                                            </table>
                                        </div>

                                        <div class='modal-footer'>
                                            
                                            <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    <!-- MODAL MORT -->
                     <!-- MODAL BLESSE -->
                    <?php
                    $bls="";
                    $i=1;
                    foreach ($blesse as $value) {
                      if ($value['CONCERNE_DGPC']==0) {
                        $is_dgpc="NON";
                      }
                      if ($value['CONCERNE_DGPC']==1) {
                        $is_dgpc="OUI";
                      }
                      $bls.="<tr><td>".$i."</td><td>".$value['NOM_PRENOM']."</td><td>".$is_dgpc."</td></tr>";
                      $i++;
                    }
                    ?>
                    <div class='modal fade' id='blesse'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>

                                        <div class='modal-body'>
                                          <h3>LISTE DES BLESSES</h3>
                                            <table id='blesse_prsone' class='table table-bordered  table-responsive'>
                                              <thead><tr><th>No</th><th>NOM & PRENOM</th><th>PERSONNEL DGPC?</th></tr></thead><tbody><?=$bls?></tbody>
                                            </table>
                                        </div>

                                        <div class='modal-footer'>
                                            
                                            <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    <!-- MODAL BLESSE -->
                    <!-- MODAL DETAIL CPPC -->
                     <div class='modal fade' id='detail_cppc'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content'>

                                        <div class='modal-body '>
                                         <h3><?=$cppc['CPPC_NOM']?></h3> 
                                            <div id='map1' style="height: 300px ;" class="col-md-6"></div>
                                            <div id='mrt' style="height:  ;" class="col-md-6"></div>
                                        </div>

                                        <div class='modal-footer'>
                                            
                                            
                                        </div>

                                    </div>
                                </div>
                            </div>
                          <!-- MODAL TOTAL INTERVENTION -->
                          <?php
                    $interv="";
                    $i=1;
                    foreach ($ticket1 as $value) {

      $cause=$this->Model->getOne('tk_causes',array('CAUSE_ID'=>$value['CAUSE_ID']));
      $statut=$this->Model->getOne('tk_statuts',array('STATUT_ID'=>$value['STATUT_ID']));

                     $interv.="<tr><td>".$i."</td><td>".$value['DATE_INSERTION']."</td><td>".$value['CODE_EVENEMENT']."</td><td>".$value['TICKET_DESCR']."</td><td>".$cause['CAUSE_DESCR']."</td><td>".$value['TICKET_DECLARANT']."</td><td style='color:".$statut['STATUT_COLOR']."'>".$statut['STATUT_DESCR']."</td></tr>"; 
                     $i++;
                      }
                  
                    ?>
                     <div class='modal fade' id='total_intervention'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content'>

                                        <div class='modal-body '>
                                          <h3>LES INTERVENTIONS DEJAS FAITES</h3>
                                          <table id='interventions_total' class='table table-bordered  table-responsive'>
                                              <thead>
                                                 <tr>
                                                    <th>No</th>
                                                    <th>DATE TIME</th>
                                                    <th>CODE INTERV</th>
                                                    <th>DESCRIPTION</th>
                                                    <th>CAUSES</th>
                                                    <th>DECLARANT</th>
                                                    <th>STATUT</th>
                                                 </tr>
                                              </thead>
                                              <?=$interv?>
                                            </table>
                                        </div>

                                        <div class='modal-footer'>
                                            
                                            
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- TOTAL MORT -->
                             <?php
                    $mrt="";
                    $i=1;
                    foreach ($ticket1 as $value) {
                      $dega_humain_mort=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$value['TICKET_CODE'],'STATUT_SANTE'=>1));
                      foreach ($dega_humain_mort as $key) {
                         if ($key['CONCERNE_DGPC']==0) {
                        $is_dgpc="NON";
                      }
                      if ($key['CONCERNE_DGPC']==1) {
                        $is_dgpc="OUI";
                      }
                        # code...
                        $mrt.="<tr><td>".$i."</td><td>".$key['NOM_PRENOM']."</td><td>".$is_dgpc."</td></tr>";
                        $i++;
                      }
                      
                      
                    }
                    ?>
                      <div class='modal fade' id='total_mort'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content'>

                                        <div class='modal-body '>
                                           <!-- <table class='table table-bordered  table-responsive'>
                                              <tr><th>No</th><th>NOM & PRENOM</th></tr><?=$mrt?>
                                            </table> -->
                                            <h3>LISTE DES MORTS DES TOUS LES INTERVENTIONS FAITES</h3>
                                            <table id='mort_persone_total' class='table table-bordered  table-responsive'>
                                              <thead><tr><th>No</th><th>NOM & PRENOM</th><th>PERSONNEL DGPC?</th></tr></thead><tbody><?=$mrt?></tbody>
                                            </table>
                                        </div>

                                        <div class='modal-footer'>
                                            
                                            
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- TOTAL BLESSE -->
                            <?php
                    $bls="";
                    $i=1;
                    
                    foreach ($ticket1 as $value) {
                      $dega_humain_blesse=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$value['TICKET_CODE'],'STATUT_SANTE'=>0));
                      foreach ($dega_humain_blesse as $key) {
                        # code...
                         if ($key['CONCERNE_DGPC']==0) {
                        $is_dgpc="NON";
                      }
                      if ($key['CONCERNE_DGPC']==1) {
                        $is_dgpc="OUI";
                      }
                        $bls.="<tr><td>".$i."</td><td>".$key['NOM_PRENOM']."</td><td>".$is_dgpc."</td></tr>";
                        $i++;
                      }
                      
                      
                    }
                    ?>
                    <div class='modal fade' id='total_blesse'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content'>

                                        <div class='modal-body '>
                                          <h3>LISTE DES BLESSES DES TOUS LES INTERVENTIONS FAITES</h3>
                                            <table id='blesse_persone_total' class='table table-bordered  table-responsive'>
                                              <thead><tr><th>No</th><th>NOM & PRENOM</th><th>PERSONNEL DGPC?</th></tr></thead><tbody><?=$bls?></tbody>
                                            </table>
                                        </div>

                                        <div class='modal-footer'>
                                            
                                            
                                        </div>

                                    </div>
                                </div>
                            </div>
                    <!-- <center><div  id="date_heure"  class="col-lg-12 bg-primary"></div></center> -->
                    
                     <!-- <div class="col-lg-12"> <b style="color: <?=$stutut_ticket['STATUT_COLOR']?>">Ticket <?=$stutut_ticket['STATUT_DESCR']?></b></div> -->
                      <div class="col-lg-6">
                    <table  class='table table-bordered  table-responsive' style="font-size: 12px">
                      <tr>
                         <th rowspan="2">DESCRIPTION</th>
                         <th colspan="4">DECLARANT</th>
                      </tr>
                      <tr>
                         <th>NOM&PRENOM</th>
                         <th>TELEPHONE</th>
                         <th>CANAL</th>
                         <th>INFOs DECLAREES</th>
                      </tr>
                      <tr>
                        <td><?=$categorie_mat['CATEGORIE_DESCR']?> / <?=$ticket['TICKET_DESCR']?></td>
                        <td><?=$ticket['TICKET_DECLARANT']?></td>
                        <td><?=$ticket['TICKET_DECLARANT_TEL']?></td>
                        <td><?=$canal['CANAL_DESCR']?></td>
                        <td><?='Blessé(s) :'.$ticket['NOMBRE_BLESSE'].'<br> Mort(s) :'.$ticket['NOMBRE_MORT']?></td>
                      </tr>
                    </table> 
                  </div>
                   
                    <center>
<!-- <div  id="date_heure"  class="col-lg-12 bg-primary"></div> -->
                    <div class="col-lg-6">
                      <div class="col-lg-4">
                        <?php
                        if(!empty($image)){ 
                        echo '<img src="data:image/jpeg;base64,'.base64_encode($image['IMAGE_BLOB']) .'" width="150px" height="150px" alt="user image" title="image" download/>';
                        }
                        ?>
                      </div>
                      <div class="col-lg-4">
                        <?php
                        if(!empty($video)){ 
                        $ma_video = "data:video/mp4;base64,".base64_encode($video['VIDEO_BLOB']);
                       echo "<video controls width='150px' height='150px'><source src='".$ma_video."' type='video/mp4'></video>";
                        }
                       ?>
                      </div>
                       <div class="col-lg-4">
                      <i id="<?=$ticket['TICKET_CODE']?>" class="fa fa-film video" style="font-size:30px; color:#0B3493;"  onmouseover="this.style.color='black';" onmouseout="this.style.color='#0B3493';"><br></i> 
                        <i id="<?=$ticket['TICKET_CODE']?>" class="fa fa-image img" style="font-size:30px; color:#0B3493;"  onmouseover="this.style.color='black';" onmouseout="this.style.color='#0B3493';"><br></i>
                      </div>
                    </div>

                    </center>
                     <div class="col-lg-12"><b>Intervention</b></div>
                    <table class='table table-bordered  table-responsive' style="font-size: 12px">
                            <tr>
                              <th rowspan="2">CPPC</th>
                                <!-- <th>INTERVENTIONS FAITES</th> -->
                              <th rowspan="2">NOMBRE BLESSES REEL</th>
                              <th rowspan="2">NOMBRE MORTS REEL</th>
                              <th rowspan="2">MATERIELS RIVERAIN</th>
                              <th rowspan="2">MATERIELS DGPC</th>
                              <th rowspan="2">EQUIPES INTERVENANTS</center></th><!-- <th>MEMBRES EQUIPES</th> -->
                              <th colspan="2"><center>MATERIELS DISPONIBLES</th>
                            </tr>
                           
                            <tr>
                              <th>MATERIELS DE CATEGORIE <?=strtoupper($categorie_mat['CATEGORIE_DESCR'])?></th>
                              <th>TOUS LES MATERIELS</th>
                            </tr> 
                            
                            <tr>
                              <td><b><a href='' id='' data-toggle='modal' data-target='#detail_cppc'><?=$cppc['CPPC_NOM']?></a></b>  (Total :<a href='' id='' data-toggle='modal' data-target='#total_intervention'><b><?=sizeof($tiquet_cppc)?> intervention(s)</a></b> <a href='' id='' data-toggle='modal' data-target='#total_mort'><?=$mt?> mort(s)</a> - <a href='' id='' data-toggle='modal' data-target='#total_blesse'><?=$nb?>Blessé(s)</a> )<br><b>Manager cppc: <?=$manger['GRADE']?> <?=$manger['PERSONNEL_PRENOM']?> <?=strtoupper($manger['PERSONNEL_NOM'])?> (<?=$manger['FONCTION']?>)</b>
                              </td>
                      <!-- <td><?=sizeof($tiquet_cppc)?> fois</td> -->
                             <td>
                                  <center>
                                     <a href='' id='' data-toggle='modal' data-target='#blesse'><?=sizeof($blesse)?></a>
                                  </center>
                             </td>
                             
                              <td>
                                 <center>
                                    <a href='' id='' data-toggle='modal' data-target='#mort'><?=sizeof($mort)?></a>
                                  </center>
                              </td>
                             <td>
                               <center>
                                    <a href='' id='' data-toggle='modal' data-target='#mat_rivrain'><?=sizeof($materiel_riverains)?></a>
                                  </center>
                             </td>

                             <td>
                                  <center>
                                    <a href='' id='' data-toggle='modal' data-target='#mat_dgpc'><?=sizeof($materiel_dgpcs)?></a>
                                  </center>
                              </td>
                             

                             <td>
                                <center><a href='' id='' data-toggle='modal' data-target='#equipe'><?=sizeof($equipe_intervenant)?></a></center>
                             </td><!-- <td><center><a href='' id='' data-toggle='modal' data-target='#membre'><?=sizeof($membre_intervenant)?></a></center></td> --><td><center>
                            <?php if (sizeof($interv_materiaux)==0) {?>
                                <span style="color: red">Aucun materiel relatif</span>
                           <?php }else{ ?>
                        <a href='' id='' data-toggle='modal' data-target='#materiel'><?=sizeof($interv_materiaux)?></a><?php }?></center></td>
                            
                            <td><center>
                            <?php if (sizeof($materieles)==0) {?>
                                <span style="color: red">Aucun materiel</span>
                           <?php }else{ ?>
                        <a href='' id='' data-toggle='modal' data-target='#materieles'><?=sizeof($materieles)?></a><?php }?></center></td></tr> 
                    </table>

                    <div id="map" style="height: 50vh ;border: 1px solid" class="col-md-4"></div>
                    <div id='mtrl' style="height: 50vh ; border: 1px solid" class="col-md-4"></div>
                    <div id='mrts' style="height: 50vh ;border: 1px solid" class="col-md-4"></div>
                 </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
                <!-- <?=$latitude1?><?=$longitude?> -->
            </div>

            <!-- /#page-wrapper -->

       <!--  </div>
    </div> -->

</body>
<script type="text/javascript">
$('.img').click(function(){
    var id=$(this).attr("id");
    // alert(id);
    window.open("<?php echo base_url('geolocalisation/Map/image/');?>"+id+"","_blank","width=1000,height=600,scrollbars=yes,toolbar=no,resizable=yes,left=500,right=500");
});
$('.video').click(function(){
    var id=$(this).attr("id");
    // alert(id);
    window.open("<?php echo base_url('geolocalisation/Map/image/');?>"+id+"","_blank","width=1000,height=600,scrollbars=yes,toolbar=no,resizable=yes,left=500,right=500");
});

</script>
<script type="text/javascript">

Highcharts.chart('mtrl', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Dégat'
    },
    subtitle: {
        text: ''
        // text: '<b>DGPC</b>:<?=$total_materiel_dgpc?> materiels; <?=$total_blesse_dgpc?> blessés; <?=$total_mort_dgpc?> morts<br><b>Riverains</b>:<?=$total_materiel_riverain?> materiels; <?=$total_blesse_riverain?> blessés; <?=$total_mort_riverain?> morts<br>'
    },
    xAxis: {
        categories: ['DGCP', 'Riverains'],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Nombre dégat',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ''
    },
    plotOptions: {
      column: {
            dataLabels: {
                enabled: true
            }
        },
        bar: {
            dataLabels: {
                enabled: true
            }
        },
        series: {
                        cursor:'pointer',
                        point:{
                            events: {
                                 click: function()
                                 {
                                      var cat=this.category;
                                      var serie=this.series.name;
                                      var res = serie.replace("é", "e");
                                  window.open("<?php echo base_url('equipes/Detail_rapport/index/');?>"+cat+"."+res+".<?=$ticket['TICKET_ID']?>","_blank","width=1000,height=600,scrollbars=yes,toolbar=no,resizable=yes,left=500,right=500");
                                   
                                }
                            }
                        }
        },
    },
    
    credits: {
        enabled: false
    },
    series: <?=$series?>

    
});
    </script>
   <!--  <script type="text/javascript">

Highcharts.chart('mrt', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Dégat humain'
    },
    subtitle: {
        text: 'total: <?=$total_humain?>'
    },
    xAxis: {
        categories: ['DGCP', 'Riverains'],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Nombre dégat',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ''
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    
    credits: {
        enabled: false
    },
    series: <?=$series1?>

    
});
    </script> -->
     <script>

                var MarkerIcon="<?=base_url()?>assets/bootstrap/images/icon.png";
                        
                var map = L.map('map', {
                                        center: [<?=$latitude?>,<?=$longitude?>],
                                        zoom: 10
                                        });
                    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="#">DGCP SI</a> '}).addTo(map);
                     var greenIcon = L.icon({
                            iconUrl: MarkerIcon,
                            shadowUrl: '',

                            iconSize: [20, 26],
                            
                            });
                        L.marker([<?=$latitude?>,<?=$longitude?>], 
                                 {icon: greenIcon,
                                  title:'Incident '}).addTo(map)
                        .bindPopup("<font color=''><b><?=$categorie_mat['CATEGORIE_DESCR']?> / <?=$ticket['TICKET_DESCR']?> </b> ");
  var blesse_persone_total=$("#blesse_persone_total").DataTable({
                
                dom:'Bfrtlip',
                buttons:['copy','csv','excel','pdf','print']
                  
        }); 
  var mort_persone_total=$("#mort_persone_total").DataTable({
                
                dom:'Bfrtlip',
                buttons:['copy','csv','excel','pdf','print']
                  
        }); 

  var interventions_total=$("#interventions_total").DataTable({
                
                dom:'Bfrtlip',
                buttons:['copy','csv','excel','pdf','print']
                  
        }); 

   var materiel_categorie1=$("#materiel_categorie1").DataTable({
                
                dom:'Bfrtlip',
                buttons:['copy','csv','excel','pdf','print']
                  
                  
        });    


var materielCat=$("#materielCat").DataTable({
                
               
                dom:'Bfrtlip',
                buttons:['copy','csv','excel','pdf','print']
                  
        }); 
var blesse_prsone=$("#blesse_prsone").DataTable({
                
                dom:'Bfrtlip',
                buttons:['copy','csv','excel','pdf','print']
                  
        });

               var materielCat=$("#mort_persone").DataTable({
                
                dom:'Bfrtlip',
                buttons:['copy','csv','excel','pdf','print']
                  
        });  
         var table_equipe=$("#table_equipe").DataTable({
                
                dom:'Bfrtlip',
                buttons:['copy','csv','excel','pdf','print']
                  
        });


 



                </script>
         
       <script type="text/javascript">

Highcharts.chart('mrt', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Rapport intervention/Dégats rencontrés'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: ['interventions faites','degat humains','degat materiels'],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Nombre',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ''
    },
    plotOptions: {
         column: {
            dataLabels: {
                enabled: true
            }
        },
        bar: {
            dataLabels: {
                enabled: true
            }
        },
        // series: {
        //                 cursor:'pointer',
        //                 point:{
        //                     events: {
        //                          click: function()
        //                          {
        //                               var cat=this.category;
        //                               var serie=this.series.name;
        //                               var res = serie.replace("é", "e");
        //                           window.open("<?php echo base_url('equipes/Caserne/chaque_detail/');?>"+res+".<?=$cppc1?>","_blank","width=1000,height=600,scrollbars=yes,toolbar=no,resizable=yes,left=500,right=500");
                                   
        //                         }
        //                     }
        //                 }
        // },
    },
    
    credits: {
        enabled: false
    },
    series: <?=$series1?>

    
});
    </script> 
    <script>

                var MarkerIcon="<?=base_url()?>assets/bootstrap/images/icon.png";
                        
                var map1 = L.map('map1', {
                                        center: [<?=$latitude1+0.2?>,<?=$longitude1-0.3?>],
                                        zoom: 10
                                        });
                    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="#">DGCP SI</a> '}).addTo(map1);
                     var greenIcon = L.icon({
                            iconUrl: MarkerIcon,
                            //shadowUrl: '',

                            iconSize: [20, 26],
                            
                            });
                        L.marker([<?=$latitude1?>,<?=$longitude1?>], 
                                 {icon: greenIcon,
                                  title:'Incident '}).addTo(map1)
                        .bindPopup("<font color=''><b><?=$categorie_mat['CATEGORIE_DESCR']?> / <?=$ticket['TICKET_DESCR']?> </b> ");

                    
                </script>
 

<script>

Highcharts.chart('mrts', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'CYCLE D\'INTERVENTION'
    },
    subtitle: {
        text: 'Rapport du <?=date('Y-m-d')?>'
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Temps (Min)'
        }
    },
    legend: {
        enabled: false
    },
    credits: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Temps: <b>{point.y} </b>'
    },
    series: [{
        name: 'Temps',
        data: <?php echo $serie_progression;?>,
        dataLabels: {
            enabled: true,
            //rotation: -90,
            color: '#FFFFFF',
            align: 'right',
          //  format: '{point.y}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '12px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
</script>

<script type="text/javascript">
     $(document).ready(function(){

      setInterval(function(){
      $.ajax({
              url:"<?php echo base_url() ?>tickets/Tickets/actualisation_details/<?php echo $ticket_code ?>",
              method:"POST",
              success:function(data){  
                if(data==1){

                  //SendNotificationSound(1);
                 
                  window.location.href="<?= base_url('tickets/Tickets/dashboard/'.$ticket_code) ?>";


                  }
                              
                }
            });

    },15000);

    });

</script>
               
</html>
