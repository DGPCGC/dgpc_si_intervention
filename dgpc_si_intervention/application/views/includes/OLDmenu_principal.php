<style type="text/css">
    .jumbotron, #conta{
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    background-color: white;
    }
  }
    #cont,  #navp{
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    }
     
    #cont:hover {
        box-shadow: 0 8px 16px 0 #063361;
    }
    
    .pull-center li a {
        font-size: 13px;
        font-weight: bold;
            }
</style>
            <div class="col-lg-12">
                <span><img src="<?php echo base_url() ?>upload/banderole/bando.jpg" class="img-responsive"/></span>
                <div class="row" style="margin: 2px;">
                    <ul class="nav nav-pills pull-center">
                   <?php
                    if($this->mylibrary->get_permission('Tickets/index') ==1){
                  ?>
                    <li <?php if($this->router->class=='Dashboard') echo "class='active'";?>>
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tachometer"></i> Tableaux de bord <b class="caret"></b> </a>
                    <ul class="dropdown-menu">
                      <li><a href="<?=base_url('reporting/Dashboard')?>">Dashboard</a></li>
                      <li><a href="<?=base_url('reporting/Reporting_Statut')?>">Intervention par statut</a></li>
                      <li><a href="<?=base_url('reporting/Moyenne_temps')?>">Moyenne de temps d'intervention</a></li>
                      <li><a href="<?=base_url('reporting/Rapport_Type_Incidents')?>">Rapport par type d'incidents</a></li>
                      <li><a href="<?=base_url('reporting/Cppc_Intervantion')?>">Nombre d'intervations vs dégâts par DGPC</a></li>
                      <li><a href="<?=base_url('reporting/Top_Intervantion_cppc/')?>">Meilleurs / Mauvais classements par DGPC</a></li>
                      <li><a href="<?=base_url('reporting/Repport_materiaux/')?>">Disponibilite des mat&eacute;riels</a></li>
                      <!-- Meilleur (ou mauvaise) resultat -->

                    </ul>
                  </li>
                 
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-truck fa-fw"></i> Interventions <b class="caret"></b> </a>
                    <ul class="dropdown-menu">
                     
                      <li <?php if($this->router->class=='Tickets') echo "class='active'";?>><a href="<?=base_url().'tickets/Tickets/liste'?>">Tickets</a></li>
                      <li <?php if($this->router->class=='Notification') echo "class='active'";?>><a href="<?=base_url().'tickets/Notification/index'?>">Notifications</a></li>
                      <li>
                         <a href="#" id="men"> <?=$this->mylibrary->checkProfil($this->session->userdata('DGPC_USER_ID'));?></a>
                          <ul class="nav nav-second-level">
                            <?php
                              // if($this->mylibrary->get_permission('Intervention/rapport_ticket') ==1){
                                // $this->mylibrary->checkProfil($this->session->userdata('DGPC_USER_ID'));
                               // }
                                ?>
                                
                            </ul>
                      </li>
                    </ul>
                  </li>
                  <?php } ?>
                  <?php if($this->session->userdata('DGPC_USER_EMAIL') != NULL){?>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bullhorn"></i> Notifications <b class="caret"></b> </a>
                    <ul class="dropdown-menu">
                      <li><a href="<?=base_url('alerte/Notification_Alert')?>">Alertes</a></li>
                      <li><a href="<?=base_url('alerte/Instititions/index')?>">Populations</a></li>
                      <li><a href="<?=base_url('alerte/Personnel/listing')?>">Autorit&eacute;s</a></li>
                      <li><a href="<?=base_url('alerte/Partenaire/liste')?>">Partenaires</a></li>
                    </ul>
                  </li>
                  <?php }?>
                  <?php if($this->session->userdata('DGPC_USER_EMAIL') != NULL){?>
                  
                  
                  <?php } ?>
                  <?php if($this->session->userdata('DGPC_USER_EMAIL') != NULL){?>
                  
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-map-marker"></i> Map <b class="caret"></b> </a>
                    <ul class="dropdown-menu">
                     <!--  <li><a href="<?=base_url('geolocalisation/Map/index')?>">Couverture</a></li> -->
                      <li><a href="<?=base_url('geolocalisation/Map/map_cppc')?>">Couverture CPPC</a></li>
                      <li><a href="<?=base_url('geolocalisation/Map/enintervention')?>">Interventions encours</a></li>
                      <!-- <li><a href="<?=base_url('geolocalisation/Map/map_cppc')?>">CPPC</a></li> -->
                     <!--  <li><a href="<?=base_url('geolocalisation/Carte_cppc')?>">Globale</a></li> -->
                    </ul>
                  </li>
                  <?php } ?>
                  <?php
                          if($this->mylibrary->get_permission('Collaborateurs') ==1 || $this->mylibrary->get_permission('Profiles') ==1||$this->mylibrary->get_permission('Fonctionnalites') ==1){
                  ?> 
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> Administration<b class="caret"></b> </a>
                    <ul class="dropdown-menu">
                     <?php
                      if($this->mylibrary->get_permission('Collaborateurs/liste_collaborateur') ==1){
                      ?>
                      <li><a href="<?=base_url()?>administration/Collaborateurs/liste_collaborateur">Collaborateurs</a></li>
                      <?php
                       }
                                                     
                          if($this->mylibrary->get_permission('Collaborateurs/liste') ==1){
                        ?>
                      <li><a href="<?=base_url()?>administration/Collaborateurs/liste">Utilisateurs</a></li>
                      <?php
                       }
                      
                        if($this->mylibrary->get_permission('Profiles') ==1){
                      ?>
                      <li><a href="<?=base_url()?>administration/Profiles/liste">Profils</a></li>
                      <?php
                       }
                        if($this->mylibrary->get_permission('Fonctionnalites') ==1){
                      ?>
                     <li><a href="<?=base_url()?>administration/Fonctionnalites/liste">Fonctionnalités</a></li>

                     
                     <?php }
                      if($this->mylibrary->get_permission('Caserne') ==1){
                      ?>
                         <li <?php if($this->router->class=='Caserne' && $this->router->method=='liste') echo "class='active'";?>>
                          <a href="<?=base_url('equipes/Caserne/liste')?>">CPPCs</a>
                                </li>
                        <?php
                           }
                           if($this->mylibrary->get_permission('Services') ==1){
                             ?>
                              <li <?php if($this->router->class=='Services' && $this->router->method=='index') echo "class='active'";?>>
                                     <a href="<?=base_url('equipes/Services/index')?>">Services DGPCs</a>
                              </li>
                              <?php
                              } 

                              if($this->mylibrary->get_permission('Materiaux') ==1){
                             ?>
                              <li <?php if($this->router->class=='Materiaux' && $this->router->method=='index') echo "class='active'";?>>
                                     <a href="<?=base_url('materiaux/Materiaux')?>" id="men">Materiel</a>
                              </li>
                              <?php
                              } 

                                if($this->mylibrary->get_permission('Equipes') ==1){
                              ?>
                              <li <?php if($this->router->class=='Equipes' && $this->router->method=='liste') echo "class='active'";?>>
                                     <a href="<?=base_url('equipes/Equipes/liste')?>">Equipes</a>
                              </li>
                              <?php } ?>

                              <?php 
                                if($this->mylibrary->get_permission('Horaire') ==1){
                              ?>
                              <li <?php if($this->router->class=='Horaire' && $this->router->method=='list') echo "class='active'";?>>
                                     <a href="<?=base_url('equipes/Horaire/list')?>">Horaires</a>
                              </li>
                              <?php } ?>
                    </ul>
                  </li>
                  <?php } ?>
                  <li class=""><a href="" class="btn-xs"><div id="times" style="color: black; padding-left: 5px!important"></div></a></li>
                        <li class=""><a href="" class="btn-xs"> <div id="numselected" style="color: black"></div></a></li>

                        <li class="dropdown navbar-right">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= $this->session->userdata('DGPC_USER_EMAIL') ?> <i class="fa fa-caret-down"></i> 
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <!-- <li><a href="<?=base_url()?>Users/listing">Utilisateurs</a>
                                </li> -->
                                <li><a href="<?=base_url()?>Change_Pwd">Modifier Mot de passe</a>
                                <!-- </li> -->
                                <li><a href="<?=base_url()?>Login/do_logout">D&eacute;connexion</a>
                                </li>
                               
                                
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>
                </ul>             
                    
                </div>

                
            </div>