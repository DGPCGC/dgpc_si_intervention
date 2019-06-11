<ul class="nav nav-pills pull-right">
   <li <?php if($this->router->class=='Partenaire' && $this->router->method=='add_data') echo "class='active'";?>><a href="<?php echo base_url() ?>alerte/Partenaire/add_data" class="btn-xs">Nouveau</a></li>
  
   <li <?php if($this->router->class=='Partenaire' && $this->router->method=='liste') echo "class='active'";?>><a href="<?php echo base_url() ?>alerte/Partenaire/liste" class="btn-xs">Liste</a></li>
</ul>