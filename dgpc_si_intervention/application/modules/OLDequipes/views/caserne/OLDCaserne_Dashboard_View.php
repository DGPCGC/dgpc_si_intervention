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
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b></b></h4>   
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                   <?php include 'menu_caserne.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12" style="padding: 5px">
                      <?php
                        if($this->session->flashdata('msg'))
                            echo $this->session->flashdata('msg');
                     ?> 

                     <div class="table-responsive"> 
                     <div class="col-md-12">
                      <!-- MODAL MORT -->
                    <?php
                    $interv="";
                    $i=1;
                    foreach ($ticket as $value) {

      $cause=$this->Model->getOne('tk_causes',array('CAUSE_ID'=>$value['CAUSE_ID']));
      $statut=$this->Model->getOne('tk_statuts',array('STATUT_ID'=>$value['STATUT_ID']));

                     $interv.="<tr><td>".$i."</td><td>".$value['DATE_INSERTION']."</td><td>".$value['CODE_EVENEMENT']."</td><td>".$value['TICKET_DESCR']."</td><td>".$cause['CAUSE_DESCR']."</td><td>".$value['TICKET_DECLARANT']."</td><td style='color:".$statut['STATUT_COLOR']."'>".$statut['STATUT_DESCR']."</td></tr>"; 
                     $i++;
                      }
                  
                    ?>
                    <div class='modal fade' id='intervention'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content'>

                                        <div class='modal-body'>
                                            <table id='interv' class='table table-bordered  table-responsive'>
                                              <thead><tr><th>No</th><th>DATE TIME</th><th>CODE INTERV</th><th>DESCRIPTION</th><th>CAUSES</th><th>DECLARANT</th><th>STATUT</th></tr></thead><tbody>
                                              <?=$interv?>
                                              </tbody>
                                            </table>
                                        </div>

                                        <div class='modal-footer'>
                                            
                                            <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                      <!-- MODAL MORT -->
                    <?php
                    $mrt="";
                    $i=1;
                    foreach ($ticket as $value) {
                      $dega_humain_mort=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$value['TICKET_CODE'],'CONCERNE_DGPC'=>1,'STATUT_SANTE'=>1));
                      foreach ($dega_humain_mort as $key) {
                        # code...
                        $mrt.="<tr><td>".$i."</td><td>".$key['NOM_PRENOM']."</td></tr>";
                        $i++;
                      }
                      
                      
                    }
                    ?>
                    <div class='modal fade' id='mort'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>

                                        <div class='modal-body'>
                                            <table id='mort_depuis' class='table table-bordered  table-responsive'>
                                             <thead> <tr><th>No</th><th>NOM & PRENOM</th></tr></thead><tbody><?=$mrt?></tbody>
                                            </table>
                                        </div>

                                        <div class='modal-footer'>
                                            
                                            <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                              <!-- MODAL BLESSE -->
                    <?php
                    $bls="";
                    $i=1;
                    
                    foreach ($ticket as $value) {
                      $dega_humain_blesse=$this->Model->getList('interv_odk_degat_humain',array('TICKET_CODE'=>$value['TICKET_CODE'],'CONCERNE_DGPC'=>1,'STATUT_SANTE'=>0));
                      foreach ($dega_humain_blesse as $key) {
                        # code...
                        $bls.="<tr><td>".$i."</td><td>".$key['NOM_PRENOM']."</td></tr>";
                        $i++;
                      }
                      
                      
                    }
                    ?>
                    <div class='modal fade' id='blesse'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>

                                        <div class='modal-body'>
                                            <h4>Effectif de la <?=$cppc?></h4>
                                            <table id='blesse_total' class='table table-bordered  table-responsive'>
                                              <thead><tr><th>No</th><th>NOM & PRENOM</th><th>CHEF EQUIPE</th></tr></thead><tbody><?=$bls?></tbody>
                                            </table>
                                        </div>

                                        <div class='modal-footer'>
                                            
                                            <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    <!-- MODAL BLESSE -->
                         <!-- MODAL EQUIPE -->
                    <?php
                    $equi="";
                    

                    foreach ($equipe2 as $value) {
                      $equipe=$this->Model->getOne('rh_equipe_cppc',array('EQUIPE_ID'=>$value['EQUIPE_ID']));
                      $equi.="<tr><td  colspan='4'><b>".$equipe['EQUIPE_NOM']."</b></td></tr>";
                      $membre=$this->Model->getList('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$value['EQUIPE_ID']));
                      $i=1;
                      foreach ($membre as $key) {
                          # code...
                        $personnel=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$key['PERSONEL_ID']));
                        $equi.="<tr><td>".$i."</td><td>".$personnel['PERSONNEL_NOM']."</td><td>".$personnel['PERSONNEL_PRENOM']."</td><td>".(($key['IS_CHEF_EQUIPE']==1)?'Oui':'Non')."</td></tr>";
                        $i++;
                      }
                       
                    }
                    ?>
                    <div class='modal fade' id='equipe'>
                                <div class='modal-dialog'> 
                                    <div class='modal-content'>

                                        <div class='modal-body'>
                                          <h4>Effectif de la <?=$cppc?></h4>
                                            <table class='table table-bordered  table-responsive'>
                                              <?=$equi?>
                                            </table>
                                        </div>

                                        <div class='modal-footer'>
                                            
                                            <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- MODAL MATERIEL -->
                    <?php
                    $mat="";
                    $i=1;
                    foreach ($materiel as $value) {
                        $cat=$this->Model->getOne('tk_causes',array('CAUSE_ID'=>$value['CAUSE_ID']));
                      $mat.="<tr><td>".$i."</td><td>".$value['MATERIEL_DESCR']."</td><td>".$cat['CAUSE_DESCR']."</td></tr>";
                       $i++;
                    }
                    ?>
                    <div class='modal fade' id='materiel'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>

                                        <div class='modal-body'>
                                            <table id='materiel_total' class='table table-bordered  table-responsive'>
                                              <thead><tr><th>No</th><th>MATERIEL</th><th>CATEGORIE</th></tr></thead><tbody><?=$mat?></tbody>
                                            </table>
                                        </div>

                                        <div class='modal-footer'>
                                            
                                            <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    <!-- MODAL MATERIEL -->
                    <?php
         $id1 =$this->uri->segment(4);
        $cppcs = $this->Model->getOne('rh_cppc',array('CPPC_ID'=>$id1));
    $manager1=$this->Model->getOne('rh_cppc_manager',array('CPPC_ID'=>$id1));
    $nom_manager1=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$manager1['PERSONNEL_ID']));

    $manager1 = $nom_manager1;

                    ?>

                         <table class='table table-bordered  table-responsive' style="font-size: 12px">
                          <tr><th colspan="5"><b><?=$cppcs['CPPC_NOM']?></b><center> <b>MANAGER <?=$cppcs['CPPC_NOM']?>:</b> <?=$manager1['GRADE']?> <?=$manager1['PERSONNEL_PRENOM']?>  <?=$manager1['PERSONNEL_NOM']?>(<?=$manager1['FONCTION']?>)</center></th></tr>
                            <tr><th>INTERVENTIONS FAITES</th><th>NOMBRE BLESSES</th><th>NOMBRE MORTS</th><th>EQUIPES</th><th>MATERIELS</th></tr>
                            <tr><td><center><a href='' id='' data-toggle='modal' data-target='#intervention'><?=sizeof($ticket)?></a></center></td><td><center><a href='' id='' data-toggle='modal' data-target='#blesse'><?=$blesse?></a></center></td><td><center><a href='' id='' data-toggle='modal' data-target='#mort'><?=$mort?></a></center></td><td><center><a href='' id='' data-toggle='modal' data-target='#equipe'><?=sizeof($equipe2)?><a></center></td><td><center><a href='' id='' data-toggle='modal' data-target='#materiel'><?=sizeof($materiel)?></center></a></td></tr>
                         </table>

                     </div> 
                     <div id="map" style="height: 50vh ;" class="col-md-6"></div> 
                     <div id="mrt" style="height: 50vh ;" class="col-md-6"></div> 
                      
                      </div>   
                      
                 </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->


</body> 

<script>

                var MarkerIcon="<?=base_url()?>assets/bootstrap/images/icon.png";
                        
                var map = L.map('map', {
                                        center: [<?=$latitude?>,<?=$longitude?>],
                                        zoom: 10
                                        });
                    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="#">DGCP SI</a> '}).addTo(map);
                     var greenIcon = L.icon({
                            iconUrl: MarkerIcon,
                            shadowUrl: '',

                            iconSize: [20, 26],
                            
                            });
                        L.marker([<?=$latitude?>,<?=$longitude?>], 
                                 {icon: greenIcon,
                                  title:'Incident '}).addTo(map)
                        .bindPopup("<font color=''><b><?=$cppc?> </b> ");

                    
                </script>
                <script type="text/javascript">

Highcharts.chart('mrt', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Rapport intervention/Dégats rencontrés'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: ['interventions faites','degat humains','degat materiels'],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Nombre',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ''
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
        },
        // series: {
        //                 cursor:'pointer',
        //                 point:{
        //                     events: {
        //                          click: function()
        //                          {
        //                               var cat=this.category;
        //                               var serie=this.series.name;
        //                               var res = serie.replace("é", "e");
        //                           window.open("<?php echo base_url('equipes/Caserne/chaque_detail/');?>"+res+".<?=$cppc1?>","_blank","width=1000,height=600,scrollbars=yes,toolbar=no,resizable=yes,left=500,right=500");
                                   
        //                         }
        //                     }
        //                 }
        // },
    },
    
    credits: {
        enabled: false
    },
    series: <?=$series1?>

    
});

 var interv=$("#interv").DataTable({
                
                dom:'Bfrtlip',
                buttons:['copy','csv','excel','pdf','print']
                  
                  
        });    


var mort_depuis=$("#mort_depuis").DataTable({
                
               
                dom:'Bfrtlip',
                buttons:['copy','csv','excel','pdf','print']
                  
        }); 
var materiel_total=$("#materiel_total").DataTable({
                
                dom:'Bfrtlip',
                buttons:['copy','csv','excel','pdf','print']
                  
        });

               var blesse_total=$("#blesse_total").DataTable({
                
                dom:'Bfrtlip',
                buttons:['copy','csv','excel','pdf','print']
                  
        });  


    </script> 
</html>


