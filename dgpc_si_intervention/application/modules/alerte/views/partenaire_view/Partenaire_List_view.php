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
                                     <?php include 'menu_partenaire.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12" style="padding: 5px">
                      <?php
                         if($this->session->flashdata('msg'))
                         echo $this->session->flashdata('msg');
                       ?>  

                        <div class="table-responsive">   
                        <table class="table table-bordered" id="requests_list">
                                <thead class="">
                                    <th>CODE</th>
                                    <th>DESCRIPTION</th>
                                    <th>TELEPHONE</th>
                                    <th>EMAIL</th>
                                    <th>OPTIONS</th>
                                    
                                </thead>
                                <tbody>
                                  <?php 
                                  foreach ($liste_partenaire as $key) {
                                    # code...
                                    ?>

                                    <tr>
                                       <td><?= $key['PARTENAIRE_CODE'] ?></td>
                                       <td><?= $key['PARTENAIRE_DESCR'] ?></td>
                                       <td><?= $key['PARTENAIRE_TEL'] ?></td>
                                       <td><?= $key['PARTENAIRE_EMAIL'] ?></td>
                                       <td>
                                         <div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            <li><a href='<?= base_url('alerte/Partenaire/updateform/'.$key['PARTENAIRE_ID']) ?>'>Modifier</li>
                            <li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete<?= $key['PARTENAIRE_ID']  ?>'><font color='red'>Supprimer</font></button></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete<?= $key['PARTENAIRE_ID']  ?>'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Supprimer <b><?= $key['PARTENAIRE_CODE'] ?></b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='<?= base_url('alerte/Partenaire/delete/'.$key['PARTENAIRE_ID']) ?>'>Supprimer</a>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                       </td>
                                     </tr>

                                    <?php
                                  }
                                   ?>
                                     
                                   
                                </tbody>
                            </table>
                      </div>   
                      
               </div>
                </div>
            </div>
           

</body>
<script>
        $(document).ready(function(){
            var requests_list = $("#requests_list").DataTable({
                 
                 
                dom: 'Bfrtlip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ] 
                  
        });
    });

    </script>
</html>


