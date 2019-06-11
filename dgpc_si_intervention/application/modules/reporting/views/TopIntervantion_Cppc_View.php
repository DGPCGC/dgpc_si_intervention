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
                                <?=$breadcrumb ?> 
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-9 col-md-9">                                  
                                   <h4 class=""><b>Classement CPPCs par intervention</b></h4>  
                                </div>
                                <div class="col-lg-3 col-md-3" style="padding-bottom: 3px">
                                
                                </div>
                            </div>  
                        </div>
                        <div class="col-md-12">
                            <form method="POST" action="<?= base_url().'reporting/Top_Intervantion_cppc/filtre' ?>" name='myform'> 
                                    
                               
                        <table class="table">
                            <tr>
                                <th>Type</th>
                                <th>Nombre</th>
                                <th>Ordre</th>
                                <th>Annee</th>
                                <th>Trimestre</th>
                                <!-- <th>Mois</th> -->
                                
                            </tr>
                            


                            <tr>
                                <td>
                                   <select name="TY" onchange="reloadDonnees();" class="form-control">
                                    <?php
                                    if ($TY == 1) {
                                        ?>
                                    <option value="1" selected="selected"> Intervention </option>  
                                    <option value="2"> Civil Blesse </option>  
                                    <option value="3"> Civil Mort </option> 
                                    <option value="4"> Policier Blesse </option> 
                                    <option value="5"> Policier Mort </option>  
                                    <?php
                                }
                                    else if ($TY == 2) {
                                ?>
                                <option value="1"> Intervention </option>  
                                    <option value="2" selected="selected"> Civil Blesse </option>  
                                    <option value="3"> Civil Mort </option> 
                                    <option value="4"> Policier Blesse </option> 
                                    <option value="5"> Policier Mort </option>  
                                    <?php
                                }
                                    else if ($TY == 3) {
                                ?>
                                <option value="1"> Intervention </option>  
                                    <option value="2"> Civil Blesse </option>  
                                    <option value="3" selected="selected"> Civil Mort </option> 
                                    <option value="4"> Policier Blesse </option> 
                                    <option value="5"> Policier Mort </option>  
                                   <?php
                                    }
                                    else if ($TY == 4) {
                                ?>
                                <option value="1"> Intervention </option>  
                                    <option value="2"> Civil Blesse </option>  
                                    <option value="3"> Civil Mort </option> 
                                    <option value="4" selected="selected"> Policier Blesse </option> 
                                    <option value="5"> Policier Mort </option>  
                                    <?php
                                }
                                    else if ($TY == 5) {
                                ?>
                                <option value="1"> Intervention </option>  
                                    <option value="2"> Civil Blesse </option>  
                                    <option value="3"> Civil Mort </option> 
                                    <option value="4"> Policier Blesse </option> 
                                    <option value="5" selected="selected"> Policier Mort </option>  
                                   <?php }
                                   else{
                                    echo '<option value="1" selected="selected"> Intervention </option>  
                                    <option value="2"> Civil Blesse </option>  
                                    <option value="3"> Civil Mort </option> 
                                    <option value="4"> Policier Blesse </option> 
                                    <option value="5" > Policier Mort </option> ';
                                   }
                                    ?>

                                    
                                    </select>
                                </td>
                                <td>
                                <select class="form-control" name="nombre" onchange="reloadDonnees()">
                                    <?php
                                    if ($nombre == 5) {
                                   echo '<option selected value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="100000">Tout</option>';
                                    }
                                    elseif ($nombre == 10) {
                                echo '<option  value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="15">15</option>
                                <option value="100000">Tout</option>';
                                    }
                                    elseif ($nombre == 15) {
                                echo '<option  value="5">5</option>
                                <option value="10">10</option>
                                <option selected value="15">15</option>
                                <option value="100000">Tout</option>';
                                    }
                                    else{
                                echo '<option  value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option selected value="100000">Tout</option>';
                                    
                                    }
                                    ?>
                                
                                </select>
                                </td>
                                <td>
                                    <select name="ORD" onchange="reloadDonnees();" class="form-control">
                                    <?php
                                    if ($ORD == 'ASC') {
                                   echo '<option selected value="ASC"> Ascendant</option>
                                   <option value="DESC"> Descendant</option>';
                                    }
                                    else{
                                echo '<option value="ASC"> Ascendant</option>
                                   <option selected value="DESC"> Descendant</option>';
                                    }
                                    ?>
                                   

                                    </select>
                                </td>
                                
                               
                                <td>
                                    <select name="YEAR" onchange="reloadDonnees();" class="form-control">
                                        <?php
                                        foreach ($data_annee as $key) {
                                            if ($key['yea'] == $YEAR ) {
                                        ?>
                                        <option selected value="<?= $key['yea'] ?>"> <?= $key['yea'] ?></option>
                                        <?php
                                            }
                                            else{
                                                ?>
                                        <option value="<?= $key['yea'] ?>"> <?= $key['yea'] ?></option>
                                           <?php }
                                                
                                                   
                                        }
                                        ?>
                                    </select>
                                </td>



                        

                            
                                <td>
                                    <select class="form-control" name="trimestre" id="trimestre" onchange="reloadDonnees()">
                                    <option value="">-sélectionner-</option>
                                       <?php
                                        $pr=$de=$tr=$qu="";
                                        if($data_mois != null){
                                        foreach ($data_mois as $value) {
                if($value['moi'] == '1' || $value['moi'] == '2' || $value['moi'] == '3'){
                                        if($trim_s == '1'){
                                        $pr="<option value='1' selected>1<sup>er</sup> trimestre</option>";
                                        }else{
                                         $pr="<option value='1'>1<sup>er</sup> trimestre</option>";  
                                        }
                                         
                                        }
                if($value['moi'] == '4' || $value['moi'] == '5' || $value['moi'] == '6'){
                                         if($trim_s == '2'){
                                            $de="<option value='2' selected>2<sup>ème</sup> trimestre</option>";
                                         }else{
                                         $de="<option value='2'>2<sup>ème</sup> trimestre</option>";
                                          }
                                         }
                if($value['moi'] == '7' || $value['moi'] == '8' || $value['moi'] == '9'){
                                        if($trim_s == '3'){
                                         $tr="<option value='3' selected>3<sup>ème</sup> trimestre</option>";
                                          }else{
                                           $tr="<option value='3'>3<sup>ème</sup> trimestre</option>"; 
                                          }
                                         }
                if($value['moi'] == '10' || $value['moi'] == '11' || $value['moi'] == '12'){
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
                            </tr>

                            <?php

                            echo form_close();

                            ?>

                        </table>
                         </form>
                    </div>
                        <div id="container"></div>
                       
                    </div>

                    </div>
           <!-- </div> -->

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
        text: '<?php echo $stitre; ?>'
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
            name: ' <?php echo $labelt; ?> (<?php echo $totalinterv;?>) ',
            data:

             [<?php echo $nombreintervention; ?>]
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
<script type="text/javascript">
    function reloadDonnees() {
        myform.action = myform.action;
        myform.submit();
    }
</script>

</html>