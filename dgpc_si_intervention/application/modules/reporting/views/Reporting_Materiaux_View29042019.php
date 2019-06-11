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

            <div class="col-md-12" id="container" style="height: 400px; border: 1px solid #000">

            </div>
            </div>
                            </div>  
                        </div>

                        
           </div>

</body>
 <script type="text/javascript">
        Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Disponibilité des matériels'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [<?php echo $category;?>],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Rainfall (mm)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [<?php echo $serie_mat;?>]
});
    </script>
    
</html>