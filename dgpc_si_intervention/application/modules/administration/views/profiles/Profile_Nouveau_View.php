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
                                    <?php include 'menu_profile.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12 jumbotron" style="padding: 5px">
                      <?= $this->session->flashdata('message') ?>   
                      <form method="POST" action="<?=base_url().'administration/Profiles/save'?>">
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>Description</label>
                                  <input type="text" class="form-control" name="PROFILE_DESCR" value="<?=set_value('PROFILE_DESCR')?>" autofocus> 
                                  <font color='red'><?php echo form_error('PROFILE_DESCR'); ?></font>               
                              </div>

                              
                              <div class="form-group">
                                  <label>Code</label>
                                  <input type="text" class="form-control" name="PROFILE_CODE" value="<?=set_value('PROFILE_CODE')?>">
                                  <font color='red'><?php echo form_error('PROFILE_CODE'); ?></font>                
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


