<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
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
                                 <div class="col-lg-9 col-md-9">                                  
                                   <h4 class=""><b><?=$title?></b></h4>  
                                </div>
                                <div class="col-lg-3 col-md-3" style="padding-bottom: 3px">
                                <form method="POST" action="<?= base_url().'reporting/Dashboard' ?>" name='myform'> 
                                    <select name="MOIS" onchange="reloadDonnees();" class="form-control">
                                        <?php
                                        foreach ($periodes as $key => $value) {
                                            if ($key == $MOIS) {
                                                ?>
                                                <option value="<?= $key ?>" selected> <?= $value ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?= $key ?>"> <?= $value ?></option>

                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <a href="<?= base_url().'reporting/Dashboard'?>" class="">Vider</a>
                                </form>
                                </div>
                            </div>  
                        </div>

                        <div class="col-lg-12 jumbotron" style="padding: 5px">
                           <div class="content">
                            <div class="row" style="height: 200px;margin-bottom: 20px">
                               <div id="canal" style="width: 48%;float: left;border:1px solid #111;"></div>   
                               <div id="cause" style="width: 48%;float: right;border:1px solid #111;"></div>   
                            </div>
                            <div class="row" style="height: 200px;margin-bottom: 20px">
                               <div id="mort_blesse" style="width: 100%;float: left;border:1px solid #111;"></div> 
                            </div>
                            <div class="row" style="height: 200px;margin-bottom: 20px">
                               <div id="mort_blesse_type" style="width: 48%;float: left;border:1px solid #111;"></div>
                               <div id="effets_dgpc" style="width: 48%;float: right;border:1px solid #111;"></div>     
                            </div>

                           </div>
                                    <!-- /.row -->
                        </div>
                       <!-- /.container-fluid -->
                    </div>
</body>
<script>
    // Build the chart
Highcharts.chart('canal', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Répartition des évenements par canal'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    credits: {
                enabled: true,
                href: "#",
                text: "DGPC"
            },
    series: [{
        name: 'Ticket',
        colorByPoint: true,
        data: [<?php echo $serieCanal;?>]
    }]
});

Highcharts.chart('cause', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },
    title: {
        text: 'Répartition des évenements par cause'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            innerSize: 120,
            depth: 25,
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    credits: {
                enabled: true,
                href: "#",
                text: "DGPC"
            },
    series: [{
        name: 'Ticket',
        colorByPoint: true,
        data: [<?php echo $serieCause;?>]
    }]
});

Highcharts.chart('mort_blesse', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Effets par incident'
    },
    
    xAxis: {
        categories: [<?php echo $category;?>],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Ticket',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' Ticket'
    },
    plotOptions: {
        column: {
            dataLabels: {
                enabled: true
            }
        }
    },
   
    credits: {
        enabled: false
    },
    series: [<?php echo $effets;?>]
});

Highcharts.chart('mort_blesse_type', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Effets par catégories'
    },
    
    xAxis: {
        categories: [<?php echo $category_typ;?>],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Ticket',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' Ticket'
    },
    plotOptions: {
        column: {
            dataLabels: {
                enabled: true
            }
        }
    },
   
    credits: {
        enabled: false
    },
    series: [<?php echo $effets_type;?>]
});

Highcharts.chart('effets_dgpc', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Perte Humaine DGPC'
    },
    
    xAxis: {
        categories: [<?php echo $category_typ;?>],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Ticket',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' Ticket'
    },
    plotOptions: {
        column: {
            dataLabels: {
                enabled: true
            }
        },
        series: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function ()
                            {
                             console.log(this.options.key);   
                            var mywindow = window.open("<?php echo base_url(); ?>Dashboard/get_humain_dgpc/" + this.options.key, "_blank", "width=800,height=300,scrollbars=yes,toolbar=no,resizable=yes,left=500,right=500");
                            }
                        }
                    }
                }
    },
   
    credits: {
        enabled: false
    },
    series: [<?php echo $effets_dgpc;?>]
});
</script>

<script type="text/javascript">
    function reloadDonnees() {
        myform.action = myform.action;
        myform.submit();
    }
</script>

</html>