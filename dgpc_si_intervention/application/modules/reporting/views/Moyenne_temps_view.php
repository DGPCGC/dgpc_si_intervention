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
                           <form class="col-md-12" method="post" name='myform' action="<?= base_url('reporting/Moyenne_temps')?>">
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label>CPPC</label>
                                    <select class="form-control" name="cppc[]" id="cppc" multiple='multiple'> 
                                    <?php
                                          foreach ($cppc as $value) {
                                            echo "<option value='".$value['CPPC_ID']."'>".$value['CPPC_NOM']."</option>";
                                              
                                          }
                                       ?>
                                    </select>
                                 </div>
                              </div>

                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label>Année</label>
                                    <select class="form-control" name="annee" onchange="">
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
                              <div class="col-md-2">
                                 <div class="form-group">
                                   <label>Trimestre</label>
                                <select class="form-control" name="trimestre" id="trimestre" onchange="submitf()">
                                    <option value="">-sélectionner-</option>
                                       <?php
                                        $pr=$de=$tr=$qu="";
                                        if($mois != null){
                                        foreach ($mois as $value) {
                if($value['year'] == '1' || $value['year'] == '2' || $value['year'] == '3'){
                                        if($trim_s == '1'){
                                        $pr="<option value='1' selected>1<sup>er</sup> trimestre</option>";
                                        }else{
                                         $pr="<option value='1'>1<sup>er</sup> trimestre</option>";  
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
                              <div class="col-md-2">
                                  <div class="form-group">
                                    <label>Mois</label>
                                    
                                    <select class="form-control" name="mois" id="mois" onchange="submitf()">
                                    <option value="">-sélectionner-</option>
                                        <?php
                                            if($mois_trim != null){
                                                foreach ($mois_trim as $value) {
                                                    if($value['year'] == '1'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='1' selected>Janvier</option>";
                                                       }else{
                                                       echo "<option value='1'>Janvier</option>";     
                                                       }
                                                    }else if($value['year'] == '2'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='2' selected>Février</option>";
                                                       }else{
                                                         echo "<option value='2'>Février</option>";  
                                                       }
                                                    }else if($value['year'] == '3'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='3' selected>Mars</option>";
                                                       }else{
                                                          echo "<option value='3'>Mars</option>"; 
                                                       }
                                                    }else if($value['year'] == '4'){
                                                        if($value['year'] == $mois_s){
                                                 echo "<option value='4' selected>Avril</option>";
                                                       }else{
                                                  echo "<option value='4'>Avril</option>";         
                                                       }
                                                    }else if($value['year'] == '5'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='5' selected>Mai</option>";
                                                       }else{
                                                    echo "<option value='5'>Mai</option>";       
                                                       }
                                                    }else if($value['year'] == '6'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='6' selected>Juin</option>";
                                                       }else{
                                                    echo "<option value='6'>Juin</option>";       
                                                       }
                                                    }else if($value['year'] == '7'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='7' selected>Juillet</option>";
                                                       }else{
                                                    echo "<option value='7'>Juillet</option>";       
                                                       }
                                                    }else if($value['year'] == '8'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='8' selected>Aout</option>";
                                                       }else{
                                                    echo "<option value='8'>Aout</option>";       
                                                       }
                                                    }else if($value['year'] == '9'){
                                                        if($value['year'] == $mois_s){
                                                       echo "<option value='9' selected>Septembre</option>";
                                                       }else{
                                                  echo "<option value='9'>Septembre</option>";
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
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label>Statut</label>
                                    <select class="form-control" name="statut" id="statut" onchange="submitf()">
                                       <option value="">-sélectionner-</option>   
                                    <?php
                                          foreach ($statut as $value) {
                                              if($value['STATUT_ID'] == $statut_s){
                                            echo "<option value='".$value['STATUT_ID']."' selected>".$value['STATUT_DESCR']."</option>";
                                              }else{
                                            echo "<option value='".$value['STATUT_ID']."'>".$value['STATUT_DESCR']."</option>";
                                              }
                                          }
                                       ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                    <label></label>
                                    <button style="margin-top: 23px" type="button" onclick="submitf()" class="btn btn-primary">Rechercher</button>
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

    Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Moyenne de temps d\'intervention en heures'
    },
    subtitle: {
        text: 'Rapport du <?= date('d-m-Y')?>'
    },
    xAxis: {
        categories: [<?= $cate?>],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Temps d\'intervention',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' heure(s)'
    },
    plotOptions: {
       column: {
            dataLabels: {
                enabled: true
            }
        },
        bar: {
            dataLabels: {
                enabled: true 
            }
        }
        ,series: {
                        cursor:'pointer',
                        point:{
                            events: {
                                 click: function()
                                 {
                                      var cat=this.category;
                                      var serie=this.series.name;
                                      var res = serie.replace("é","e");
                                  window.open("http://195.154.81.102/pid2019/Rapport_listing_comp/index/"+cat+".province.","_blank","width=1000,height=600,scrollbars=yes,toolbar=no,resizable=yes,left=500,right=500");
                                   
                                }
                            }
                        }
        }
    },
    chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            },
    credits: {
        enabled: false
    },
    series: [{name: 'Temps d\'intervention',data: [<?= $tickets?>]}]});

</script>

<script>
   function get_trimestry_mois(val){
       var annee= $(val).val();
       if(annee != ""){
         $.post('<?= base_url('reporting/Moyenne_temps/get_trimestry') ?>',
         { annee: annee},
         function(data){
             $('#trimestre').html(data); 
         });

         $.post('<?= base_url('reporting/Moyenne_temps/get_mois') ?>',
         { annee: annee},
         function(data){
             $('#mois').html(data); 
         });
       }
   }

   function get_mois(val){
       var trim= $(val).val();
       if(trim != ""){
         $.post('<?= base_url('reporting/Moyenne_temps/get_mois2') ?>',
         { trim: trim},
         function(data){
             $('#mois').html(data); 
         });
       }
   }
</script>

</html>