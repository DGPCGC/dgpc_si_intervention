<!-- <ul class="nav nav-pills pull-right">
   <li <?php if($this->router->class=='Materiaux' && $this->router->method=='add_form') echo "class='active'";?>><a href="<?php echo base_url() ?>materiaux/Materiaux/add_form" class="btn-xs">Nouveau</a></li>
  
   <li <?php if($this->router->class=='Materiaux' && $this->router->method=='index') echo "class='active'";?>><a href="<?php echo base_url() ?>materiaux/Materiaux" class="btn-xs">Liste</a></li>

   <li <?php if($this->router->class=='Materiaux' && $this->router->method=='approv') echo "class='active'";?>><a href="<?php echo base_url() ?>materiaux/Materiaux/approv" class="btn-xs">Approvisionnement</a></li>


   <li <?php if($this->router->class=='Materiaux' && $this->router->method=='listing_qte_distr') echo "class='active'";?>><a href="<?php echo base_url() ?>materiaux/Materiaux/listing_qte_distr" class="btn-xs">Matériel distribués</a></li>


   </ul> -->

   <div class="list-group">
  <a href="<?php echo base_url() ?>materiaux/Materiaux/add_form" class="btn-xs list-group-item <?php if($this->router->class=='Materiaux' && $this->router->method=='add_form') echo "active";?>">Nouveau</a>
  <a href="<?php echo base_url() ?>materiaux/Materiaux" class="btn-xs list-group-item <?php if($this->router->class=='Materiaux' && $this->router->method=='index') echo "active";?>">Liste</a>
  <a href="<?php echo base_url() ?>materiaux/Materiaux/approv" class="btn-xs list-group-item <?php if($this->router->class=='Materiaux' && $this->router->method=='approv') echo "active";?>">Approvisionnement</a>
  <a href="<?php echo base_url() ?>materiaux/Materiaux/listing_qte_distr" class="btn-xs list-group-item <?php if($this->router->class=='Materiaux' && $this->router->method=='listing_qte_distr') echo "active";?>">Matériel distribués</a>
</div>