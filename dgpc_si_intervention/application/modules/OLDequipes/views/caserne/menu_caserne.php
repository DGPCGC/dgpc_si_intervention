<ul class="nav nav-pills pull-right">
   <li <?php if($this->router->class=='Caserne' && $this->router->method=='index') echo "class='active'";?>><a href="<?php echo base_url() ?>equipes/Caserne/index" class="btn-xs">Nouvelle</a></li>
  
   <li <?php if($this->router->class=='Caserne' && $this->router->method=='liste') echo "class='active'";?>><a href="<?php echo base_url() ?>equipes/Caserne/liste" class="btn-xs">Liste</a></li>
</ul>