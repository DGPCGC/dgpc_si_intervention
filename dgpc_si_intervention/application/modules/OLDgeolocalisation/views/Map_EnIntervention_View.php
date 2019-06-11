<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>

<script>           
      function SendNotificationSound(bip){
       //alert(bip);
      if (bip==1){
       // alert(bip);
        notification.play();
      }
    }
</script>

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script> 


</head>
<audio id="notification">
    <source src="<?=base_url()?>sounds/alarm.wav"></source>
    <!--Bip d'alerte en cas de probleme-->
</audio>

<div>

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
                                   <h4 class=""><b><?=$title?></b></h4>  
                                </div>
                                <div class="col-lg-7 col-md-7" style="padding-bottom: 3px">
                                <form action="<?=base_url().'geolocalisation/Map/enintervention'?>" name="myform" method="POST"> 
                                  <div class="col-lg-4 col-md-4">
                                  <label>Canal</label><br>
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

                                  <label>Cause</label><br>
                                  <select name="CAUSE_ID[]" class="form-control selectpicker" multiple data-live-search="true" data-actions-box="true" >
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
                                  <label>Province</label><br>

                                  <select id="PROVINCE_ID" name="PROVINCE_ID[]" class="form-control selectpicker" multiple data-live-search="true" data-actions-box="true">
                                    
                                <?php
                                $ststm_provinces=$this->Model->getList('ststm_provinces',array());
                                      
                                foreach($ststm_provinces as $prov){
                                  if(in_array($prov['PROVINCE_ID'], $PROVINCE_ID)){
                                    ?>
                                     <option selected value="<?=$prov['PROVINCE_ID']?>"><?=$prov['PROVINCE_NAME']?></option>
                               
                                    <?php
                                  }else{
                                    ?>
                                     <option value="<?=$prov['PROVINCE_ID']?>"><?=$prov['PROVINCE_NAME']?></option>
                               
                                    <?php
                                  }
                                  
                                ?>
                                
                                <?php
                                }
                                ?>
                                </select>


                                
                                  </div>

                                  <div class="col-lg-4 col-md-4">
                                    <label>Commune</label>
                                  <select name="COMMUNE_ID[]" class="form-control selectpicker" multiple data-live-search="true" data-actions-box="true">
                                      <?php
                                      foreach ($PROVINCE_ID as $key => $value) {
                                        # code...\
                                         $provi=$this->Model->getOne('ststm_provinces',array('PROVINCE_ID'=>$value));
                                         ?>
                                          <optgroup label ="<?= $provi['PROVINCE_NAME'] ?>">
                                          <?php
                                          $ststm_communes=$this->Model->getList('ststm_communes',array('PROVINCE_ID'=>$value));
                                      
                                        foreach ($ststm_communes as $key_ststm_communes) {
                                         
                                         
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

                                  <div class="col-lg-4 col-md-4">
                                  <label>Date</label><br>
                                  <input type="text" name="DATE"  class="form-control" value="<?= $DATE ?>"  id="datecreation">
                                  
                                  </div>

                                  <div class="col-lg-4 col-md-4">
                                    <br>
                                  <button type="submit" class="btn btn-primary"> <span class="fa fa-search"></span> Rechercher</button>
                                  
                                  </div>
                                </form>

                                  
                                  
                                </div>
                            </div>  
                        </div> 


        <div   class="col-lg-12 jumbotron" style="padding: 5px">
          <div class="col-lg-9 col-md-9">
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
                    console.log(donnee[4]);                    

                     var greenIcon = L.icon({
                            iconUrl: donnee[4],
                            shadowUrl: '',

                            iconSize: [33, 37],
                            shadowSize: [50, 64],
                            iconAnchor:   [22, 94],
                            shadowAnchor: [4, 62],
                            popupAnchor: [-3, -76]
                            });
                        L.marker([donnee[2], donnee[3]], 
                                 {icon: greenIcon,
                                  title:'Incident '+donnee[1]}).addTo(map)
                        .bounce(0)
                        .bindPopup("<font color='"+donnee[12]+"'>INCIDENT <b>"+donnee[1]+"</b></font><br>------------------------------------<br><b>Code intervention</b> "+donnee[5]+"<br><b>Canal</b> "+donnee[9]+"<br><b>Cause </b> "+donnee[10]+"<br><b>Localite</b> "+donnee[6]+"<br> <b>Ticket ouvert le</b> "+donnee[7]+"<br><b>Déclarant</b> "+donnee[8]);
                    }     
                </script>
                </div>
            </div>
           </div>
        </div>
        <div class="col-lg-3 col-md-3">

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
        </div>

        
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
             

</body>
</div>
  
  <script type="text/javascript">

    $(document).ready(function(){

      $('#PROVINCE_ID').change(function(){
    var id=$('#PROVINCE_ID').val();
   // alert(id);
 
                            $.ajax({
                            url:"<?php echo base_url() ?>geolocalisation/Map/ajouter_commune",
                            method:"POST",
                            //async:false,
                            data: {id:id},
                                                                                 
                            success:function(data)
                                                {  
                                
                                                   $('#commune').html(data); 

                                                $('#commune').selectpicker('refresh');                                                    }
                            });
    
 

});

    });
    
    

  </script>

<script type="text/javascript">
    function reload_map() {
       myform.action = myform.action;
       myform.submit();   
    }

    function reload_Map(){
      myform1.action=myform1.action;
      myform1.submit();
    }


    $(document).ready(function(){

      setInterval(function(){
      $.ajax({
              url:"<?php echo base_url() ?>geolocalisation/Map/Bruit_carte",
              method:"POST",
              success:function(data){  
                if(data==1){
                  SendNotificationSound(1);
                  window.location.href="<?= base_url('geolocalisation/Map/enintervention/1') ?>";

                  }//else{
                  //window.location.href="<?= base_url('geolocalisation/Map/enintervention') ?>";
               
                //}
                              
                }
            });

    },15000);

    });

     
</script>


<script type="text/javascript">
  $(document).ready(function(){

        $('#datecreation').datepicker({
          format: 'dd-mm-yyyy'
        });
    });
</script>



</html>
