<!DOCTYPE html>
<html lang="en">
<title></title>

<head>
<?php
   include VIEWPATH.'includes/header.php' 
?>

  <style>
            #map {
                width: 100%;
                height:80%;
            }



            #box1{
    max-width: 20em;
    /*height: 20em;*/
    padding: 1em;
    margin: auto;
    border: 0.062em solid #999;
    background-color: #fff;
    overflow: auto;
    /*direction: rtl;*/
    text-align: right;
}
            
 
</style>

<script type="text/javascript">
    function initialize() {

                        var info='<?php echo $zooms; ?>';
                        var cordon='<?php echo $coordCenter; ?>';
                        var val_cord=cordon.split(",");
                        var liste_don='<?php echo $listdata; ?>';
                        var donnes=liste_don.split("#");
                        var itineraires = '[<?php echo "$itineraires"; ?>]'
                        
                        var map = L.map('map', {
                          center: [val_cord[0],val_cord[1]],
                          zoom: info
                                                });

                       L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {// La Map de fond. localisation anterieurement definie par center: [-3.37972,29.365]
                        attribution: '&copy; <a href="#">DGPC SI</a>'
                                                    }).addTo(map);

                       itineraires=itineraires.replace("'","");

                                                    console.log(itineraires);

                                                    // [-3.39014,29.3595],[-3.37416,29.3601],[-3.39014,29.3595],[-3.37416,29.3601]

                                                   //var ligne=L.polyline([[-3.39014,29.3595],[-3.37416,29.3601],[-3.97315,29.4382],[-3.4288,29.9249]]);
                                                  var ligne=L.polyline([<?php echo $itineraires; ?>]);
                                                   //ligne.addTo(map);


                                    for (var i = 0; i < donnes.length; i++) {
                                                    

                                                        var currentSA = donnes[i].split("<>"); // => produit un tqbleau de 8 colonnes contenant tous les details de l'ATM

                                                         if(currentSA[0]==1){
                                                            window.setTimeout(currentSA[4],50);
                                                         }

                                                        
                                                        var IconFixe = currentSA[4];
                                                        var BPSIcon = L.Icon.extend({
                                                            options: {
                                                                shadowUrl: '',
                                                                iconSize: [20, 25],
                                                                //shadowSize: [50, 64],
                                                                //iconAnchor:   [22, 94],
                                                                //shadowAnchor: [4, 62],
                                                                //popupAnchor: [-3, -76]
                                                            }
                                                        });



                                                   

                                                 var Icone = new BPSIcon({iconUrl: currentSA[4]});
                                                         
                                                        L.marker(
                                                                [currentSA[2], currentSA[3]],
                                                                {icon: Icone,
                                                                title: "DESCRIPTION : "+currentSA[1],
                                                                    opacity: 2.5

                                                                }
                                                        )

                                                         .addTo(map)

                                                         .bindPopup("<b>"+currentSA[9]+"</b></br>__________________________</br><b>DESCRIPTION</b> : "+currentSA[1]+"<br><b>DECLARANT</b> : "+currentSA[8]);

                                                         // var startpopup = L.popup({
                                                         //                closeButton: true,
                                                         //                autoClose: true,
                                                         //                keepInView: true
                                                         //                })
                                                         //                .setLatLng([currentSA[2], currentSA[3]])
                                                         //                .setContent("<b>"+currentSA[9]+"</b></br>__________________________</br><b>DESCRIPTION</b> : "+currentSA[1]+"<br><b>DECLARANT</b> : "+currentSA[8])
                                                         //                .openOn(map);
                                                     }

                                                  }
                                              </script>
                                              </head>

<body onload="initialize()">
    <div class="container-fluid" style="background-color: white">
         
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 5px" id="navp">
           
              <?php include VIEWPATH.'includes/menu_principal.php'?>
                
            </nav>

           

            <!-- Page Content -->
            <?php 

              $map = 'active';
            ?>
                 <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                               
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b> </b></h4>  
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px; float: right;">
                            
                                 
                                </div>
                            </div>  
                        </div>


                        <form name="myform" id="myform" method="POST" action="<?= base_url('geolocalisation/Carte_cppc/index') ?>"  >
                          
                        
                        
                        
                    <div class="col-md-12 jumbotron" style="padding: 5px">          
                      <div class="content">
                      
                      <div class="col-md-4">
                          
                       
                        <table class="table table-striped table-hover" >
                          <tr>
                            <td><label>Province</label></td>
                            <td colspan="2"><select onchange="submit_fx()" name="PROVINCE_ID" class="form-control">
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
                          <?php 
                            if($PROVINCE_ID>0){
                              ?>

                               <tr>
                            <td><label>Commune</label></td>
                            <td colspan="2"><select onchange="submit_fx()" name="COMMUNE_ID" class="form-control">
                              <option disabled selected>--- Sélectionner ---</option>
                              <?php 
                              $ststm_communes=$this->Model->getList('ststm_communes',array('PROVINCE_ID'=>$PROVINCE_ID));
                              foreach ($ststm_communes as $keys) {
                                # code...
                                if($COMMUNE_ID==$keys['COMMUNE_ID']){
                                  ?>
                                  <option selected value="<?= $keys['COMMUNE_ID'] ?>"><?= $keys['COMMUNE_NAME'] ?></option>
                                  <?php
                                }else{
                                  ?>
                                    <option value="<?= $keys['COMMUNE_ID'] ?>"><?= $keys['COMMUNE_NAME'] ?></option>
                              
                                  <?php
                                }
                                ?>
                                <?php

                              }
                               ?>
                            </select></td>
                          </tr>

                              <?php
                            }
                           ?>
                           
                           
                           <tr>
                            <th class="bg-primary" colspan="3"><center>Legende</center></th>
                          </tr>
                          <tr>
                            <th>CPPC (Nombre : <?= $nb_cppc; ?>)</th><td style="background: ;"><input name="chk1" onchange="submit_fx()" <?= $checked; ?> type="checkbox"  value="1" name=""></td>
                             <td class="input-sm"> <label style="width: 20px; background: green"><font color="green">In</font></label></td> 
                          </tr>
                          <tr style="background:">
                            <th>Ticket (Nombre : <?= $nb_tick; ?>)</th><td><input name="chk2" onchange="submit_fx()" <?= $checked2; ?> type="checkbox" value="0" name=""></td>
                            <td class="input-sm"> <label style="width: 20px; background: red"><font color="red">In</font></label></td> 
                          </tr>
                          <tr>
                            <td></td><td></td><td></td>
                          </tr>
                          
                          
                        </table>

                        <div id="box">
                        
                        <table class="table table-striped table-hover table-bordered" id="id_table" >
                            <thead>
                              <th>Date</th>
                              <th>Description ticket</th>
                              <th>CPPC</th>
                              <th>Mort(s) / Blessé(s)</th>
                            </thead>
                            <tbody>

                              <?php
                              foreach ($tk_ticket as $key) {
                                 # code...
                                $rh_cppc=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$key['CPPC_ID']));
                                ?>
                                <tr>
                                  <td><?= $key['DATE_INSERTION'] ?></td>
                                  <td><?= $key['TICKET_DESCR'] ?></td>
                                  <td>
                                    <?= $rh_cppc['CPPC_DESCR'] ?>
                                  </td>
                                <td><?= $key['NOMBRE_MORT']." / ".$key['NOMBRE_BLESSE'] ?></td> 
                                </tr>
                                <?php
                               } 
                                ?>
                            </tbody>
                        </table>
                         </div>
                      </div>
                      <div class="col-md-8">
                        <div class="horizontal">
                        <div class="" align='center'>
                            
                            <div id="map" style="width: 100%;height: 600px"></div>
                          </div>
                      </div>
                      </div>
                      
                      </div>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
              <script type="text/javascript">
                function submit_fx() {
                  // body...
                  myform.submit();
                }
              </script>

               <script>
    $(document).ready(function () {
        $('#id_table').DataTable({
            responsive: false,

            dom: "<'row'<'col-sm-4'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            searching:false,
            buttons: [
                
                'excelHtml5',
                'csvHtml5',
            ],

            aLengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "All"]
            ],
            iDisplayLength: 5,
            "order": [[0, "desc"]],

            "language": {
                "lengthMenu": "_MENU_ ",
            }


        });
    });
</script>

           </body></html>
                            


