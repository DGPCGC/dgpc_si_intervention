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
                                    <a <?php if($this->router->class=='Collaborateurs' && $this->router->method=='AddProfile') echo "class='active'";?> href="<?php echo base_url() ?>administration/Collaborateurs/AddProfile" class="btn-xs">Profiles</a>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12 col-md-12" style="padding: 5px">
                      <?php
                        if($this->session->flashdata('msg'))
                            echo $this->session->flashdata('msg');
                     ?> 
  
                          <?php
                            if(!empty($users)){
                                ?>
                               <form method="POST" action="<?=base_url('administration/Collaborateurs/AddProfile')?>">
                                <div class="row">
                                   <div class="col-md-2">
                                     <label>Utilisateur</label>
                                   </div>
                                  <div class="col-md-4">
                                    <select class="form-control" name="USER_ID" id="USER_ID" autofocus>
                                      <option value=""> - Sélectionner - </option>
                                      <?php
                                        foreach ($users as $user) {
                                          if($user['USER_ID'] == set_value('USER_ID')){
                                             ?>
                                               <option value="<?=$user['USER_ID']?>" selected><?=$user['USER_NOM'].' '.$user['USER_PRENOM']?></option>
                                          <?php
                                          }else{
                                          ?>
                                            <option value="<?=$user['USER_ID']?>"><?=$user['USER_NOM'].' '.$user['USER_PRENOM']?></option>
                                          <?php
                                         }
                                        }
                                      ?>
                                    </select>
                                  </div>
                                </div>
                                
                                   <div id="profiles"></div>
                                   
                                  
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
        var USER_ID = $("#USER_ID").val();
        if(USER_ID >0){
            $.ajax({
                    url: "<?php echo base_url(); ?>administration/Collaborateurs/getProfiles",
                    method: "POST",
                    data: {USER_ID: USER_ID},
                    dataType: "html",
                    success: function (data) {
                        $("#profiles").html(data);
                    }
                }); 
            }
            
        $("#USER_ID").change(function () {
          var USER_ID = $("#USER_ID").val();

            $.ajax({
                    url: "<?php echo base_url(); ?>administration/Collaborateurs/getProfiles",
                    method: "POST",
                    data: {USER_ID: USER_ID},
                    dataType: "html",
                    success: function (data) {
                        $("#profiles").html(data);
                    }
                });
        });
    });
</script>
</html>


