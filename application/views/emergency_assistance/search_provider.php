<style>
/* Always set the map height explicitly to define the size of the div
 * element that contains the map. */
#map {
  height: 400px;
}
</style>
<duv >
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
              <?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'get')); ?>
                <div class="row">
                  <div class="col-sm-4">
                     <div class="form-group col-sm-12">
                        <?php 
                           echo form_label('Street No.:', 'street_no', array("class"=>'col-sm-12'));                               
                           echo form_input("street_no", $this->input->get("street_no"), array("class"=>"form-control", 'placeholder'=>'Street No.'));
                        ?>
                     </div>              
                     <div class="form-group col-sm-12">
                        <?php      
                        echo form_label('Street Name:', 'street_name', array("class"=>'col-sm-12'));        
                        echo form_input("street_name", $this->input->get("street_name"), array("class"=>"form-control", 'placeholder'=>'Street Name'));
                        ?>
                     </div>
                     <div class="form-group col-sm-12">
                        <?php 
                           echo form_label('City:', 'city', array("class"=>'col-sm-12'));                               
                           echo form_input("city", $this->input->get("city"), array("class"=>"form-control", 'placeholder'=>'City'));
                        ?>
                     </div>  
                     <div class="form-group col-sm-12">
                        <?php 
                           echo form_label('Province:', 'province', array("class"=>'col-sm-12'));       
                           echo $provinces;
                        ?>
                     </div>  
                     <div class="form-group col-sm-12">
                        <?php 
                           echo form_label('Country:', 'country', array("class"=>'col-sm-12'));                  
                           echo $countries;
                        ?> 
                     </div>  
                     <div class="form-group col-sm-8">
                        <?php               
                           echo form_label('Post Code:', 'post_code', array("class"=>'col-sm-12'));  
                           echo form_input("post_code", $this->input->get("post_code"), array("class"=>"form-control", 'placeholder'=>'Post Code'));
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
            <?php if(!empty($records)): ?>
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
                        <?php foreach($records as $value): ?>
                           <tr> 
                              <td><?php echo $value['name']; ?></td>
                              <td><?php echo $value['services']; ?></td>
                              <td><?php echo $value['address']; ?></td>
                              <td><?php echo $value['postcode']; ?></td>
                              <td><?php echo $value['discount']; ?></td>
                              <td><?php echo $value['contact_person']; ?></td>
                              <td><?php echo $value['phone_no']; ?></td>
                              <td><?php echo $value['email']; ?></td>
                              <td><?php echo $value['ppo_codes']; ?></td>
                           </tr>
                        <?php endforeach;?>
                     </tbody>
                  </table>
               <!-- End Search List Section -->

                  <div class="col-sm-12" style="text-align:center">
                     <button class="btn btn-primary return_back">Return</button>  
                  </div>
               </div>
            <?php else: ?>
               <center><?php echo heading("No record available", 4); ?></center>
            <?php endif ?>
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
   $(".return_back").click(function(){
      window.close(); // or self.close();
   })
})
$(document).on("click",".more_filters", function(){
   $(".more_items").toggle();
})
var map;
var markers = [];
function initMap() {
   map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -34.397, lng: 150.644},
      zoom: 8
   });

  var infowindow = new google.maps.InfoWindow();
  var bounds = new google.maps.LatLngBounds();

   <?php 
   if(!empty($records)) {
      $i = 0;
      foreach ($records as $key => $value) {
         $i++;
         # code...
         ?>
         var myLatLng = {lat: <?php echo $value['lat'];?>, lng: <?php echo $value['lng'];?>};
         var marker<?php echo $i; ?> = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: '<?php echo $value['address'];?>'
         });
         bounds.extend(marker<?php echo $i; ?>.getPosition());

         google.maps.event.addListener(marker<?php echo $i; ?>, 'click', function() {
           infowindow.setContent("<div><strong> <?php echo $value['name'];?> </strong><br><?php echo $value['address'];?></div>");
           infowindow.open(map, this);
         });
         <?php
      }
   }
   ?> 

   map.fitBounds(bounds);
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_KEY; ?>&callback=initMap" async defer></script>