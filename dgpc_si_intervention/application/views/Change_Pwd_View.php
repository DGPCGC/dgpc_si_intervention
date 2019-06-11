
<!DOCTYPE html>
<html lang="en">

<head>
<?php include 'includes/header.php' ?>
</head>

<body>
    <div class="container-fluid" style="background-color: white">
        <div id="wrapper">
            <!-- Navigation -->
          <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 5px" id="navp">
                <!-- /.navbar-top-links -->
                <?php include 'includes/menu_principal.php' ?>
                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->
            <?php 
            $diligence1 ='active';
            $diligence2 ='';
            ?>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                     <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                                <?=$breadcrumb?> 
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b>Modification du mot de passe</b></h4>

                                      
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                   <!--  <?php include 'includes/sous_menu_diligence.php' ?> -->
                                </div>
                            </div>  
                        </div>
                         
                     <div class="col-lg-12 jumbotron">

                  <?=$msg; ?>
                      
                <form class="form-horizontal" action="<?=base_url('Change_Pwd/changer');?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

         <div class="form-group">
               <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label">Ancien mot de passe</label>
                          <div class="col-md-4 col-sm-6 col-xs-6">
                             <input type="password" class="form-control" name="ACTUEL_PASSWORD" value="<?=set_value('ACTUEL_PASSWORD')?>" autofocus>
                             <div style="color: red">   <?php echo form_error('ACTUEL_PASSWORD');
                             

                              ?> </div>
                          </div>
          </div>



         <div class="form-group">

          
              <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label">Nouveau mot de passe</label>
                          <div class="col-md-4 col-sm-6 col-xs-6">
                             <input type="password" class="form-control" name="NEW_PASSWORD" value="<?=set_value('NEW_PASSWORD')?>" autofocus>
                             <div style="color: red">   <?php echo form_error('NEW_PASSWORD'); ?> </div>
                          </div>

          </div>



    
         <div class="form-group">

          
              <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label">Confirmer le mot de passe</label>
                          <div class="col-md-4 col-sm-6 col-xs-6">
                             <input type="password" class="form-control" name="PASSWORDCONFIRM" value="<?=set_value('PASSWORDCONFIRM')?>" autofocus>
                             <div style="color: red">   <?php echo form_error('PASSWORDCONFIRM'); ?> </div>
                          </div>

          </div>



                     <div class="form-group">
                                <label class="col-md-12 col-sm-12 col-xs-12 control-label"></label>
                                <div class="col-md-4 col-sm-12 col-xs-12 col-md-push-3">
                                    <input type="submit" class="btn btn-primary btn-block" value="Modifier"/>
                                 </div>
                         </div>
                     </form>

                    </div>
                    </div>

                </div>
            </div>
            </div>
    </body>
 


</html>
