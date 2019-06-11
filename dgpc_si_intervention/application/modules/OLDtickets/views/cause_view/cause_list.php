<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
</head>

<?php 
             $add ='';
            $list ='active';
            ?>

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
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                                <?= $breadcrumb ?> 
                             </div>

                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b>Liste des causes d'intervation</b></h4>  
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px" >
                                    <?php include 'includes/sous_menu_classe.php' ?>
                                </div>
                            </div>  
                        </div>
                        <div class="col-lg-12 jumbotron"  style="padding: 10px;overflow-x: scroll;">
                             <?= $this->session->flashdata('message') ?>
                            <?php echo $table; ?>     
                        </div> 
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
$(document).ready( function () {
    $('#mytable').DataTable({
     /*dom: 'lBfrtip',
    buttons: ['copy', 'print']*/ });  
} );
</script>