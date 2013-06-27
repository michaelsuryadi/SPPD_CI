<script type="text/javascript">
$('document').ready(function(){
   $('#pilih-pegawai').click(function(){
            var org = $('#list_org').val();
            window.open('http://127.0.0.1/sppd_ci/index.php/jobs/pilih_employee/id/'+org, 'Pilih Pemeriksa', 'height=500,width=800');
            return false;
        });
        
        $('#list_org').change(function(){
           $('#employee').val("");
           $('#emp_num').val("");
        });
});

</script>

<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">Update Job</h2>
    <fieldset style="border:1px dotted black;">
        <legend>Job Information</legend>
        <?php
            $this->load->helper('form');
            echo form_open('jobs/process_update');
        ?>
        <table style="width: 500px; margin-left: 20px;">
            <tr>
                <td>Job ID</td>
                <td> : </td>
                    <td><?php 
                    $row = $job_data->row();
                $data = array(
                    'name'=>'job_id',
                    'size'=>'15',
                    'readonly'=>'readonly',
                    'value'=> $row->job_id
                );
                
                
                echo form_input($data);
                ?></td>
            </tr>
            <tr>
                <td>Job Name</td>
                <td> : </td>
                    <td><?php 
                $data = array(
                    'name'=>'job_name',
                    'size'=>'40',
                    'value'=>$row->job_name
                    
                );
                
                echo form_input($data);
                ?></td>
            </tr>
            <tr>
                <td>Job Code</td>
                <td> : </td>
                    <td><?php 
                $data = array(
                    'name'=>'job_code',
                    'size'=>'20',
                    'value'=>$row->job_code
                );
                
                echo form_input($data);
                ?></td>
            </tr>
            <tr>
                <td>Job Description</td>
                <td>: </td>
                    <td><?php 
                $data = array(
                    'name'=>'job_description',
                    'cols'=>'20',
                    'rows'=>'5',
                    'value'=>$row->job_description
                );
                
                echo form_textarea($data);
                ?></td>
            </tr>
            <tr>
                <td>Organization : </td>
                <td> : </td>
                
                <td><select name="org" id="list_org">
                        <?php
                        foreach($org->result() as $rowOrg){
                            
                            ?>
                        <option value="<?php echo $rowOrg->org_num; ?>" <?php
                        if($row->org_num == $rowOrg->org_num){
                            echo " selected='selected'";
                        }
                        ?>><?php echo $rowOrg->org_name; ?></option>
                        <?php
                        }
                        ?>
                    </select></td>
            </tr>
        </table>
    </fieldset>
    <div style="text-align: center; margin-top: 10px;">
        <?php echo form_submit('submit','Simpan'); ?>
    </div>
</div>
