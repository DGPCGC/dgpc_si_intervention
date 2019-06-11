<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script> 
<!-- <link rel="stylesheet" type="text/css" href="<?=base_url()?>MultiSelect/css/bootstrap-multiselect.css"> -->
<!-- <script type="text/javascript" src="<?=base_url()?>MultiSelect/js/bootstrap-multiselect.js"></script> -->
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
                                   <h4 class=""><b>Alerte</b></h4>  
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                   <a class="btn <?=($this->router->class=='Notification_Alert' && $this->router->method=='index')?'btn-primary':''?>" href="<?=base_url('alerte/Notification_Alert')?>"> Nouvel </a>
                                    <a class="btn <?=($this->router->class=='Notification_Alert' && $this->router->method=='liste')?'btn-primary':''?>" href="<?=base_url('alerte/Notification_Alert/liste')?>"> Liste </a>
                                </div>
                            </div>  
                        </div> 
                         <div class="col-lg-12 jumbotron" style="padding: 5px">
                      <?= $this->session->flashdata('message') ?>   
                      <form method="POST" action="<?=base_url().'alerte/Notification_Alert/index/'.$this->uri->segment(4)?>">
                        <!-- <div class="col-lg-12">
                          <div class="col-md-6"> -->
                            <div class="col-lg-6 col-md-6"> 
                            <?php $code=$this->Model->getOne('tk_ticket',array('TICKET_CODE'=>$this->uri->segment(4)));
                            if($code['TICKET_CODE']==$this->uri->segment(4))
                            {    
                            ?>  
                             <div class="form-group">
                                  <label>Objet</label>
                                  <input type="hidden" class="form-control" name="CODE" value="<?=$ticket['TICKET_CODE']?>"> 
                                  <input type="text" class="form-control" name="DESCR" value="<?=$ticket['TICKET_DESCR'].'  '.$ticket['TICKET_CODE']?>"> 
                                  <font color='red'><?php echo form_error('DESCR'); ?></font>
                              </div>
                            <?php 
                              }?>
                              <div class="form-group">
                                  <label>Message</label>
                                <textarea name="MESSAGE" id="MESSAGE"  value="<?php echo!empty($MESSAGE) ? $MESSAGE : ''; ?>" class="form-control"></textarea>
                                <font color="red"><?php echo form_error('MESSAGE'); ?></font>
                              </div>
                              <div class="form-group">
                                <label>Categorie</label>
                                <select class="form-control selectpicker" multiple data-live-search="true" data-actions-box="true" name="CATEGORIE[]" id="CATEGORIE" onchange="get_others(this)">
                                        <option value="0">Population</option>
                                        <option value="1">Institution</option>
                                        <option value="2">Partenaire</option>
                                </select>
                                <font color="red"><?php echo form_error('CATEGORIE[]'); ?></font>
                            </div>
                          <div class="form-group">
                            <div class="col-md-4 col-sm-12 col-xs-12 col-md-push-1">
                            <input type="checkbox" id="CHECK1"
                             name="CHECK1[]" value="1">
                            <label for="CHECK2">Sms</label>
                            <input type="checkbox" id="CHECK1"
                             name="CHECK1[]" value="2">
                            <label for="CHECK1">Email</label>
                            <font color="red"><?php echo form_error('CHECK1[]'); ?></font>
                        </div>
                        </div> 
                      </div>
                      <div class="col-lg-6 col-md-6"> 
                         <div class="form-group" id="COMMUNES">
                            <label>Commune</label>
                                <select class="form-control" name="COMMUNE" id="COMMUNE">
                                       <option value="">--Choisir--</option>
                                       <?php foreach ($communes as $key => $value) {
                                          echo "<option value='".$value['COMMUNE_ID']."'>".$value['COMMUNE_NAME']."</option>";
                                    }?>
                                </select>
                                <font color="red"><?php echo form_error('COMMUNE'); ?></font>
                        </div>
                        <div class="form-group" id="institution">
                            <label>Institutions</label>
                                <select class="selectpicker form-control" name="INSTITUTION[]" id="INSTITUTION" data-live-search="true" data-actions-box="true" multiple="multiple">
                                </select>
                                <font color="red"><?php echo form_error('INSTITUTION[]'); ?></font>
                          </div>
                       
                       <div class="form-group" id="partenaire">
                            <label>Partenaires</label>
                                <select class="selectpicker form-control" name="PARTENAIRE[]" id="PARTENAIRE" data-live-search="true" data-actions-box="true" multiple="multiple">
                                </select>
                                <font color="red"><?php echo form_error('PARTENAIRE[]'); ?></font>
                          </div>

                       
                        <div class="form-group" id="personne">
                            <label>Personnes</label>
                                <select class="selectpicker form-control" name="PERSONNE[]" id="PERSONNE" data-live-search="true" data-actions-box="true" multiple="multiple">
                                </select>
                                <font color="red"><?php echo form_error('PERSONNE[]'); ?></font>
                            </div>
                   </div> 
                   <div class="col-md-12">
                   <div class="form-group">
                            <label></label>
                                <input type="submit" class="btn btn-primary btn-block add" value="Enregistrer"/>
                      </div>
                    </div>
                </form>
           </div>
           
       </div>
     </div>

     </div>

</body>
<script type="text/javascript">
  function get_others(val){
    var n=$('#CATEGORIE').val();




     if($(val).val() == '0'){ 
            $('#COMMUNES').show();
            $('#personne').show();
            $('#partenaire').hide();
            $('#institution').hide();
            $(document).on('change', '#COMMUNE', function(){
  
    var n=$('#COMMUNE').val(); 
             $.ajax({
                          url:"<?php echo base_url()?>alerte/Notification_Alert/select_personne",
                          method:"POST",
                          data: {COMMUNE:n},

                              success:function(data)
                              { 
                                $('#PERSONNE').html(data);
                                $('#PERSONNE').selectpicker('refresh');
                              }


            });
   });
             }
            else if($(val).val()=='1'){
              // $('#COMMUNE').prop("disabled",true);
              $('#COMMUNES').hide();
              $('#personne').hide();
              $('#institution').show();
              $('#partenaire').hide();

              $.ajax({
                          url:"<?php echo base_url()?>alerte/Notification_Alert/select_institution",
                          method:"POST",
                          data: {},

                              success:function(data)
                              {
                                $('#INSTITUTION').html(data);
                                $('#INSTITUTION').selectpicker('refresh');
                              }


            });
             }
            else if($(val).val()=='2'){
              // $('#COMMUNE').prop("disabled",true);
              $('#COMMUNES').hide();
              $('#personne').hide();
              $('#institution').hide();
              $('#partenaire').show();

              $.ajax({
                      url:"<?php echo base_url()?>alerte/Notification_Alert/select_partenaire",
                      method:"POST",
                      data: {},

                          success:function(data)
                          {
                            $('#PARTENAIRE').html(data);
                            $('#PARTENAIRE').selectpicker('refresh');
                          }
                });
             }
             else if($(val).val()=='0,1'){
                $('#COMMUNES').show();
                $('#institution').show();
                $('#personne').show();
                $('#partenaire').hide();

               $(document).on('change', '#COMMUNE', function(){
                 
    var n=$('#COMMUNE').val(); 
    
             $.ajax({
                      url:"<?php echo base_url()?>alerte/Notification_Alert/select_personne",
                      method:"POST",
                      data: {COMMUNE:n},

                          success:function(data)
                          {  
                            $('#PERSONNE').html(data);
                            $('#PERSONNE').selectpicker('refresh');
                          }
                 });
          });
               $.ajax({
                          url:"<?php echo base_url()?>alerte/Notification_Alert/select_institution",
                          method:"POST",
                          data: {},

                              success:function(data)
                              {  
                                $('#INSTITUTION').html(data);
                                $('#INSTITUTION').selectpicker('refresh');
                              }
                      });
  } else if($(val).val()=='0,2'){
                $('#COMMUNES').show();
                $('#institution').hide();
                $('#personne').show();
                $('#partenaire').show();

               $(document).on('change', '#COMMUNE', function(){
                 
    var n=$('#COMMUNE').val(); 
    
             $.ajax({
                      url:"<?php echo base_url()?>alerte/Notification_Alert/select_personne",
                      method:"POST",
                      data: {COMMUNE:n},

                          success:function(data)
                          {  
                            $('#PERSONNE').html(data);
                            $('#PERSONNE').selectpicker('refresh');
                          }
                 });
          });
              $.ajax({
                      url:"<?php echo base_url()?>alerte/Notification_Alert/select_partenaire",
                      method:"POST",
                      data: {},

                          success:function(data)
                          {
                            $('#PARTENAIRE').html(data);
                            $('#PARTENAIRE').selectpicker('refresh');
                          }
                });
  }else if($(val).val()=='1,2'){
                $('#COMMUNES').hide();
                $('#institution').show();
                $('#personne').hide();
                $('#partenaire').show();
               $.ajax({
                          url:"<?php echo base_url()?>alerte/Notification_Alert/select_institution",
                          method:"POST",
                          data: {},

                              success:function(data)
                              {  
                                $('#INSTITUTION').html(data);
                                $('#INSTITUTION').selectpicker('refresh');
                              }
                      });
              $.ajax({
                      url:"<?php echo base_url()?>alerte/Notification_Alert/select_partenaire",
                      method:"POST",
                      data: {},

                          success:function(data)
                          {
                            $('#PARTENAIRE').html(data);
                            $('#PARTENAIRE').selectpicker('refresh');
                          }
                });
  }else if($(val).val()=='0,1,2'){
                $('#COMMUNES').show();
                $('#institution').show();
                $('#personne').show();
                $('#partenaire').show();
                $(document).on('change', '#COMMUNE', function(){
  
    var n=$('#COMMUNE').val(); 
             $.ajax({
                          url:"<?php echo base_url()?>alerte/Notification_Alert/select_personne",
                          method:"POST",
                          data: {COMMUNE:n},

                              success:function(data)
                              { 
                                $('#PERSONNE').html(data);
                                $('#PERSONNE').selectpicker('refresh');
                              }


            });
   });
               $.ajax({
                          url:"<?php echo base_url()?>alerte/Notification_Alert/select_institution",
                          method:"POST",
                          data: {},

                              success:function(data)
                              {  
                                $('#INSTITUTION').html(data);
                                $('#INSTITUTION').selectpicker('refresh');
                              }
                      });
              $.ajax({
                      url:"<?php echo base_url()?>alerte/Notification_Alert/select_partenaire",
                      method:"POST",
                      data: {},

                          success:function(data)
                          {
                            $('#PARTENAIRE').html(data);
                            $('#PARTENAIRE').selectpicker('refresh');
                          }
                });
  }

}
</script>
</html>
