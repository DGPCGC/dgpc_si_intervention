<ul class="nav nav-pills pull-right">
   <li <?php if($this->router->class=='Profiles' && $this->router->method=='index') echo "class='active'";?>><a href="<?php echo base_url() ?>administration/Profiles/index" class="btn-xs">Nouveau</a></li>
  
   <li <?php if($this->router->class=='Profiles' && $this->router->method=='liste') echo "class='active'";?>><a href="<?php echo base_url() ?>administration/Profiles/liste" class="btn-xs">Liste</a></li>
   <ul class="nav nav-pills pull-right">
   <li <?php if($this->router->class=='Profiles' && $this->router->method=='AddFonctionnalite') echo "class='active'";?>><a href="<?php echo base_url() ?>administration/Profiles/AddFonctionnalite" class="btn-xs">Fonctionnalités</a></li>
</ul>