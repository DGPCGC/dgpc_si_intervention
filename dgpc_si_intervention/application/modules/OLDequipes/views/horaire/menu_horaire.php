<ul class="nav nav-pills pull-right">
   <li <?php if($this->router->class=='Horaire' && $this->router->method=='index') echo "class='active'";?>><a href="<?php echo base_url() ?>equipes/Horaire" class="btn-xs">Nouvelle</a></li>
  
   <li <?php if($this->router->class=='Horaire' && $this->router->method=='list') echo "class='active'";?>><a href="<?php echo base_url() ?>equipes/Horaire/list" class="btn-xs">Liste</a></li>
</ul>