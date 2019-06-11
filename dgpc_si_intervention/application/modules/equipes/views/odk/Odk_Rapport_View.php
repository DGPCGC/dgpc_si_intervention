
<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
</head>

<body>
    <div class="container-fluid" style="background-color: white">
        
          <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 5px" id="navp">
                <!-- /.navbar-top-links -->
                <?php include VIEWPATH.'includes/menu_principal_test.php' ?>
                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->
            <?php 
            $diligence1 ='active';
            $diligence2 ='';
            ?>
                <div class="container-fluid">
                    <div class="row">
                     <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                                <?=$breadcrumb?> 
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b>Rapport Catastrophe</b></h4>

                                      
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                    
                                </div>
                            </div>  
                        </div>
                         
                     <div class="col-lg-12 jumbotron">
                     <div class="row">
                        <div class="col-lg-5" style="margin-bottom: 20px">
                          <form action="<?=base_url().'equipes/Horaire/rapport'?>" name="myform" method="POST">
                              <div class="col-lg-12 col-md-12">
                                  <label>Rechercher par: </label>
                                  <input type="radio" name="check" id="check" value="1" onclick="show_agent()" checked=""> Agent

                                  <input type="radio" name="check" id="check" value="2" onclick="show_localite()"> Localité
                              </div>
                              <div class="col-lg-12 col-md-12" id="agent">
                              <label>Agent</label>
                              <select name="AGENT" class="form-control" onchange="reload_map()">
                                  <option value=""> - Sélectionner agent- </option>
                                  <option value=""> Tous </option>
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
                        </div>
                        <div class="row">
                          <div class="col-lg-6 col-md-6" id="container"></div>
                          <div class="col-lg-6 col-md-6" id="container2"></div>
                          <div class="col-lg-12 col-md-12" id="container3"></div>
                        </div>
                      
               

                    </div>
                    </div>

                </div>
            
    </body>
 

</html>
<script type="text/javascript">
 Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Agent Vs Catastrophes'
    },
    subtitle: {
        text: 'Le nombre de Catastrophes par agent'
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Nombre catastrophe'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Catastrophes: <b>{point.y}</b>'
    },
    series: [{
        name: 'Population',
        data: [ <?=$finale ?> ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
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
        text: 'Nombre de catastrophes par localité'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Nombre catastrophe',
        colorByPoint: true,
        data: [<?=$rapp_loca ?>]
    }]
});
</script>

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
<script type="text/javascript">
 Highcharts.chart('container3', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Nombre de catastrophes par date'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Nombre catastrophe'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Catastrophes: <b>{point.y}</b>'
    },
    series: [{
        name: 'Population',
        data: [ <?=$rapp_par_date ?> ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
</script>

