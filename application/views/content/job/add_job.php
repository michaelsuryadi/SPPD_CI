<script type="text/javascript">
    $(document).ready(function(){
        $("#list_org").change(function(){
           
           var orgnum = $('#list_org').val();
           $.ajax({
                type: "POST",
                url: "http://127.0.0.1/sppd_ci/index.php/emp/load_emp_per_org",
                dataType: "JSON",
                data: "org=" + orgnum,
                success: function(data) {
                    $('#list_mgr')
                            .find('option')
                            .remove()
                            .end()
                            .append('<option value="0">--Pilih--</option>');
                    $.each(data, function(i, n) {
                        var x = document.getElementById("list_mgr");
                        var option = document.createElement("option");
                        option.text = n['emp_id']+"-"+n['emp_firstname']+" "+n['emp_lastname'];
                        option.value = n['emp_num'];
                        x.add(option, x.options[null]);
                    });
//                   
                }
            });
        });
    });
</script>

<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">Add New Job</h2>
    <fieldset style="border:1px dotted black;">
        <legend>Job Information</legend>
        <?php
            $this->load->helper('form');
            echo form_open('jobs/process_add');
        ?>
        <table style="width: 500px; margin-left: 20px;">
            <tr>
                <td>Job ID</td>
                <td> : </td>
                    <td><?php 
                $data = array(
                    'name'=>'job_id',
                    'size'=>'15',
                    'value'=>$job_curr_num,
                    'readonly'=>'readonly'
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
                    'size'=>'20'
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
                    'size'=>'20'
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
                    'rows'=>'5'
                );
                
                echo form_textarea($data);
                ?></td>
            </tr>
            <tr>
                <td>Organization </td>
                <td> : </td>
                <td><select name="organization" id="list_org">
                        <option value="0">--Pilih Organization--</option>
                        <?php
                            foreach($org->result() as $row){
                                
                                ?>
                        <option value="<?php echo $row->org_num; ?>"><?php echo $row->org_name; ?></option>
                        <?php
                            }
                        
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td>Manager</td>
                <td> : </td>
                <td><select id="list_mgr" name="manager">
                        <option value="0">--Pilih--</option>
                    </select></td>
            </tr>
        </table>
    </fieldset>
    <div style="text-align: center; margin-top: 10px;">
        <?php echo form_submit('submit','Simpan'); ?>
    </div>
</div>
