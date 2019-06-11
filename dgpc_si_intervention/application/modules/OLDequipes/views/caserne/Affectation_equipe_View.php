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
                                    <?php include 'menu_caserne.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12" style="padding: 5px">
                    <b>MANAGER <?=$CPPC_NOM?>:</b> <?=$manager['GRADE']?> <?=$manager['PERSONNEL_PRENOM']?>  <?=$manager['PERSONNEL_NOM']?>(<?=$manager['FONCTION']?>)<p>
                      <?php
                    $equi="";

                    foreach ($equipe2 as $value) {
                        $horaire=$this->Model->getOne('horaire_equipe',array('EQUIPE_ID'=>$value['EQUIPE_ID']));
                        $horaire_secour=$this->Model->getOne('horaire_equipe',array('EQUIPE_SECOUR_ID'=>$value['EQUIPE_ID']));

                      $equipe=$this->Model->getOne('rh_equipe_cppc',array('EQUIPE_ID'=>$value['EQUIPE_ID']));
                      $equi.="<tr><td  colspan='6'><b>".$equipe['EQUIPE_NOM']."</b> <center>HORAIRE PRINCIPAL: <b>".$horaire['DESCRIPTION']."</b> HORAIRE DE SECOUR: <b>".$horaire_secour['DESCRIPTION']."</b></center></td></tr>";
                      $membre=$this->Model->getList('rh_equipe_membre_cppc',array('EQUIPE_ID'=>$value['EQUIPE_ID']));
                      $i=1;
                      $equi.="<tr><th>No</th><th>NOM</th><th>PRENOM</th><th>FONCTION</th><th>GRADE</th><th>CHEF D'EQUIPE?</th></tr>";
                      foreach ($membre as $key) {
                        $chef="Non";
                          if ($key['IS_CHEF_EQUIPE']==1) {
                              $chef="Oui";
                          }
                        $personnel=$this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$key['PERSONEL_ID']));
                        $equi.="<tr><td>".$i."</td><td>".$personnel['PERSONNEL_NOM']."</td><td>".$personnel['PERSONNEL_PRENOM']."</td><td>".$personnel['GRADE']."</td><td>".$personnel['GRADE']."</td><td>".$chef."</td></tr>";
                        $i++;
                      }
                       
                    }
                    ?>
                    <table class='table table-bordered  table-responsive'>
                                              <?=$equi?>
                                            </table>
                     <div class="table-responsive">   
                         
                      </div>   
                      
                 </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->


</body>

</html>

