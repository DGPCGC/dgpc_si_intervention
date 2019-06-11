<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
</head>

<script type="text/javascript">
    

</script>
<body>
    <div class="container-fluid" style="background-color: white">
        
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 5px" id="navp">
                <!-- /.navbar-top-links -->
                <?php include VIEWPATH.'includes/menu_principal_test.php' ?>
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
                                   <h4 class=""><b><?=$title?></b></h4>  
                                </div>
                                <div class="col-lg-7 col-md-7" style="padding-bottom: 3px">
                               
                                  
                                  
                                </div>
                            </div>  
                        </div> 


        <div class="col-lg-12 jumbotron" style="padding: 5px">
            <div class="col-lg-9 col-md-9">
           <div class="content">
             
            <div class="horizontal">
                <div class="" align='center'>
                   <div id="map" style="width: 100%;height: 600px">

                   
                       
                   </div>  
              <script>




                var info='<?php echo $zooms; ?>';
                var cordon='<?php echo $centerCoord; ?>';
                // alert(cordon);
                var val_cord=cordon.split(",");
                var liste_don='<?php echo $list_data; ?>';
                var donnes=liste_don.split("#");

                //alert(liste_don);
                        
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

                            iconSize: [20, 26],
                            shadowSize: [50, 64],
                            iconAnchor:   [22, 94],
                            shadowAnchor: [4, 62],
                            popupAnchor: [-3, -76]
                            });
                        L.marker([donnee[2], donnee[3]], 
                                 {icon: greenIcon,
                                  title:''+donnee[0]}).addTo(map)
                        
                        .bounce(donnee[6])
                        
                        
                        .bindPopup("<font color='"+donnee[12]+"'><b>"+donnee[0]+"</b></font><br>----------------------------------------------------<br><b>Description:</b> "+donnee[0]+"<b></br><b>Localité:</b> "+donnee[7]+"<b></br>Longitude: </b> "+donnee[3]+"<br><b>Latitude</b> "+donnee[2]+"<br><b>Date catastrophe</b> "+donnee[5]+"<br><b>Date saisie</b> "+donnee[8]+"<br><b>Déclarer par :</b>"+donnee[1]);
                    }     
                </script>
                </div>
            </div>
           </div>
           </div>
           <div class="col-lg-3 col-md-3">

                <div class="row" style="margin-bottom: 20px">
                <form action="<?=base_url().'geolocalisation/Map/map_cata'?>" name="myform" method="POST">
                    <div class="col-lg-12 col-md-12">
                        <label>Rechercher par:</label><br>
                        <input type="radio" name="check" id="check" value="1" onclick="show_agent()" checked=""> Agent

                        <input type="radio" name="check" id="check" value="2" onclick="show_localite()"> Localité
                    </div>
                    <div class="col-lg-12 col-md-12" id="agent">
                    <label>Agent</label>
                    <select name="AGENT" class="form-control" onchange="reload_map()">
                        <option value=""> - Sélectionner agent- </option>
                            <?php
                                foreach ($agent as $agents) {
                                    ?>
                            <option value="<?=$agents['USER_ODK'] ?>"><?=$agents['USER_ODK'] ?></option>
                                    <?php
                                }
                             ?>          
                    </select>
                    </div>
                    <div class="col-lg-12 col-md-12" id="localite" style="display: none">
                    <label>Localité</label>
                    <select name="LOCALITE" class="form-control" onchange="reload_map()">
                        <option value=""> - Sélectionner localité- </option>
                            <?php
                                foreach ($localite as $localites) {
                                    ?>
                            <option value="<?=$localites['LOCALITE'] ?>"><?=$localites['LOCALITE'] ?></option>
                                    <?php
                                }
                             ?>          
                    </select>
                    </div>
                </form>
                </div>











                  <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="3000">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                      <?=$sildes?> 
                    </div>
                  </div>

                  
                </div>
        </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        

</body>
<script type="text/javascript">
    function reload_map() {
       myform.action = myform.action;
       myform.submit();   
    }

    function show_localite(){
        $("#localite").show();
        $("#agent").hide();
    }
    function show_agent(){
        $("#localite").hide();
        $("#agent").show();
    }
</script>
</html>
