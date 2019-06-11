.<!DOCTYPE html>
<html>
    <head>
        <title>DGPC Abutip</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <?php
       include 'includes/header.php';
        ?>

    </head>
    

        <div class="container-fluid" id="header">
            <img src="<?php echo base_url() ?>upload/banderole/bando.jpg" width="100%" height="120" alt="logo" /> 
        </div>
        <div class="col-lg-4 col-md-3">

        </div>
        <center>
            <div class="col-lg-4 col-md-6 col-xs-12 login" style="margin-top: 50px;">
                <?php echo($message)  ?>
                <div class="bg-primary text-center">
                    <label class="control-label"><h4>CONNEXION</h4></label> 
                </div> 

                <form action="<?= base_url('Password_Oublier/check') ?>" method="POST">
                    <table class="table table-inverse">
                        <tr class="bg-primary">
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input type="text" name="USERNAME" placeholder="Nom d'utilisateur" class="form-control" required onfocus>
                                </div>
                            </td>
                        </tr>  
                        <tr class="bg-primary"><td colspan="2"><input type="submit" value="CONNEXION" class="btn btn-primary form-control"></td></tr>
                    </table>    
                </form>

            </div>
        </center>
        <div class="col-lg-4 col-md-3">

        </div>
    </body>
</html>
