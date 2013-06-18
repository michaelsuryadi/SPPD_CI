
<fieldset style="border: 1px dotted black; margin-bottom: 10px;">
    <legend>Filter Data</legend>
    <table>
    <tr>
        <?php $this->load->helper('form');
        echo form_open('jobs/filter_job'); ?>
        <td>Organization :</td>
        <td>
    
    <?php
        
        $options = array(
            'org'=>'--All Organization--'
        );
        
        $v = array(
            'name'=>'keyword',
            'size'=>'26'
        );
        
        echo form_dropdown('filter',$options);
        echo form_submit('submit','Process');
    ?>
        </td>
      </tr>
        </table>
        
</fieldset>
