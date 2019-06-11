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
                                    <?php include 'menu_collaborateur.php'; ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-md-12 jumbotron" style="padding: 5px">
                      <?= $this->session->flashdata('msg') ?>   
                      <form id="myform" method="POST" action="<?=base_url().'administration/Collaborateurs/modifier_collaborateur'?>">
                         <input type="hidden" class="form-control" name="PERSONNEL_ID" value="<?=$collabo['PERSONNEL_ID']?>" autofocus> 
                            <div class="col-lg-6 col-md-6">  
                              <div class="form-group">
                                  <label>Nom</label>
                                  <input type="text" class="form-control" name="NOM" value="<?=$collabo['PERSONNEL_NOM']?>" autofocus> 
                                  <font color='red'><?php echo form_error('NOM'); ?></font>               
                              </div>

                              <div class="form-group">
                                  <label>Prénom</label>
                                  <input type="text" class="form-control" name="PRENOM" value="<?=$collabo['PERSONNEL_PRENOM']?>">
                                  <font color='red'><?php echo form_error('PRENOM'); ?></font>
                              </div>

                              <div class="form-group">
                                  <label>Matricule</label>
                                  <input type="text" class="form-control" name="MATRICULE" value="<?=$collabo['PERSONNEL_MATRICULE']?>">
                                  <font color='red'><?php echo form_error('MATRICULE'); ?></font>
                              </div>

                              <div class="form-group">
                                  <label>Grade</label>
                                  <input type="text" class="form-control" name="GRADE" value="<?=$collabo['GRADE']?>">
                                  <font color='red'><?php echo form_error('GRADE'); ?></font>
                              </div>

                              <div class="form-group">
                                  <label>Fonction</label>
                                  <input type="text" class="form-control" name="FONCTION" value="<?=$collabo['FONCTION']?>">
                                  <font color='red'><?php echo form_error('FONCTION'); ?></font>
                              </div>

                              <div class="form-group">
                                  <label>Date entrée en service</label>
                                  <input type="date" class="form-control" name="DATE_ENTREE" value="<?=$collabo['DATE_ENTREE']?>">
                                  <font color='red'><?php echo form_error('DATE_ENTREE'); ?></font>
                              </div>

                               <div class="form-group">
                                   <?php 
                                     $checked = (!empty($user))?'checked':'';
                                     $checked_value = (!empty($user))?1:0;
                                   ?>

                                <input type="checkbox" name="EST_UTILISATEUR" id="EST_UTILISATEUR" class="form-check-input" value="<?=$checked_value?>" <?=$checked?> >
                                <label> Est utilisateur ?</label>
                              </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                              
                              <div class="form-group">
                                  <label>Télephone</label>

                                  <?php

                                  $newnumber=str_replace('+257','', $collabo['PERSONNEL_TELEPHONE']);

                                   ?>

                                  <div class="input-group">

                                    <span class="input-group-addon">+257</span>

                                      <input type="text" class="form-control" name="TELEPHONE" value="<?=$newnumber?>">
                                    
                                  </div>

                                
                                  <font color='red'><?php echo form_error('TELEPHONE'); ?></font>                
                              </div>

                              <div class="form-group">
                                  <label>Email</label>
                                  <input type="text" class="form-control" name="EMAIL" value="<?=$collabo['PERSONNEL_EMAIL']?>">
                                  <font color='red'><?php echo form_error('EMAIL'); ?></font>
                              </div>
                              <div class="form-group">
                                  <label>Confirmer l'Email</label>
                                  <input type="text" class="form-control" name="EMAIL_CONFIRM" value="<?=$collabo['PERSONNEL_EMAIL']?>">
                                  <font color='red'><?php echo form_error('EMAIL_CONFIRM'); ?></font>
                              </div>

                              <div class="form-group">
                                  <label>Adresse</label>
                                  <input type="text" class="form-control" name="ADRESSE" value="<?=$collabo['PERSONNEL_ADRESSE']?>">
                                  <font color='red'><?php echo form_error('ADRESSE'); ?></font>
                              </div>

                              <div class="form-group">
                                  <label>ODK</label>
                                  <input type="text" class="form-control" name="ODK" value="<?=$collabo['PERSONNEL_ODK']?>">
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

</html>
<script>
  
$(document).ready(function(){
  var id="<?=$this->uri->segment(4)?>"
  $.ajax({
            url: "<?=base_url()?>administration/Collaborateurs/getListeProfile1",
            method: "POST",
            data: {id:id},
            dataType: "html",
            success: function (data) {
              // alert(data);
               $("#profiles").html(data);
            }
        });
 // $("#ms_prf").hide();
  if(myform.elements['EST_UTILISATEUR'].checked == false){
  $("#ms_prf").hide();
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
               $("#profiles").html(data);
            }
        });
    }else{
     $("#ms_prf").hide(); 
    }
  });
  });
</script>
