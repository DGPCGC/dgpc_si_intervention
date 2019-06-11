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
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                                <?=$breadcrumb ?> 
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-5 col-md-5">                                  
                                   <h4 class=""><b><?=$title?></b></h4>  
                                </div>
                                <div class="col-lg-7 col-md-7" style="padding-bottom: 3px">
                               
                                  
                                  
                                </div>
                            </div>  
                        </div> 


        <div class="col-lg-12 jumbotron" style="padding: 5px">
            <form name="myform" method="POST" id="myform" action="<?php echo base_url('geolocalisation/Map/map_cppc') ?>" >
            <div class="col-lg-3">
                <table class="table table-striped table-hover">
                     <tr>
                     


                        <tr>
                           <td><label>Province</label></td>
                        </tr>
                          <tr>
                            
                            <td colspan="2">
                                <select onchange="submit_fx()" name="PROVINCE_ID" class="form-control">
                              <option disabled selected>--- Sélectionner ---</option>
                              <?php 

                              foreach ($ststm_provinces as $key) {
                                # code...
                                if($PROVINCE_ID==$key['PROVINCE_ID']){
                                  ?>
                                  <option selected value="<?= $key['PROVINCE_ID'] ?>"><?= $key['PROVINCE_NAME'] ?></option>
                                  <?php
                                }else{
                                  ?>
                                    <option value="<?= $key['PROVINCE_ID'] ?>"><?= $key['PROVINCE_NAME'] ?></option>
                              
                                  <?php
                                }
                                ?>
                                <?php

                              }
                               ?>
                            </select></td>
                          </tr>

                                <td><label>CPPC</label></td>
                        </tr>
                        <tr>
                            <td>
                                <select onchange="submit_fx()" name="CPPC_ID" class="form-control">
                                   <option>--- Sélectionner ---</option> 
                                   <?php
                                    foreach ($rh_cppc as $keyrh_cppc) {
                                        # code...
                                        if($CPPC_ID==$keyrh_cppc['CPPC_ID']){
                                            ?>
                                            <option selected value="<?php echo $keyrh_cppc['CPPC_ID'] ?>"><?php echo $keyrh_cppc['CPPC_NOM'] ?></option>
                                            <?php
                                        }else{
                                            ?>
                                            <option value="<?php echo $keyrh_cppc['CPPC_ID'] ?>"><?php echo $keyrh_cppc['CPPC_NOM'] ?></option>
                                            <?php
                                        }
                                        ?>
                                        
                                        <?php
                                    }

                                    ?>
                                </select>
                            </td>
                        </tr>
                        <?php
                            if($CPPC_ID>0){
                                ?>
                                <tr>
                                    <td>Ticket</td>
                                </tr>
                                 <tr>
                                    <td>
                                        <select name="TICKET_ID" onchange="submit_fx()" class="form-control" name="">
                                    <option selected disabled>--- Sélectionner ---</option>
                                    <?php 
                                        foreach ($tk_tickets as $key_tk_tickets) {
                                            # code...
                                            if($TICKET_ID==$key_tk_tickets['TICKET_ID']){
                                                ?>
                                                <option selected value="<?php echo $key_tk_tickets['TICKET_ID'] ?>">
                                                <?php echo $key_tk_tickets['TICKET_DESCR'] ?>
                                                    
                                                </option>
                                                <?php
                                            }else{
                                                ?>
                                                <option value="<?php echo $key_tk_tickets['TICKET_ID'] ?>">
                                                <?php echo $key_tk_tickets['TICKET_DESCR'] ?>
                                                    
                                                </option>
                                                <?php
                                            }
                                            ?>
                                            
                                            <?php
                                        }
                                    ?>
                                </select>
                                    </td>
                                </tr>
                                
                                <?php
                            }
                         ?>

                           <tr>
                           <td><label>Date déclaration</label></td>
                           </tr>

                           <tr>
                           <td>
                               <input type="date" value="<?php echo $datecreation; ?>" onchange="submit_fx()" name="datecreation" id="datecreation" class="form-control">
                           </td>
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
                        
                var map = L.map('map', {
                                        center: [val_cord[0],val_cord[1]],
                                        zoom: info
                                        });
                    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="#">DGPC SI</a>'}).addTo(map);
                    console.log(donnes.length);

                 for (var i = 0; i < (donnes.length-1); i++) { 
                    var donnee = donnes[i].split("<>");
                    ///console.log(donnee);                    

                     var greenIcon = L.icon({
                            iconUrl: donnee[4],
                            shadowUrl: '',

                            iconSize: [15, 20],
                            shadowSize: [15, 20],
                            //iconAnchor:   [22, 94],
                            shadowAnchor: [4, 62],
                            //popupAnchor: [-3, -76]
                            });
                        L.marker([donnee[2], donnee[3]], 
                                 {icon: greenIcon,
                                  title:''+donnee[1]}).addTo(map)
                        .bindPopup("<font color='"+donnee[12]+"'><b>"+donnee[0]+"</b></font><br>----------------------------------------------------<br><b>Déscription:</b> "+donnee[1]+"<b></br>Email : </b> "+donnee[6]+"<br><b>Tél : </b> "+donnee[5]+"<br><b>Province : </b> "+donnee[7]+"</br><b>Nombre de peuple blessé : </b>"+donnee[8]+"</br><b>Nombre de peuple mort : </b>"+donnee[9]+"<br><b>Nombre de police blessé : </b>"+donnee[10]+"<br><b>Nombre de police mort : </b>"+donnee[11]+"<br><b>Ticket : "+donnee[12]);
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
            <!-- /#page-wrapper -->

        </div>
    </div>

</body>
<script type="text/javascript">
    function submit_fx() {
       myform.action = myform.action;
       myform.submit();   
    }


    $(document).ready(function(){

        $('datecreation').Datepicker();
    });
</script>
</html>
