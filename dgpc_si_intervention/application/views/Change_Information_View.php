
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
                                   <h4 class=""><b>Modification Information</b></h4>

                                      
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                   <!--  <?php include 'includes/sous_menu_diligence.php' ?> -->
                                </div>
                            </div>  
                        </div>
                         
                     <div class="col-lg-12 jumbotron">

                  
                      
                <form class="form-horizontal" action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">

            <?=$msg ?>

         <div class="form-group">
            <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label">Nom</label>
            <div class="col-md-4 col-sm-6 col-xs-6">
            <input type="text" class="form-control" name="NOM_COLAB" value="<?=$infor['COLLABORATEUR_NOM'] ?>" autofocus>
                  <div style="color: red"> 
                      <?php echo form_error('NOM_COLAB');
                             // echo $msg;
                  ?>    
                  </div>
                  </div>
          </div>



         <div class="form-group">

            <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label">Prénom</label>
              <div class="col-md-4 col-sm-6 col-xs-6">
                  <input type="text" class="form-control" name="PRENOM_COLAB" value="<?=$infor['COLLABORATEUR_PRENOM'] ?>">
              <div style="color: red">   <?php echo form_error('PRENOM_COLAB'); ?> </div>
          </div>

          </div>



    
         <div class="form-group">

          <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label">Date Naissance</label>
                          <div class="col-md-4 col-sm-6 col-xs-6">
                             <input type="text" class="form-control" name="DATE_NAISSANCE" value="<?=$infor['DATE_NAISSANCE'] ?>">
                             <div style="color: red">   <?php echo form_error('DATE_NAISSANCE'); ?> </div>
                          </div>

          </div>
    
           <div class="form-group">

          <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label">Téléphone</label>
                          <div class="col-md-4 col-sm-6 col-xs-6">
                             <input type="text" class="form-control" name="TELEPHONE" value="<?=$infor['COLLABORATEUR_TELEPHONE'] ?>">
                             <div style="color: red">   <?php echo form_error('TELEPHONE'); ?> </div>
                          </div>

          </div>
           <div class="form-group">

          <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label">Email</label>
                          <div class="col-md-4 col-sm-6 col-xs-6">
                             <input type="text" class="form-control" name="EMAIL_COLAB" value="<?=$infor['COLLABORATEUR_EMAIL'] ?>" readOnly>
                             <div style="color: red">   <?php echo form_error('EMAIL_COLAB'); ?> </div>
                          </div>

          </div>
          <div class="form-group">

          <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label">Adresse</label>
                          <div class="col-md-4 col-sm-6 col-xs-6">
                             <input type="text" class="form-control" name="ADRESSE_COLAB" value="<?=$infor['COLLABORATEUR_ADRESSE'] ?>" >
                             <div style="color: red">   <?php echo form_error('COLLABORATEUR_ADRESSE'); ?> </div>
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
