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
                                   <h4 class=""><b><?=$title?></b></h4>  
                                </div>
                                <div class="col-lg-3 col-md-3" style="padding-bottom: 3px">
                                 
                                    
                                </div>
                            </div>  
                        </div>
                        <form method="POST" action="<?= base_url().'reporting/Intervantion_cppc/filtre' ?>" name='myform'>
                                    
                    <div class="col-md-12">
                                           <table class="table">
                            <tr>
                                <th>Annee</th>
                                <th>Mois</th>
                            </tr>
                            


                            <tr>
                                <td>
                                    <select name="YEAR" onchange="reloadDonnees();" class="form-control">
                                        <option selected value="">Selectionner</option>
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
                                    <select class="form-control" name="MOIS" onchange="reloadDonnees()">
                                        <option selected value="">Selectionner</option>
                                        <?php
                                        foreach ($lesnombres as $key ) {
                                            if ($key['moi']<10) {
                                                $NMOIS= '0'.$key['moi'];
                                                }
                                                else{
                                                $NMOIS= $key['moi'];
                                                }
                                            if($MOIS==$key['moi']){
                                                ?>
                                                <option selected value="<?= $key['moi'] ?>"><?= $YEAR ?>/<?= $NMOIS ?></option>

                                                <?php
                                            }else{
                                                ?>
                                                <option value="<?= $key['moi'] ?>"><?= $YEAR ?>/<?= $NMOIS ?></option>

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

<script type="text/javascript">
    function reloadDonnees() {
        myform.action = myform.action;
        myform.submit();
    }
</script>

</html>