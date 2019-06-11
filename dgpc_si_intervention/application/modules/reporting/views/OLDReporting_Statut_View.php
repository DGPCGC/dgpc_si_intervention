<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
</head>
<body>
    <div class="container-fluid" style="background-color: white">
        <div id="wrapper">
            
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 5px" id="navp">
                
                <?php include VIEWPATH.'includes/menu_principal.php' ?>
               
            </nav>

            
            <!-- <div id="page-wrapper"> -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                               
                             </div>
                            <div class="row" id="conta" style="">
                                 <div class="col-lg-9 col-md-9">      
                                   <h4 class=""><b><?=$title?></b></h4>  
                                </div>
                                    </div>
            <div class="col-md-12">

            <div class="col-md-4" id="container3" style="width: 33%; height: 550px; border: 1px solid #000">

            </div>
            <div class="col-md-4" id="container2" style="width: 33%; height: 550px; border: 1px solid #000">

            </div>
            <div class="col-md-4" id="container1" style="width: 34%; height: 550px; border: 1px solid #000">

            </div>
            </div>
                            </div>  
                        </div>

                        <!-- <div class="col-lg-12 jumbotron" style="padding: 5px">
                           <div class="content">
                            <div class="row" style="height: 200px;margin-bottom: 10px">
                               <div id="canal" style="width: 48%;float: left"></div>   
                               <div id="cause" style="width: 48%;float: right"></div>   
                            </div>
                            <div class="row" style="height: 200px;margin-bottom: 10px">
                               <div id="mort_blesse" style="width: 100%;float: left"></div> 
                            </div>
                            <div class="row" style="height: 200px;margin-bottom: 10px">
                               <div id="mort_blesse_type" style="width: 48%;float: left"></div>
                               <div id="effets_dgpc" style="width: 48%;float: right"></div>     
                            </div>

                           </div>
                        </div> -->
                       <!-- /.container-fluid -->
                    </div>
                   <!-- /#page-wrapper -->

                    <!-- </div> -->
           </div>

</body>
 <script type="text/javascript">
        Highcharts.chart('container1', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '<?php echo $titre1; ?>'
            },subtitle: {
        text: '<?php echo $soustitre;?>'
           },
            credits: {
                enabled: true,
                href: "http://www.mediabox.bi",
                text: ""
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{y} </b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {y} ',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                    name: 'nombre',
                    colorByPoint: true,
                    data: [<?php echo $series1; ?>]
                }]
        });
    </script>
    
    <script type="text/javascript">
        Highcharts.chart('container2', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '<?php echo $titre2; ?>'
            },subtitle: {
        text: '<?php echo $soustitre;?>'
           },
            credits: {
                enabled: true,
                href: "http://www.mediabox.bi",
                text: ""
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{y} </b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {y} ',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                    name: 'nombre',
                    colorByPoint: true,
                    data: [<?php echo $series2; ?>]
                }]
        });
    </script>
    
    <script type="text/javascript">
        Highcharts.chart('container3', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '<?php echo $titre3; ?>'
            },subtitle: {
        text: '<?php echo $soustitre;?>'
           },
            credits: {
                enabled: true,
                href: "http://www.mediabox.bi",
                text: ""
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {y} ',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                    name: 'nombre',
                    colorByPoint: true,
                    data: [<?php echo $series3; ?>]
                }]
        });
    </script>
</html>