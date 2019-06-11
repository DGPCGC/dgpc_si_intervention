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




                        <div class="col-md-3">
                                 <div class="form-group">
                                    <label>Année</label>
                                    <select class="form-control" name="annee" onchange="envoyer(this)">
                                    <option value="">-Sélectionner-</option>
                                      <?php for($i = $date_max; $i > $date_min; $i--){
                                          if($annee != "" && $annee == $i){
                                            echo '<option value="'.$i.'" selected>'.$i.'</option>';
                                          }else{
                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                          }
                                       } ?>
                                    </select>
                                 </div>
                              </div>



                                                <div class="col-md-3">
                                <div class="form-group">
                                    <label>Mois</label>
                                    <select class="form-control" name="mois" onchange="envoyer(this)">
                                    <option value="">-Sélectionner-</option>
                                
                 <?php 


                 if($annee)
                 {
                  

                 if($mois=="01") { ?>
                   <option value="01" selected>Janvier </option>
                      <?php } else { ?>
                     <option value="01">Janvier </option>
                      <?php } ?>


                 <?php if($mois=="02") { ?>
                   <option value="02" selected>Février </option>
                      <?php } else { ?>
                     <option value="02">Février </option>
                      <?php } ?>

                 <?php if($mois=="03") { ?>
                   <option value="03" selected>Mars </option>
                      <?php } else { ?>
                     <option value="03">Mars </option>
                      <?php } ?>

                <?php if($mois=="04") { ?>
                   <option value="04" selected>Avril </option>
                      <?php } else { ?>
                     <option value="04">Avril </option>
                      <?php } ?>

                <?php if($mois=="05") { ?>
                   <option value="05" selected>Mais </option>
                      <?php } else { ?>
                     <option value="05">Mais </option>
                      <?php } ?>

                 <?php if($mois=="06") { ?>
                   <option value="06" selected>Juin </option>
                      <?php } else { ?>
                     <option value="06">Juin </option>
                      <?php } ?>

              <?php if($mois=="07") { ?>
                      <option value="07" selected>Juillet </option>
                       <?php } else { ?>
                      <option value="07">Juillet </option>
                        <?php } ?>

              <?php if($mois=="08") { ?>
                   <option value="08" selected>Août </option>
                      <?php } else { ?>
                     <option value="08">Août </option>
                      <?php } ?>

               <?php if($mois=="09") { ?>
                   <option value="09" selected>Septembre </option>
                      <?php } else { ?>
                     <option value="09">Septembre </option>
                      <?php } ?>

                 <?php if($mois=="10") { ?>
                   <option value="10" selected>Octobre </option>
                      <?php } else { ?>
                     <option value="10">Octobre </option>
                      <?php } ?>

                 <?php if($mois=="11") { ?>
                   <option value="11" selected>Novembre </option>
                      <?php } else { ?>
                     <option value="11">Novembre </option>
                      <?php } ?>


                 <?php if($mois=="12") { ?>
                   <option value="12" selected>Décembre </option>
                      <?php } else { ?>
                     <option value="12">Décembre </option>
                      <?php } } ?>
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