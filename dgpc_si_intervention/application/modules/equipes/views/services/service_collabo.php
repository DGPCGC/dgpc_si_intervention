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

                <div class="container-fluid" >
                    <div class="row">
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                                <?=$breadcrumb ?> 
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b>Nouveau personnel</b></h4>  
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                    <?php include 'menu_services.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12 jumbotron" style="padding: 5px">
                  <?php
                        $id=$this->uri->segment(4);
                         if($this->session->flashdata('msg'))
                         echo $this->session->flashdata('msg');

                  ?>  <div class="row"> 
                      
                    <form method="POST" id="regiration_form" action="<?=base_url('equipes/Services/ajout') ?>" > 

                           <div class="col-lg-12 col-md-12">

                            <div class="panel panel-default">
                              <div class="panel-heading">
                                   <h4 style="text-align: center;">Ajouter un nouveau personnel</h4>
                              </div>
                            <div class="panel-body">

                            <br>
                              <div class="form-group">
                                  <label>Nom Service</label>
                                 <select name="PERSONNEL_ID" class="form-control" id="PER">
                                    <option value=""> - Sélectionner - </option>
                                    <?php
                                       foreach ($service as $services) {
                                         $id_service=$this->uri->segment(4);
                                         if($services['SERVICE_DGPC_ID']==$id_service){?>
                                          <option value="<?=$services['SERVICE_DGPC_ID']?>" selected><?=$services['SERVICE_DGPC_DESCR']?></option>
                                          <?php
                                         }else{
                                          ?>
                                            <option value="<?=$services['SERVICE_DGPC_ID']?>"><?=$services['SERVICE_DGPC_DESCR']?></option>
                                          <?php
                                           }
                                         }
                                         ?>
                                  </select>
                                                 
                              </div>
                              <div class="form-group">
                                  <label>Collaborateur</label>
                                 <select name="PERSONNEL_ID" class="form-control" id="PER">
                                    <option value=""> - Sélectionner - </option>
                                    <?php
                                       $id_personnel=$this->uri->segment(5);
                                       foreach ($personnel as $service) {
                                         if($service['PERSONNEL_ID']==$id_personnel){
                                          ?>
                                            <option value="<?=$service['PERSONNEL_ID']?>" selected><?=$service['PERSONNEL_NOM']?></option>
                                          <?php
                                         }else{
                                          ?>
                                            <option value="<?=$service['PERSONNEL_ID']?>"><?=$service['PERSONNEL_NOM']?></option>
                                          <?php
                                        }
                                           }
                                         ?>
                                  </select>
                                                 
                              </div>
                              
                              <div class="form-group">
                                <label>Date debut</label>
                                 <select name="SERVICE_DGPC_ID" class="form-control" id="DAT">
                                    <option value=""> - Sélectionner - </option>
                                    <?php
                                       foreach ($date as $dat) {

                                        $per=$this->session->userdata('DGPC_USER_ID');

                                        if ($dat['USER_ID']==$per) {
                                         
                                          ?>
                                      <option value="<?=$dat['SERVICE_DGPC_ID']?>" selected><?=$dat['DATE_INSERTION']?></option>
                                          <?php
                                            } }
                                         ?>
                                  </select>                                             
                              </div>
                              <div class="form-group">

                                <label>Déscription</label>
                                 <input type="text"  id="DESCR" name="description" class="form-control">

                              </div>
                              <div class="form-group">
                                <label>Est-il un Chef :</label>
                                 <div class="checkbox">
                                    <label><input type="radio"  name="is_cppc" value="1" checked="">Oui</label>
                                    <label><input type="radio" name="is_cppc" value="0">Non</label>
                                 </div>
                                    
                              </div>
                              <div class="form-group">
                                 <input type="button" class="btn btn-primary envoi" value="Enregister">
                              </div>
                           </div>
                             </div>
                           </div>
                      </form>

                      <?php
                        
                       ?> 

                 </div>       
           </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
</body>

</html>
<script>
$(document).ready( function () {
    $('#mytable').DataTable({
     /*dom: 'lBfrtip',
    buttons: ['copy', 'print']*/ });  
} );
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $(".envoi").click(function(){
         

            if(!$('#DAT').val().trim()){
                    alert('La date est requise et obligatoire');
                $('#DAT').focus();
                } if(!$('#PER').val().trim()){
                    alert('La sélection du non est obligatoire');
                $('#PER').focus();
                } if(!$('#DESCR').val().trim()){
                    alert('La description est requise et obligatoire');
                $('#DESCR').focus();
                }else{
                    document.getElementById("regiration_form").submit();
                }
        });
    });
</script>


