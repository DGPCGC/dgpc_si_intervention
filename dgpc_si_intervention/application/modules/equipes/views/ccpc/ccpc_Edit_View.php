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
                                    <?php include 'menu_ccpc.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12" style="padding: 5px">
                      <?php
                         if($this->session->flashdata('msg'))
                         echo $this->session->flashdata('msg');
                       ?>   
                      <form method="POST" action="">
                           <div class="col-lg-12 col-md-12">
                              <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <label >CPPC</label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                    <select name="CPPC" class="form-control" autofocus>
                                    <option value=""> - Sélectionner - </option>
                                    <?php
                                       foreach ($cppc as $ccpcs) {
                                         if($ccpcs['CPPC_ID'] ==$ccpc['CPPC_ID']){
                                          ?>
                                            <option value="<?=$ccpcs['CPPC_ID']?>" selected><?=$ccpcs['CPPC_NOM']?></option>
                                          <?php
                                         }else{
                                          ?>
                                            <option value="<?=$ccpcs['CPPC_ID']?>"><?=$ccpcs['CPPC_NOM']?></option>
                                          <?php
                                         }
                                       }
                                    ?>
                                  </select> 
                                  <font color='red'><?php echo form_error('CPPC'); ?></font> 
                                </div>
                                                
                              </div>
                              <div class="row">
                                <div class="col-lg-3 col-md-3">
                                  <label>Description de la CCPC</label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                  <input type="text" class="form-control" name="CCPC_DESCR" value="<?=$ccpc['DESCRIPTION'] ?>"> 
                                  <font color='red'><?php echo form_error('CCPC_DESCR'); ?></font> 
                                  </div>              
                              </div>
                              
                
                              <div class="row">
                                <div class="col-lg-3 col-md-3">
                                  <label>Province </label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                  <select name="PROVINCE_ID" id="PROVINCE_ID" class="form-control">
                                    <option value=""> - Sélectionner - </option>
                                    <?php
                                       foreach ($provinces as $province) {
                                         if($commune['PROVINCE_ID'] == $province['PROVINCE_ID']){
                                          ?>
                                            <option value="<?=$province['PROVINCE_ID']?>" selected><?=$province['PROVINCE_NAME']?></option>
                                          <?php
                                         }else{
                                          ?>
                                            <option value="<?=$province['PROVINCE_ID']?>"><?=$province['PROVINCE_NAME']?></option>
                                          <?php
                                         }
                                       }
                                    ?>
                                  </select>
                                  <font color='red'><?php echo form_error('PROVINCE_ID'); ?></font>  
                                  </div>              
                              </div>

                               <div class="row">
                                <div class="col-lg-3 col-md-3">
                                  <label>Commune </label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                   <select name="COMMUNE_ID" id="communes" class="form-control">
                                    <option value="<?=$commune['COMMUNE_ID'] ?>" selected><?=$commune['COMMUNE_NAME'] ?></option>
                                   </select>
                                  <!-- <p id="communes"></p> -->
                                  <font color='red'><?php echo form_error('COMMUNE_ID'); ?></font>
                                </div>
                               </div>

                               <div class="row">
                                <div class="col-lg-3 col-md-3">
                                  <label>Longitude </label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                  <input type="text" class="form-control" name="CCPC_LONG" value="<?=$ccpc['LONGITUDE'] ?>">
                                  <font color='red'><?php echo form_error('CASERNE_LONG'); ?></font>  
                                </div>              
                              </div>
                               <div class="row">
                                <div class="col-lg-3 col-md-3">
                                  <label>Latitude </label>
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                  <input type="text" class="form-control" name="CCPC_LAT" value="<?=$ccpc['LATITUDE'] ?>">
                                  <font color='red'><?php echo form_error('CASERNE_LAT'); ?></font> 
                                  </div>               
                              </div>
                              
                              <div class="form-group">
                                 <input type="submit" class="btn btn-primary" value="Modifier">
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
        var PROVINCE_ID = $("#PROVINCE_ID").val();
            $.ajax({
                    url: "<?php echo base_url(); ?>tickets/Tickets/getCommune",
                    method: "POST",
                    data: {PROVINCE_ID: PROVINCE_ID},
                    dataType: "html",
                    success: function (data) {
                        // $("#communes").html(data);
                    }
                });
            
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

       $("#CAUSE_ID").change(function () {
       var id=$("#CAUSE_ID").val();
         $.ajax({
                    // url: "<?php echo base_url(); ?>tickets/Tickets/infoCause",
                    // method: "POST",
                    // data: {id:id},
                    // dataType: "html",
                    // success: function (stutut) {
                    //  alert(stutut);
                    //   if("AUTR"==stutut){
                    //      $("#autre").html('aaa');
                    //      // $("#autre").html('');
                    //      $("#autre").html('<input type="text" class="form-control" name="AUTRE" value="" required>');
                    //    }
                    //      }
                url:"<?php echo base_url() ?>tickets/Tickets/infoCause",
              method:"POST",
              async:false,
              data: {id:id},                           
              success:function(data)
                            { if(data==1){
                              $("#autre").html('<div class="col-lg-6 col-md-6"><br><input type="text" class="form-control" placeholder="Description de la cause" name="AUTRE" value="" required></div><div class="col-lg-6 col-md-6"><br><input type="text" class="form-control" name="CODE" placeholder="code de la cause" value="" required></div>');
                            }else{
                            $("#autre").html('');
                            }
                            }    
                });

      });
    });

</script>

