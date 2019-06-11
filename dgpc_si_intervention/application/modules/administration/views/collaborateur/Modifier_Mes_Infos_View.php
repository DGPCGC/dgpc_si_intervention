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
                            </div>  
                        </div> 
                  <div class="col-md-12 jumbotron" style="padding: 5px">
                      <?= $this->session->flashdata('msg') ?>   
                <form method="POST" id="myform" action="<?=base_url().'administration/Information_User/update'?>">
                  
                  <input type="hidden" class="form-control" name="idn" value="<?=$donnee['PERSONNEL_ID']?>">
                  
                            <div class="col-lg-6 col-md-6">  
                              <div class="form-group">
                                  <label>Nom</label>
                                      <input type="text" class="form-control" name="NOM" value="<?=$donnee['PERSONNEL_NOM']?>" id="NOM"> 
                                  <font color='red'><?php echo form_error('NOM'); ?></font>               
                              </div>

                              <div class="form-group">
                                  <label>Prénom</label>
                                    <input type="text" class="form-control" name="PRENOM" value="<?=$donnee['PERSONNEL_PRENOM']?>" id="PRENOM">
                                  
                              </div>

                              <div class="form-group">
                                  <label>Matricule</label>
                                  <input type="text" class="form-control" name="MATRICULE" value="<?=$donnee['PERSONNEL_MATRICULE']?>" id="MATRICULE">
                                  
                              </div>

                              <div class="form-group">
                                  <label>Grade</label>
                                     <input type="text" class="form-control" name="GRADE" value="<?=$donnee['GRADE']?>" id="GRADE">
                                  
                              </div>

                              <div class="form-group">
                                   <label>Fonction</label>
                                <input type="text" class="form-control" name="FONCTION" value="<?=$donnee['FONCTION']?>" id="FONCTION" >
                                  <font color='red'><?php echo form_error('FONCTION'); ?></font>
                              </div>
                            </div>
                            <div class="col-lg-6 col-md-6"> 
                              <div class="form-group">
                                  <label>Télephone</label>
                                  <input type="text" class="form-control" name="TELEPHONE" value="<?=$donnee['PERSONNEL_TELEPHONE']?>" id="TELEPHONE">
                                                 
                              </div>

                              <div class="form-group">
                                  <label>Email</label>
                                    <input type="text" class="form-control" name="EMAIL" value="<?=$donnee['PERSONNEL_EMAIL']?>" id="EMAIL">
                                  
                              </div>

                              <div class="form-group">
                                  <label>Adresse</label>
                                    <input type="text" class="form-control" name="ADRESSE" value="<?=$donnee['PERSONNEL_ADRESSE']?>"id="ADRESSE">
                                  
                              </div>
                              <div class="form-group">
                                  <label>ODK</label>
                                     <input type="text" class="form-control" name="ODK" value="<?=$donnee['PERSONNEL_ODK']?>" disabled>
                                                 
                              </div>
                              
                              <label></label>
                              <div class="form-group">                                 
                                    <input type="button" class="btn btn-primary envoi" value="Modifier">
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
  $(document).ready(function(){
        $(".envoi").click(function(){
      
          // alert('Bien');
            if(!$('#NOM').val().trim()){
                    alert('Le nom est requis');
                $('#NOM').focus();
                }else if(!$('#PRENOM').val().trim()){
                    alert('le prenon est requis');
                $('#PRENOM').focus();

                }else if(!$('#MATRICULE').val().trim()){
                    alert('Matricule est requis');
                $('#MATRICULE').focus();
                }
                else if(!$('#GRADE').val().trim()){
                    alert('le prenon est requis');
                $('#GRADE').focus();

                }else if(!$('#FONCTION').val().trim()){
                    alert('la fonction est requise');
                $('#FONCTION').focus();
                }
                else if(!$('#TELEPHONE').val().trim()){
                    alert('le numéro de télephone est requis');
                $('#TELEPHONE').focus();
                }
                else if(!$('#ADRESSE').val().trim()){
                    alert('la dresse est requise');
                $('#ADRESSE').focus();
                }
                else if(!$('#EMAIL').val().trim()){
                    alert('l\' Email est requis');
                $('#EMAIL').focus();
                }
                else {
                    document.getElementById("myform").submit();
                }
        });
    });
</script>

