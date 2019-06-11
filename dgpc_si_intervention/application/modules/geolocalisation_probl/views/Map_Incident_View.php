<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script> 
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
                                   <h4 class=""><b><?=$title?></b></h4>  
                                </div>
                                <div class="col-lg-7 col-md-7" style="padding-bottom: 3px">
                                <form action="<?=base_url().'geolocalisation/Map/index'?>" name="myform" method="POST"> 

                                  <div class="col-lg-4 col-md-4">
                                  Province<br>
                                  <select name="PROVINCE_ID[]" class="form-control selectpicker" multiple data-live-search="true" data-actions-box="true">
                                      <?php
                                        foreach ($ststm_provinces as $key_ststm_provinces) {
                                          if(in_array($key_ststm_provinces['PROVINCE_ID'], $PROVINCE_ID)  ){
                                         ?>
                                          <option value="<?=$key_ststm_provinces['PROVINCE_ID']?>" selected><?=$key_ststm_provinces['PROVINCE_NAME']?></option>
                                         <?php  
                                        }
                                        else{
                                          ?>
                                           <option value="<?=$key_ststm_provinces['PROVINCE_ID']?>" ><?=$key_ststm_provinces['PROVINCE_NAME']?></option>
                                         <?php 
                                        }
                                    }
                                      ?>
                                  </select>
                                  </div>

                                  <?php
                                      if($ststm_communes){
                                        ?>
                                        <div class="col-lg-4 col-md-4">
                                  Commune<br>
                                  <select name="COMMUNE_ID[]" class="form-control selectpicker" multiple data-live-search="true" data-actions-box="true">
                                      <?php
                                      foreach ($PROVINCE_ID as $key => $value) {
                                        # code...\
                                         $provi=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$value));
                                         ?>
                                          <optgroup label ="<?= $provi['PROVINCE_NAME'] ?>">
                                          <?php
                                          $ststm_communes1=$this->Model->getList('ststm_communes',array('PROVINCE_ID'=>$value));
                                      
                                        foreach ($ststm_communes1 as $key_ststm_communes) {
                                         
                                         
                                          if(in_array($key_ststm_communes['COMMUNE_ID'],$COMMUNE_ID)){
                                         ?>
                                          <option value="<?=$key_ststm_communes['COMMUNE_ID']?>" selected><?=$key_ststm_communes['COMMUNE_NAME']?></option>
                                         <?php  
                                        }
                                        else{
                                          ?>
                                           <option value="<?=$key_ststm_communes['COMMUNE_ID']?>" ><?=$key_ststm_communes['COMMUNE_NAME']?></option>

                                         <?php 
                                        }
                                        
                                    }
                                    ?>
                                          </optgroup>
                                        <?php
                                  }
                                      ?>

                                  </select>
                                  </div>
                                        <?php
                                      }
                                   ?>

                                  <div class="col-lg-4 col-md-4">
                                  Canal<br>
                                  <select name="CANAL_ID[]" class="form-control selectpicker" multiple data-live-search="true" data-actions-box="true">
                                      <?php
                                        foreach ($canals as $canal) {
                                          if(in_array($canal['CANAL_ID'], $CANAL_ID)){
                                         ?>
                                          <option value="<?=$canal['CANAL_ID']?>" selected><?=$canal['CANAL_DESCR']?></option>
                                         <?php  
                                        }
                                        else{
                                          ?>
                                           <option value="<?=$canal['CANAL_ID']?>" ><?=$canal['CANAL_DESCR']?></option>
                                         <?php 
                                        }
                                    }
                                      ?>
                                  </select>
                                  </div>

                                  <div class="col-lg-4 col-md-4">
                                  Cause<br>
                                  <select name="CAUSE_ID[]" class="form-control selectpicker" multiple data-live-search="true" data-actions-box="true">
                                      <?php
                                        foreach ($causes as $cause) {
                                          if(in_array($cause['CAUSE_ID'], $CAUSE_ID)){
                                         ?>
                                          <option value="<?=$cause['CAUSE_ID']?>" selected><?=$cause['CAUSE_DESCR']?></option>
                                         <?php  
                                        }
                                        else{
                                          ?>
                                           <option value="<?=$cause['CAUSE_ID']?>" ><?=$cause['CAUSE_DESCR']?></option>
                                         <?php 
                                        }
                                    }
                                      ?>
                                  </select>
                                  </div>
                                  <div class="col-lg-4 col-md-4">
                                  Statut<br>
                                  <select name="STATUT_ID[]" class="form-control selectpicker" multiple data-live-search="true" data-actions-box="true">
                                      <?php
                                        foreach ($statuts as $statut) {
                                          if(in_array($statut['STATUT_ID'], $STATUT_ID)){
                                         ?>
                                          <option value="<?=$statut['STATUT_ID']?>" selected><?=$statut['STATUT_DESCR']?></option>
                                         <?php  
                                        }
                                        else{
                                          ?>
                                           <option value="<?=$statut['STATUT_ID']?>" ><?=$statut['STATUT_DESCR']?></option>
                                         <?php 
                                        }
                                    }
                                      ?>
                                  </select>
                                  </div>

                                  <div class="col-lg-4 col-md-4">
                                  Categorie<br>
                                  <select name="CATEGORIE_ID[]" class="form-control selectpicker" multiple data-live-search="true" data-actions-box="true">
                                      <?php
                                        foreach ($tk_categories as $categories) {
                                          if(in_array($categories['CATEGORIE_ID'], $CATEGORIE_ID)){
                                         ?>
                                          <option value="<?=$categories['CATEGORIE_ID']?>" selected><?=$categories['CATEGORIE_DESCR']?></option>
                                         <?php  
                                        }
                                        else{
                                          ?>
                                           <option value="<?=$categories['CATEGORIE_ID']?>" ><?=$categories['CATEGORIE_DESCR']?></option>
                                         <?php 
                                        }
                                    }
                                      ?>
                                  </select>
                                  </div>

                                  <div class="col-lg-4 col-md-4">
                                    .<br>
                                  <button class="btn btn-primary"><span class="fa fa-search"></span> Rechercher</button>
                                  </div>
                                </div>
                            </div>  
                        </div> 


        <div class="col-lg-12 jumbotron" style="padding: 5px">
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

                            iconSize: [20, 26],
                            shadowSize: [50, 64],
                            iconAnchor:   [22, 94],
                            shadowAnchor: [4, 62],
                            popupAnchor: [-3, -76]
                            });
                        L.marker([donnee[2], donnee[3]], 
                                 {icon: greenIcon,
                                  title:'Incident '+donnee[1]}).addTo(map)
                        .bindPopup("<font color='"+donnee[12]+"'>INCIDENT <b>"+donnee[1]+"</b></font><br>------------------------------------<br><b>Code intervention</b> "+donnee[5]+"<br><b>Statut</b> "+donnee[11]+"<br><b>Canal</b> "+donnee[9]+"<br><b>Cause </b> "+donnee[10]+"<br><b>Categorie </b>"+donnee[13]+"<br><b>Localite</b> "+donnee[6]+"<br> <b>Date declaré</b> "+donnee[7]+"<br><b>Déclarant</b> "+donnee[8]);
                    }     
                </script>
                </div>
            </div>
           </div>
        </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            

</body>
<script type="text/javascript">
    function reload_map() {
       myform.action = myform.action;
       myform.submit();   
    }
</script>
</html>
