<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>AEL ADMIN PANEL</title>



        <link rel="stylesheet" href="<?php echo base_url() ?>assets/login/admin/css/style.css">


    </head>

    <body>
        <div class="wrapper">
            <div class="container">
                <h1>Welcome</h1>
                <p><img src="<?php echo base_url();?>assets/ael.png" height="50px" width="200px"/></p>
                <form class="form" method="post" action="">

                    <h3 style="color:red; text-align: center">
                        <?php
                        $message = $this->session->userdata('message');
                        if ($message) {

                            echo $message;
                            $this->session->unset_userdata('message');
                        }
                        ?><br>
                    </h3>
                    <input type="text" name="admin_email" placeholder="Username">
                    <input type="password" name="admin_password"  placeholder="Password">
                    <button type="submit" >Login</button>
                </form>
            </div>

            <!-- <ul class="bg-bubbles">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
            </ul> -->
        </div>
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="<?php echo base_url() ?>assets/login/admin/js/index.js"></script>

    </body>
</html>
