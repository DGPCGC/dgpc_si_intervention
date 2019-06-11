<ul class="nav nav-pills pull-right">
   <?php 
      if($this->mylibrary->get_permission('Tickets/index') ==1){
    ?>
   <li <?php if($this->router->class=='Tickets' && $this->router->method=='index') echo "class='active'";?>><a href="<?php echo base_url() ?>tickets/Tickets/index" class="btn-xs">Nouveau</a></li>
   <?php
     }
   ?>
   <li <?php if($this->router->class=='Tickets' && $this->router->method=='liste') echo "class='active'";?>><a href="<?php echo base_url() ?>tickets/Tickets/liste" class="btn-xs">Liste</a></li>
</ul>