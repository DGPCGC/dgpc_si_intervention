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
                                   <h4 class=""><b>Modifier le personnel</b></h4>  
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                    <?php include 'menu_services.php' ?>
                                </div>
                            </div>  
                      </div> 
                  <div class="col-lg-12 jumbotron" style="padding: 5px">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <h4 style="text-align: center;"></h4>
                        </div>
                        <div class="panel-body">
                       <div class="row"> 
                      <form method="POST" id="regiration_form" style="margin:10px 40px 0px 10px" action="<?=base_url().'equipes/Services/dater/'?>" >

                           <div class="col-lg-12 col-md-12">
                              <div class="form-group">
                                <input type="hidden" name="idn" value="<?=$manager['SERVICE_MANAGER_ID']?>">
                                  <label>Collaborateur</label>
                                 <select name="PERSONNEL_ID" class="form-control">
                                
                                    <?php
                                       foreach ($personnel as $service) {

                                        if ($service['PERSONNEL_ID']==$manager['PERSONNEL_ID']) {
                                         
                                          ?>
                                            <option value="<?=$service['PERSONNEL_ID']?>" selected><?=$service['PERSONNEL_NOM']?></option>
                                          <?php
                                           } }
                                         ?>
                                  </select>
                                                 
                              </div>
                              
                              <div class="form-group">
                                <label>Date debut</label>
                                 <select name="SERVICE_DGPC_ID" class="form-control">
                                    
                                    <?php
                                       foreach ($date as $dat) {

                                        if ($dat['SERVICE_DGPC_ID']==$manager['SERVICE_DGPC_ID']) {
                                         
                                          ?>
                                      <option value="<?=$dat['SERVICE_DGPC_ID']?>" selected><?=$dat['DATE_INSERTION']?></option>
                                          <?php
                                            } }
                                         ?>
                                  </select>                                             
                              </div>
                              <div class="form-group">

                                <label>Déscription</label>

                                 <input type="text"  id="DESCR" name="description" class="form-control" value="<?= $manager['DESCRIPTION'] ?>">

                              </div>
                              <div class="form-group">
                                <label>Est-il un Chef :</label>
                                 <div class="checkbox">
                                    <?php
                                if( $manager['IS_CHEF']==1){
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
                                 <input type="button" class="btn btn-primary envoi" value="Modifier">
                              </div>
                           </div>
                           
                      </form>

                      <?php
                        
                       ?> 
                       </div>
                   </div>  
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
         

            if(!$('#DESCR').val().trim()){
                    alert('La description est requise et obligatoire');
                $('#DESCR').focus();
                }else{
                    document.getElementById("regiration_form").submit();
                }
        });
    });
</script>