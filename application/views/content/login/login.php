<div id="content2">
    <div id="login-form">
        <div id='login-content-left'>
            <img src='<?php echo base_url(); ?>css/logo-telkom.jpg' />
        </div>
        <div id='login-content-right'>
            <div id='title' style='border-bottom: 1px dotted black;'>
                <h3 id="title" style='margin-top:5px;margin-bottom:5px;'>Login To System</h3>
            </div>
            <?php
            $this->load->helper('form');
            echo form_open('login/validate_credentials');

            $data = array(
                array("", ""),
                array(form_label("Username :"), form_input('username', "")),
                array(form_label('Password :'), form_password('password', "")),
                array("", form_checkbox('remember', "Remember Me")." Remember Me"),
                array("", form_submit('submit', 'Login'))
            );

            echo $this->table->generate($data);
            ?>
        </div>

    </div>
</div>