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
                                    <?php include 'menu_services.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12 jumbotron" style="padding: 5px">
                      <?php
                         if($this->session->flashdata('msg'))
                         echo $this->session->flashdata('msg');
                       ?>   
                      <form method="POST" action="<?=base_url().'equipes/Services/update'?>"><div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>Nom du service<span style="color:red">*</span> </label>
                                  <input type="text" class="form-control" name="service" value="<?=$description ?>" required> 
                                  <input type="hidden" class="form-control" name="id" value="<?=$this->uri->segment(4) ?>" required>
                                                 
                              </div>
                              
                              <div class="form-group">
                                <label>Est-il un CPPC<span style="color:red">*</span> </label>
                                <?php
                                  if($IS_CPPC==1){
                                    $check_oui='checked';
                                    $check_non='';
                                  }else{
                                    $check_oui='';
                                    $check_non='checked';
                                  }

                                 ?>
                                 <div class="checkbox">
                                    <label><input type="radio"  name="is_cppc" value="1" <?=$check_oui ?>>Oui</label>
                                    <label><input type="radio" name="is_cppc" value="0" <?=$check_non ?>>Non</label>
                                 </div>
                                
                                 
                                             
                              </div>
                              
                              <div class="form-group">
                                 <input type="submit" class="btn btn-primary" value="Modifier">
                              </div>
                           </div
                           
                      </form>
           </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
</body>

</html>


