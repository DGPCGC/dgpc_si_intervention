<?php
    //echo '1'.$this->session->userdata('LOGO');
 ?>
<style type="text/css">
    .jumbotron, #conta{
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    background-color: white;
    }
  }
    #cont, #wrapper, #navp{
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    }
     
    #cont:hover {
        box-shadow: 0 8px 16px 0 #063361;
    }
    #wrapper:hover {
        box-shadow: 0 8px 16px 0 #063361;
    }
    #side-menu li a{
        color:white;
    }
    #side-menu li a:hover{
        color:#253E62;


    }
    
    #side-menu li a.active{
        color:#253E62;

        
    }
    #tete li a {
        color: black;
        font-weight: bold;
    }
    #tete li a:hover {
        color: #253E62;
    }
    #act{
        border:1px solid #253E62;
    }

    #men:focus{
        color: #253E62;
    }



    

    
</style>

          <div class="col-lg-12 col-md-12">
            <div class="col-lg-3 col-md-3" style="margin-left: -14px">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img src="<?= base_url() ?>upload/banderole/logo.jpg" style="width:234px;height: 67px "/>                
                
            </div>
            <!-- /.navbar-header -->
            <div class="col-lg-5 col-md-5"><h3 style="text-align: right">
              Saisie Restitution Traitement et archivage des catastrophes passées
            </h3></div>
            <div class="col-lg-4 col-md-4">
                
                <ul class="nav navbar-top-links navbar-right" id="tete" style="padding:8px">    
                <!-- /.dropdown -->
                <?php if($this->router->class != 'Dashboard'){?>
                <li>
                    <a  href="<?=$this->session->userdata('URL_REPORTING')?>">
                        <i class="fa fa-bar-chart-o fa-fw"></i> Reporting
                    </a>
                    <!-- /.dropdown-alerts -->
                </li>
                <?php } ?>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                   <?= $this->session->userdata('DGPC_USER_EMAIL') ?> <i class="fa fa-caret-down"></i> 
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?=base_url()?>Change_Pwd/changer_info"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="<?=base_url()?>Change_Pwd/"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?=base_url()?>Login/do_logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
                </ul>
            </div>
          </div>
                <div class="navbar-default sidebar" id="cont" role="navigation" style="background-color: #253E62;margin-top: 72px">
                <div class="sidebar-nav navbar-collapse" id="side-menu">
                    <ul class="nav">
                    <?php
                      //echo $this->router->class;
                       if($this->mylibrary->get_permission('Horaire/index') ==1){
                    ?>        
                        <li <?php if($this->router->class=='Horaire') echo "class='active'";?>>
                            <a href="<?=base_url().'equipes/Horaire/odk_form'?>" id="men"><i class="fa fa-dashboard fa-fw"></i> <span>Catastrophe</span></span></a>

                        </li>
                        <li <?php if($this->router->class=='Horaire') echo "class='active'";?>>
                            <a href="<?=base_url().'geolocalisation/Map/map_cata'?>" id="men"><i class="fa fa-dashboard fa-fw"></i> <span>Carte</span></span></a>

                        </li>
                        <li <?php if($this->router->class=='Horaire') echo "class='active'";?>>
                            <a href="<?=base_url().'equipes/Horaire/rapport'?>" id="men"><i class="fa fa-dashboard fa-fw"></i> <span>Rapport</span></span></a>

                        </li>
                    <?php } ?>

                   
                    </ul>

                        
                </div>
                <!-- /.sidebar-collapse -->
            </div>