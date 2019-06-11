<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
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
                <div class="col-lg-2">
                    <?php include 'm_mat.php' ?>
                </div>
                <div class="col-lg-10">
                    
                
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
                                    
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12 jumbotron" style="padding: 5px">
                      <?php
                        if($this->session->flashdata('msg'))
                            echo $this->session->flashdata('msg');
                     ?> 

                     <div class="table-responsive">   
                         <table id='requests_list' class="table table-responsive">
                             <thead>
                                 <th>DESCRIPTION</th>
                                 <th>CODE</th> 
                                 <th>CATEGORIE</th> 
                                 <th>CPPC</th> 
                                 <th>ETAT</th> 
                                 <th>QUANTITE TOTALE</th> 
                                 <th>QUANTITE DISPONIBLE</th> 
                                 <th>OPTIONS</th>
                             </thead>
                         </table> 
                      </div>   
                      
                 </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            </div>
            <!-- /#page-wrapper -->

        <!-- </div> -->
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
                    url:"<?php echo base_url(). 'materiaux/Materiaux/get_materiaux'?>",
                    type:"POST"
                },
                "columnDefs":[{
                    "targets":[2],
                    "orderable":false
                }],
                dom: 'Bfrtlip',
                buttons: [
                 'copy', 'csv','pdf', 'print'
                ]
                  
        });
    });

    </script>

