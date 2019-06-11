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
            <!-- <div id="page-wrapper"> -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                           
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-9 col-md-9">                                  
                                   <h4 class=""><b><?=$title?></b></h4>  
                                </div>
                                <div class="col-lg-3 col-md-3" style="padding-bottom: 3px">
                                 
                                    
                                </div>
                            </div>  
                        </div>
                        <form method="POST" action="<?= base_url().'reporting/Cppc_Intervantion/' ?>" name='myform'>
                                    
                    <div class="col-md-12">
                                      <table class="table"">
                            <tr>
                                <th>Année</th>
                                <th>Trimestre</th>
                                <th>Mois</th>
                            </tr>
                            


                            <tr>
                                <td style="margin-left: 200px">
                                  <select class="form-control" name="annee" onchange="envoyer(this)">
                                    <option value="">--Sélectionner--</option>
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
                                </td>

                                
                                
                               
                                

                                <td>
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
                                </td>



                            <td>

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
                                 
                                </td>

                        

                            </tr>

                            <?php

                            echo form_close();

                            ?>

                        </table>
                         </form>
                    </div>
                        <div id="container"></div>
                       
                    </div>

                    <!-- </div> -->
           </div>

</body>
<script type="text/javascript">

Highcharts.chart('container', {

  chart: {
                type: 'column'
            },
            title: {
        text: '<?php echo $titre; ?>'
    },
            subtitle: {
        text: 'Rapport du <?= date('d-m-Y')?> ' 
    },
            credits:{
              enabled: false
            },

            yAxis: {
        title: {
            text: '<?php echo $ytitre; ?>'
        }
    },

            exporting: {
              enabled: true
            },
            legend: {
              enabled: true
            },
            xAxis: {
                type: 'category'
            },
            tooltip: {
                pointFormat: '{series.name}: {point.y}<br>',
                // valueSuffix: ' BIF',
                shared: true
            },

            plotOptions: {
                column:{
                    dataLabels:{
                        enabled: true
                    }
                },
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                },
                series: {
                    cursor: 'pointer',
                }
            },
    series: [{
            name: 'Nombre d\'intervation (<?php echo $totalinterv; ?>)',
            data:

             [<?php echo $nombreintervention; ?>]
           },
           {
            name: 'Nombre de civils blessés (<?php echo $ttotalble; ?>)',
            data:

             [<?php echo $nombreblesse; ?>]
           },
           {
            name: 'Nombre de civils mort (<?php echo $ttotalmort; ?>)',
            data:

             [<?php echo $nombremort; ?>]
           },
           {
            name: 'Nombre de Policiers blessés (<?php echo $tPtotalble; ?>)',
            data:

             [<?php echo $Pnombreblesse; ?>]
           },
           {
            name: 'Nombre de Policiers mort (<?php echo $tPtotalmort; ?>)',
            data:

             [<?php echo $Pnombremort; ?>]
           }
           
           
           
           ],
           
    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});
    </script>


<script>
   function envoyer(){
       
           myform.submit();
       
   }
</script>

</html>