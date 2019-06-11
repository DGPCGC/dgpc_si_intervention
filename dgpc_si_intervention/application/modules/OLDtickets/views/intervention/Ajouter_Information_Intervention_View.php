<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
</head>
<body>
    <div class="container-fluid" style="background-color: white">
        
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 5px" id="navp">
                <!-- /.navbar-top-links -->
                <?php include VIEWPATH.'includes/menu_principal.php' ?>
                <!-- /.navbar-static-side -->
            </nav>

   
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                                <?=$breadcrumb ?> 
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b><?=$title?></b></h4>  
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                    <?php //include 'menu_intervention.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12" style="padding: 5px">
                  <?php
                          if($this->session->flashdata('msg'))
                            echo $this->session->flashdata('msg');
                        ?>
                    <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 20px">
                    <li role="presentation" class="active"><a href="#info_ticket" aria-controls="identite" role="tab" data-toggle="tab">Information de ticket</a></li>
                    <li role="presentation"><a href="#degats" aria-controls="cotation" role="tab" data-toggle="tab">Dégats</a></li>
                    <li role="presentation"><a href="#degats_dgpc" aria-controls="soins" role="tab" data-toggle="tab">Dégats DGPC</a></li>
                    <li role="presentation"><a href="#partenaire" aria-controls="soins" role="tab" data-toggle="tab">Partenaire</a></li>
                    <li role="presentation"><a href="#valider" aria-controls="soins" role="tab" data-toggle="tab">Valider</a></li>
                    <!-- <li role="presentation"><a href="<?=base_url() ?>tickets/Intervention/validerData/<?=$this->uri->segment(4) ?>" class="btn btn-primary" style="float: right;">Valider les donnes</a></li> -->
                  </ul>

                  <div class="tab-content">
                    <div role='tabpanel' class='tab-pane active' id='info_ticket'>
                      <fieldset>
                        <legend><h5><b>Information de ticket</b></h5></legend>
                      <form method="POST" action="<?=base_url().'tickets/Intervention/add_temp_action/'.$ticket['TICKET_CODE']?>">
                        <div class="row">
                           <div class="col-lg-2 col-md-2">
                             Date arrive site
                             <input type="text" name="DATE_ARRIVEE" class="datepicker form-control" value="<?=set_value('DATE_ARRIVEE')?>" required>
                           </div>
                           <div class="col-lg-3 col-md-3">
                             
                             <div class="col-lg-6 col-md-6">
                              Heure
                               <select class="form-control" name="HEURE">
                                 <?php
                                   for($i=0;$i<25;$i++){
                                    ?>
                                      <option value="<?=$i?>"><?=$i?></option>
                                    <?php
                                   }
                                 ?>
                               </select>
                             </div>

                             <div class="col-lg-6 col-md-6">
                              Munite
                               <select class="form-control" name="MINUTE">
                                 <?php
                                   for($i=0;$i<13;$i++){
                                    ?>
                                      <option value="<?=$i*5?>"><?=$i*5?></option>
                                    <?php
                                   }
                                 ?>
                               </select>
                             </div>
                           </div>
                        </div>   
                        <div class="row">
                           <div class="col-lg-2 col-md-2">
                             Date retour CPPC
                             <input type="text" name="DATE_RETOUR" class="datepicker form-control" value="<?=set_value('DATE_RETOUR')?>" required>
                           </div>
                           <div class="col-lg-3 col-md-3">
                             
                             <div class="col-lg-6 col-md-6">
                              Heure
                               <select class="form-control" name="HEURE1" required>
                                 <?php
                                   for($i=0;$i<25;$i++){
                                    ?>
                                      <option value="<?=$i?>"><?=$i?></option>
                                    <?php
                                   }
                                 ?>
                               </select>
                             </div>

                             <div class="col-lg-6 col-md-6">
                              Munite
                               <select class="form-control" name="MINUTE1" required> 
                                 <?php
                                   for($i=0;$i<13;$i++){
                                    ?>
                                      <option value="<?=$i*5?>"><?=$i*5?></option>
                                    <?php
                                   }
                                 ?>
                               </select>
                             </div>
                           </div>
                           <div class="col-md-2 col-lg-2" style="margin-top: 19px">
                             <input type="submit" value="Enregistrer" class="btn btn-primary btn-sm">
                           </div>
                        </div>
                        </form>
                  </fieldset>
                    </div>
                    <div role='tabpanel' class='tab-pane' id='degats'>
                      <fieldset>
                        <legend><h5><b>Dégat Humain</b></h5></legend>
                       
                      <form method="POST" action="<?=base_url().'tickets/Intervention/degat_humain/'.$ticket['TICKET_CODE']?>">
                        <div class="row">
                           <div class="col-lg-4 col-md-4">
                             Nom
                             <input style="text-transform: capitalize;" onkeypress="return (event.charCode > 64 && 
  event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" type="text" name="NOM" class="form-control" value="<?=set_value('NOM')?>">
                           </div>
                           <div class="col-lg-4 col-md-4">
                             Prénom
                             <input style="text-transform: capitalize;" onkeypress="return (event.charCode > 64 && 
  event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" type="text" name="PRENOM" class="form-control" value="<?=set_value('PRENOM')?>">
                           </div>
                           <div class="col-lg-4 col-md-4">
                             CNI
                             <input type="text" name="IDENTIFICATION" class="form-control" value="<?=set_value('IDENTIFICATION')?>">
                           </div>
                        </div>

                        <div class="row" style="margin-bottom: 10px">
                           <div class="col-lg-4 col-md-4">
                             Date Naissance
                             <input type="text" name="DATE_NAISSANCE" class="datepicker form-control" value="<?=set_value('DATE_NAISSANCE')?>">
                           </div>
                           <div class="col-lg-4 col-md-4">
                             <?php
                                $statut_array = array('0' =>'Blessée','1'=>'Morte' );
                             ?>
                             Etat sanitaire
                             <select name='STATUT_SANTE' class="form-control">
                               <option value=""> - Sélectionner - </option>
                               <?php
                                 foreach ($statut_array as $key => $value) {
                                  ?>
                                   <option value="<?=$key?>"><?=$value?></option>
                                  <?php
                                 }
                               ?>
                             </select>
                           </div>

                           <div class="col-lg-4 col-md-4">
                             Séverité
                             <input type="text" name="SEVERITE" class="form-control" value="<?=set_value('SEVERITE')?>">
                           </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px">
                           <div class="col-lg-4 col-md-4" style="margin-top: 19px">
                             <input type="submit" value="Enregistrer" class="btn btn-primary">
                           </div>
                        </div>
                      </form>
                     <?php if(!empty($degat_humain)){?>
                    

                        <table class="table table-bordered">
                            <tr>
                                <th>Nom & Prénom</th>
                                <th>CNI</th>
                                <th>Date Naissance</th>
                                <th>Statut</th>
                                <th>Séverité</th>
                                <th>Action</th>
                            </tr>
                            <?php 
                              foreach ($degat_humain as $dg_humain) {
                                ?>
                                  <tr>
                                    <td><?=$dg_humain['NOM_PRENOM']?></td>
                                    <td><?=$dg_humain['IDENTIFICATION']?></td>
                                    <td><?=$dg_humain['DATE_NAISSANCE']?></td>
                                    <td><?=($dg_humain['STATUT_SANTE'] ==1)?'Mort':'Blessé'?></td>
                                    <td><?=($dg_humain['STATUT_SANTE'] ==0)?$dg_humain['SEVERITE']:''?></td>
                                    <td><a href="<?=base_url().'tickets/Intervention/supprimer_degat_humain/'.$dg_humain['DEGAT_HUMAIN_ID'].'/'.$ticket['TICKET_CODE']?>" class='btn btn-danger btn-sm'> Supprimer</a></td>
                                  </tr>
                                <?php
                              }
                            ?>
                            </table>                   

                    <?php }?>
                  </fieldset>
                  
                  <fieldset>
                        <legend><h5><b>Dégats matériel</b></h5></legend>

                    <form method="POST" action="<?=base_url().'tickets/Intervention/degat_matariel/'.$ticket['TICKET_CODE']?>">
                        <div class="row" style="margin-bottom: 4px">
                           <div class="col-lg-4 col-md-4">
                             Materiel

                            <select name="MATERIEL_ID" class="form-control">
                              <?php
                                foreach ($materiaux_riv as $mat) {
                                    if($materiel['MATERIEL_ENDO_CODE'] == set_value('MATERIEL_ID')){
                                    ?>
                                     <option value="<?=$mat['MATERIEL_ENDO_CODE']?>" selected><?=$mat['MATERIEL_ENDO_DESCR']?></option>
                                    <?php
                                   }else{
                                      ?>
                                     <option value="<?=$mat['MATERIEL_ENDO_CODE']?>"><?=$mat['MATERIEL_ENDO_DESCR']?></option>
                                    <?php
                                   }
                                }
                              ?>
                            </select>
                             
                           </div>
                           <div class="col-lg-3 col-md-3">
                             Nombre
                             <input type="text" name="NOMBRE" class="form-control" value="<?=set_value('NOMBRE')?>">
                           </div>
                          
                           <div class="col-lg-3 col-md-3">
                             Commentaire
                             <input type="text" name="COMMENTAIRE" class="form-control" value="<?=set_value('COMMENTAIRE')?>">
                           </div>

                           <div class="col-lg-2 col-md-2" style="margin-top: 19px">
                             <input type="submit" value="Enregistrer" class="btn btn-primary">
                           </div>
                        </div>
                      </form>
                    <?php if(!empty($degat_materiel)){?>
                    
                        <table class="table table-bordered">
                            <tr>
                                <td>Matériel</td>
                                <td>Nombre</td>
                                <th>Commentaire</th>
                                <th>Date insertion</th>
                                <th>Action</th>
                            </tr>
                            <?php 
                              foreach ($degat_materiel as $dg_materiel) {
                               ?>
                              <tr>
                                <td><?=$this->mylibrary->getOne('tk_materiel_endomage',array('MATERIEL_ENDO_CODE'=>$dg_materiel['MATERIEL_ENDO_CODE']))['MATERIEL_ENDO_DESCR']?></td>
                                <td><?=$dg_materiel['NOMBRE']?></td>
                                <td><?=$dg_materiel['COMMENTAIRE']?></td>
                                <td><?=$dg_materiel['DATE_INSERTION']?></td>
                                <td><a href="<?=base_url().'tickets/Intervention/supprimer_degat_materiel/'.$dg_materiel['DEGAT_MATERIEL_ID'].'/'.$ticket['TICKET_CODE']?>" class='btn btn-danger btn-sm'> Supprimer</a></td>
                              </tr>
                               <?php 
                              }
                            ?>
                            </table>                    

                    <?php }?>

                  </fieldset>
                    </div>
                    <div role='tabpanel' class='tab-pane' id='degats_dgpc'>
                      <fieldset>
                        <legend><h5><b>Dégat Humain DGPC</b></h5></legend>  
                    <form method="POST" action="<?=base_url().'tickets/Intervention/degat_humain_dgpc/'.$ticket['TICKET_CODE']?>">
                        <div class="row" style="margin-bottom: 4px">
                           <div class="col-lg-3 col-md-3">
                             Collaborateur
                             <select name='PERSONNEL_ID' class="form-control">
                               <option value=""> - Sélectionner - </option>
                               <?php
                                 foreach ($collaborateurs as $collaborateur) {
                                  if($collaborateur['PERSONNEL_ID'] == set_value('PERSONNEL_ID')){
                                  ?>
                                   <option value="<?=$collaborateur['PERSONNEL_ID']?>" selected><?=$collaborateur['PERSONNEL_NOM'].' '.$collaborateur['PERSONNEL_PRENOM']?></option>
                                  <?php
                                 }else{
                                    ?>
                                   <option value="<?=$collaborateur['PERSONNEL_ID']?>"><?=$collaborateur['PERSONNEL_NOM'].' '.$collaborateur['PERSONNEL_PRENOM']?></option>
                                  <?php
                                 }
                               }
                               ?>
                             </select>
                           </div>
                           <div class="col-lg-3 col-md-3">
                               <?php
                                $statut_array = array('0' =>'Blessée','1'=>'Morte' );
                             ?>
                             Etat sanitaire
                             <select name='STATUT_SANTE' class="form-control">
                               <option value=""> - Sélectionner - </option>
                               <?php
                                 foreach ($statut_array as $key => $value) {
                                  ?>
                                   <option value="<?=$key?>"><?=$value?></option>
                                  <?php
                                 }
                               ?>
                             </select>
                           </div>
                           <div class="col-lg-3 col-md-3">
                             Séverité
                             <input type="text" name="SEVERITE" class="form-control" value="<?=set_value('SEVERITE')?>">
                           </div>                       
                           <div class="col-lg-3 col-md-3" style="margin-top: 19px">
                             <input type="submit" value="Enregistrer" class="btn btn-primary">
                           </div>
                        </div>
                      </form>
                    <?php if(!empty($degat_humain_dg)){?>
                    
                        <table class="table table-bordered">
                            <tr>
                                <th>Nom & Prénom</th>
                                <th>Matricule</th>
                                <th>Date Naissance</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                            <?php 
                              foreach ($degat_humain_dg as $dg_humain_dgpc) {
                                ?>
                                 <tr>
                                   <td><?=$dg_humain_dgpc['NOM_PRENOM']?></td>
                                   <td><?=$dg_humain_dgpc['IDENTIFICATION']?></td>
                                   <td><?=$dg_humain_dgpc['DATE_NAISSANCE']?></td>
                                   <td><?=($dg_humain_dgpc['STATUT_SANTE'] ==1)?'Mort':'Blessé'?></td>
                                   <td><a href="<?=base_url().'tickets/Intervention/supprimer_degat_humain/'.$dg_humain_dgpc['DEGAT_HUMAIN_ID'].'/'.$ticket['TICKET_CODE']?>" class='btn btn-danger btn-sm'> Supprimer</a></td>
                                 </tr>
                                <?php
                              }
                            ?>
                            </table>                   

                    <?php }?>
                    </fieldset>

                  <fieldset>
                        <legend><h5><b>Dégats matériel DGPC</b></h5></legend>

                    <form method="POST" action="<?=base_url().'tickets/Intervention/degat_matariel_dgpc/'.$ticket['TICKET_CODE']?>">
                        <div class="row" style="margin-bottom: 4px">
                           <div class="col-lg-3 col-md-3">
                             Matériel
                             <select name='MATERIEL_ID' class="form-control">
                               <option value=""> - Sélectionner - </option>
                               <?php
                                 foreach ($materiaux as $materiel) {
                                  if($materiel['MATERIEL_ID'] == set_value('MATERIEL_ID')){
                                  ?>
                                   <option value="<?=$materiel['MATERIEL_ID']?>" selected><?=$materiel['MATERIEL_DESCR']?></option>
                                  <?php
                                 }else{
                                    ?>
                                   <option value="<?=$materiel['MATERIEL_ID']?>"><?=$materiel['MATERIEL_DESCR']?></option>
                                  <?php
                                 }
                               }
                               ?>
                             </select>
                           </div>
                           <div class="col-lg-3 col-md-3">
                             Nombre
                             <input type="text" name="NOMBRE" class="form-control" value="<?=set_value('NOMBRE')?>">
                           </div>
                           <div class="col-lg-3 col-md-3">
                             Commentaire
                             <input type="text" name="COMMENTAIRE" class="form-control" value="<?=set_value('COMMENTAIRE')?>">
                           </div>                       
                           <div class="col-lg-3 col-md-3" style="margin-top: 19px">
                             <input type="submit" value="Enregistrer" class="btn btn-primary">
                           </div>
                        </div>
                      </form>  
                    <?php if(!empty($degat_materiel_dgpc)){
                      ?>
                    
                        <table class="table table-bordered">
                            <tr>
                                <th>Matériel</th>
                                <th>NOMBRE</th>
                                <th>Commentaire</th>
                                <th>Action</th>
                            </tr>
                            <?php 
                              foreach ($degat_materiel_dgpc as $dg_materiel_dgpc) {
                              //  print_r($dg_materiel_dgpc);
                                ?>
                                <tr>
                                  <td><?=$this->mylibrary->getOne('interv_materiaux',array('MATERIEL_CODE'=>$dg_materiel_dgpc['MATERIEL_ENDO_CODE']))['MATERIEL_DESCR']?></td>
                                  <td><?=$dg_materiel_dgpc['NOMBRE']?></td>
                                  <td><?=$dg_materiel_dgpc['COMMENTAIRE']?></td>
                                  <td><a href="<?=base_url().'tickets/Intervention/supprimer_degat_materiel/'.$dg_materiel_dgpc['DEGAT_MATERIEL_ID'].'/'.$ticket['TICKET_CODE']?>" class='btn btn-danger btn-sm'> Supprimer</a></td>
                                </tr>
                                <?php
                              }
                            ?>
                            </table>                   

                    <?php }?>
                  </fieldset>
                    </div>
                    <div role='tabpanel' class='tab-pane' id='partenaire'>
                      <fieldset>
                        <legend><h5><b>Présence de(s) partenaire(s)</b></h5></legend>
                     <form method="POST" action="<?=base_url().'tickets/Intervention/interv_partenaire/'.$ticket['TICKET_CODE']?>">
                        <div class="row" style="margin-bottom: 4px">
                           <div class="col-lg-3 col-md-3">
                             Matériel
                             <select name='PARTENAIRE_ID' class="form-control">
                               <option value=""> - Sélectionner - </option>
                               <?php
                                 foreach ($partenaires as $partenaire) {
                                  if($partenaire['PARTENAIRE_ID'] == set_value('PARTENAIRE_ID')){
                                  ?>
                                   <option value="<?=$partenaire['PARTENAIRE_ID']?>" selected><?=$partenaire['PARTENAIRE_DESCR']?></option>
                                  <?php
                                 }else{
                                    ?>
                                   <option value="<?=$partenaire['PARTENAIRE_ID']?>"><?=$partenaire['PARTENAIRE_DESCR']?></option>
                                  <?php
                                 }
                               }
                               ?>
                             </select>
                           </div>
                           <div class="col-lg-3 col-md-3">
                             Matériel
                             <input type="text" name="MATERIEL_DESCR" class="form-control" value="<?=set_value('MATERIEL_DESCR')?>">
                           </div>
                           <div class="col-lg-3 col-md-3">
                             Commentaire
                             <input type="text" name="COMMENTAIRE" class="form-control" value="<?=set_value('COMMENTAIRE')?>">
                           </div>
                                                  
                           <div class="col-lg-3 col-md-3" style="margin-top: 19px">
                             <input type="submit" value="Enregistrer" class="btn btn-primary">
                           </div>
                        </div>
                      </form> 
                    <?php if(!empty($interv_partenaire)){
                      ?>
                    
                        <table class="table table-bordered">
                            <tr>
                                <th>Partenaire</th>
                                <th>Matériel</th>
                                <th>Commentaire</th>
                                <th>Action</th>
                            </tr>
                            <?php 
                              foreach ($interv_partenaire as $partenaire) {
                                ?>
                                <tr>
                                  <td><?=$this->mylibrary->getOne('interv_partenaire',array('PARTENAIRE_CODE'=>$partenaire['PARTENAIRE_CODE']))['PARTENAIRE_DESCR']?></td>
                                  <td><?=$partenaire['MATERIEL_DESCR']?></td>
                                  <td><?=$partenaire['COMMENTAIRE']?></td>
                                  <td><a href="<?=base_url().'tickets/Intervention/interv_partenaire_supprimer/'.$partenaire['INTERV_PARTENAIRE_ID'].'/'.$ticket['TICKET_CODE']?>" class='btn btn-danger btn-sm'> Supprimer</a></td>
                                </tr>
                                <?php
                              }
                            ?>
                            </table>                   

                    <?php }?>
                    </fieldset>
                    </div>
                    <div role='tabpanel' class='tab-pane' id='valider'>
                      <?php
                        $commentaire=$this->Model->getOne('transm_rapport_histo',array('TICKET_CODE'=>$this->uri->segment(4),'USER_ID'=>$this->session->userdata('DGPC_USER_ID'),'NIVEAU_ID'=>1));
                       ?>
                      <form method="POST" action="<?=base_url().'pdf/Pdf/valider_transmission/'.$ticket['TICKET_CODE']?>">
                          <div class="col-lg-6 col-md-6">
                            <label>Observation</label>
                            <textarea class="form-control" name="OBSERVATION"><?=$commentaire['COMMENTAIRE'] ?></textarea>
                            <input type="checkbox" name="VALIDER" class="input-radio" value="1">Valider<br><br>
                          </div>
                          <div class="col-lg-12 col-md-12">
                            <input type="submit" value="Transmettre" class="btn btn-primary btn-sm">
                          </div>
                        
                      </form>
                      
                    </div>

                  </div>









                  
                  
                  
                  

                  
                   </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
           

</body>
<script type="text/javascript">
    $(function () {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            minDate: new Date(),
            todayHighlight: true,
            autoclose: true
        });
    });

    function getRegex(val){
       if ($(val).val().search(/[^a-z]+/) == false) {
           $(val).val($.trim($(val).val()).slice(0, -1));
        }
    }

    </script>

</html>


