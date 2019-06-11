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
                <!-- <div class="col-lg-2">
                   <div class="list-group">
  <a href="<?php echo base_url() ?>alerte/Notification_Alert" class="btn-xs list-group-item ">Alertes</a>
  <a href="<?php echo base_url() ?>alerte/Instititions/index" class="btn-xs list-group-item active">Institution &agrave; notifier</a>
  <a href="<?php echo base_url() ?>alerte/Personnel/index" class="btn-xs list-group-item">Personne &agrave; notifier</a>
</div>
<div class="list-group">
  <a href="<?php echo base_url() ?>alerte/Instititions/addform" class="btn-xs list-group-item <?php if($this->router->class=='Instititions' && $this->router->method=='addform') echo '';?>">Nouvelle Institution</a>
  <a href="<?php echo base_url() ?>alerte/Instititions" class="btn-xs list-group-item <?php if($this->router->class=='Instititions' && $this->router->method=='index') echo 'active';?>">Liste</a>
</div>
                </div> -->
                <div class="col-lg-12">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                                <?=$breadcrumb ?> 
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-4 col-md-4">                                  
                                   <h4 class=""><b><?=$title?></b></h4>  
                                </div>
                                <div class="col-lg-8 col-md-8" style="padding-bottom: 3px">
                            <ul class="nav nav-pills pull-right">
                                <li>
                                <a href="<?php echo base_url() ?>alerte/Notification_Alert" class="btn-xs list-group-item ">Alertes</a>
                                </li>
                                <li>
                                  <a href="<?php echo base_url() ?>alerte/Instititions/index" class="btn-xs list-group-item active">Institutions &agrave; notifier</a>
                              </li>
                              <li>
                                  <a href="<?php echo base_url() ?>alerte/Personnel/index" class="btn-xs list-group-item">Personnes &agrave; notifier</a>
                                </li>
                                <li>
                                  <a href="<?php echo base_url() ?>alerte/Instititions/addform" class="btn-xs list-group-item <?php if($this->router->class=='Instititions' && $this->router->method=='addform') echo '';?>">Nouvelle Institution</a>
                              </li>
                              <li>
                                  <a href="<?php echo base_url() ?>alerte/Instititions" class="btn-xs list-group-item <?php if($this->router->class=='Instititions' && $this->router->method=='index') echo 'active';?>">Liste</a>
                              </li>
                                </ul>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12 jumbotron" style="padding: 5px">
                      <?php
                        if($info)
                            echo $info;
                     ?> 

                     <div class="table-responsive">   
                        <?php echo $this->table->generate($table); ?>
                         <!-- <table id='requests_list' class="table table-responsive">
                             <thead>
                                 <th>INSTITITION</th>
                                 <th>TELEPHONE</th> 
                                 <th>EMAIL</th>
                                 <th>PERSONNE A CONTACTER</th>
                                 <th>OPTIONS</th>
                             </thead>
                         </table>  -->
                      </div>   
                      
                 </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
    </div>

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

