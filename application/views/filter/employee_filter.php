<fieldset style="border: 1px dotted black; margin-bottom: 10px;">
    <legend>Filter Data</legend>
    <table>
    <p>Filter By :
    
    <?php
        $this->load->helper('form');
        echo form_open('emp/filter_emp');
        
        $options = array(
            'emp_id'=>'Employee id',
            'emp_firstname'=>'Employee name',
            'job'=>'Job',
            'organization'=>'Organization'
        );
        
        $v = array(
            'name'=>'keyword',
            'size'=>'26'
        );
        
        echo form_dropdown('filter',$options);
        echo "  Keyword : ";
        echo form_input($v);
        echo form_submit('submit','Process');
    ?>
        </p>
        </table>
        
</fieldset>
