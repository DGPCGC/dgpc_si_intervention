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
                   <div class="list-group">
  <a href="<?php echo base_url() ?>alerte/Notification_Alert" class="btn-xs list-group-item ">Alertes</a>
  <a href="<?php echo base_url() ?>alerte/Instititions/index" class="btn-xs list-group-item active">Institution &agrave; notifier</a>
  <a href="<?php echo base_url() ?>alerte/Personnel/index" class="btn-xs list-group-item">Personne &agrave; notifier</a>
</div>
<div class="list-group">
  <a href="<?php echo base_url() ?>alerte/Instititions/addform" class="btn-xs list-group-item <?php if($this->router->class=='Instititions' && $this->router->method=='addform') echo 'active';?>">Nouvelle Institution</a>
  <a href="<?php echo base_url() ?>alerte/Instititions" class="btn-xs list-group-item<?php if($this->router->class=='Instititions' && $this->router->method=='index') echo '';?>">Liste</a>
</div>
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
                                  <!-- <ul class="nav nav-pills pull-right"> -->
   
  
 
   
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12 jumbotron" style="padding: 5px">
                      <?php
                        if($this->session->flashdata('msg'))
                            echo $this->session->flashdata('msg');
                     ?> 
                     <form method="POST" action="<?= base_url('alerte/Instititions/add') ?>">
                          <div class="row">
                        <!-- <div class="col-lg-12"> -->
                            <div class="col-md-7">
                                <label>Nom de l'institition</label>
                                <input type="text" autofocus name="NOM_INSTITUTION" value="<?= set_value('NOM_INSTITUTION') ?>" class="form-control">
                                <font color="red"><?= form_error('NOM_INSTITUTION')?></font>
                                <label>Email</label>
                                <input type="text" name="EMAIL" value="<?= set_value('EMAIL') ?>" class="form-control">
                                <font color="red"><?= form_error('EMAIL')?></font>
                                <label>Telephone</label>
                                <input type="text" value="<?= set_value('TELEPHONE') ?>" name="TELEPHONE" class="form-control">
                                <font color="red"><?= form_error('TELEPHONE')?></font>
                                <label>Personne a contacter</label>
                                <input type="text" value="<?= set_value('PERSONNEL_CONTACT') ?>" name="PERSONNEL_CONTACT" class="form-control">
                                <font color="red"><?= form_error('PERSONNEL_CONTACT')?></font>
                                <br>
                                <button class="btn btn-primary">Enregistrer</button>
                            </div>
                        <!-- </div> -->
                    </div>
                     </form>

                   
                      
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
        $(document).ready(function(){
            var requests_list = $("#requests_list").DataTable({
                "processing":true,
                "serverSide":true,
                "oreder":[],
                "ajax":{
                    url:"<?php echo base_url(). 'alerte/Instititions/get_instititions'?>",
                    type:"POST"
                },
                "columnDefs":[{
                    "targets":[2],
                    "orderable":false
                }]
                  
        });
    });

    </script>

