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
                <div class="col-lg-5 col-md-5">                                  
                <h4 class=""><b> <?= $title ?> </b></h4>  
                </div>
                <div class="col-lg-7 col-md-7" style="padding-bottom: 3px">
                <form name="myform" method="POST" id="myform" action="<?php echo base_url('geolocalisation/New_Map') ?>" >

                <div class="col-lg-4 col-md-4">
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

                <div class="col-lg-4 col-md-4">
                CPPC<br>
                <select name="CPPC_ID" id="CPPC_ID" onchange="submit_fx()" class="form-control">
                              <option >Tout</option>
                 <?php 

                  foreach ($rh_cppc as $key_rh_cppc) {
                    # code...
                    if($CPPC_ID==$key_rh_cppc['CPPC_ID']){
                      ?>
                       <option selected value="<?= $key_rh_cppc['CPPC_ID'] ?>"><?= $key_rh_cppc['CPPC_NOM'] ?></option>
                      <?php
                    }else{
                      ?>
                       <option value="<?= $key_rh_cppc['CPPC_ID'] ?>"><?= $key_rh_cppc['CPPC_NOM'] ?></option>
                      <?php
                    }
                    ?>
                   
                    <?php
                  }

                  ?>
               
                             
                                </select>
                                  </div>

                                           
                             

                                   <?php //print_r($tickets); ?>
                              
            
                                </div>
                            </div>  
                        </div> 


        <div class="col-lg-12 jumbotron" style="padding: 5px">
            
             <div class="col-lg-5">
              <?php 
                  if($divaffich==1){
                    ?>
                     <table class="table">
                <tr>


        
          
                  <td><input type="checkbox" <?= $select_OUV; ?> name="OUV" onchange="submit_fx()"></td>
                  <td>
                    <img width="33" height="27" src="<?= base_url().'assets/bootstrap/care/carered1.jpg'; ?>">
                    <label>(<?= $count_statut1['statut_un'] ?>)Ouvert</label>
                    
                  </td>

                  <td><input type="checkbox" <?= $select_INT; ?> name="INT" onchange="submit_fx()"></td>

                  <td>
                    <img width="33" height="27" src="<?= base_url().'assets/bootstrap/care/carejaune.jpg'; ?>">
                    <label>(<?= $count_statut2['statut_un'] ?>)En intervention</label>
                    
                  </td>
                  <td>
                     <input type="checkbox" <?= $select_CLO; ?> name="CLO" onchange="submit_fx()">
                  </td>
                  
                  <td>
                    <img width="33" height="27" src="<?= base_url().'assets/bootstrap/care/caregreen.jpg'; ?>">
                    <label>(<?= $count_statut3['statut_un'] ?>)Cloturé</label>
                   
                  </td>
                  
                  
                   
                  </tr>
                  <tr>
                    <td><input type="checkbox" <?= $select_ATT; ?> name="ATT" onchange="submit_fx()"></td>

                  <td>
                    <img width="33" height="27" src="<?= base_url().'assets/bootstrap/care/caregreee.jpg'; ?>">
                    <label>(<?= $count_statut4['statut_un'] ?>)En attente</label>
                    
                  </td>
                   <td><input type="checkbox" name="FAA" <?= $select_FAA; ?> onchange="submit_fx()"></td>

                  
                  <td>
                    <img width="33" height="27" src="<?= base_url().'assets/bootstrap/care/caredgpc2.jpg'; ?>">
                    <label>(<?= $count_statut5['statut_un'] ?>)Fausse alerte</label>
                    
                  </td>

                 
                   <td>
                    
                  </td>

                  <td></td>
                   
                  </tr>
                  </table>
                    <?php
                  }
               ?>
             
              <?php 
                echo $table_cppc;
               ?>

             </div>
           </form>
             <div class="col-lg-7">

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
                        .bindPopup("<font color='"+donnee[12]+"'><b>"+donnee[0]+"</b></font><br>----------------------------------------------------<br><b>Déscription:</b> "+donnee[1]+"<b></br>Email : </b> "+donnee[6]+"<br><b>Tél : </b> "+donnee[5]+"<br><b>Province : </b> "+donnee[7]+"</br><b>Nombre de population blessé : </b>"+donnee[8]+"</br><b>Nombre de population mort : </b>"+donnee[9]+"<br><b>Nombre de DGPC blessé : </b>"+donnee[10]+"<br><b>Nombre de DGPC mort : </b>"+donnee[11]+"<br><b>Ticket : "+donnee[12]+"<br><b>Date et heure : </b>"+donnee[13]+"<br><b>Manager du CPPC / Declarant de l'intervention: </b>"+donnee[14]);
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
