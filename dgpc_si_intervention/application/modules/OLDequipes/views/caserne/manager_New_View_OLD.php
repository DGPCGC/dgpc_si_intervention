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
                                   <h4 class=""><b><?=$title?></h4>  
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                    <?php include 'menu_caserne.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12 jumbotron" style="padding: 5px">
                  <?php
                         if($this->session->flashdata('msg'))
                         echo $this->session->flashdata('msg');
                       ?>  
                   
                      <form method="POST" action="">
                           <div class="col-lg-6 col-md-6">   
                              <div class="form-group">
                                  <label>Personnel</label>
                                  <select name="PERSONNEL_ID" class="form-control">
                                    <option value=""> - Sélectionner - </option>
                                      <?php
                                        foreach ($personnel as $personnels) {
                                          ?>
                                           <option value="<?=$personnels['PERSONNEL_ID']?>" ><?=$personnels['PERSONNEL_NOM'].' '.$personnels['PERSONNEL_PRENOM'] ?></option>
                                         <?php 
                                        }
                                    
                                      ?>
                                  </select>
                                  <font color='red'><?php echo form_error('PERSONNEL_ID'); ?></font>
                              </div>
                              <div class="form-group">
                                  <label>Date Debut</label>
                                  <input type="date" class="form-control" name="DATE_DEBUT" id="DATE_DEBUT">
                                   <input type="hidden" class="form-control" name="CPPC_ID" id="CPPC_ID" value="<?=$this->uri->segment(4) ?>">
                                  <font color='red'><?php echo form_error('DATE_DEBUT'); ?></font>            
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
<script>
    $(document).ready(function () {
        $("#PROVINCE_ID").change(function () {
            var PROVINCE_ID = $("#PROVINCE_ID").val();
            $.ajax({
                    url: "<?php echo base_url(); ?>tickets/Tickets/getCommune",
                    method: "POST",
                    data: {PROVINCE_ID: PROVINCE_ID},
                    dataType: "html",
                    success: function (data) {
                        $("#communes").html(data);
                    }
                });
        });
    });

</script>