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
              <div class="col-lg-2">
                    <?php include 'm_mat.php' ?>
                </div>
                <div class="col-lg-10">
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
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12 jumbotron" style="padding: 5px">
                      <?= $this->session->flashdata('message') ?>   
                      <form method="POST" action="<?=base_url().'materiaux/Materiaux/save'?>">
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>Description</label>
                                  <input required type="text" class="form-control" name="MATERIEL_DESCR" value="<?=set_value('MATERIEL_DESCR')?>" autofocus> 
                                  <font color='red'><?php echo form_error('MATERIEL_DESCR'); ?></font>               
                              </div>
                            </div>

                              <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>Code</label>
                                  <input required type="text" class="form-control" name="MATERIEL_CODE" value="<?=set_value('MATERIEL_CODE')?>">
                                  <font color='red'><?php echo form_error('MATERIEL_CODE'); ?></font>                
                              </div>
                          
                              
                           </div>

                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>Categorie</label>
                                 <select required class="form-control" name="CATEGORIE_ID">
                                   <option disabled selected>--- Sélectionner ---</option>
                                   <?php 
                                        $interv_categorie_materiaux=$this->Model->getList('interv_categorie_materiaux',array());
                                        foreach ($interv_categorie_materiaux as $key) {
                                          # code...
                                          ?>
                                          <option value="<?= $key['CATEGORIE_ID'] ?>"><?= $key['CATEGORIE_DESCR'] ?></option>
                                          <?php
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
                                          ?>
                                          <option value="<?= $key['CPPC_ID'] ?>"><?= $key['CPPC_NOM'] ?></option>
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
                                          # code...
                                          ?>
                                          <option value="<?= $key['ETAT_ID'] ?>"><?= $key['DESCRIPTION'] ?></option>
                                          <?php
                                        }
                                     ?>

                                 </select>  </div>
                          
                              
                           </div>
                           <div class="col-lg-12 col-md-6">
                            <div class="form-group">
                                 <input type="submit" class="btn btn-primary" value="Enregister">
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


