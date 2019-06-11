
<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
</head>

<body>
    <div class="container-fluid" style="background-color: white">
        
          <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 5px" id="navp">
                <!-- /.navbar-top-links -->
                <?php include VIEWPATH.'includes/menu_principal_test.php' ?>
                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->
            <?php 
            $diligence1 ='active';
            $diligence2 ='';
            ?>
                <div class="container-fluid">
                    <div class="row">
                     <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                                <?=$breadcrumb?> 
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b>Enregistrement catastrophe</b></h4>

                                      
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                    <?php include 'menu_odk.php' ?>
                                </div>
                            </div>  
                        </div>
                         
                     <div class="col-lg-12 jumbotron">
                     <?=$msg ?>

                  
                      
                <form class="form-horizontal" action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <div class="form-group">
               <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label">Agent DGPC</label>
                <div class="col-md-4 col-sm-6 col-xs-6">
                   <input type="text" class="form-control" name="AGENT">
                
                  <div style="color: red">   <?php echo form_error('AGENT');?>
                  </div>
                </div>
          </div>

         <div class="form-group">
               <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label">Déscription catastrophe</label>
                <div class="col-md-4 col-sm-6 col-xs-6">
                  <textarea class="form-control" name="DESCRIPTION" autofocus></textarea>
                
                  <div style="color: red">   <?php echo form_error('DESCRIPTION');?>
                  </div>
                </div>
          </div>
          <div class="form-group">
               <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label">Localité</label>
                <div class="col-md-4 col-sm-6 col-xs-6">
                   <input type="text" class="form-control" name="LOCALITE">
                
                  <div style="color: red">   <?php echo form_error('LOCALITE');?>
                  </div>
                </div>
          </div>



         <div class="form-group">

          
              <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label">Longitude</label>
              <div class="col-md-4 col-sm-6 col-xs-6">
                <input type="text" class="form-control" name="LONGITUDE" value="-1" >
                <div style="color: red">   <?php echo form_error('LONGITUDE'); ?> </div>
              </div>

          </div>
          <div class="form-group">

          
              <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label">Latitude</label>
              <div class="col-md-4 col-sm-6 col-xs-6">
                <input type="text" class="form-control" name="LAT" value="-1" >
                <div style="color: red">   <?php echo form_error('LAT'); ?> </div>
              </div>

          </div>

          <div class="form-group">

          
              <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label">Date</label>
              <div class="col-md-4 col-sm-6 col-xs-6">
                <input type="text" class="form-control" name="DATE" id='date'>
                <div style="color: red">   <?php echo form_error('DATE'); ?> </div>
              </div>

          </div>



  


                     <div class="form-group">
                                <label class="col-md-12 col-sm-12 col-xs-12 control-label"></label>
                                <div class="col-md-4 col-sm-12 col-xs-12 col-md-push-3">
                                    <input type="submit" class="btn btn-primary btn-block" value="Enregistrer"/>
                                 </div>
                         </div>
                     </form>

                    </div>
                    </div>

                </div>
           
    </body>
 


</html>
<script type="text/javascript">
  // $('#date').Datapicker();
   $( "#date" ).datepicker({
       dateFormat: 'yy-mm-dd',

   });
</script>
