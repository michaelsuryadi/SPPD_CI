<div id="content2">
    <div id="login-form">
        <h2 id="title">Login To System</h2>
    <?php
        $this->load->helper('form');
        echo form_open('login/validate_credentials');
            
        $data = array(
            array("",""),
            array(form_label("Username :"),form_input('username',"")),
            array(form_label('Password :'),form_password('password',"")),
            array("",form_submit('submit','Login'))
        );
        
        echo $this->table->generate($data);
    ?>
    </div>
</div>