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
            
                <div class="col-lg-12">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                                <?=$breadcrumb ?> 
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">

                                    <?php $mate=$this->Model->getOne('interv_materiaux',array('MATERIEL_ID'=>$materiel));
                                         ?>
                                   <h4 class=""><b><?=$title?> : <?=$mate['MATERIEL_DESCR']?></b></h4>  
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                  <?php include 'm_mat.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12 jumbotron" style="padding: 5px">
                      <?= $this->session->flashdata('message') ?> 


                       <form name="myform" id="myform" method="POST" action="<?= base_url('materiaux/Materiaux/send') ?>" >
                                
                      <input required type="hidden" class="form-control" name="MATERIEL_ID" value="<?=$mate['MATERIEL_ID']?>" autofocus >


                              <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>Quantité à distribuer</label>
                                  <input required type="text" class="form-control" name="QUANTITE" value="<?=$nb?>" readonly="readonly">            
                              </div>
                             
                           </div>


                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>CPPC</label>
                                 <select required class="form-control" name="CPPC_ID" onchange="get_data()">
                                   <option value="<?=$CPPC_ID['CPPC_ID']?>"><?=$CPPC_ID['CPPC_NOM']?></option>
                                   <?php 
                                     
                                        foreach ($cppc as $key) {

                                          if($key['CPPC_ID']==$CPPC_ID)
                                          {
                                      
                                          ?>
                                          <option value="<?= $key['CPPC_ID'] ?>" selected><?= $key['CPPC_NOM'] ?></option>
                                          <?php
                                        }
                                        else
                                        { ?>

                                          <option value="<?= $key['CPPC_ID'] ?>"><?= $key['CPPC_NOM'] ?></option>


                                       <?php }

                                        }
                                     ?>

                                 </select>            
                              </div>
                            </div>

                            <?php 
                                if($nb>0)
                                {
                                  for ($i=0; $i < $nb; $i++) { 

                                  
                                        ?>

                       


                                     <div class="col-lg-6 col-md-6">
                                 <div class="form-group">
                                    <label>Code du matériel</label>
                                    <input type="text" name="code[]" class="form-control" required>
                                     </div>
                                    </div>


                                  <div class="col-lg-6 col-md-6">
                                 <div class="form-group">
                                  <label>Quantité à distribuer</label>
                                    <input type="number" name="descr[]" class="form-control" required value="1" readonly="readonly">
                                     </div>
                                    </div>

                                    <?php
                                  }
                                }
                             ?>


                           <div class="col-lg-12 col-md-6">
                            <div class="form-group">
                                 <input type="submit" class="btn btn-primary" value="Distribuer">
                              </div>
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


