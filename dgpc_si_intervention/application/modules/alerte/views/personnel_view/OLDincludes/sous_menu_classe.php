<!-- <ul class="nav nav-pills pull-right">
	<li class="<?php echo $add ?>"><a href="<?php echo base_url() ?>alerte/Personnel" class="btn-xs">Nouvelle</a></li>

      <li class=""><a href="<?php echo base_url() ?>alerte/Personnel/listing" class="btn-xs">Liste</a></li> 
     
    
</ul> -->

<div class="list-group">
  <a href="<?php echo base_url() ?>alerte/Notification_Alert" class="btn-xs list-group-item ">Alertes</a>
  <a href="<?php echo base_url() ?>alerte/Instititions/index" class="btn-xs list-group-item">Institution &agrave; notifier</a>
  <a href="<?php echo base_url() ?>alerte/Personnel/index" class="btn-xs list-group-item active">Personne &agrave; notifier</a>
</div>
<div class="list-group">
  <a href="<?php echo base_url() ?>alerte/Personnel" class="btn-xs list-group-item <?php echo $add ?>">Nouveaux Personnel</a>
  <a href="<?php echo base_url() ?>alerte/Personnel/listing" class="btn-xs list-group-item <?php echo $list ?>">Liste des personne</a>
</div>