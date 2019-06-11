
<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
</head>

<body>
    <div class="container-fluid" style="background-color: white">
        
          <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 5px" id="navp">
                <!-- /.navbar-top-links -->
                <?php include VIEWPATH.'includes/menu_principal_test.php' ?>
                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->
            <?php 
            $diligence1 ='active';
            $diligence2 ='';
            ?>
                <div class="container-fluid">
                    <div class="row">
                     <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                                <?=$breadcrumb?> 
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b>Liste de catastrophes</b></h4>

                                      
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                    <?php include 'menu_odk.php' ?>
                                </div>
                            </div>  
                        </div>
                         
                     <div class="col-lg-12 jumbotron">
                     <?php echo $this->table->generate($table) ?>

                  
                    </div>
                    </div>

                </div>
         
    </body>
 


</html>
<script>
        $(document).ready(function(){
            // $("#mytable").DataTable
            $('#mytable').DataTable({
                        'paging': true,
                        'lengthChange': true,
                        'searching': true,
                        'ordering': true,
                        'info': false,
                        'responsive': true,
                        'autoWidth': false,
                        'pageLength': 10,
       dom: 'Bfrtlip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
                     
                        
                    });
                    $('.dt-buttons').addClass('pull-right');
                    $('d_table_paginate').addClass('pull-right');
                    $('#d_table_filter').addClass('pull-left');            
            var requests_list = $("#requests_list").DataTable({
                "processing":true,
                "serverSide":true,
                "oreder":[],
                "ajax":{
                    url:"http://195.154.81.102/dgpc/equipes/Equipes/get_equipes",
                    type:"POST"
                },
                "columnDefs":[{
                    "targets":[3,4,6],
                    "orderable":false
                }]
                  
        });
    });

    </script>