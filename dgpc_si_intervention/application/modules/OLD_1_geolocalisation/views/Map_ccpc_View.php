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
                               <form name="myform" method="POST" id="myform" action="<?php echo base_url('geolocalisation/Map/map_cppc') ?>" >

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

                                   <div class="col-lg-4 col-md-4">
                                  CPPC<br>
                                   <select name="CPPC_ID[]" id="CPPC_ID" class="form-control selectpicker" multiple data-live-search="true" data-actions-box="true">
                                  
                                   <?php
                                  
                                    foreach ($rh_cppc as $keyrh_cppc) {
                                     
                                        # code...
                                        if(in_array($keyrh_cppc['CPPC_ID'], $CPPC_ID)){
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
                                  </div>

                                   <?php
                                      if($tickets){
                                        ?>
                                        <div class="col-lg-4 col-md-4">
                                  Ticket<br>
                                  <select name="TICKET_ID[]" class="form-control selectpicker" multiple data-live-search="true" data-actions-box="true">
                                      <?php
                                      foreach ($CPPC_ID as $key => $value) {
                                        # code...\
                                         $provi=$this->Model->getOne('rh_cppc',array('CPPC_ID'=>$value));
                                         ?>
                                          <optgroup label ="<?= $provi['CPPC_DESCR'] ?>">
                                          <?php
                                          $tk_ticket=$this->Model->getList('tk_ticket',array('CPPC_ID'=>$value));
                                      
                                        foreach ($tk_ticket as $key_tk_ticket) {
                                         
                                         
                                          if(in_array($key_tk_ticket['TICKET_ID'],$TICKET_ID)){
                                         ?>
                                          <option value="<?=$key_tk_ticket['TICKET_ID']?>" selected><?=$key_tk_ticket['TICKET_DESCR']?></option>
                                         <?php  
                                        }
                                        else{
                                          ?>
                                           <option value="<?=$key_tk_ticket['TICKET_ID']?>" ><?=$key_tk_ticket['TICKET_DESCR']?></option>

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
                                    Date déclaration<br>
                                    <input type="date" value="<?php echo $datecreation; ?>" name="datecreation" id="datecreation" class="form-control">
                                
                                  </div>
                                  <div class="col-lg-4 col-md-4">
                                    .<br>
                                    <button class="btn btn-primary"><font class="fa fa-search"></font>Rechercher</button>
                          
                                
                                  </div>

                                   <?php //print_r($tickets); ?>
                               </form>
            
                                  
                                  
                                </div>
                            </div>  
                        </div> 


        <div class="col-lg-12 jumbotron" style="padding: 5px">
            
             <div class="col-lg-12">

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

                            iconSize: [20, 25],
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

<script>  
  $(document).ready(function(){

    $('#CPPC_ID').change(function(){
    var id=$('#CPPC_ID').val();
    $.ajax({
            url:"<?php echo base_url() ?>geolocalisation/Map/ajouter_Ticket",
            method:"POST",
            //async:false,
            data: {id:id},
            success:function(data)
          { 
            $('#ticket').html(data); 
            $('#ticket').selectpicker('refresh');
          }
          });
    });
  });
</script>

</html>
