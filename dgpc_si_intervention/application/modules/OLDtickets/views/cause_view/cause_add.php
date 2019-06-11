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
            <?php 
             $add ='active';
            $list ='';
            ?>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                     
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                             <?= $breadcrumb ?>
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b>Ajouter une cause</b></h4>
                                 </div>
                                 <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                <?php include 'includes/sous_menu_classe.php' ?>;
                                 </div>
                            </div>  
                        </div>
                    <div class="col-lg-12 jumbotron table-responsive" style="padding: 30px">
                     <?= $this->session->flashdata('message') ?>
                      <form class="form-horizontal" id="myform" action="<?=base_url('tickets/Cause/add');?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    
                    
                <div class="form-group">
                     <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label">Cause</label>
                          <div class="col-md-4 col-sm-6 col-xs-6">
                             <input type="text" class="form-control" name="cause" id="CAUSE" value="" autofocus>

                          </div>
                     </div>
              <div class="form-group">
              <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label">Code du cause</label>
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <input type="number" class="form-control" name="code" value="" id="CODE" autofocus  placeholder=" le code de 1 à <?=$code ?> existe déjà ">
                   </div>
            </div>
           <div class="form-group">
              <label for="" class="col-md-3 col-sm-6 col-xs-6 control-label"> C'est une exposif ?</label>
            <div class="col-md-4 col-sm-6 col-xs-6">
                <select name="check"  class="form-control " id="CHECK">
                <option value=''>--select--</option>
                <option value="0" selected>NON</option>
                <option value="1">OUI</option>
                </select> 
             </div>
          </div>
              <div class="form-group">
                  <label class="col-md-12 col-sm-12 col-xs-12 control-label"></label>
                  <div class="col-md-4 col-sm-12 col-xs-12 col-md-push-3">
                                    <input type="button" class="btn btn-primary btn-block envoi" value="Enregistre"/>
                                 </div>
                         </div>
                     </form>

    
  </div>
</div>
</div></div></div></div>

</body>
</html>


<script type="text/javascript">
  $(document).ready(function(){
        $(".envoi").click(function(){
      
          // alert('Bien');
            if(!$('#CAUSE').val().trim()){
                    alert('Le Nom de la cause  est requis');
                $('#CAUSE').focus();
                }else  if(!$('#CODE').val().trim()){
                    alert('le code de la cause  est requis et obligatoir svp');
                $('#CODE').focus();

                }else if(!$('#CHECK').val().trim()){
                    alert('inquer si la cause est du genre explosive ou pas ');
                $('#CHECK').focus();

                } 
                else{
                    document.getElementById("myform").submit();
                }
        });
    });
</script>
