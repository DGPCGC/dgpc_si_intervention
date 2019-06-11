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
                                    <?php include 'menu_horaire.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12" style="padding: 5px">
                      <?php
                         if($this->session->flashdata('msg'))
                         echo $this->session->flashdata('msg');
                       ?>   
                      <form method="POST" action="<?=base_url().'equipes/Horaire/add'?>">
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>CPPC</label>
                                  <select name="CPPC_ID" id='CPPC_ID' class="form-control">
                                    <option value=""> - Sélectionner - </option>
                                    <?php
                                       foreach ($cppc as $cppcs) {
                                  
                                          ?>
                                            <option value="<?=$cppcs['CPPC_ID']?>"><?=$cppcs['CPPC_NOM']?></option>
                                          
                                        <?php
                                       }
                                    ?>
                                  </select>
                                  <font color='red'><?php echo form_error('CPPC_ID'); ?></font>               
                              </div>
                              <div class="form-group">
                                  <label>Nom d'équipe</label>
                                  <select name="EQUIPE_ID" id='EQUIPE_ID' class="form-control">
                                    <option>-- Selectionner--</option>
                                    
                                  </select>
                                  <font color='red'><?php echo form_error('EQUIPE_ID'); ?></font>               
                              </div>
                            
                              <div class="form-group">
                                  <label>Heure</label>
                                  <select name="TRANCHE" class="form-control">
                                    <option value=""> - Sélectionner - </option>
                                    <option value="1"> 00h-08h </option>
                                    <option value="2"> 08h-16h </option>
                                    <option value="3"> 16h-24h </option>
                                   
                                  </select>
                                  <font color='red'><?php echo form_error('TRANCHE'); ?></font>
                              </div>
                              <div class="form-group">
                                  <label>Equipe de secour</label>
                                  <select name="EQUIPE_ID_SECOUR" id='EQUIPE_ID_SECOUR' class="form-control">
                                    <option value="">- Sélectionner - </option>
                                  </select>
                                  <font color='red'><?php echo form_error('EQUIPE_ID_SECOUR'); ?></font>               
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

<script type="text/javascript">
  $("#EQUIPE_ID").change(function(){
      var equipe=$('#EQUIPE_ID').val();
          $.ajax({
            url:"<?= base_url() ?>equipes/Horaire/select_team",
            method:"POST",
            data:{equipe:equipe},
            success:function(data){
                $('#EQUIPE_ID_SECOUR').html(data);
                // alert(data);
            }
          });
                     
      });

</script>

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


