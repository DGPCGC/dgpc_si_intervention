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
                                    <?php include 'menu_equipe.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12" style="padding: 5px">
                      <?php
                        if($this->session->flashdata('msg'))
                            echo $this->session->flashdata('msg');
                     ?> 

                     <div class="table-responsive">   
                         <table id='requests_list' class="table table-responsive">
                             <thead>
                                 <th>NOM</th>
                                 <th>TELEPHONE.</th>
                                 <th>EMAIL</th>   
                                 <th>CPPCs</th>   
                                 <th>Service</th>   
                                 <th>STATUT</th>  
                                 <th>MEMBRE</th>
                                 <th>OPTIONS</th>
                             </thead>
                         </table> 
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
            var requests_list = $("#requests_list").DataTable({
                "processing":true,
                "serverSide":true,
                "oreder":[],
                "ajax":{
                    url:"<?php echo base_url(). 'equipes/Equipes/get_equipes'?>",
                    type:"POST"
                },
                "columnDefs":[{
                    "targets":[3,4,6],
                    "orderable":false
                }],
             dom: 'Bfrtlip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]      
        });
    });

    </script>

