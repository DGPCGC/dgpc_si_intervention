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
                                <?php //$breadcrumb ?> 
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b><?=$title?></b></h4>  
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                    <?php include 'menu_ticket.php' ?>
                                </div>
                            </div>  
                        </div> 
                  <div class="col-lg-12" style="padding: 5px">
                      <?= $this->session->flashdata('message') ?> 
                      <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 20px">
                        <li role="presentation" class="active" id='li_descr'><a href="#" aria-controls="identite" role="tab">Déscription</a></li>
                        <li role="presentation" id='li_impact'><a href="#" aria-controls="cotation" role="tab">Impacts</a></li>
                        <li role="presentation" id='li_qualif'><a href="#" aria-controls="soins" role="tab" >Qualification</a></li>
                        <li role="presentation" id='li_assign'><a href="#" aria-controls="soins" role="tab">Assignation</a></li>
                        
                      </ul>

                      <div class="tab-content">
                        
                        <div role='tabpanel' class='tab-pane active' id='description'>
                          <form method="POST" action="<?=base_url().'tickets/Tickets/save_modification/'.$ticket['TICKET_ID']?>">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                  <label>Déclarant</label>
                                  <input type="text" class="form-control" name="TICKET_DECLARANT" value="<?=$ticket['TICKET_DECLARANT']?>" autofocus>
                                  <font color='red'><?php echo form_error('TICKET_DECLARANT'); ?></font>                
                                </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                  <label>Tél Déclarant</label>
                                  <input class="form-control" name="TICKET_DECLARANT_TEL" value="<?=$ticket['TICKET_DECLARANT_TEL']?>">
                                  <font color='red'><?php echo form_error('TICKET_DECLARANT_TEL'); ?></font>

                                </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                  <label>Description</label>
                                  <input class="form-control" name="TICKET_DESCR" value="<?=$ticket['TICKET_DESCR']?>">  
                                  <font color='red'><?php echo form_error('TICKET_DESCR'); ?></font>
                              </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                  <label>Canal</label>
                                  <select name="CANAL_ID" class="form-control">
                                      <option value=""> - Sélectionner - </option>
                                      <?php
                                        foreach ($canals as $canal) {
                                          if($canal['CANAL_ID'] == $ticket['CANAL_ID']){
                                         ?>
                                          <option value="<?=$canal['CANAL_ID']?>" selected><?=$canal['CANAL_DESCR']?></option>
                                         <?php  
                                        }
                                        else{
                                          ?>
                                           <option value="<?=$canal['CANAL_ID']?>" ><?=$canal['CANAL_DESCR']?></option>
                                         <?php 
                                        }
                                    }
                                      ?>
                                  </select>
                                  <font color='red'><?php echo form_error('CANAL_ID'); ?></font>
                              </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                  <label>Provinces</label>
                                  <select name="PROVINCE_ID" id='PROVINCE_ID' class="form-control">
                                      <option value=""> - Sélectionner - </option>
                                      <?php
                                        foreach ($provinces as $province) {
                                          if($province['PROVINCE_ID'] ==$commune['PROVINCE_ID']){
                                         ?>
                                          <option value="<?=$province['PROVINCE_ID']?>" selected><?=$province['PROVINCE_NAME']?></option>
                                         <?php  
                                        }
                                        else{
                                          ?>
                                           <option value="<?=$province['PROVINCE_ID']?>" ><?=$province['PROVINCE_NAME']?></option>
                                         <?php 
                                        }
                                    }
                                      ?>
                                  </select>
                                  <font color='red'><?php echo form_error('PROVINCE_ID'); ?></font>

                                </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                  <label>Commune</label>
                                  <!--  <select name="PROVINCE_ID"  class="form-control">
                                    <option></option>
                                   </select> -->
                                  <p id="communes"></p>
                                  <font color='red'><?php echo form_error('COMMUNE_ID'); ?></font>
                                 
                              </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                  <label>Localité</label>
                                  <input class="form-control" name="LOCALITE" value="<?=$ticket['LOCALITE']?>">
                                  <font color='red'><?php echo form_error('LOCALITE'); ?></font>
                              </div>
                              
                              </div>
                              <div class="col-12 col-md-12">
                                <div class="form-group">
                                 <input type="button" class="btn btn-success" onclick='suivant_impact()' value="suivant">
                                </div>
                              </div>
                        </div>
                        <div role='tabpanel' class='tab-pane' id='impact'>
                          
                          <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                  <label>Nombre de bléssé(e)s</label>
                                  <input type="text" class="form-control" name="NOMBRE_BLESSE" value="<?=$ticket['NOMBRE_BLESSE']?>">
                                  <font color='red'><?php echo form_error('NOMBRE_BLESSE'); ?></font>
                              </div>
                          </div>
                          
                          <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                  <label>Nombre de morts</label>
                                  <input type="text" class="form-control" name="NOMBRE_MORT" value="<?=$ticket['NOMBRE_MORT']?>">
                                  <font color='red'><?php echo form_error('NOMBRE_MORT'); ?></font>
                              </div>
                          </div>
                          <div class="col-12 col-md-12">
                                <div class="form-group">
                                 <input type="button" class="btn btn-success" value="Précedent" onclick='precent_description()'>

                                 <input type="button" class="btn btn-success" value="Suivant" onclick='suivant_qualification()'>
                                </div>
                              </div>
                        
                        </div>
                        <div role='tabpanel' class='tab-pane' id='qualification'>
                        <div class="col-lg-6 col-md-6">
                          <div class="col-lg-12 col-md-12">
                                <label>Catégorie</label>
                                  <select name="CATEGORIE_ID" class="form-control">
                                    <option value=""> - Sélectionner - </option>
                                      <?php
                                        foreach ($categories as $categorie) {
                                          if($categorie['CATEGORIE_ID'] == $ticket['CATEGORIE_ID']){
                                         ?>
                                          <option value="<?=$categorie['CATEGORIE_ID']?>" selected><?=$categorie['CATEGORIE_DESCR']?></option>
                                         <?php  
                                        }
                                        else{
                                          ?>
                                           <option value="<?=$categorie['CATEGORIE_ID']?>" ><?=$categorie['CATEGORIE_DESCR']?></option>
                                         <?php 
                                        }
                                    }
                                      ?>
                                  </select>
                                  <font color='red'><?php echo form_error('CATEGORIE_ID'); ?></font>
                              </div>
                          <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                  <label>Causes</label>
                                  <select name="CAUSE_ID" id="CAUSE_ID" class="form-control">
                                    <option value=""> - Sélectionner - </option>
                                      <?php
                                        foreach ($causes as $cause) {
                                          if($cause['CAUSE_ID'] == $ticket['CAUSE_ID']){
                                         ?>
                                          <option value="<?=$cause['CAUSE_ID']?>" selected><?=$cause['CAUSE_DESCR']?></option>
                                         <?php  
                                        }
                                        else{
                                          ?>
                                           <option value="<?=$cause['CAUSE_ID']?>" ><?=$cause['CAUSE_DESCR']?></option>
                                         <?php 
                                        }
                                    }
                                      ?>
                                  </select>
                                  <font color='red'><?php echo form_error('CAUSE_ID'); ?></font>

                              </div>
                          </div>
                           <div class="col-12 col-md-12">
                                <div class="form-group">
                                 <input type="button" class="btn btn-success" value="Précedent" onclick='precent_impact()'>

                                 <input type="button" class="btn btn-success" value="Suivant" onclick='suivant_assignation()'>
                                </div>
                              </div>
                        </div>

                        
                        </div>
                        <div role='tabpanel' class='tab-pane' id='assignation'>
                          <div class="col-lg-6 col-md-6">
                           <div class="col-lg-12 col-md-12">
                             <div class="form-group">
                                  <label>CPPCs</label>
                                 <select name="CPPC_ID" id='CPPC_ID' class="form-control">
                                      <option value=""> - Sélectionner - </option>
                                      <?php
                                        foreach ($cppcs as $cppc) {
                                          if($cppc['CPPC_ID'] == $ticket['CPPC_ID']){
                                         ?>
                                          <option value="<?=$cppc['CPPC_ID']?>" selected><?=$cppc['CPPC_NOM']?></option>
                                         <?php  
                                        }
                                        else{
                                          ?>
                                           <option value="<?=$cppc['CPPC_ID']?>" ><?=$cppc['CPPC_NOM']?></option>
                                         <?php 
                                        }
                                    }
                                      ?>
                                  </select>
                                  <font color='red'><?php echo form_error('CPPC_ID'); ?></font>
                              </div>
                           </div>
                           <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                  <label>Commentaire</label>
                                  <textarea class="form-control" name="COMMENTAIRE"> <?=$ticket['COMMENTAIRE']?></textarea>
                              </div>
                           </div>
                           <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                              <label>Notifier DAHMI</label><br>
                              <input type='radio' name='NOTIFIE_DAHMI' value='1' id="dahmi_oui"> Oui<br>
                              <input type='radio' name='NOTIFIE_DAHMI' value='0' id="dahmi_non"> Non<br>
                            </div>
                           </div>

                           </div>
                           <div id="mtrl" class="col-lg-6 col-md-6"></div>
                            <div class="col-12 col-md-12">
                              <div class="col-12 col-md-12">
                                <div class="form-group">
                                <input type="button" class="btn btn-success" value="Précedent" onclick="precent_qualification()">
                                 <input type="submit" class="btn btn-primary" value="Modifier">
                                </div>
                              </div>
                            </div>
                            </form>
                          </div>
                        
                        </div>

                      </div>

                </div>
                    <!-- /.row -->
                </div>
            
    
</body>

</html>
<script>
    $(document).ready(function () {
        var PROVINCE_ID = $("#PROVINCE_ID").val();
        var COMMUNE_ID = <?php echo $ticket['COMMUNE_ID']?>;
            $.ajax({
                    url: "<?php echo base_url(); ?>tickets/Tickets/getCommune",
                    method: "POST",
                    data: {PROVINCE_ID: PROVINCE_ID,COMMUNE_ID:COMMUNE_ID},
                    dataType: "html",
                    success: function (data) {
                      var com=data.split("|");
                        $("#communes").html(com[0]);
                    }
                });

        $("#PROVINCE_ID").change(function () {
            var PROVINCE_ID = $("#PROVINCE_ID").val();
            $.ajax({
                    url: "<?php echo base_url(); ?>tickets/Tickets/getCommune",
                    method: "POST",
                    data: {PROVINCE_ID: PROVINCE_ID,COMMUNE_ID:COMMUNE_ID},
                    dataType: "html",
                    success: function (data) {
                        var com=data.split("|");
                        $("#communes").html(com[0]);
                    }
                });
        });
    });

</script>
<script type="text/javascript">
  function suivant_impact(){
    $('#description').hide();
    //$('#li_impact').css('class','active');
    document.getElementById("li_descr").className = "";
    document.getElementById("li_impact").className = "active";
    $('#impact').show();
  }

  function precent_description(){
    // alert('ben');
    $('#description').show();
    $('#impact').hide();
    document.getElementById("li_descr").className = "active";
    document.getElementById("li_impact").className = "";
  }
  function suivant_qualification(){
    $('#qualification').show();
    $('#impact').hide();
    document.getElementById("li_impact").className = "";
    document.getElementById("li_qualif").className = "active";
    

  }
  function precent_impact(){
    $('#impact').show();
    $('#qualification').hide();
    document.getElementById("li_impact").className = "active";
    document.getElementById("li_qualif").className = "";
  }
function suivant_assignation(){
    $('#assignation').show();
    $('#qualification').hide();
    document.getElementById("li_qualif").className = "";
    document.getElementById("li_assign").className = "active";
    
  

}
function precent_qualification(){
   $('#assignation').hide();
    $('#qualification').show();
    document.getElementById("li_qualif").className = "active";
    document.getElementById("li_assign").className = "";

}

  var id=$('#CPPC_ID').val();
    var CATEGORIE_ID = $("#CATEGORIE_ID").val();
    var CAUSE_ID = $("#CAUSE_ID").val();
   $.ajax({
          url:"<?php echo base_url() ?>tickets/Tickets/materiaux",
          method:"POST",
          //async:false,
           data: {id:id,CATEGORIE_ID:CATEGORIE_ID,CAUSE_ID:CAUSE_ID},
                                                               
          success:function(data){  
              $('#mtrl').html(data);
            }
          });
   
$('#CPPC_ID').change(function(){
     var id=$('#CPPC_ID').val();
    var CATEGORIE_ID = $("#CATEGORIE_ID").val();
    var CAUSE_ID = $("#CAUSE_ID").val();
   $.ajax({
          url:"<?php echo base_url() ?>tickets/Tickets/materiaux",
          method:"POST",
          //async:false,
           data: {id:id,CATEGORIE_ID:CATEGORIE_ID,CAUSE_ID:CAUSE_ID},
                                                               
          success:function(data){  
              $('#mtrl').html(data);
            }
          });
 });

var CAUSE_ID = $('#CAUSE_ID').val();

  $.ajax({
          url:"<?php echo base_url() ?>tickets/Tickets/testerNotificationDAHMI",
          method:"POST",
          data: {CAUSE_ID:CAUSE_ID},                                                               
          success:function(data)
                {
                if(data ==1){ 
                  $('#dahmi_oui').attr("checked",true);}
                else{
                  $('#dahmi_non').attr("checked",true);
                }
                }
   });
$("#CAUSE_ID").change(function() {
  $.ajax({
          url:"<?php echo base_url() ?>tickets/Tickets/testerNotificationDAHMI",
          method:"POST",
          data: {CAUSE_ID:CAUSE_ID},                                                               
          success:function(data)
                {
                if(data ==1){ 
                  $('#dahmi_oui').attr("checked",true);}
                else{
                  $('#dahmi_non').attr("checked",true);
                }
                }
   });
         var id=$('#CPPC_ID').val();
    var CATEGORIE_ID = $("#CATEGORIE_ID").val();
    var CAUSE_ID = $("#CAUSE_ID").val();
 // alert(id);

  $.ajax({
            url:"<?php echo base_url() ?>tickets/Tickets/materiaux",
            method:"POST",
            //async:false,
            data: {id:id,CATEGORIE_ID:CATEGORIE_ID,CAUSE_ID:CAUSE_ID},
                                                                 
            success:function(data)
                  { 
                    $('#mtrl').html(data);
                  }
});
})
</script>
</script>

