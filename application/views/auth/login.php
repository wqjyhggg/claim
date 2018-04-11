<!DOCTYPE html>
<html class=" " lang="en">
   <head>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>JF Group - Login</title>
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">
      <!-- bootstrap style -->
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap_002.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker.css">
      <!-- font-awesome style -->
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.css">
      <!-- customize template style -->
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/green.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/prettify.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/select2.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/starrr.css">
      <!-- Build theme style -->
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
      <!-- jQuery -->
      <script src="<?php echo base_url(); ?>assets/js/jquery_003.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.js"></script>
   </head>
   <body class="nav-md body-bg">
      <header>
         <div class="container" style="padding:0;">
            <div class="hlogo">
               <img class="img-responsive" src="<?php echo base_url(); ?>assets/img/otc_big.jpg" alt="JF Insurance">
            </div>
            </nav>
         </div>
      </header>
      <div class="nav-m22d">
         <!-- Start body content -->
         <div class="container body" style="padding:0;">
            <!-- div.container.body-->
            <div class="main_container">
               <!-- div.main_container -->
               <div class="container">
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="main">
                           <div class="login-form">
                              <?php
                              echo heading('Login', 3, array("class"=>'login-title'));
                              echo $message;
                              ?>
                              <?php echo form_open("auth/login", array("method"=>'post')) ?>
                                 <div class="form-group row">
                                    <?php echo form_label('Username', 'identity', array('class'=>'col-sm-3 form-control-label')); ?>
                                    <div class="col-sm-9">
                                       <?php echo form_input($identity); ?>
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="password" class="col-sm-3 form-control-label">Password</label>
                                    <div class="col-sm-9">
                                       <?php echo form_password($password); ?>
                                    </div>
                                 </div>
                                 <br><br>
                                 <div class="form-group row">
                                    <div class="col-sm-12 pull-right">
                                       <?php echo form_submit('submit', 'Submit', array('class'=>'btn btn-primary', 'padding'=>'padding:6px 25px')); ?>
                                    </div>
                                 </div>
                              <?php echo form_close(); ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div><footer>
                  <div class="container">
                     <div class="row">
                        <div class="col-sm-12 text-center">
                           <p>Powered by Aurora Technology Development. Auroratechdevelopment.com</p>
                        </div>
                     </div>
                  </div>
                  <a href="#" class="scrollToTop" style="display: none;"><i class="fa fa-arrow-circle-up"></i></a>
               </footer>
            <!-- End of div.main_container -->
         </div>
         <!-- End of div.container.body-->
      </div>
      <!-- End Body Content -->
      <script>
         //Check to see if the window is top if not then display button
         $(window).scroll(function(){
            if ($(this).scrollTop() > 100) {
               $('.scrollToTop').fadeIn();
            } else {
               $('.scrollToTop').fadeOut();
            }
         });

         //Click event to scroll to top
         $('.scrollToTop').click(function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
         });

      </script>
      <!-- Bootstrap -->
      <!-- FastClick -->
      <script src="<?php echo base_url(); ?>assets/js/fastclick.js"></script>
      <!-- NProgress -->
      <script src="<?php echo base_url(); ?>assets/js/nprogress.js"></script>
      <!-- bootstrap-progressbar -->
      <script src="<?php echo base_url(); ?>assets/js/bootstrap-progressbar.js"></script>
      <!-- iCheck -->
      <script src="<?php echo base_url(); ?>assets/js/icheck.js"></script>
      <!-- bootstrap-daterangepicker -->
      <script src="<?php echo base_url(); ?>assets/js/moment.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/daterangepicker.js"></script>
      <!-- bootstrap-wysiwyg -->
      <script src="<?php echo base_url(); ?>assets/js/bootstrap-wysiwyg.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/jquery_004.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/prettify.js"></script>
      <!-- jQuery Tags Input -->
      <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
      <!-- Switchery -->
      <script src="<?php echo base_url(); ?>assets/js/switchery.js"></script>
      <!-- Select2 -->
      <script src="<?php echo base_url(); ?>assets/js/select2.js"></script>
      <!-- Parsley -->
      <script src="<?php echo base_url(); ?>assets/js/parsley.js"></script>
      <!-- Autosize -->
      <script src="<?php echo base_url(); ?>assets/js/autosize.js"></script>
      <!-- jQuery autocomplete -->
      <script src="<?php echo base_url(); ?>assets/js/jquery_002.js"></script>
      <!-- starrr -->
      <script src="<?php echo base_url(); ?>assets/js/starrr.js"></script>
      <!-- Build Custom Theme Scripts -->
      <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>

   </body>
</html>


<!-- <h1><?php echo lang('login_heading');?></h1>
<p><?php echo lang('login_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/login");?>

  <p>
    <?php echo lang('login_identity_label', 'identity');?>
    <?php echo form_input($identity);?>
  </p>

  <p>
    <?php echo lang('login_password_label', 'password');?>
    <?php echo form_input($password);?>
  </p>

  <p>
    <?php echo lang('login_remember_label', 'remember');?>
    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
  </p>


  <p><?php echo form_submit('submit', lang('login_submit_btn'));?></p>

<?php echo form_close();?>

<p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p> -->
