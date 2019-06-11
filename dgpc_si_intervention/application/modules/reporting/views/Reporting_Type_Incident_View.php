<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>

<script>
   function envoyer(){
       
           myform.submit();
       
   }
</script>
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
            <div id="">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                                
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b> </b></h4>  
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                    <?php //include 'menu_collaborateur.php' ?>
                                </div>
                            </div>  
                        </div> 

                  <div id="" class="col-md-12 jumbotron" style="padding: 5px">
                       <div class="col-md-12">
                           <form class="col-md-12" name='myform' action="<?= base_url('reporting/Rapport_Type_Incidents')?>" method="post">




               
                                  <div class="col-md-3" style="">
                                 <div class="form-group">
                                    <label>Année</label>
                                    <select class="form-control" name="annee" onchange="envoyer(this)">
                                    <option value="">-sélectionner-</option>
                                        <?php
                                            for ($i=0; $i<= count($year); $i++) {
                                              if($year[$i]['year'] != ""){
                                                if($year[$i]['year'] == $year_s){
                                                   echo "<option value='".$year[$i]['year']."' selected>".$year[$i]['year']."</option>";
                                                }else{
                                                   echo "<option value='".$year[$i]['year']."'>".$year[$i]['year']."</option>";
                                                }
                                              }
                                            }
                                        ?>
                                    </select>
                                 </div>
                              </div>




                                                              <div class="col-md-3">
                                 <div class="form-group">
                                   <label>Trimestre</label>
                                <select class="form-control" name="trimestre" id="trimestre" onchange="envoyer(this)">
                                    <option value="">-sélectionner-</option>
                                       <?php
                                        $pr=$de=$tr=$qu="";
                                        if($moiss != null){
                                        foreach ($moiss as $value)
                                         {

                       if($value['year'] == '1' || $value['year'] == '2' || $value['year'] == '3'){
                                        if($trim_s == '1'){
                                        $pr="<option value='1' selected>1<sup>er</sup> trimestre</option>";
                                        }else{
                                         $pr="<option value='01'>1<sup>er</sup> trimestre</option>";  
                                        }
                                         
                                        }
                      if($value['year'] == '4' || $value['year'] == '5' || $value['year'] == '6'){
                                         if($trim_s == '2'){
                                            $de="<option value='2' selected>2<sup>ème</sup> trimestre</option>";
                                         }else{
                                         $de="<option value='2'>2<sup>ème</sup> trimestre</option>";
                                          }
                                         }
                        if($value['year'] == '7' || $value['year'] == '8' || $value['year'] == '9'){
                                        if($trim_s == '3'){
                                         $tr="<option value='3' selected>3<sup>ème</sup> trimestre</option>";
                                          }else{
                                           $tr="<option value='3'>3<sup>ème</sup> trimestre</option>"; 
                                          }
                                         }
                if($value['year'] == '10' || $value['year'] == '11' || $value['year'] == '12'){
                                        if($trim_s == '4'){
                                            $qu="<option value='4' selected>4<sup>ème</sup> trimestre</option>";
                                        }else{
                                            $qu="<option value='4' >4<sup>ème</sup> trimestre</option>";
                                        }
                                         }
                                        }
                                       }
                                       if($pr != ""){echo $pr;}
                                       if($de != ""){echo $de;}
                                       if($tr != ""){echo $tr;}
                                       if($qu != ""){echo $qu;}
                                       ?>
                                    </select>
                                 </div>
                              </div>



                 
                              <div class="col-md-3">
                                  <div class="form-group">
                                    <label>Mois</label>
                                    
                                    <select class="form-control" name="mois" onchange="envoyer(this)">
                                    <option value="">-Sélectionner-</option>
                                        <?php
                                            if($moiss != null){
                                                foreach ($moiss as $value) {
                                                    if($value['year'] == '1'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='01' selected>Janvier</option>";
                                                       }else{
                                                       echo "<option value='01'>Janvier</option>";     
                                                       }
                                                    }
                                                    else if($value['year'] == '2'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='02' selected>Février</option>";
                                                       }else{
                                                         echo "<option value='02'>Février</option>";  
                                                       }
                                                    }else if($value['year'] == '3'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='03' selected>Mars</option>";
                                                       }else{
                                                          echo "<option value='03'>Mars</option>"; 
                                                       }
                                                    }else if($value['year'] == '4'){
                                                        if($value['year'] == $mois_s){
                                                 echo "<option value='04' selected>Avril</option>";
                                                       }else{
                                                  echo "<option value='04'>Avril</option>";         
                                                       }
                                                    }else if($value['year'] == '5'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='05' selected>Mai</option>";
                                                       }else{
                                                    echo "<option value='05'>Mai</option>";       
                                                       }
                                                    }else if($value['year'] == '6'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='06' selected>Juin</option>";
                                                       }else{
                                                    echo "<option value='06'>Juin</option>";       
                                                       }
                                                    }else if($value['year'] == '7'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='07' selected>Juillet</option>";
                                                       }else{
                                                    echo "<option value='07'>Juillet</option>";       
                                                       }
                                                    }else if($value['year'] == '8'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='08' selected>Aout</option>";
                                                       }else{
                                                    echo "<option value='08'>Aout</option>";       
                                                       }
                                                    }else if($value['year'] == '9'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='09' selected>Septembre</option>";
                                                       }else{
                                                  echo "<option value='09'>Septembre</option>";
                                                       }
                                                    }else if($value['year'] == '10'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='10' selected>Octobre</option>";
                                                       }else{
                                                    echo "<option value='10'>Octobre</option>";     
                                                       }
                                                    }else if($value['year'] == '11'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='11' selected>Novembre</option>";
                                                       }else{
                                                     echo "<option value='11'>Novembre</option>";      
                                                       }
                                                    }else if($value['year'] == '12'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='12' selected>Décembre</option>";
                                                       }else{
                                                     echo "<option value='12'>Décembre</option>";      
                                                       }
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                 </div>
                              </div>




 
                          <div class="col-md-3">
                                 <div class="form-group">
                                    <label>CPPC</label>
                        <select class="form-control" name="CPPC_ID" onchange="envoyer(this)">

                         <option value="">-Sélectionner-</option>

                             
                            <?php foreach($cppc as $cp)
                              {
                               if($cp['CPPC_ID']==$CPPC_ID) { ?>
                           
                              <option value="<?php echo $cp["CPPC_ID"];?>" selected><?php echo $cp["CPPC_NOM"];?></option>
                                 <?php 
                            } 
                              else{ ?>

                            <option value="<?php echo $cp["CPPC_ID"];?>" ><?php echo $cp["CPPC_NOM"];?></option>

                             <?php
                              } }
                             ?>

                                    </select>
                                 </div>
                              </div>


                          




                
                         
                           </form>

                           <div id="container">
                           </div>
                       </div>
                  </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
    </div>

</body>
<script type="text/javascript">
      

// Build the chart
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: '<b>Rapport sur les types d\'incidents</b>'
    },
    subtitle: {
         text: 'Rapport du <?= date('d-m-Y')?> <br><br><b>Total d\'incidents: <?php echo $incid_total; ?>  Incidents</b>' 
    },


     credits: {
        enabled: false,
        href: "http://www.mediabox.bi",
        text: "Source Mediabox"
    },
   


    exporting: {
        enabled: true
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y:,.0f} Incident(s)</b>'
    },



     plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '{point.name}: <b>{point.y:,.0f} Incident(s)</b>',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                },
                connectorColor: 'silver'
            }
        },
        series: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function ()
                            {
                                //location.href='http://127.0.0.1/brarudi_cantine/index.php/courriers/listes';
                                // var mywindow = window.open("http://127.0.0.1/brarudi_cantine/index.php/Accueil/details_autorisation/" + this.options.key+"/"+0+"/"+0+"/"+0+"/"+0+"/"+0+"/", "_blank", "width=1000,height=600,scrollbars=yes,toolbar=no,resizable=yes,left=500,right=500");
                            }
                        }
                    }
                }
    },




    series: [{
        name: 'Nombre',
        data: <?php echo $datas; ?>
    }]
});


        </script>


      <script>
            $(function () {
                $("#date").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    format: 'yyyy-mm-dd',
                    startDate:'1950-01-01',
                    minDate: new Date(),
                    todayHighlight: true,
                    autoclose: true
                });




            });

    </script>



</html>