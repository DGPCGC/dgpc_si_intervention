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
                                   <h4 class=""><b>Modifier le Personnel</b></h4>
                                 </div>
                                 <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                 </div>
                            </div>  
                        </div>
                    <div class="col-lg-12 jumbotron table-responsive" style="padding: 5px">
                     
                      <form id="myform" action="<?php echo base_url()?>alerte/Personnel/update"  method="post" enctype="multipart/form-data" >
                    <input type="hidden"  name="idn" value="<?=$personnel['PERSONNEL_ID']?>" autofocus>
                 <div class="row">          
               <div class="col-md-4 sm-12 xs-12 form-group">
                     <label>Nom </label>

                   <input type="text" name="NON" id="nom" value="<?=$personnel['PERSONNEL_NOM']?>" class="form-control " autofocus>
                     </div>
                            <div class="col-md-offset-0 col-md-4 sm-12 xs-12 form-group">
                               
                    <label>Prenom </label>

            <input type="text" name="PRENOM" value="<?=$personnel['PERSONNEL_PRENOM']?>" id="prenom"  class="form-control " autofocus>
                
            </div>
            <div class="col-md-4 sm-12 xs-12 form-group"> 
           
               <label>Télephone</label>

            <input type="text" name="PHONE" value="<?=$personnel['PERSONNEL_TELEPHONE']?>" id="phone"  class="form-control " autofocus>
        
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
                if($provinc['PROVINCE_ID']==$personnel['COMMUNE_ID'])
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

            <input type="email" name="EMAIL" value="<?=$personnel['PERSONNEL_EMAIL']?>" id="email"  class="form-control " autofocus>
         
                   </div>
                   <div class="col-md-4 sm-12 xs-12 form-group">

            <label>Colline :</label>

              <input type="text" name="COLLINE" value="<?=$personnel['COLLINE']?>" id="colline" class="form-control " autofocus>

  
                </div>
                      </div>
                          <div class=" row">
                            <div class="col-md-offset-0 col-md-4 sm-12 xs-12 form-group">


               <div id="listcom">  
               <label>Commune </label>
          <select name='COMMUNE'  class='form-control ' id='commune'>
                                 
            <?php    
                foreach($mescommunes as $comm)
                {
                if($comm['COMMUNE_ID']==$personnel['COMMUNE_ID'])

                {
                echo "<option id='listcom' value='".$comm['COMMUNE_ID']."' selected>".$comm['COMMUNE_NAME']." </option>";
                }else if($comm['COMMUNE_ID']==$comm['COMMUNE_ID']){

                echo "<option value ='".$comm['COMMUNE_ID']."'>".$comm['COMMUNE_NAME']."</option>";  
                }}
                  ?>
            </select> </div> 

          
              </div>
          </div>
              
                <div class="row">    
            <div class="col-md-12 sm-12 xs-12 form-group">

              <input type="button" name="next" class="btn btn-primary btn-block envoi" value="Modifier" />

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

         $.post("#commune",
          {province:province},
          function(data){
            $("#listcom").val();
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
