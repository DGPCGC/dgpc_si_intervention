<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
</head>
<body>
    <div class="container-fluid" style="background-color: white">
        
                <!-- /.navbar-top-links -->
                <?php //include VIEWPATH.'includes/menu_principal.php' ?>
                <!-- /.navbar-static-side -->
            

         
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                                
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b><?=$title?></b></h4>  
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                    <?php //include 'menu_caserne.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12" style="padding: 5px">
                      

                     <div class="table-responsive">   
                         <?php echo $this->table->generate($table); ?>
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
    $(document).ready(function () {
        $("#mytable").DataTable({
           
                dom:'Bfrtlip',
                buttons:['copy','csv','excel','pdf','print']
                  
    });
    });
</script>

