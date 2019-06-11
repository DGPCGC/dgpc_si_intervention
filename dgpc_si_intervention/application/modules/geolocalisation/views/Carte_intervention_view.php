<!DOCTYPE html>
<html lang="en">


<head>
<?php include VIEWPATH.'includes/header.php' ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script> 

<link rel="stylesheet" href="<?= base_url() ?>leafletlabel/dist/leaflet.label.css" /> 
<script src="<?= base_url() ?>leafletlabel/dist/leaflet.label.js"></script> 
        <style>
            #map {
                width: 100%;
                height:100%;
                 }

        .labelstyle {
        all: revert;
        color: black;
        font-size:10px;
        font-weight: 70;
        fillColor: none;
        fillOpacity: 0;
        background-color: none;
        border-color: none;
        background: none;
        border: none;
        box-shadow: none;
        margin: 0px;
        cursor: none;
        direction: 'top';
        interactive: false;
        fill: false;
        background-color: transparent;
        border: transparent;
        box-shadow: none;
       }

</style>
</head>
<body onload="SendNotificationSound(<?php echo $bip;?>);">
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
                <div class="col-lg-5 col-md-5">                                  
                <h4 class=""><b> <?= $title ?> </b></h4>  
                </div>
                <div class="col-lg-7 col-md-7" style="padding-bottom: 3px">
                <form name="myform" method="POST" id="myform" action="<?php echo base_url('geolocalisation/Carte_intervention') ?>" >


                  <div class="col-lg-3 col-md-3">
                                  Canal<br>
                <select name="CANAL_ID" onchange="submit_fx()" class="form-control">
                 <option>Tout</option>
                 <?php 

                  foreach ($canals as $key_canals) {
                    # code...
                    if($CANAL_ID==$key_canals['CANAL_ID']){
                      ?>
                       <option selected value="<?= $key_canals['CANAL_ID'] ?>"><?= $key_canals['CANAL_DESCR'] ?></option>
                      <?php
                    }else{
                      ?>
                       <option value="<?= $key_canals['CANAL_ID'] ?>"><?= $key_canals['CANAL_DESCR'] ?></option>
                      <?php
                    }
                    ?>
                   
                    <?php
                  }

                  ?>
                </select>
                </div>

               <div class="col-lg-3 col-md-3">
                                  Cause<br>
                <select name="CAUSE_ID" onchange="submit_fx()" class="form-control">
                 <option >Tout</option>
                 <?php 

                  foreach ($causes as $key_causes) {
                    # code...
                    if($CAUSE_ID==$key_causes['CAUSE_ID']){
                      ?>
                       <option selected value="<?= $key_causes['CAUSE_ID'] ?>"><?= $key_causes['CAUSE_DESCR'] ?></option>
                      <?php
                    }else{
                      ?>
                       <option value="<?= $key_causes['CAUSE_ID'] ?>"><?= $key_causes['CAUSE_DESCR'] ?></option>
                      <?php
                    }
                    ?>
                   
                    <?php
                  }

                  ?>
                </select>
                </div>



                <div class="col-lg-3 col-md-3">
                                  Province<br>
                <select name="PROVINCE_ID" onchange="submit_fx()" class="form-control">
                 <option >Tout</option>
                 <?php 

                  foreach ($ststm_provinces as $key_ststm_provinces) {
                    # code...
                    if($PROVINCE_ID==$key_ststm_provinces['PROVINCE_ID']){
                      ?>
                       <option selected value="<?= $key_ststm_provinces['PROVINCE_ID'] ?>"><?= $key_ststm_provinces['PROVINCE_NAME'] ?></option>
                      <?php
                    }else{
                      ?>
                       <option value="<?= $key_ststm_provinces['PROVINCE_ID'] ?>"><?= $key_ststm_provinces['PROVINCE_NAME'] ?></option>
                      <?php
                    }
                    ?>
                   
                    <?php
                  }

                  ?>
                </select>
                </div>

                <div class="col-lg-3 col-md-3">
                                  Commune<br>
                <select name="COMMUNE_ID" onchange="submit_fx()" class="form-control">
                 <option >Tout</option>
                 <?php 

                 if($ststm_provinces){

                  foreach ($ststm_communes as $key_ststm_communes) {
                    # code...
                    if($COMMUNE_ID==$key_ststm_communes['COMMUNE_ID']){
                      ?>
                       <option selected value="<?= $key_ststm_communes['COMMUNE_ID'] ?>"><?= $key_ststm_communes['COMMUNE_NAME'] ?></option>
                      <?php
                    }else{
                      ?>
                       <option value="<?= $key_ststm_communes['COMMUNE_ID'] ?>"><?= $key_ststm_communes['COMMUNE_NAME'] ?></option>
                      <?php
                    }
                    ?>
                   
                    <?php
                  }
                 }
                  

                  ?>
                </select>
                </div>


         
            
                                </div>
                            </div>  
                        </div> 


        <div class="col-lg-12 jumbotron" style="padding: 5px">
            
             <div class="col-lg-3">
              
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="3000">
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
           <?=$sildes?>
            </div>
          </div>

          <table class="table">
            <tr>
              <th>Nombre Mort</th>
              <td><?=$nombre_mort?></td>
            </tr>
            
            <tr>
              <th>Nombre Mort DGPC</th>
              <td><?=$nombre_mort_dgpc?></td>
            </tr>

            <tr>
              <th>Nombre Bléssé(e)s</th>
              <td><?=$nombre_blesse?></td>
            </tr>
            
            <tr>
              <th>Nombre Bléssé(e)s DGPC</th>
              <td><?=$nombre_blesse_dgpc?></td>
            </tr>
          </table>
             </div>
            
             <div class="col-lg-9">

           <div class="content">
             
            <div class="horizontal">
                <div class="" align='center'>
                   <div id="map" style="width: 100%;height: 600px">
                       
                   </div>  
              <script>
                
                var info='<?php echo $zooms; ?>';
                var cordon='<?php echo $centerCoord; ?>';
                var val_cord=cordon.split(",");
                var liste_don='<?php echo $list_data; ?>';
                var donnes=liste_don.split("&&");
                console.log(donnes); 
                        
                var map = L.map('map', {
                                        center: [val_cord[0],val_cord[1]],
                                        zoom: info
                                        });
                    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="#">DGPC SI</a>'}).addTo(map);

                    for (var i = 0; i < (donnes.length-1); i++) { 
                    var donnee = donnes[i].split("<>");
                    ///console.log(donnee);                    

                     var greenIcon = L.icon({
                            iconUrl: donnee[4],
                            shadowUrl: '',

                            iconSize: [33, 37],
                            shadowSize: [15, 20],
                            //iconAnchor:   [22, 94],
                            shadowAnchor: [4, 62],
                            //popupAnchor: [-3, -76]
                            });
                        L.marker([donnee[2], donnee[3]], 
                                 {icon: greenIcon,
                                  title:''+donnee[1]}).addTo(map)
                        .bindPopup("<font color='"+donnee[12]+"'><b>"+donnee[0]+"</b></font><br>----------------------------------------------------<br><b>Déscription:</b> "+donnee[1]+"<b><br><b>Canal : </b>"+donnee[9]+"<br><b>Cause : </b>"+donnee[10]+"<br><b>Statut : </b>"+donnee[11]+"<br><b>Date et heure : </b>"+donnee[7]+"<br><b>Manager du CPPC / Declarant de l'intervention: </b>"+donnee[8]);
                    } 
                    
 
                </script>
                </div>
            </div>
           </div>
       </div>
       </form>
        </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
         

</body>
<script type="text/javascript">
    function submit_fx() {
       myform.action = myform.action;
       myform.submit();   
    }


    $(document).ready(function(){

        $('#datecreation').datepicker({
          format: 'dd-mm-yyyy'
        });
    });


    $(document).ready(function(){

      setInterval(function(){
      $.ajax({
              url:"<?php echo base_url() ?>geolocalisation/Carte_intervention/Bruit_carte",
              method:"POST",
              success:function(data){  
                if(data==1){
                  SendNotificationSound(1);
                  window.location.href="<?= base_url('geolocalisation/Carte_intervention/index/1') ?>";

                  }
                              
                }
            });

    },15000);

    });


</script>

<script>
$(document).ready( function () {
    $('#mytables').DataTable({ 
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "iDisplayLength": 3,


           dom: 'Bfrtlip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
  });  
} );
</script>
</html>
