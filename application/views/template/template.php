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
      <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.js"></script>
      <!-- style sheets specific to the page -->
        {_styles}
      <!-- js files specific to the page -->
        {_scripts}
      <script src="<?php echo base_url(); ?>assets/js/auroratd.js"></script>
   </head>
   <body class="nav-md">
      <header>
         <div class="container" style="padding:0;">
            <div class="hlogo">
               <img class="img-responsive" src="<?php echo base_url(); ?>assets/img/logo.png" alt="JF Insurance">
               <a href="<?php echo base_url(); ?>auth/help" class="pull-right-custom"><i class="fa fa-question-circle"></i> Help</a>
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
                        <?php $this->load->model('phone_model'); ?>
                        <?php if ($phoneid = $this->users_model->get_user_phoneid()) { ?>
                        <div class="navbar site_title" id="phone_opt_div" style="border: 0;">
                           <i class="fa fa-phone"></i>
                           	<span id="phone_login" style="display:none;">
                           		<button type="button" class="btn btn-info btn-xs phonelogin">Online</button>&nbsp;
                           		<input type='text' id='login_phone_number' value='' style="max-width: 4em; max-height: 1em; color: black;">
                           	</span>
                           	<span id="phone_logout" style="display:none;">
                           		<button type="button" class="btn btn-info btn-xs phonelogout">Logout</button>
                           		<button type="button" class="btn btn-info btn-xs phonebreak">Break</button>
                           		<button type="button" class="btn btn-info btn-xs phonewaiting">ACW</button>
                           	</span>
                        </div>
                        <div class="navbar site_title" id="phone_queue_div" style="border: 0; display:none;">
                       		<button type="button" class="btn btn-info btn-xs phonequeue">Get Queue</button> <span id='curr_queue' style='color:#3010d0; background-color:#508090;'></span>
                        </div>
                        <?php } ?>
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

         // get provinces list
         $(document).on("change", "select[name=country]", function(){
            var url = ("<?php echo base_url('emergency_assistance/get_provinces/print/') ?>"+$(this).val());
            $("select[name=province]").load(encodeURI(url));
         })

         $(document).on("keydown", "input[name='payees[account_cheque][]'], input[name='expenses_claimed[amount_billed][]'], input[name='expenses_claimed[amount_client_paid][]'], input[name=amount_claimed], input[name=amt_deductible], input[name=amt_insure], input[name=amt_received], input[name=amt_payable], input[name='payees[payment][]']", function (e) {
           // Allow: backspace, delete, tab, escape, enter and .
           if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A, Command+A
               (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
                // Allow: home, end, left, right, down, up
               (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
           }
           // Ensure that it is a number and stop the keypress
           if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
               e.preventDefault();
           }
       });

      $(document).ready(function(){


        <?php
        if($this->input->post('country')):
         ?>
        var url = ("<?php echo base_url('emergency_assistance/get_provinces/print/'.$this->input->post('country')) ?>");
        $("select[name=province]").load(encodeURI(url));
        <?php endif; ?>

        // hide error/success message
        $('.alert-success').delay(8000).fadeOut('slow');

         $(".doc_title h1").css("font-size", '23px');

         setInterval(function(){ 

            // check user logout script here
             $.ajax({
               url: "<?php echo base_url("auth/check_user"); ?>",
               method:"get",
               dataType: "json",
               success: function(data){
                  if(data){
                     // open model popup here
                     $("#model_logout").modal()

                  }
               }
            })

          }, 60000);         
      })
         
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

      <!-- model window for logout message -->
      <div id="model_logout" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"> <i class="fa fa-warning"></i> Your account is inactivated</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                  <center>
                     <h2>Your account is now deactivated </h2>
                     please contact administrator to activate it again.<br/> <?php echo anchor('auth/login', 'click here') ?> to go home page.
                  </center>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <?php echo anchor('auth/login', 'OK', array('class'=>'btn btn-primary')) ?>
               </center>
            </div>
          </div>

        </div>
      </div>
   </body>
</html>
