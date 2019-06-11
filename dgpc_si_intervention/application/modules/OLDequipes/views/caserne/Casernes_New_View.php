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
                                    <?php include 'menu_caserne.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12" style="padding: 5px">
                      <?php
                         if($this->session->flashdata('msg'))
                         echo $this->session->flashdata('msg');
                       ?>   
                      <form method="POST" action="<?=base_url().'equipes/Caserne/save'?>">
                           <div class="col-lg-12 col-md-12">
                              <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <label >Nom de la CPPC</label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                    <input type="text" class="form-control" name="CPPC_NOM" value="<?=set_value('CPPC_NOM')?>" autofocus> 
                                    <font color='red'><?php echo form_error('CPPC_NOM'); ?></font> 
                                </div>
                                                
                              </div>
                              <div class="row">
                                <div class="col-lg-3 col-md-3">
                                  <label>Description de la CPPC</label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                  <input type="text" class="form-control" name="CPPC_DESCR" value="<?=set_value('CPPC_DESCR')?>"> 
                                  <font color='red'><?php echo form_error('CPPC_DESCR'); ?></font> 
                                  </div>              
                              </div>
                              <div class="row">
                                <div class="col-lg-3 col-md-3">
                                  <label>Service DGPC </label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                  <select name="SERVICE_DGPC_ID" class="form-control">
                                    <option value=""> - Sélectionner - </option>
                                    <?php
                                       foreach ($services as $service) {
                                         if($service['SERVICE_DGPC_ID'] == set_value('SERVICE_DGPC_ID')){
                                          ?>
                                            <option value="<?=$service['SERVICE_DGPC_ID']?>" selected><?=$service['SERVICE_DGPC_DESCR']?></option>
                                          <?php
                                         }else{
                                          ?>
                                            <option value="<?=$service['SERVICE_DGPC_ID']?>"><?=$service['SERVICE_DGPC_DESCR']?></option>
                                          <?php
                                         }
                                       }
                                    ?>
                                  </select>
                                  <font color='red'><?php echo form_error('SERVICE_DGPC_ID'); ?></font>  
                                  </div>              
                              </div>
                              <div class="row">
                                <div class="col-lg-3 col-md-3">
                                  <label>Email</label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                  <input type="text" class="form-control" name="CPPC_EMAIL" value="<?=set_value('CPPC_EMAIL')?>">
                                  <font color='red'><?php echo form_error('CPPC_EMAIL'); ?></font>
                                </div>
                                  
                              </div>

                              <div class="row">
                                <div class="col-lg-3 col-md-3">
                                  <label>Télephone <i title="Ajouter l'indicateur Pays. ex.: BDI : +257">?</i></label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                  <input type="text" class="form-control" name="CPPC_TEL" value="<?=set_value('CPPC_TEL')?>">
                                  <font color='red'><?php echo form_error('CPPC_TEL'); ?></font> 
                                </div>               
                              </div>

                              <div class="row">
                                <div class="col-lg-3 col-md-3">
                                  <label>Province </label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                  <select name="PROVINCE_ID" class="form-control">
                                    <option value=""> - Sélectionner - </option>
                                    <?php
                                       foreach ($provinces as $province) {
                                         if($province['PROVINCE_ID'] == set_value('PROVINCE_ID')){
                                          ?>
                                            <option value="<?=$province['PROVINCE_ID']?>" selected><?=$province['PROVINCE_NAME']?></option>
                                          <?php
                                         }else{
                                          ?>
                                            <option value="<?=$province['PROVINCE_ID']?>"><?=$province['PROVINCE_NAME']?></option>
                                          <?php
                                         }
                                       }
                                    ?>
                                  </select>
                                  <font color='red'><?php echo form_error('PROVINCE_ID'); ?></font>  
                                  </div>              
                              </div>
                               <div class="row">
                                <div class="col-lg-3 col-md-3">
                                  <label>Longitude </label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                  <input type="text" class="form-control" name="CASERNE_LONG" value="-1">
                                  <font color='red'><?php echo form_error('CASERNE_LONG'); ?></font>  
                                </div>              
                              </div>
                               <div class="row">
                                <div class="col-lg-3 col-md-3">
                                  <label>Latitude </label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                  <input type="text" class="form-control" name="CASERNE_LAT" value="-1">
                                  <font color='red'><?php echo form_error('CASERNE_LAT'); ?></font> 
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


