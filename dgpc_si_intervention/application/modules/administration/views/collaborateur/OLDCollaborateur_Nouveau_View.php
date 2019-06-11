<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php'; ?>
</head>
<body>
    <div class="container-fluid" style="background-color: white">
        
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 5px" id="navp">
                <!-- /.navbar-top-links -->
                <?php include VIEWPATH.'includes/menu_principal.php'; ?>
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
                                    <?php include 'menu_collaborateur.php' ;?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-md-12 jumbotron" style="padding: 5px">
                      <?= $this->session->flashdata('msg') ?>   
                      <form method="POST" action="<?=base_url().'administration/Collaborateurs/enregistrer'?>">
                            <div class="col-lg-6 col-md-6">  
                              <div class="form-group">
                                  <label>Nom</label>
                                  <input type="text" class="form-control" name="NOM" value="<?=set_value('NOM')?>" autofocus> 
                                  <font color='red'><?php echo form_error('NOM'); ?></font>               
                              </div>

                              <div class="form-group">
                                  <label>Prénom</label>
                                  <input type="text" class="form-control" name="PRENOM" value="<?=set_value('PRENOM')?>">
                                  <font color='red'><?php echo form_error('PRENOM'); ?></font>
                              </div>

                              <div class="form-group">
                                  <label>Matricule</label>
                                  <input type="text" class="form-control" name="MATRICULE" value="<?=set_value('MATRICULE')?>">
                                  <font color='red'><?php echo form_error('MATRICULE'); ?></font>
                              </div>

                              <div class="form-group">
                                  <label>Grade</label>
                                  <input type="text" class="form-control" name="GRADE" value="<?=set_value('GRADE')?>">
                                  <font color='red'><?php echo form_error('GRADE'); ?></font>
                              </div>

                               <div class="form-group">
                                  <label>Fonction</label>
                                  <input type="text" class="form-control" name="FONCTION" value="<?=set_value('FONCTION')?>">
                                  <font color='red'><?php echo form_error('FONCTION'); ?></font>
                              </div>
                              <div class="form-group">
                                  <label>Date entrée en service</label>
                                  <input type="date" class="form-control" name="DATE_ENTREE" value="<?=set_value('DATE_ENTREE')?>">
                                  <font color='red'><?php echo form_error('DATE_ENTREE'); ?></font>
                              </div>

                              <div class="form-group">                                  
                                  <input type="checkbox" name="EST_UTILISATEUR" id="EST_UTILISATEUR" class="form-check-input" value="1" <?=(set_value('EST_UTILISATEUR')==1)?'checked':''?>>
                                  <label> Est utilisateur ?</label>
                              </div>
 
                            </div>
                            <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>Télephone</label>

                                  <div class="input-group">

                                    <span class="input-group-addon">+257</span>


                                  <input type="text" class="form-control" name="TELEPHONE" value="<?=set_value('TELEPHONE')?>">

                                </div>


                                  <font color='red'><?php echo form_error('TELEPHONE'); ?></font>                
                              </div>

                              <div class="form-group">
                                  <label>Email</label>
                                  <input type="text" class="form-control" name="EMAIL" value="<?=set_value('EMAIL')?>">
                                  <font color='red'><?php echo form_error('EMAIL'); ?></font>
                              </div>

                              <div class="form-group">
                                  <label>Confirmer l'Email</label>
                                  <input type="text" class="form-control" name="EMAIL_CONFIRM" value="<?=set_value('EMAIL_CONFIRM')?>">
                                  <font color='red'><?php echo form_error('EMAIL_CONFIRM'); ?></font>
                              </div>

                              <div class="form-group">
                                  <label>Adresse</label>
                                  <input type="text" class="form-control" name="ADRESSE" value="<?=set_value('ADRESSE')?>">
                                  <font color='red'><?php echo form_error('ADRESSE'); ?></font>
                              </div>

                              <div class="form-group">
                                  <label>LOGIN ODK</label>
                                  <input type="text" class="form-control" name="ODK" value="<?=set_value('ODK')?>">
                                  <font color='red'><?php echo form_error('ODK'); ?></font>                
                              </div> 

                             <div class="form-group" id='ms_prf'>                                  
                                  <label>Profiles</label>
                                  <select name="PROFILE_ID" class="form-control" id="profiles">
                                    
                                  </select>
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

<script>
  
$(document).ready(function(){
  $("#ms_prf").hide();

  var EST_UTILISATEUR = $("input:checked").length;
  var selected = $("#profiles").val();
  
  console.log(selected);
  if(EST_UTILISATEUR ==1){
      $("#ms_prf").show();
      
      $.ajax({
            url: "<?=base_url()?>administration/Collaborateurs/getListeProfile",
            method: "POST",
            dataType: "html",
            success: function (data) {
              // alert(data);
               $("#profiles").html(data);
            }
        });
  }

 $("#EST_UTILISATEUR").click(function(){
  $("#ms_prf").show();

  var n = $( "input:checked" ).length;

  if(n>0) {
    
      $.ajax({
            url: "<?=base_url()?>administration/Collaborateurs/getListeProfile",
            method: "POST",
            dataType: "html",
            success: function (data) {
              // alert(data);
               $("#profiles").html(data);
            }
        });
    }else{
     $("#ms_prf").hide(); 
    }
  });
  });
</script>
</html>

