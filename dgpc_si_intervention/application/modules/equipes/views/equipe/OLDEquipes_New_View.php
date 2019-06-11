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
                                    <?php include 'menu_equipe.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12" style="padding: 5px">
                      <?php
                         if($this->session->flashdata('msg'))
                         echo $this->session->flashdata('msg');
                       ?>   
                      <form method="POST" action="<?=base_url().'equipes/Equipes/save'?>">
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>Nom d'équipe</label>
                                  <input type="text" class="form-control" name="EQUIPE_NOM" value="<?=set_value('EQUIPE_NOM')?>" style="text-transform: capitalize;" onkeypress="return (envent.charCode > 64 && envent.charCode < 91) || (envent.charCode > 96  && envent.charCode < 123)" autofocus> 
                                  <font color='red'><?php echo form_error('EQUIPE_NOM'); ?></font>               
                              </div>
                              <div class="form-group">
                                  <label>Email</label>
                                  <input type="Email" class="form-control" name="EQUIPE_EMAIL" value="<?=set_value('EQUIPE_EMAIL')?>">
                                  <font color='red'><?php echo form_error('EQUIPE_EMAIL'); ?></font>
                              </div>

                              <div class="form-group">

                                  <label>Télephone  <i title="Ajouter l'indicateur Pays. ex.: BDI : +257">?</i></label>
                                  <div class="input-group">
                                    <span class="input-group-addon">+257</i></span>
                                  <input type="number" class="form-control" name="EQUIPE_TEL" value="<?=set_value('EQUIPE_TEL')?>">
                                </div>
                                  <font color='red'><?php echo form_error('EQUIPE_TEL'); ?></font>                
                              </div>

                              <div class="form-group">
                                  <label>CPPCs </label>
                                  <select name="CPPC_ID" class="form-control">
                                    <option value=""> - Sélectionner - </option>
                                    <?php
                                       foreach ($cppc as $cppcs) {
                                         if($cppcs['CPPC_ID'] == set_value('CPPC_ID')){
                                          ?>
                                            <option value="<?=$cppcs['CPPC_ID']?>" selected><?=$cppcs['CPPC_NOM']?></option>
                                          <?php
                                         }else{
                                          ?>
                                            <option value="<?=$cppcs['CPPC_ID']?>"><?=$cppcs['CPPC_NOM']?></option>
                                          <?php
                                         }
                                       }
                                    ?>
                                  </select>
                                  <font color='red'><?php echo form_error('CPPC_ID'); ?></font>                
                              </div>
                               <div class="form-group">
                                  <label>Service </label>
                                  <select name="SERVICE_CPPC_ID" class="form-control">
                                    <option value=""> - Sélectionner - </option>
                                    <?php
                                       foreach ($services as $val) {
                                         if($val['SERVICE_CPPC_ID'] == set_value('SERVICE_CPPC_ID')){
                                          ?>
                                            <option value="<?=$val['SERVICE_CPPC_ID']?>" selected><?=$val['DESCRIPTION']?></option>
                                          <?php
                                         }else{
                                          ?>
                                            <option value="<?=$val['SERVICE_CPPC_ID']?>"><?=$val['DESCRIPTION']?></option>
                                          <?php
                                         }
                                       }
                                    ?>
                                  </select>
                                  <font color='red'><?php echo form_error('SERVICE_CPPC_ID'); ?></font>                
                              </div>
                              
                              <div class="form-group">
                                 <input type="submit" class="btn btn-primary" value="Enregister">
                              </div>
                           </div>
                           
                      </form>
           </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
          
</body>

</html>


