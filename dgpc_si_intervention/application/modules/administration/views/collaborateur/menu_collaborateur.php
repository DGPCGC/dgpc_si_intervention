<ul class="nav nav-pills pull-right">
   <li <?php if($this->router->class=='Collaborateurs' && $this->router->method=='nouveau') echo "class='active'";?>><a href="<?php echo base_url() ?>administration/Collaborateurs/nouveau" class="btn-xs">Nouveau</a></li>
  
   <li <?php if($this->router->class=='Collaborateurs' && $this->router->method=='liste_collaborateur') echo "class='active'";?>><a href="<?php echo base_url() ?>administration/Collaborateurs/liste_collaborateur" class="btn-xs">Liste</a></li>
   <ul class="nav nav-pills pull-right">

</ul>