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
                                   <h4 class=""><b><?=$title?></b></h4>  
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                    <?php include 'menu_ticket.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12" style="padding: 5px">
                      <?php
                        if($this->session->flashdata('msg'))
                            echo $this->session->flashdata('msg');
                     ?> 
                     <ul class="nav nav-tabs">
                      <li class="active"><a href="<?=base_url('tickets/Tickets/liste')?>" id="tickets">Toutes les interventions DGPC</a></li>
                      <?php if($this->session->userdata('DGPC_CPPC_ID') >0){?>
                      <li><a href="<?=base_url('tickets/Tickets/liste/cppc')?>" id="ma_cppc">Interventions de ma CPPC</a></li>
                  <?php } ?>
                      <li><a href="<?=base_url('tickets/Tickets/get_interventions')?>" id='mes_interventions'>Mes interventions</a></li>
                    </ul>
                    <br>

                     <div class="table-responsive" id="tickets"> 
                       <div id='table1'>
                          <?=$this->table->generate($liste_ticket)?>
                        </div>
                          
                      </div>
                 </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
</body>

</html>
<script>
        $(document).ready(function(){
             setInterval(function(){

            $.ajax({
                    url:"<?php echo base_url() ?>tickets/Tickets/actualisation",
                    method:"POST",
                    success:function(data){  
                      //alert(data);
                      if(data==1){
                        window.location.href="<?= base_url('tickets/Tickets/liste') ?>";

                        }
                                    
                      }
                  });

          },1000);


            $("#table2").hide();
            var requests_list = $("#table_ticket").DataTable({
                 "order": [[ 0, "desc" ]],
                 language: {
                "sProcessing":     "Traitement en cours...",
                "sSearch":         "Rechercher&nbsp;:",
                "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
                "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                "sInfoPostFix":    "",
                "sLoadingRecords": "Chargement en cours...",
                "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
                "oPaginate": {
                    "sFirst":      "Premier",
                    "sPrevious":   "Pr&eacute;c&eacute;dent",
                    "sNext":       "Suivant",
                    "sLast":       "Dernier"
                },
                "oAria": {
                    "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                }
            },                
                dom: 'Bfrtlip',
        buttons: [
              
               {
               extend: 'copy',
               exportOptions: {
                    columns: [ 0, 1, 2,3,4,5,6]
                }
               },
               {
               extend: 'csv',
               exportOptions: {
                    columns: [ 0, 1, 2,3,4,5,6]
                }
               }, 
               { 
               extend: 'excel',
               exportOptions: {
                    columns: [ 0, 1, 2,3,4,5,6]
                }
               },
               {
               extend: 'pdf',
               exportOptions: {
                    columns: [ 0, 1, 2,3,4,5,6]
                }
               },
               {
               extend: 'print',
               exportOptions: {
                    columns: [ 0, 1, 2,3,4,5,6]
                }
               } 
           
            
           ]                  
        });
    });



    </script>

    <script type="text/javascript">
     $(document).ready(function(){

      setInterval(function(){
      $.ajax({
              url:"<?php echo base_url() ?>tickets/Tickets/actualisation_liste",
              method:"POST",
              success:function(data){  
                if(data==1){

                  //SendNotificationSound(1);
                 
                  window.location.href="<?= base_url('tickets/Tickets/liste') ?>";


                  }
                              
                }
            });

    },15000);

    });

</script>

