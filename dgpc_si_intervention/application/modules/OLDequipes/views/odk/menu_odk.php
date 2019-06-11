<ul class="nav nav-pills pull-right">
   <li <?php if($this->router->class=='Horaire' && $this->router->method=='odk_form') echo "class='active'";?>><a href="<?php echo base_url() ?>equipes/Horaire/odk_form" class="btn-xs">Nouvelle</a></li>
  
   <li <?php if($this->router->class=='Horaire' && $this->router->method=='list_Odk_cata' OR $this->router->method=='update_cata')   echo "class='active'";?>><a href="<?php echo base_url() ?>equipes/Horaire/list_Odk_cata" class="btn-xs">Liste</a></li>
</ul>