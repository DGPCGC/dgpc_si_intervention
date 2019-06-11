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
                                     <?php include 'menu_partenaire.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12" style="padding: 5px">
                      <?php
                         if($this->session->flashdata('msg'))
                         echo $this->session->flashdata('msg');
                       ?>   
                      <form method="POST" action="<?=base_url().'alerte/Partenaire/add'?>">
                           <div class="col-lg-12 col-md-12">
                              <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <label >Code du partenaire</label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                    <input type="text" class="form-control" name="PARTENAIRE_CODE" value="<?=set_value('PARTENAIRE_CODE')?>" autofocus> 
                                    <font color='red'><?php echo form_error('PARTENAIRE_CODE'); ?></font> 
                                </div>
                                                
                              </div>
                              <div class="row">
                                <div class="col-lg-3 col-md-3">
                                  <label>Description du partenaire</label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                  <input type="text" class="form-control" name="PARTENAIRE_DESCR" value="<?=set_value('PARTENAIRE_DESCR')?>"> 
                                  <font color='red'><?php echo form_error('PARTENAIRE_DESCR'); ?></font> 
                                  </div>              
                              </div>
                               
                              <div class="row">
                                <div class="col-lg-3 col-md-3">
                                  <label>Email du partenaire</label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                  <input type="text" class="form-control" name="PARTENAIRE_EMAIL" value="<?=set_value('PARTENAIRE_EMAIL')?>">
                                  <font color='red'><?php echo form_error('PARTENAIRE_EMAIL'); ?></font>
                                </div>
                                  
                              </div>

                              <div class="row">
                                <div class="col-lg-3 col-md-3">
                                  <label>Télephone du partenaire <i title="Ajouter l'indicateur Pays. ex.: BDI : +257">?</i></label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                  <input type="text" class="form-control" name="PARTENAIRE_TEL" value="<?=set_value('PARTENAIRE_TEL')?>">
                                  <font color='red'><?php echo form_error('PARTENAIRE_TEL'); ?></font> 
                                </div>               
                              </div>

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
           

</body>

</html>


