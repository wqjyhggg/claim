<style>
/* Always set the map height explicitly to define the size of the div
 * element that contains the map. */
#map {
  height: 400px;
}
</style>
<duv class-"main-div"="">
   <div class="page-title">
      <div class="title_left">
         <h3>Search Provider</h3>         
      </div>
   </div>
   <div class="clearfix"></div>

   <!-- Provider search Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_content"> 

               <!-- search policy filter start -->       
              <?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'post')); ?>
                <div class="row">
                  <div class="col-sm-4">
                     <div class="form-group col-sm-12">
                        <?php 
                           echo form_label('Street No.:', 'stree_no', array("class"=>'col-sm-12'));                               
                           echo form_input("stree_no", $this->input->post("stree_no"), array("class"=>"form-control", 'placeholder'=>'Street No.'));
                        ?>
                     </div>              
                     <div class="form-group col-sm-12">
                        <?php      
                        echo form_label('Street Name:', 'street_name', array("class"=>'col-sm-12'));        
                        echo form_input("street_name", $this->input->post("street_name"), array("class"=>"form-control", 'placeholder'=>'Street Name'));
                        ?>
                     </div>
                     <div class="form-group col-sm-12">
                        <?php 
                           echo form_label('City:', 'city', array("class"=>'col-sm-12'));                               
                           echo form_input("city", $this->input->post("city"), array("class"=>"form-control", 'placeholder'=>'City'));
                        ?>
                     </div>  
                     <div class="form-group col-sm-12">
                        <?php 
                           echo form_label('Province:', 'province', array("class"=>'col-sm-12'));                  
                           $province = array(""=>'--Select Province--');
                           echo form_dropdown("province", $province, $this->input->get("province"), array("class"=>'form-control'));
                        ?>
                     </div>  
                     <div class="form-group col-sm-12">
                        <?php 
                           echo form_label('Country:', 'country', array("class"=>'col-sm-12'));                  
                           $country = array(""=>'--Select Country--');
                           echo form_dropdown("country", $country, $this->input->get("country"), array("class"=>'form-control'));
                        ?> 
                     </div>  
                     <div class="form-group col-sm-8">
                        <?php               
                           echo form_label('Post Code:', 'post_code', array("class"=>'col-sm-12'));  
                           echo form_input("post_code", $this->input->post("post_code"), array("class"=>"form-control", 'placeholder'=>'Post Code'));
                        ?>
                     </div>      
                     <div class="col-sm-4">
                        <label class="col-sm-12">&nbsp;</label>
                        <button class="btn btn-primary">Search</button>
                     </div>
                  </div>   
                  <div class="col-sm-8">
                     <div id="map"></div>
                  </div>            
               </div> 

               <?php echo form_close(); ?>
               <!-- search policy filter end -->

               <div class="clearfix"></div>
            </div>
         </div>
      </div>
   </div>


   <!-- Provider List Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <!-- search results start -->
         <div class="x_title">
            <h2>Search Result<small></small></h2>
            <div class="clearfix"></div>
         </div>
         <div class="x_content">
            <div class="table-responsive">
               <table class="table table-hover table-bordered">
                  <thead>
                     <tr>
                        <th>Name</th>
                        <th>Services</th>
                        <th>Address</th>
                        <th>PostCode</th>
                        <th>Discount</th>
                        <th>Contact Person</th>
                        <th>Phone number</th>
                        <th>Email</th>
                        <th>PPO codes</th>                          
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>Scarbo Hospital</td>
                        <td> </td>
                        <td>3430, toronto, ON, CA</td>
                        <td>M1W2MN</td>
                        <td>10%</td>
                        <td>Mary Lee</td>
                        <td>6725554202000</td>
                        <td>MaryL@gmail.com</td>
                        <td>11111</td>
                     </tr>
                  </tbody>
               </table>
            <!-- End Search List Section -->
            </div>
         </div>
      </div>
   </div>

</duv>

<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
$(document).ready(function() {
   $(".datepicker").datepicker({
        startDate: '-5y',
        endDate: '+2y',
    });
})
$(document).on("click",".more_filters", function(){
   $(".more_items").toggle();
})
var map;
function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: -34.397, lng: 150.644},
    zoom: 8
  });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_KEY; ?>&callback=initMap" async defer></script>