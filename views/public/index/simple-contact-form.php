<div id="simple-contact">
<?php echo $this->form('contact_form', $options['form_attributes']); ?>
    <fieldset>
        <div class="field">
            <?php echo $this->formLabel('name', __('Your Name:') . ' '); ?>
            <div class="inputs">
                <?php echo $this->formText('name', $options['name'], array('class' => 'textinput')); ?>
            </div>
        </div>
        <div class="field">
            <?php echo $this->formLabel('email', __('Your Email:') . ' '); ?>
            <div class="inputs">
                <?php echo $this->formText('email', $options['email'], array('class' => 'textinput')); ?>
            </div>
        </div>
        <div class="field">
            <?php echo $this->formLabel('message', __('Your Message:') . ' '); ?>
            <div class="inputs">
                <?php echo $this->formTextarea('message', $options['message'], array('class' => 'textinput', 'rows' => '10')); ?>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <?php if ($options['captcha']): ?>
        <div class="field">
            <?php echo $options['captcha']; ?>
        </div>
        <?php endif; ?>
        <?php echo $this->formHidden('path', $options['path']); ?>
        <div class="field">
            <?php echo $this->formSubmit('send', __('Send Message')); ?>
        </div>
    </fieldset>
</form>
</div>
