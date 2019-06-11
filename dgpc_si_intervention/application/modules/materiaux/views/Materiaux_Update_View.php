<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
</head>
<body>
    <div class="container-fluid" style="background-color: white">
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 5px" id="navp">
                <!-- /.navbar-top-links -->
                <?php include VIEWPATH.'includes/menu_principal.php' ?>
                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->
            <!-- <div id="page-wrapper"> -->
              
                <div class="col-lg-12">
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
                                   <?php include 'm_mat.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12 jumbotron" style="padding: 5px">
                      <?= $this->session->flashdata('message') ?>   
                      <form method="POST" action="<?=base_url().'materiaux/Materiaux/Modifier_data'?>">
                           <div class="col-lg-6 col-md-6">
                            <input type="hidden" name="MATERIEL_ID" value="<?= $list_mat['MATERIEL_ID'] ?>">
                              <div class="form-group">
                                  <label>Description</label>
                                  <input required type="text" class="form-control" name="MATERIEL_DESCR" value="<?= $list_mat['MATERIEL_DESCR'] ?>" autofocus> 
                                  <font color='red'><?php echo form_error('MATERIEL_DESCR'); ?></font>               
                              </div>
                            </div>

                              <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>Code</label>
                                  <input required type="text" class="form-control" name="MATERIEL_CODE" value="<?= $list_mat['MATERIEL_CODE'] ?>">
                                  <font color='red'><?php echo form_error('MATERIEL_CODE'); ?></font>                
                              </div>
                          
                              
                           </div>

                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>Categorie</label>
                                 <select required class="form-control" name="CATEGORIE_ID">
                                   <option disabled selected>--- Sélectionner ---</option>
                                  <!--  <?php 
                                        $interv_categorie_materiaux=$this->Model->getList('interv_categorie_materiaux',array());
                                        foreach ($interv_categorie_materiaux as $key) {
                                          # code...
                                          if($key['CATEGORIE_ID']==$list_mat['CATEGORIE_ID']){
                                            ?>
                                              <option selected value="<?= $key['CATEGORIE_ID'] ?>"><?= $key['CATEGORIE_DESCR'] ?></option>
                                            <?php
                                          }else{
                                            ?>
                                              <option value="<?= $key['CATEGORIE_ID'] ?>"><?= $key['CATEGORIE_DESCR'] ?></option>
                                            <?php
                                          }
                                          ?>
                                        
                                          <?php
                                        }
                                     ?>
 -->
                                     <?php 
                                        $cause=$this->Model->getListOrder(' tk_causes','','CAUSE_DESCR');
                                        foreach ($cause as $key) {
                                          if ($list_mat['CAUSE_ID']==$key['CAUSE_ID'] ) {
                                           
                                          ?>

                                          <option value="<?= $key['CAUSE_ID'] ?>" selected><?= $key['CAUSE_DESCR'] ?></option>
                                          <?php

                                          }else{
                                            ?>
                                          <option value="<?= $key['CAUSE_ID'] ?>"><?= $key['CAUSE_DESCR'] ?></option>
                                            <?php
                                          }

                                        }
                                     ?>

                                 </select>            
                              </div>
                            </div>

                              <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>CPPC</label>
                                 <select required class="form-control" name="CPPC_ID">
                                   <option disabled selected>--- Sélectionner ---</option>
                                    <?php 
                                        $rh_cppc=$this->Model->getList('rh_cppc',array());
                                        foreach ($rh_cppc as $key) {
                                          # code...
                                          if($key['CPPC_ID']==$list_mat['CPPC_ID']){
                                            ?>
                                              <option selected value="<?= $key['CPPC_ID'] ?>"><?= $key['CPPC_NOM'] ?></option>
                                            <?php
                                          }else{
                                            ?>
                                              <option value="<?= $key['CPPC_ID'] ?>"><?= $key['CPPC_NOM'] ?></option>
                                            <?php
                                          }
                                          ?>
                                           
                                           <?php
                                        }
                                     ?>

                                 </select>  </div>
                          
                              
                           </div>
                            <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>ETAT</label>
                                 <select required class="form-control" name="ETAT">
                                   <option disabled selected>--- Sélectionner ---</option>
                                    <?php 
                                        $materiaux=$this->Model->getList('interv_etat_materiaux',array());
                                        foreach ($materiaux as $key) {

                                          if($key['ETAT_ID']==$list_mat['ETAT']){
                                          ?>
                                          <option value="<?= $key['ETAT_ID']?>" selected><?= $key['DESCRIPTION'] ?></option>
                                          <?php
                                        }else{ ?>
                                        <option value="<?= $key['ETAT_ID'] ?>"><?= $key['DESCRIPTION'] ?></option>
                                        <?php
                                      }
                                        }
                                     ?>

                                 </select>  </div>
                          
                              
                           </div>
                           <div class="col-lg-12 col-md-6">
                            <div class="form-group">
                                 <input type="submit" class="btn btn-primary" value="Modifier">
                              </div>
                           </div>


                           
                           
                      </form>
           </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
    </div>

</body>

</html>


