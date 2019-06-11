<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
</head>

<body>
    <div class="container-fluid" style="background-color: white">
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 5px" id="navp">
                <!-- /.navbar-top-links -->
               <?php include VIEWPATH.'includes/menu_principal.php' ?>
                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->
            <?php 
             $add ='active';
            $list ='';
            ?>
            <!-- <div id="page-wrapper"> -->
              <div class="col-lg-2">
                   <?php include 'includes/sous_menu_classe.php' ?>;
                </div>
                <div class="col-lg-10">
                <div class="container-fluid">
                    <div class="row">
                     
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                             <?= $breadcrumb ?>
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b>Ajouter une personne à notifier</b></h4>
                                 </div>
                                 <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                
                                 </div>
                            </div>  
                        </div>
                    <div class="col-lg-12 jumbotron table-responsive" style="padding: 5px">
                     
                      <form id="myform" action="<?php echo base_url()?>alerte/Personnel/add"  method="post" enctype="multipart/form-data" >
                 <div class="row">          
               <div class="col-md-4 sm-12 xs-12 form-group">
                     <label>Nom </label>

                   <input type="text" name="NON" id="nom" class="form-control " autofocus>
                     </div>
                            <div class="col-md-offset-0 col-md-4 sm-12 xs-12 form-group">
                               
                    <label>Prenom </label>

            <input type="text" name="PRENOM" id="prenom"  class="form-control " autofocus>
                
            </div>
            <div class="col-md-4 sm-12 xs-12 form-group"> 
           
               <label>Télephone</label>

            <input type="text" name="PHONE" id="phone"  class="form-control " autofocus>
        
             </div>
                 </div>
                      <div class="row">
                            <div class="col-md-offset-0 col-md-4 sm-12 xs-12 form-group">

                               <label>Province </label>
           
            <select name="province"  class="form-control " id="province">
              <option disabled selected >--- Selectionner une province ---</option>
              
                                 <?php 
                
                                foreach($mesProvinces as $provinc)
                {
                if($provinc['PROVINCE_ID']==$PROVINCE_ID)
                {
                echo "<option value='".$provinc['PROVINCE_ID']."' selected>".$provinc['PROVINCE_NAME']." </option>";
                }
                else{
                echo "<option value ='".$provinc['PROVINCE_ID']."'>".$provinc['PROVINCE_NAME']."</option>";
               
                 
                }
                } ?>

                </select>
                
                      </div>       
                  <div class="col-md-offset-0 col-md-4 sm-12 xs-12 form-group">

                 
                 <label>Email</label>

            <input type="email" name="EMAIL" id="email"  class="form-control " autofocus>
         
                   </div>
                   <div class="col-md-4 sm-12 xs-12 form-group">

            <label>Colline :</label>

              <input type="text" name="COLLINE" id="colline" class="form-control " autofocus>

  
                </div>
                      </div>
                          <div class=" row">
                            <div class="col-md-offset-0 col-md-4 sm-12 xs-12 form-group">

                   <div id="listcom"></div>
         
                  <span class="error"><?php echo form_error('org_poste'); ?></span>
          
              </div>
          </div>
              
                <div class="row">    
            <div class="col-md-12 sm-12 xs-12 form-group">

              <input type="button" name="next" class="btn btn-primary btn-block envoi" value="Enregistrer" />

          </div>
        </div>                 
      </form>
    
  </div>
</div>
</div></div></div></div>

</body>
</html>

<script type="text/javascript">

  $(document).ready(function(){
    
        $("#province").change(function(){

          var province = $("#province").val();

         $.post('<?php echo base_url(); ?>alerte/Personnel/getCommune',
          {province:province},
          function(data){
            $("#listcom").html(data);
          }
          );
             
        });
      });
</script>


<script type="text/javascript">
  $(document).ready(function(){
        $(".envoi").click(function(){
      
          // alert('Bien');
            if(!$('#nom').val().trim()){
                    alert('Le Nom du personnel est requis');
                $('#nom').focus();
                }else  if(!$('#prenom').val().trim()){
                    alert('le prenom du personnel est requise');
                $('#prenom').focus();

                }else if(!$('#phone').val().trim()){
                    alert('le numéro de Télephone du personnel est requise');
                $('#phone').focus();

                }else  if(!$('#colline').val().trim()){
                    alert('la colline du personnel est requise');
                $('#colline').focus();

                }else if(!$('#email').val().trim()){
                    alert('Email du personnel est requise');
                $('#email').focus();

                }

                else{
                    document.getElementById("myform").submit();
                }
        });
    });
</script>

<!-- <script>
    
$(document).ready( function () {

$('#niveauorg').change(function(){
    var id=$('#niveauorg').val();
    if(id==1){
    $('#province').prop("disabled",true);
    $('#commune').prop("disabled",true);
    }
     else if(id==2){
    $('#province').prop("disabled",false);
    $('#commune').prop("disabled",true);
      }else{
    $('#province').prop("disabled",false);
    $('#commune').prop("disabled",false);
      }
});
$('#organisation').change(function(){
    // alert($('#organe').val());
});
</script> -->
