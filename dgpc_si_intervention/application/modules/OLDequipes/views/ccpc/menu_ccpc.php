<ul class="nav nav-pills pull-right">
   <li <?php if($this->router->class=='Ccpc' && $this->router->method=='index') echo "class='active'";?>><a href="<?php echo base_url() ?>equipes/Ccpc/index" class="btn-xs">Nouvelle</a></li>
  
   <li <?php if($this->router->class=='Ccpc' && $this->router->method=='listing') echo "class='active'";?>><a href="<?php echo base_url() ?>equipes/Ccpc/listing" class="btn-xs">Liste</a></li>
</ul>