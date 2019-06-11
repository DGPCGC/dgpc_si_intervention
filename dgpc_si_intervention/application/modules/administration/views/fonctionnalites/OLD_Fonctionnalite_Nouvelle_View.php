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
            <div id="page-wrapper">
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
                                    <?php include 'menu_fonctionnalite.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12 jumbotron" style="padding: 5px">
                      <?= $this->session->flashdata('message') ?>   
                      <form method="POST" action="<?=base_url().'administration/Fonctionnalites/save'?>">
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>Description</label>
                                  <input type="text" class="form-control" name="FONCTIONNALITE_DESCR" value="<?=set_value('FONCTIONNALITE_DESCR')?>" autofocus> 
                                  <font color='red'><?php echo form_error('FONCTIONNALITE_DESCR'); ?></font>               
                              </div>

                              
                              <div class="form-group">
                                  <label>Url</label>
                                  <input type="text" class="form-control" name="FONCTIONNALITE_URL" value="<?=set_value('FONCTIONNALITE_URL')?>">
                                  <font color='red'><?php echo form_error('FONCTIONNALITE_URL'); ?></font>                
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
            <!-- /#page-wrapper -->

        </div>
    </div>

</body>

</html>


