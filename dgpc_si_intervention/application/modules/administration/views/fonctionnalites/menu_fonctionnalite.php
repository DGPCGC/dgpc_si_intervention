<ul class="nav nav-pills pull-right">
   <li <?php if($this->router->class=='Fonctionnalites' && $this->router->method=='index') echo "class='active'";?>><a href="<?php echo base_url() ?>administration/Fonctionnalites/index" class="btn-xs">Nouvelle</a></li>
  
   <li <?php if($this->router->class=='Fonctionnalites' && $this->router->method=='liste') echo "class='active'";?>><a href="<?php echo base_url() ?>administration/Fonctionnalites/liste" class="btn-xs">Liste</a></li>
   <ul class="nav nav-pills pull-right">
</ul>