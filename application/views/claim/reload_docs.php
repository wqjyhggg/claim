<div class="row">
   <div class="col-sm-6">
      <div>
         <label for="mail_label" class="col-sm-2">Mail Addres:</label>
         <div class="form-group col-sm-6">
            <input name="priority" value="HIGH" id="mail_address" class="col-sm-1" type="checkbox">
            <label for="mail_address" class="col-sm-10 pull-right" style="margin-top: 3px;">Use same address with the policy</label>
         </div>
      </div>
      <div>
         <?php
         echo form_label('To:', 'email', array("class"=>'col-sm-12'));
         ?>
         <div class="form-group col-sm-12">
            <?php
            echo form_input("email", "", array("class"=>"form-control col-sm-6 form-group email required", 'placeholder'=>'Email Address'));
            echo form_hidden('type', 'email'); // used for which action need to perform "email or deny claim"
            ?>
         </div>
      </div>
   </div>
   <div class="form-group col-sm-12">

      <div class="form-group col-sm-3">
         <?php
         echo form_label('Street No.:', 'street_no_email', array("class"=>'col-sm-12'));
         echo form_input("street_no_email", "", array("class"=>"form-control required", 'placeholder'=>'Street No.'));
         echo form_error("street_no_email");
         ?>
      </div>
      <div class="form-group col-sm-3">
         <?php
         echo form_label('Street Name.:', 'street_name_email', array("class"=>'col-sm-12'));
         echo form_input("street_name_email", "", array("class"=>"form-control required", 'placeholder'=>'Street Name.'));
         echo form_error("street_name_email");
         ?>
      </div>
      <div class="form-group col-sm-3">
         <?php
         echo form_label('City:', 'city_email', array("class"=>'col-sm-12'));
         echo form_input("city_email", "", array("class"=>"form-control required", 'placeholder'=>'City'));
         echo form_error("city");
         ?>
      </div>

      <div class="form-group col-sm-3">
         <?php
            echo form_label('Province:', 'province_email', array("class"=>'col-sm-12'));
            echo $province2;
            echo form_error("province_email");
         ?>
      </div>

      <?php
         echo form_label('Select Template:', 'select_template', array("class"=>'col-sm-12'));
      ?>
      <div class="form-group col-sm-12">
         <?php foreach($docs as $doc): ?>
            <div class="select-doc col-sm-2" doc="<?php echo $doc['id'] ?>">
               <i class="fa fa-file-word-o large"></i>
               <?php echo $doc['name'] ?>
            </div>
         <?php endforeach; ?>
      </div>
   </div>
   <div class="form-group col-sm-12 docfiles">
      <?php foreach($docs as $doc): ?>
         <div class="col-sm-12 doc-description doc-<?php echo $doc['id'] ?>" style="display:none">
            <div class="col-sm-12 doc_title">
               <?php echo heading($doc['name']); ?>
            </div>
            <div class="col-sm-12 doc-desc">
               <?php
                  // find and replace text
                  $find = array(
                     '{otc_logo}',
                     '{otc_logo_big}',
                     '{current_date}'
                     );
                  $replace = array(
                     img(array('src'=>'assets/img/otc.jpg','width'=>'130')),
                     img(array('src'=>'assets/img/otc_big.jpg','width'=>'262')),
                     date("F d, Y")
                     );
                echo str_replace($find, $replace, $doc['description']);
               ?>
            </div>
         </div>
      <?php endforeach; ?>
   </div>
</div>