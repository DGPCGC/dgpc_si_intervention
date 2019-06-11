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
                                    <?php include 'menu_equipe.php' ?>
                                </div>
                            </div>  
                        </div> 
                       <div class="col-lg-12" style="padding: 5px">                      
                        <div class="col-lg-6 col-md-6" style="border:0px solid red"> 
                       
                       <?php

                       if($this->session->flashdata('msg'))
                         echo $this->session->flashdata('msg');
                       ?>
                       <form method="POST" action="">
                           <div class="col-lg-10 col-md-10">
                              <div class="form-group">
                                  <label>CPPC</label>
                                  <select name="CPPC_ID" id='CPPC_ID' class="form-control" onchange="getInfoCppc()">
                                    <option value=""> - Sélectionner - </option>
                                    <?php
                                       foreach ($cppc as $cppcs) {
                                          if($cppc_id_equipe['CPPC_ID']==$cppcs['CPPC_ID']){
                                            ?>
                                            <option value="<?=$cppcs['CPPC_ID']?>" selected><?=$cppcs['CPPC_NOM']?></option>

                                            <?php
                                            }else{
                                              ?>
                                              <option value="<?=$cppcs['CPPC_ID']?>"><?=$cppcs['CPPC_NOM']?></option>
                                              <?php
                                            }
                                          
                                       }
                                    ?>
                                  </select>
                                  <font color='red'><?php echo form_error('CPPC_ID'); ?></font>               
                              </div>
                              <div class="form-group">
                                  <label>Nom d'équipe</label>
                                  <select name="EQUIPE_ID" id='EQUIPE_ID' class="form-control" onchange="getInfoEquipe()">
                                    <option>-- Selectionner--</option>
                                    <?php
                                      foreach ($equipe as $equipes) {
                                        if($equipes['EQUIPE_ID']==$this->uri->segment(4)){
                                          ?>
                                            <option value="<?=$equipes['EQUIPE_ID'] ?>" selected><?=$equipes['EQUIPE_NOM'] ?></option>
                                          <?php
                                        }
                                        ?>
                                          <option value="<?=$equipes['EQUIPE_ID'] ?>"><?=$equipes['EQUIPE_NOM'] ?></option>
                                        <?php
                                      }
                                     ?>
                                    
                                  </select>
                                  <font color='red'><?php echo form_error('EQUIPE_ID'); ?></font>               
                              </div>
                              <div class="form-group">
                                  <label>Membre Equipe</label>
                                  <select name="PERSONNEL_ID" id='PERSONNEL_ID' class="form-control">
                                    <option value=""> - Sélectionner - </option>
                                    <?php
                                       foreach ($personnel as $personnels) {
                                          if($personnels['PERSONNEL_ID']==$this->uri->segment(5)){
                                            ?>
                                              <option value="<?=$personnels['PERSONNEL_ID']?>" selected><?=$personnels['PERSONNEL_NOM'].' '.$personnels['PERSONNEL_PRENOM'] ?></option>
                                            <?php
                                          }else{
                                  
                                          ?>
                                            <option value="<?=$personnels['PERSONNEL_ID']?>"><?=$personnels['PERSONNEL_NOM'].' '.$personnels['PERSONNEL_PRENOM'] ?></option>
                                          
                                        <?php
                                       }

                                      }
                                    ?>
                                  </select>
                                  <font color='red'><?php echo form_error('PERSONNEL_ID'); ?></font>               
                              </div>
                              <div class="form-group">
                                  <label>Chef d'équipe ?</label><br>
                                  <input type="radio" name="POSTE_ID" class="" value="1"> Oui
                                  <input type="radio" name="POSTE_ID" class="" value="0" checked=""> Non
                                 
                                  <!-- <select name="IS_CHEF" id='IS_CHEF' class="form-control">
                                    <option value=""> - Sélectionner - </option>
                                    <option value="1"> Oui </option>
                                    <option value="0"> Non </option>
                                    
                                  </select> -->
                                  <font color='red'><?php echo form_error('POSTE_ID'); ?></font>               
                              </div>
                              <div class="form-group">
                                  <label>Description</label>
                                  <textarea class="form-control" name="DESCRIPTION"></textarea>
                                  <font color='red'><?php echo form_error('DESCRIPTION'); ?></font>               
                              </div>
                            
                              
                              <div class="form-group">
                                 <input type="submit" class="btn btn-primary" value="Enregister">
                              </div>
                           </div>
                           
                      </form>
                      
                     
                      </div>
                      <div class="col-lg-6 col-md-6" style="">
                        <div id="infoCppc"></div>
                        <div id="InfoEquipe"></div>
                        
                      </div>
                      </div>
                  </div>
                </div>
            </div>
</body>


</html>
<script>
  $(document).ready(function () {
      $("#users_list").DataTable();
      getInfoCppc();
      getInfoEquipe();
    });
</script>

</html>
<script type="text/javascript">
  $("#CPPC_ID").change(function(){
      var cppc=$('#CPPC_ID').val();
          $.ajax({
            url:"<?= base_url() ?>equipes/Horaire/select_team_caserne",
            method:"POST",
            data:{cppc:cppc},
            success:function(data){
                $('#EQUIPE_ID').html(data);
                // alert(data);
            }
          });
                     
      });

</script>
<script type="text/javascript">
  function getInfoCppc(){
    var cppc=$('#CPPC_ID').val();
    $.ajax({
            url:"<?= base_url() ?>equipes/Equipes/getInfoCppc",
            method:"POST",
            data:{cppc:cppc},
            success:function(data){
                $('#infoCppc').html(data);
                 //alert(data);
            }
          });
  }

  function getInfoEquipe(){
    var equipe_id=$('#EQUIPE_ID').val();
    $.ajax({
            url:"<?= base_url() ?>equipes/Equipes/getInfoEquipe",
            method:"POST",
            data:{equipe_id:equipe_id},
            success:function(data){
                $('#InfoEquipe').html(data);
                 //alert(data);
            }
          });
  }
</script>



