<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
</head>
<body>
    <div class="container-fluid" style="background-color: white">
       
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 5px" id="navp">
                <!-- /.navbar-top-links -->
                <?php include VIEWPATH.'includes/menu_principal.php' ?>
                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->
            
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                                <?=$breadcrumb ?> 
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b><?=$title?></b></h4>  
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                    <?php //include 'menu_ticket.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12" style="padding: 5px">
                    <?php
                        if($this->session->flashdata('msg'))
                            echo $this->session->flashdata('msg');
                     ?> 


                  <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 20px">
                    <li role="presentation" class="active"><a href="#evenement" aria-controls="identite" role="tab" data-toggle="tab">Evenement</a></li>
                    <li role="presentation"><a href="#intervention" aria-controls="affectation" role="tab" data-toggle="tab">Intervention</a></li>
                    <li role="presentation"><a href="#degats" aria-controls="cotation" role="tab" data-toggle="tab">Dégats</a></li>
                    <li role="presentation"><a href="#degats_dgpc" aria-controls="soins" role="tab" data-toggle="tab">Dégats DGPC</a></li>
					<li role="presentation"><a href="#graphe" aria-controls="soins" role="tab" data-toggle="tab">Graphe</a></li>
                    <li role="presentation"><a href="#partenaire" aria-controls="soins" role="tab" data-toggle="tab">Partenaire</a></li>

                    <?php
                      $this->uri->segment(4);
                      $check=$this->Model->checkvalue('transm_rapport_histo',array('TICKET_CODE'=>$this->uri->segment(4),'NIVEAU_ID'=>1,'STATUT'=>3));
                      if($check!=TRUE){
                        echo ' <li role="presentation"><a href="'.base_url().'tickets/Intervention/retournTerrain/'.$this->uri->segment(4).'" class="btn btn-warning">Valider un rapport</a></li>';
                      }
                     ?>
                   

                    <li role="presentation"><a href="<?=base_url() ?>pdf/Pdf/intervation/<?=$this->uri->segment(4) ?>" class="btn btn-primary" style="float: right;" target='_blank'>Générer PDF</a></li> 
                  </ul>

                  <div class="tab-content">
                    <div role='tabpanel' class='tab-pane active' id='evenement'>
                       <?php
                    if(!empty($ticket)){
                  ?>
                    <fieldset>
                        <legend>Evenement <b><?=$ticket['TICKET_DESCR']?></b></legend>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Code intervention</th>
                                <th>Description</th>
                                <th>Date Déclaré</th>
                                <th>Déclaré par</th>
                            </tr>
                            <tr>
                                <td><?=$ticket['TICKET_CODE']?></td>
                                <td><?=$ticket['TICKET_DESCR']?></td>
                                <td><?php $date_inter = new DateTime($ticket['DATE_INSERTION']); echo $date_inter->format('d/m/Y');?></td>
                                <td><?=$ticket['TICKET_DECLARANT'].' ('.$ticket['TICKET_DECLARANT_TEL'].')'?></td>
                            </tr>
                            
                            <tr>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Localité</th>
                                <th>Commune/Province</th>
                            </tr>

                            <tr>
                                <td><?=$ticket['LATITUDE']?></td>
                                <td><?=$ticket['LONGITUDE']?></td>
                                <td><?=$ticket['LOCALITE']?></td>
                                <td>
                                   <?php 
                                     $commune = $this->mylibrary->getOne('ststm_communes',array('COMMUNE_ID'=>$ticket['COMMUNE_ID']));
                                     $province = $this->mylibrary->getOne('ststm_provinces',array('PROVINCE_ID'=>$commune['PROVINCE_ID']));
                                     
                                    echo $commune['COMMUNE_NAME'].'/'.$province['PROVINCE_NAME'];
                                   ?>


                                </td>
                            </tr>

                            <tr>
                                <th>Statut</th>
                                <th>Canal</th>
                                <th>Cause</th>
                                <th>Enregistré par</th>
                            </tr>

                            <tr>
                                
                                <td><?=$this->mylibrary->getOne('tk_statuts',array('STATUT_ID'=>$ticket['STATUT_ID']))['STATUT_DESCR']?></td>
                                <td><?=$this->mylibrary->getOne('tk_canal',array('CANAL_ID'=>$ticket['CANAL_ID']))['CANAL_DESCR']?></td>
                                <td><?=$this->mylibrary->getOne('tk_causes',array('CAUSE_ID'=>$ticket['CAUSE_ID']))['CAUSE_DESCR']?></td>
                                <td><?php $user = $this->mylibrary->getOne('admin_users',array('USER_ID'=>$ticket['USER_ID'])); 
                                 echo $user['USER_NOM'].' '.$user['USER_PRENOM'];?></td>
                            </tr>

                        </table>
                    </fieldset> 
                    <?php } ?>
                    </div>

                    <div role='tabpanel' class='tab-pane' id='intervention'>
                    <?php 
                      // print_r($interventions);

                     if(!empty($interventions)){
                      ?>
                    <fieldset>
                        <legend>Intervention</legend>
                        <table class="table table-bordered">
                            <tr>
                                <th>Equipe</th>
                                <th>Equipe</th>
                                <th>Collaboateur</th>
                                <th>A faire</th>                                
                                <th>Date</th>
                            </tr>

                            <?php
                              foreach ($interventions as $intervention) { 
                                ?>
                                  <tr>
                                      <td><?=$this->mylibrary->getOne('rh_equipe_cppc',array('EQUIPE_ID'=>$intervention['EQUIPE_ID']))['EQUIPE_NOM']?></td>
                                      <td><?=$this->mylibrary->getOne('rh_equipe_cppc',array('EQUIPE_ID'=>$intervention['EQUIPE_ID']))['EQUIPE_NOM']?></td>
                                      <td><?php $collabo = $this->mylibrary->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$intervention['PERSONNEL_ID'])); echo $collabo['PERSONNEL_NOM'].' '.$collabo['PERSONNEL_PRENOM']?></td>
                                      <td><?=$intervention['COMMENTAIRE']?></td>
                                      <td><?php $date_deb = new DateTime($intervention['DATE_INSERTION']); echo $date_deb->format('d/m/Y'); ?></td>
                                      
                                  </tr>
                                <?php
                              }
                            ?>
                        </table>
                    </fieldset> 
                    <?php } ?>
                    </div>
                   
                    <div role='tabpanel' class='tab-pane' id='degats'>
                      <?php if(!empty($degat_humain)){?>
                    <fieldset>
                        <legend>Dégat Humain</legend>

                        <table class="table table-bordered">
                            <tr>
                                <th>Nom & Prénom</th>
                                <th>CNI</th>
                                <th>Date Naissance</th>
                                <th>Statut</th>
                                <th>Séverité</th>
                            </tr>
                            <?php 
                              foreach ($degat_humain as $dg_humain) {
                                ?>
                                  <tr>
                                    <td><?=$dg_humain['NOM_PRENOM']?></td>
                                    <td><?=$dg_humain['IDENTIFICATION']?></td>
                                    <td><?=$dg_humain['DATE_NAISSANCE']?></td>
                                    <td><?=($dg_humain['STATUT_SANTE'] ==1)?'Mort':'Blessé'?></td>
                                    <td><?=($dg_humain['STATUT_SANTE'] ==0)?$dg_humain['SEVERITE']:''?></td>
                                  </tr>
                                <?php
                              }
                            ?>
                            </table>
                    </fieldset>

                    <?php }?>
                    <?php if(!empty($degat_materiel)){?>
                    <fieldset>
                        <legend>Dégats matériel</legend>
                        <table class="table table-bordered">
                            <tr>
                                <th>Matériel</th>
                                <th>Déscription</th>
                                <th>Commentaire</th>
                                <th>Date insertion</th>
                            </tr>
                            <?php 
                              foreach ($degat_materiel as $dg_materiel) {
                               ?>
                              <tr>
                                <td><?=$this->mylibrary->getOne('tk_materiel_endomage',array('MATERIEL_ENDO_CODE'=>$dg_materiel['MATERIEL_ENDO_CODE']))['MATERIEL_ENDO_DESCR']?></td>
                                <td><?=$dg_materiel['MATERIEL_DESCR']?></td>
                                <td><?=$dg_materiel['COMMENTAIRE']?></td>
                                <td><?=$dg_materiel['DATE_INSERTION']?></td>
                              </tr>
                               <?php 
                              }
                            ?>
                            </table>
                    </fieldset>

                    <?php }?>

                    </div>
                    <div role='tabpanel' class='tab-pane' id='degats_dgpc'>

                    <?php if(!empty($degat_humain_dg)){?>
                    <fieldset>
                        <legend>Dégat Humain DGPC</legend>
                        <table class="table table-bordered">
                            <tr>
                                <th>Nom & Prénom</th>
                                <th>Matricule</th>
                                <th>Date Naissance</th>
                                <th>Statut</th>
                                <th>Séverité</th>
                            </tr>
                            <?php 
                              foreach ($degat_humain_dg as $dg_humain_dgpc) {
                                ?>
                                 <tr>
                                   <td><?=$dg_humain_dgpc['NOM_PRENOM']?></td>
                                   <td><?=$dg_humain_dgpc['IDENTIFICATION']?></td>
                                   <td><?=$dg_humain_dgpc['DATE_NAISSANCE']?></td>
                                   <td><?=($dg_humain_dgpc['STATUT_SANTE'] ==1)?'Mort':'Blessé'?></td>
                                    <td><?=$dg_humain_dgpc['SEVERITE']?></td>                                   
                                 </tr>
                                <?php
                              }
                            ?>
                            </table>
                    </fieldset>

                    <?php }?>

                    <?php if(!empty($degat_materiel_dgpc)){
                      ?>
                    <fieldset>
                        <legend>Dégats matériel DGPC</legend>
                        <table class="table table-bordered">
                            <tr>
                                <th>Matériel</th>
                                <th>Déscription</th>
                                <th>Commentaire</th>
                                <th>Date insertion</th>
                            </tr>
                            <?php 
                              foreach ($degat_materiel_dgpc as $dg_materiel_dgpc) {
                                ?>
                                <tr>
                                  <td><?=$this->mylibrary->getOne('interv_materiaux',array('MATERIEL_CODE'=>$dg_materiel_dgpc['MATERIEL_ENDO_CODE']))['MATERIEL_DESCR']?></td>
                                  <td><?=$dg_materiel_dgpc['MATERIEL_DESCR']?></td>
                                  <td><?=$dg_materiel_dgpc['COMMENTAIRE']?></td>
                                  <td><?=$dg_materiel_dgpc['DATE_INSERTION']?></td>
                                </tr>
                                <?php
                              }
                            ?>
                            </table>
                    </fieldset>

                    <?php }?>

                    </div>
					 <div role='tabpanel' class='tab-pane' id='graphe'>
						
						<div id="svg_data" style='display:none'>
                                    
                        </div>
						<canvas id="canvas" width="800" height="400" style="display:none"></canvas>
						<div id='mtrl' style='display:none'>
							
						</div>
						
						
					 </div>
                    <div role='tabpanel' class='tab-pane' id='partenaire'>
                       <?php if(!empty($interv_partenaire)){
                      ?>
                    
                        <legend>Présence de(s) partenaire(s)</legend>
                        <table class="table table-bordered">
                            <tr>
                                <th>Partenaire</th>
                                <th>Matériel</th>
                                <th>Commentaire</th>
                            </tr>
                            <?php 
                              foreach ($interv_partenaire as $partenaire) {
                                ?>
                                <tr>
                                  <td><?=$this->mylibrary->getOne('interv_partenaire',array('PARTENAIRE_CODE'=>$partenaire['PARTENAIRE_CODE']))['PARTENAIRE_DESCR']?></td>
                                  <td><?=$partenaire['MATERIEL_DESCR']?></td>
                                  <td><?=$partenaire['COMMENTAIRE']?></td>
                                </tr>
                                <?php
                              }
                            ?>
                            </table>
                    
                    <?php }?>

                    </div>
                  </div>
                 </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

       

</body>

</html>
	<script type="text/javascript" src="<?=base_url()?>canvas/canvas2image.js"></script>

<script type="text/javascript">
var chart = new Highcharts.Chart({
        chart: { renderTo: 'mtrl',type: 'column' },
        title: { text: 'Dégat' },
        subtitle: { text: '<b>DGPC</b>:<?=$total_materiel_dgpc?> materiels; <?=$total_blesse_dgpc?> blessés; <?=$total_mort_dgpc?> morts<br><b>Riverains</b>:<?=$total_materiel_riverain?> materiels; <?=$total_blesse_riverain?> blessés; <?=$total_mort_riverain?> morts<br>' },
        xAxis: { categories: ['DGCP', 'Riverains'],text:null},
		yAxis: { min:0, title :{text:'Nombre dégat'},align:'high',labels:{overflow:'justify'}},
		tooltip: {valueSuffix: ''},
		credits: {
        enabled: false
    },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: <?=$series?>
    });

	 var svgs = chart.getSVG();
    $('#svg_data').html(svgs).fadeIn('slow');
	getimage();
	
	
					
					
					
function getimage(){


                    var svgString = new XMLSerializer().serializeToString(document.querySelector('svg'));
                    //alert(svgString);
                    var canvas = document.getElementById("canvas");
					
                    var ctx = canvas.getContext("2d");
                    var DOMURL = self.URL || self.webkitURL || self;
                    var img = new Image();
                    var svg = new Blob([svgString], {type: "image/svg+xml;charset=utf-8"});
                    var url = DOMURL.createObjectURL(svg);
                    img.onload = function() {
                        ctx.drawImage(img, 0, 0);
                        var png = canvas.toDataURL("image/png");
                        //document.querySelector('#png-container').innerHTML = '<img src="'+png+'"/>';
                        DOMURL.revokeObjectURL(png);
                        var imgg=Canvas2Image.convertToPNG(canvas);
                        var image_data = $(imgg).attr('src');
						var code_image="<?=$this->uri->segment(4) ?>";
                        //alert(image_data);

                        $.ajax({
                           type: 'post',
                           url: '<?=base_url() ?>tickets/Tickets/image',
                           data: {
                              image_data : image_data,code_image:code_image     //le code "texte" du svg
                               },
                            success:function(data)  
                            {
                                // alert(data);
                                // $("#img-out").append(canvas);
                            }
                        });
                    };
                    img.src = url;

                    }
		
    </script>


<script >
     

    </script>