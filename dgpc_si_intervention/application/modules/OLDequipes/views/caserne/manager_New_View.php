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

            <!-- Page Content -->
            
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
                   
                      <form method="POST" action="<?=base_url().'equipes/Caserne/add_manager'?>" name="formulaire">
                           <div class="col-lg-6 col-md-6">   
                              <div class="form-group">
                                  <label>Nom Cppc</label>
                                  <select name="CPPC_ID" class="form-control">
                                    <option value=""> - Sélectionner - </option>
                                      <?php
                                        $cppc_id=$this->uri->segment(4);
                                        foreach ($cppc as $cppcs) {
                                          if($cppcs['CPPC_ID']==$cppc_id){?>
                                            <option value="<?=$cppcs['CPPC_ID']?>" selected><?=$cppcs['CPPC_NOM'] ?></option>
                                            <?php
                                          }else{
                                          ?>
                                           <option value="<?=$cppcs['CPPC_ID']?>" ><?=$cppcs['CPPC_NOM'] ?></option>
                                         <?php 
                                          }
                                        }
                                    
                                      ?>
                                  </select>
                                  <font color='red'><?php echo form_error('PERSONNEL_ID'); ?></font>
                              </div>
                              <div class="form-group">
                                  <label>Personnel</label>
                                  <select name="PERSONNEL_ID" id="PERSONNEL_ID" class="form-control">
                                    <option value=""> - Sélectionner - </option>
                                      <?php
                                        foreach ($personnel as $personnels) {
                                          $id_personnel=$this->uri->segment(5);
                                          if($personnels['PERSONNEL_ID']==$id_personnel){
                                            ?>
                                              <option value="<?=$personnels['PERSONNEL_ID']?>" selected><?=$personnels['PERSONNEL_NOM'].' '.$personnels['PERSONNEL_PRENOM'] ?></option>
                                            <?php
                                          }else{
                                          ?>
                                           <option value="<?=$personnels['PERSONNEL_ID']?>" ><?=$personnels['PERSONNEL_NOM'].' '.$personnels['PERSONNEL_PRENOM'] ?></option>
                                         <?php 
                                          }
                                        }
                                    
                                      ?>
                                  </select>
                                  <font color='red'><?php echo form_error('PERSONNEL_ID'); ?></font>
                              </div>
                              <div class="form-group">
                                  <label>Date Debut</label>
                                  <input type="text" class="form-control" name="DATE_DEBUT" id="DATE_DEBUT" autocomplete="off">
                                   <!-- <input type="hidden" class="form-control" name="CPPC_ID" id="CPPC_ID" value=""> -->
                                  <font color='red'><?php echo form_error('DATE_DEBUT'); ?></font>            
                              </div>                               
                              
                              
                          </div>                            
                        
                           
                      </form>
                           <div class="form-group">
                                 <input type="button" class="btn btn-primary" value="Enregister" onclick="submit()">
                              </div>
                   </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->


</body>

</html>
<script type="text/javascript">
  var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('#DATE_DEBUT').datepicker({
          format: 'dd-mm-yyyy',
          startDate: '0'
        });

    
</script>
<script>
   $("#PERSONNEL_ID").change(function () {
      
      var remplacant="";

            var PERSONNEL_ID = $("#PERSONNEL_ID").val();
            $.ajax({
                    url: "<?php echo base_url(); ?>equipes/Caserne/getName",
                    method: "POST",
                    data: {PERSONNEL_ID: PERSONNEL_ID},
                    dataType: "html",
                    success: function (data) {
                        remplacant=data;
                       // alert(remplacant); 
                    }
                });
        });
    function submit(){
          var remplacant="";

            var PERSONNEL_ID = $("#PERSONNEL_ID").val();
            $.ajax({
                    url: "<?php echo base_url(); ?>equipes/Caserne/getName",
                    method: "POST",
                    data: {PERSONNEL_ID: PERSONNEL_ID},
                    dataType: "html",
                    success: function (data) {
                        remplacant=data;
                       // alert(remplacant); 
                    }
                });     
               
        var cppc="<?=$this->uri->segment(4) ?>";
        $.ajax({
                    url: "<?php echo base_url(); ?>equipes/Caserne/getExisteManager",
                    method: "POST",
                    data: {cppc: cppc},
                    dataType: "html",
                    success: function (data) {
                        //$("#communes").html(data);
                        var info=data.split('|');
                        var nom=info[1];
                        if(info[0]==1){
                          var retVal = confirm(nom+" est Manager. Voulez vs le remplacer par "+remplacant+"?");
                          if( retVal == true ) {
                              formulaire.submit();
                           } 
                        }else{
                          formulaire.submit();
                        }
                    }
                });
    }




    $(document).ready(function () {
      // $("#PROVINCE_ID").datepicker();
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