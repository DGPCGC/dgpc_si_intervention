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
                      <?php
                        if($this->session->flashdata('msg'))
                            echo $this->session->flashdata('msg');
                     ?> 
  
                          <?php
                            if(!empty($profiles)){
                                ?>
                               <form method="POST" action="<?=base_url('administration/Profiles/AddFonctionnalite')?>">
                                <div class="row">
                                   <div class="col-md-2">
                                     <label>Profils</label>
                                   </div>
                                  <div class="col-md-4">
                                    <select class="form-control" name="PROFILE_ID" id="PROFILE_ID">
                                      <option value=""> - Sélectionner - </option>
                                      <?php
                                        foreach ($profiles as $profile) {
                                          if($profile['PROFILE_ID'] == $PROFILE_ID){
                                             ?>
                                               <option value="<?=$profile['PROFILE_ID']?>" selected><?=$profile['PROFILE_DESCR']?></option>
                                          <?php
                                          }else{
                                          ?>
                                            <option value="<?=$profile['PROFILE_ID']?>"><?=$profile['PROFILE_DESCR']?></option>
                                          <?php
                                         }
                                        }
                                      ?>
                                    </select>
                                  </div>
                                </div>
                                
                                   <div id="fonctionnalites"></div>
                                   
                                  
                                <div class="col-md-4">
                                   <input type="submit" value="Enregistrer" class="btn btn-primary">                                 
                                </div>
                                </form>
                                <?php
                            }
                          ?>
             
                                  
                 </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            
</body>
<script>
  $(document).ready(function () {
        var PROFILE_ID = $("#PROFILE_ID").val();
        if(PROFILE_ID >0){
            $.ajax({
                    url: "<?php echo base_url(); ?>administration/Profiles/getFonctionnalite",
                    method: "POST",
                    data: {PROFILE_ID: PROFILE_ID},
                    dataType: "html",
                    success: function (data) {
                        $("#fonctionnalites").html(data);
                    }
                }); 
            }
            
        $("#PROFILE_ID").change(function () {
          var PROFILE_ID = $("#PROFILE_ID").val();

            $.ajax({
                    url: "<?php echo base_url(); ?>administration/Profiles/getFonctionnalite",
                    method: "POST",
                    data: {PROFILE_ID: PROFILE_ID},
                    dataType: "html",
                    success: function (data) {
                        $("#fonctionnalites").html(data);
                    }
                });
        });
    });
</script>
</html>


