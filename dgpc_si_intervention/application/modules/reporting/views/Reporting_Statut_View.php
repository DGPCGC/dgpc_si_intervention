<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>

<script>
   function submitf(){
       if($('#year').val() != ""){
           myform.submit();
       }
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
            <!-- <div id="page-wrapper"> -->
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
                  </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
    <!-- </div> -->

</body>

<script type="text/javascript">
$(document).ready(function() {
        $('#cppc').multiselect({
            buttonWidth: '100%',
             numberDisplayed: 1,
             includeSelectAllOption: true
        });
        
    });


</script>

<script>
   function get_trimestry_mois(val){
       var annee= $(val).val();
       if(annee != ""){
         $.post('<?= base_url('reporting/Reporting_Statut/get_trimestry') ?>',
         { annee: annee},
         function(data){
             $('#trimestre').html(data); 
         });

         $.post('<?= base_url('reporting/Reporting_Statut/get_mois') ?>',
         { annee: annee},
         function(data){
             $('#mois').html(data); 
         });
       }
   }

   function get_mois(val){
       var trim= $(val).val();
       if(trim != ""){
         $.post('<?= base_url('reporting/Reporting_Statut/get_mois2') ?>',
         { trim: trim},
         function(data){
             $('#mois').html(data); 
         });
       }
   }
</script>

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