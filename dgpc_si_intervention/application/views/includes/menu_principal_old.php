<style type="text/css">
    .jumbotron, #conta{
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    background-color: white;
    }
  }
    #cont, #wrapper, #navp{
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    }
     
    #cont:hover {
        box-shadow: 0 8px 16px 0 #063361;
    }
    #wrapper:hover {
        box-shadow: 0 8px 16px 0 #063361;
    }
    .pull-center li a {
        font-size: 15px;
        font-weight: bold;
            }
</style>
            <div class="col-lg-12">
                <span><img src="<?php echo base_url() ?>upload/banderole/bando.jpg" class="img-responsive"/></span>
                <div class="row" style="margin: 5px;">
                    <ul class="nav nav-pills pull-center">
                    
                       
                        <?php
                               if($this->mylibrary->get_permission('Tickets/index') ==1){
                            ?> 
                                <li <?php if($this->router->class=='Tickets') echo "class='active'";?>>
                                       <a href="<?=base_url().'tickets/Tickets/liste'?>">Tickets</a>
                                </li>
                                <?php
                                }
                                ?>
                                
                                <li <?php if($this->router->class=='Materiaux') echo "class='active'";?>>
                            <a href="<?=base_url().'materiaux/Materiaux'?>" id="men"><i class="fa fa-cogs fa-fw"></i> <span>Matériaux</span></span></a>

                        </li>
                        
                    </ul>

              
                    
                </div>

                
            </div>