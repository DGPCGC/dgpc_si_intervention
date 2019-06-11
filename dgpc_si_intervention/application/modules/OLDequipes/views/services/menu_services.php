<ul class="nav nav-pills pull-right">
   <li <?php if($this->router->class=='Services' && $this->router->method=='ajouter') echo "class='active'";?>><a href="<?php echo base_url() ?>equipes/Services/ajouter" class="btn-xs">Nouvelle</a></li>

   <li <?php if($this->router->class=='Services' && $this->router->method=='index') echo "class=''";?>><a href="<?php echo base_url() ?>equipes/Services/listing" class="btn-xs">Personnel</a></li>
  
   <li <?php if($this->router->class=='Services' && $this->router->method=='index') echo "class='active'";?>><a href="<?php echo base_url() ?>equipes/Services" class="btn-xs">Liste</a></li>

  
</ul>