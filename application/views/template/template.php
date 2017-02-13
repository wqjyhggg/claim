<!DOCTYPE html>
<html class=" " lang="en">
   <head>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>{title}</title>
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
      <script src="<?php echo base_url(); ?>assets/js/jquery_003.js"></script><!-- style sheets specific to the page -->
        {_styles}
        <!-- js files specific to the page -->
        {_scripts}
      <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.js"></script>
      <!-- style sheets specific to the page -->
        {_styles}
      <!-- js files specific to the page -->
        {_scripts}
   </head>
   <body class="nav-md">
      <header>
         <div class="container" style="padding:0;">
            <div class="hlogo">
               <img class="img-responsive" src="<?php echo base_url(); ?>assets/img/logo.png" alt="JF Insurance">
               <a href="" class="pull-right-custom"><i class="fa fa-question-circle"></i> Help</a>
            </div>
         </div>
      </header>
      <div class="nav-m22d">
         <!-- Start body content -->
         <div class="container body" style="padding:0;">
            <!-- div.container.body-->
            <div class="main_container">
               <!-- div.main_container -->
               <div id="leftMenu">
                  <div class="col-md-3 left_col">
                     <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                           <a class="site_title"><i class="fa fa-user"></i> <span><?php echo $this->ion_auth->user()->row()->first_name." ".$this->ion_auth->user()->row()->last_name ?></span></a>
                        </div>
                        <div class="clearfix"></div>
                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                           <div class="menu_section active">
                              <!--h3>General</h3-->
                              <?php $this->load->view("elements/sidebar"); ?>
                           </div>
                        </div>
                        <!-- /sidebar menu -->
                     </div>
                  </div>
               </div>
               <!-- Product page content -->
               <!-- Content top navigation -->
               <div class="top_nav">
                  <div class="nav_menu">
                     <nav class="" role="navigation">
                        <div class="nav toggle">
                           <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>
                     </nav>
                  </div>
               </div>
               <!-- Content top navigation End-->
               <!-- page content -->
               <div class="right_col" role="main" style="min-height: 644px;">
                  {content}
               </div>
            </div>
            <!-- /page content -->
            <footer class="inner">
               <div class="container">
                  <div class="row">
                     <div class="col-sm-12 text-center">
                        <p>Powered by Aurora Technology Development. Auroratechdevelopment.com</p>
                     </div>
                  </div>
               </div>
               <a href="#" class="scrollToTop"><i class="fa fa-arrow-circle-up"></i></a>
            </footer>
         </div>
         <!-- End of div.main_container -->
      </div>
      <!-- End of div.container.body-->
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