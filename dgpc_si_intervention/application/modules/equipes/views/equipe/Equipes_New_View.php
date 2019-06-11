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
   
                      <form id="myform" method="POST" action="<?=base_url().'equipes/Equipes/save'?>">
                           <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>Nom d'équipe</label>
                                  <input type="text" class="form-control" name="EQUIPE_NOM" value="<?=set_value('EQUIPE_NOM')?>" autofocus> 
                                  <font color='red'><?php echo form_error('EQUIPE_NOM'); ?></font>               
                              </div>
                              <div class="form-group">
                                  <label>Email</label>
                                  <input type="text" class="form-control" name="EQUIPE_EMAIL" value="<?=set_value('EQUIPE_EMAIL')?>">
                                  <font color='red'><?php echo form_error('EQUIPE_EMAIL'); ?></font>
                              </div>

                              <div class="form-group">

                                  <label>Télephone  <i title="Ajouter l'indicateur Pays. ex.: BDI : +257">?</i></label>
                                  <div class="input-group">
                                    <span class="input-group-addon">+257</i></span>
                                  <input type="text" class="form-control" name="EQUIPE_TEL" value="<?=set_value('EQUIPE_TEL')?>">
                                </div>
                                  <font color='red'><?php echo form_error('EQUIPE_TEL'); ?></font>                
                              </div>

                              <div class="form-group">
                                  <label>CPPCs </label>
                                  <select id="CPPC_ID" name="CPPC_ID" class="form-control">
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
                               <!-- <div class="form-group">
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
                              </div> -->
                              <div class="form-group">
                                  <label>Horaire</label>
                                  <select id="TRANCHE" name="TRANCHE" class="form-control">
                                    <option value=""> - Sélectionner - </option>
                                    <?php
                                    if(set_value('TRANCHE')=="00h-08h"){
                                      ?>
                                    <option value="00h-08h" selected> 00h-08h </option>
                                  <?php }else{ ?>
                                    <option value="00h-08h"> 00h-08h </option>
                                  <?php }
                                    if(set_value('TRANCHE')=="08h-16h"){
                                      ?>
                                    <option value="08h-16h" selected> 08h-16h </option>
                                    <?php }else{ ?>
                                       <option value="08h-16h"> 08h-16h </option>
                                       <?php }
                                    if(set_value('TRANCHE')=="16h-24h"){
                                      ?>
                                    <option value="16h-24h" selected> 16h-24h </option>
                                   <?php }else{ ?>
                                    <option value="16h-24h"> 16h-24h </option>
                                  <?php } ?>

                                  </select>
                                  <font color='red'><?php echo form_error('TRANCHE'); ?></font>
                              </div>
                              <div class="form-group">
                                  <div class="col-md-6" >
                                  <input type="radio" id="type_equipe" name="type_equipe" value="1" checked>
                                  <label>Equipe principale</label>
                                </div>
                                <div class="col-md-6">
                                  
                                  <input type="radio" id="type_equipe" name="type_equipe" value="2">
                                  <label>Equipe de secour</label>
                                  
                              </div>
                              
                              <div class="form-group">
                                 <input type="button" id="sub" class="btn btn-primary" value="Enregister">
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
<script type="text/javascript">
  $(document).on('click','#sub',function(){
var type_equipe=$("input[name='type_equipe']:checked").val();
var cppc=$("#CPPC_ID").val();
var horaire=$("#TRANCHE").val();

// $.ajax({
//               url:"<?php echo base_url() ?>equipes/Equipes/check_horaire",
//               method:"POST",
//               async:false,
//               data: {type_equipe:type_equipe,cppc:cppc,horaire:horaire},
                                         
//               success:function(stutus)
//                             {
                       
//                              alert(stutus); 
//                           }

                            
//                           });

    $("#myform").submit();

 });

  $.validator.addMethod( "lettersonly", function( value, element ) {
  return this.optional( element ) || /^[a-zA-Záéèçàûïëöâãäùêíóúý-]+$/i.test( value );
}, "Solo letras por favor" );
$("#myform").validate({ignore: "",
              rules:{
              
               EQUIPE_NOM: { required: true},
               PRENOM: { required: true, lettersonly: true},
               EQUIPE_TEL: {required: true,number:true},
               EQUIPE_EMAIL: {required: true,email: true}, 
               CPPC_ID: {required: true},
                 
              TRANCHE: {required: true},
             
              
                 },
                 

              messages:{
                EQUIPE_NOM: {
                 required: "<span style='color:red'>Ce champ est obligatoire</span>",
                 lettersonly: "<span style='color:red'>Veuillez Entrer uniquement les chaines de caractères</span>"
               },
               
                EQUIPE_TEL: {
                 required: "<span style='color:red'>Ce champ est obligatoire</span>",
                 number: "<span style='color:red'>Veuillez Entrer uniquement les digits</span>"
               }, EQUIPE_EMAIL: {
                 required: "<span style='color:red'>Ce champ est obligatoire</span>",
                  email: "<span style='color:red'>Veuillez entrer l'email valide</span>"
               }, CPPC_ID: {
                 required: "<span style='color:red'>Ce champ est obligatoire</span>"
               }, TRANCHE: {
                 required: "<span style='color:red'>Ce champ est obligatoire</span>"
               }
               //  pwd: {
                //  required: "<span style='color:red'>Veuillez saisir ce champ</span>"
               // },
               //  profil: {
                //  required: "<span style='color:red'>Veuillez saisir ce champ</span>"
               // }
              }
            });
</script>


