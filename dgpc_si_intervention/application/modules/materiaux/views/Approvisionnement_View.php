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
                      <form method="POST" action="<?=base_url().'materiaux/Materiaux/approv'?>">
                          

                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>Matériel</label>
                                 <select  class="form-control" name="MATERIEL_ID">
                                   <option disabled selected>--- Sélectionner ---</option>
                                   <?php 
                                        foreach ($approv as $key) {
                                          # code...
                                          ?>
                                          <option value="<?= $key['MATERIEL_ID'] ?>"><?= $key['MATERIEL_DESCR'] ?></option>
                                          <?php
                                        }
                                     ?>

                                 </select>    
                                  <font color='red'><?php echo form_error('MATERIEL_ID'); ?></font>        
                              </div>
                            </div>

                              <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>Quantité</label>
                                  <input  type="number" class="form-control" name="QUANTITE" value="<?=set_value('QUANTITE')?>" min="1">
                                  <font color='red'><?php echo form_error('QUANTITE'); ?></font>                
                              </div>
                          
                              
                           </div>
                           <div class="col-lg-12 col-md-6">
                            <div class="form-group">
                                 <input type="submit" class="btn btn-primary" value="Approvisionner">
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