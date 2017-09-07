<?php echo head(); ?>
<div id="primary">
    <h1><?php echo html_escape(get_option('simple_contact_form_contact_page_title')); ?></h1>
<div id="simple-contact">
    <div id="form-instructions">
        <?php echo get_option('simple_contact_form_contact_page_instructions'); // HTML ?>
    </div>
    <?php echo flash(); ?>
    <form name="contact_form" id="contact-form"  method="post" enctype="multipart/form-data" accept-charset="utf-8">

      <?php
        $fields = SimpleContactFormPlugin::prepareFields();
        // echo "<pre>" . print_r($fields,true) . "</pre>";
        foreach($fields["fieldOrder"] as $field) {

          switch ($field) {
            case 'name': {
              ?>
                <div class="field">
                    <?php
                      echo $this->formLabel('name', __('Your Name:'));
                      if (isset($fields["mandatoryFields"]["name"])) {
                    ?>
                        <span style="color: red;">*</span>
                    <?php
                      }
                    ?>
                    <div class='inputs'>
                    <?php echo $this->formText('name', $name, array('class'=>'textinput')); ?>
                    </div>
                </div>
              <?php
            } break;

            case 'email': {
              ?>
                <div class="field">
                    <?php echo $this->formLabel('email', __('Your Email:')); ?>
                    <span style="color: red;">*</span>
                    <div class='inputs'>
                        <?php echo $this->formText('email', $email, array('class'=>'textinput'));  ?>
                    </div>
                </div>
              <?php
            } break;

            case 'message': {
              ?>
                <div class="field">
                  <?php echo $this->formLabel('message', __('Your Message:')); ?>
                  <span style="color: red;">*</span>
                  <div class='inputs'>
                  <?php echo $this->formTextarea('message', $message, array('class'=>'textinput', 'rows' => '10')); ?>
                  </div>
                </div>
              <?php
            } break;

            default: {
              $additionalField = $fields["additionalFields"][$field];
              ?>
                <div class="field">
                  <?php
                    echo $this->formLabel($additionalField["fieldName"], $additionalField["fieldLabel"]) . ":";
                    if ($additionalField["mandatoryField"]) {
                  ?>
                    <span style="color: red;">*</span>
                  <?php
                    }
                  ?>
                  <div class='inputs'>
                  <?php
                    $fieldName = $additionalField["fieldName"];
                    $fieldValue = $additionalField["fieldValue"];
                    switch ($additionalField["fieldType"]) {
                      case 'multi': echo $this->formTextarea($fieldName, $fieldValue, array('class'=>'textinput', 'rows' => '10')); break;
                      case 'dropdown': echo $this->formSelect($fieldName, $fieldValue, array(), $additionalField["dropDowns"]); break;
                      default: /* 'generic' */ echo $this->formText($fieldName, $fieldValue, array('class'=>'textinput')); break;
                    }
                  ?>
                  </div>
                </div>
              <?php
            } break;
          }

        }
      ?>

        <?php if ($captcha): ?>
        <div class="field">
            <?php echo $captcha; ?>
        </div>
        <?php endif; ?>

        <div class="field">
          <?php echo $this->formSubmit('send', __('Send Message')); ?>
        </div>
    </form>

</div>

</div>
<?php echo foot();
