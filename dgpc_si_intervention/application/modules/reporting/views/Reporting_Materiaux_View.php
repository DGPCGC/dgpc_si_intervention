<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>

<script>
   function submitf(){
      myform.submit();
   }
</script>
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

                                 <div class="col-md-12">
                           <form class="col-md-12" method="post" name='myform' action="<?= base_url('reporting/Repport_materiaux')?>">
                              <div class="col-md-4" style="margin-left: 100px">
                                 <div class="form-group">
                                    <label>CPPC</label>
                                    <select  name="cppc[]" id="cppc" class="form-control selectpicker" multiple data-live-search="true" data-actions-box="true"> 

                                    <?php
                                        
                                        foreach ($cppc as $value)
                                         {

                                       if(!empty($CPPC_ID)){  
                                        if(in_array($value['CPPC_ID'], $CPPC_ID)){
                                            ?>
                                            <option selected value="<?php echo $value['CPPC_ID'] ?>"><?php echo $value['CPPC_NOM'] ?></option>
                                            <?php
                                        }else{
                                            ?>
                                            <option value="<?php echo $value['CPPC_ID'] ?>"><?php echo $value['CPPC_NOM'] ?></option>
                                            <?php
                                        }
                                      }else{
                                        ?>
                                            <option value="<?php echo $value['CPPC_ID'] ?>"><?php echo $value['CPPC_NOM'] ?></option>
                                            <?php
                                      }
                                        ?>

                                              
                                        <?php  }
                                       ?>

                                    </select>
                                 </div>
                              </div>

                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label>Cause</label>
                                    <select class="form-control" name="cause" id="cause" onchange="submitf()">
                                       <option value="">-Sélectionner-</option>   
                                    <?php
                                          foreach ($causes as $cause) {
                                           // $c= $this->Model->getOne('tk_causes',array('CAUSE_ID'=>$value['year']));
                                              if($cause['CAUSE_ID'] == $CAUSE_ID){
                                            echo "<option value='".$cause['CAUSE_ID']."' selected>".$cause['CAUSE_DESCR']."</option>";
                                              }else{
                                            echo "<option value='".$cause['CAUSE_ID']."'>".$cause['CAUSE_DESCR']."</option>";
                                              }
                                          }
                                       ?>
                                    </select>
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label></label>
                                    <button style="margin-top: 23px" type="button" onclick="submitf()" class="btn btn-primary">Rechercher</button>
                                </div>
                              </div>
                            </form>
                            </div>

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

 $('#cppc').multiselect({
            buttonWidth: '100%',
             numberDisplayed: 1,
             includeSelectAllOption: true
        });


        Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Disponibilité des matériels'
    },
    subtitle: {
        text: 'Rapport du <?=date('d-m-Y')?>'
    },
    xAxis: {
        categories: [<?php echo $category;?>],
        crosshair: true
    },
    credits:{
        enabled: false
    },
    yAxis: {
        min: 0,
        title: {
            text: 'matériels'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} matériels</b></td></tr>',
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