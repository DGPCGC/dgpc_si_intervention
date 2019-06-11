  <ul class="nav nav-pills pull-right">
    <li><a href="<?php echo base_url() ?>materiaux/Materiaux/add_form" class="btn-xs list-group-item <?php if($this->router->class=='Materiaux' && $this->router->method=='add_form') echo "active";?>">Nouveau</a></li>
    <li>
  <a href="<?php echo base_url() ?>materiaux/Materiaux" class="btn-xs list-group-item <?php if($this->router->class=='Materiaux' && $this->router->method=='index') echo "active";?>">Liste</a>
</li><li>
  <a href="<?php echo base_url() ?>materiaux/Materiaux/approv" class="btn-xs list-group-item <?php if($this->router->class=='Materiaux' && $this->router->method=='approv') echo "active";?>">Approvisionnement</a>
</li><li>
  <a href="<?php echo base_url() ?>materiaux/Materiaux/listing_qte_distr" class="btn-xs list-group-item <?php if($this->router->class=='Materiaux' && $this->router->method=='listing_qte_distr') echo "active";?>">Matériel distribués</a>
  </li>
</ul>