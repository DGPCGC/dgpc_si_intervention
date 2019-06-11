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

         
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b><?=$title?></b></h4>  
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                   <a class="btn <?=($this->router->class=='Notification_Alert' && $this->router->method=='index')?'btn-primary':''?>" href="<?=base_url('alerte/Notification_Alert')?>"> Nouvel </a>
                                    <a class="btn <?=($this->router->class=='Notification_Alert' && $this->router->method=='liste')?'btn-primary':''?>" href="<?=base_url('alerte/Notification_Alert/liste')?>"> Liste </a>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12" style="padding: 5px">
                      <?php
                        if($this->session->flashdata('msg'))
                            echo $this->session->flashdata('msg');
                     ?>         
                     </div>
                     <div class="col-md-12 jumbotron table-responsive" style="padding: 5px">  
                             <?php
                            echo $this->table->generate($alert_notif);?> 
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
    $('#mytable').DataTable({ 
     /*dom: 'lBfrtip',
    buttons: ['copy', 'print']*/ });  
});
</script>