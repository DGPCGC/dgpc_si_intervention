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
                                 <div class="col-lg-12 col-md-12">
									 <ul class="nav nav-tabs pull-right" role="tablist" style="margin-bottom: 20px">
										<li role="presentation" class="active"><a href="#Avalider" aria-controls="identite" role="tab" data-toggle="tab">A Transmettre</a></li>
										<li role="presentation"><a href="#DAvalider" aria-controls="affectation" role="tab" data-toggle="tab">Transmis</a></li>
									 </ul>
                                   <h4 class=""><b><?=$title?></b></h4>  
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
									
                                    <?php //include 'menu_ccpc.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12" style="padding: 5px">
                      <?php
                        if($this->session->flashdata('msg'))
                            echo $this->session->flashdata('msg');
                     ?> 

                     <div class="">   
						<div class="tab-content">
							<div role='tabpanel' class='tab-pane active' id='Avalider'>
								<?php echo $this->table->generate($table) ?>
							</div>
							<div role='tabpanel' class='tab-pane' id='DAvalider'>
								<?php echo $tables ?>
							</div>
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
<script>
        $(document).ready(function(){
            var requests_list = $("#requests_list").DataTable({
                "processing":true,
                "serverSide":true,
                "oreder":[],
                "ajax":{
                    url:"<?php echo base_url(). 'equipes/Caserne/get_casernes'?>",
                    type:"POST"
                },
                "columnDefs":[{
                    "targets":[3,4,6],
                    "orderable":false
                }]
                  
        });
    });

    </script>
    <script>
        $(document).ready(function(){
            // $("#mytable").DataTable
            $('#mytable').DataTable({
                        'paging': true,
                        'lengthChange': true,
                        'searching': true,
                        'ordering': false,
                        'info': false,
                        'responsive': true,
                        'autoWidth': false,
                        'pageLength': 10,
                     
                        
                    });
			
                    $('.dt-buttons').addClass('pull-right');
                    $('d_table_paginate').addClass('pull-right');
                    $('#d_table_filter').addClass('pull-left');            
            
    });

    </script>
	<script>
        $(document).ready(function(){
            // $("#mytable").DataTable
            $('#mytb').DataTable({
                        'paging': true,
                        'lengthChange': true,
                        'searching': true,
                        'ordering': false,
                        'info': false,
                        'responsive': true,
                        'autoWidth': false,
                        'pageLength': 10,
                     
                        
                    });
			
                    $('.dt-buttons').addClass('pull-right');
                    $('d_table_paginate').addClass('pull-right');
                    $('#d_table_filter').addClass('pull-left');            
            
    });

    </script>


