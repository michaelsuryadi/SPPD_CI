<script src="<?php echo base_url(); ?>js/jquery.numberformatter.js"></script>
<script>
    $(document).ready(function() {
        $("#list_org").change(function() {
            var orgnum = $('#list_org').val();
            $.ajax({
                type: "POST",
                url: "http://127.0.0.1/sppd_ci/index.php/jobs/load_job",
                dataType: "JSON",
                data: "org=" + orgnum,
                success: function(data) {
                    $('#list_job')
                            .find('option')
                            .remove()
                            .end()
                            .append('<option value="0">--Pilih--</option>');
                    $.each(data, function(i, n) {
                        var x = document.getElementById("list_job");
                        var option = document.createElement("option");
                        option.text = n['job_name'];
                        option.value = n['job_num'];
                        x.add(option, x.options[null]);
                    });
//                   
                }
            });
            return false;

        });

        $('#list_job').change(function() {
            var jobnum = $('#list_job').val();

            $.ajax({
                type: "POST",
                url: "http://127.0.0.1/sppd_ci/index.php/jobs/load_mgr",
                dataType: "JSON",
                data: "job_num=" + jobnum,
                success: function(data) {
                    $('#add_data').html("");
                    $.each(data, function(i, n) {
                        $("#mgr_num").val(n['emp_num']);
                        $("#mgr_name").val(n['emp_id'] + " - " + n['emp_firstname'] + " " + n['emp_lastname']);
                        $("#org_code").val(n['org_code']);
                        $("#job_code").val(n['job_code']);
                    });
                }
            });
        });

        $("#reg_salary").change(function() {
            var number = $("#reg_salary").val();
            $("#reg_salary_send").val(number);

            var dollars = number.split('.')[0],
                    cents = (number.split('.')[1] || '') + '00';
            dollars = dollars.split('').reverse().join('')
                    .replace(/(\d{3}(?!$))/g, '$1.')
                    .split('').reverse().join('');
            $("#reg_salary").val("Rp. "+dollars);
        });
        
        $("#over_salary").change(function() {
            var number = $("#over_salary").val();
            $("#over_salary_send").val(number);

            var dollars = number.split('.')[0],
                    cents = (number.split('.')[1] || '') + '00';
            dollars = dollars.split('').reverse().join('')
                    .replace(/(\d{3}(?!$))/g, '$1.')
                    .split('').reverse().join('');
            $("#over_salary").val("Rp. "+dollars);
            
        });
    });



</script>
<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">Add New Employees</h2>
    <form id="form_add_emp" action="<?php echo base_url(); ?>index.php/emp/process_add" method="post"> 
        <fieldset style="border:1px dotted black;">
            <legend>Basic Information</legend>
            <table>
                <?php
                $this->load->helper('form');
                ?>

                <tr>
                    <td>Employee_id</td>
                    <?php
                    $data = array(
                        'name' => 'emp_id',
                        'size' => '15',
                        'value' => $emp_curr_num,
                        'readonly'=>'readonly'
                    );
                    ?>
                    <td> : <?php echo form_input($data); ?></td>

                </tr>
                <tr>
                    <td>First Name</td>
                    <td> : <?php
                        $data = array(
                            'name' => 'emp_firstname',
                            'size' => '30'
                        );
                        echo form_input($data);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td> : <?php
                        $data = array(
                            'name' => 'emp_lastname',
                            'size' => '30'
                        );
                        echo form_input($data);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td> : <select name="gender">
                            <option value="0">--Pilih--</option>
                            <option value="L">Laki - Laki</option>
                            <option value="P">Perempuan</option>
                        </select></td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td> : <?php
                        $data = array(
                            'id' => 'dob',
                            'name' => 'emp_dob',
                            'size' => '20'
                        );

                        echo form_input($data);
                        ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td> : <?php
                        $data = array(
                            'name' => 'emp_street',
                            'size' => '50'
                        );
                        echo form_input($data);
                        ?></td>
                </tr>
                <tr>
                    <td>Telepon</td>
                    <td> : <?php
                        $data = array(
                            'name' => 'emp_work_telp',
                            'size' => '25'
                        );
                        echo form_input($data);
                        ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td> : <?php
                        $data = array(
                            'name' => 'emp_email',
                            'size' => '35'
                        );
                        echo form_input($data);
                        ?></td>
                </tr>
                <tr>
                    <td>Foto</td>
                    <td> : <?php
                        $data = array(
                            'name' => 'emp_foto',
                            'size' => '35'
                        );
                        echo form_upload($data);
                        ?></td>
                </tr>
            </table>
        </fieldset>
        <fieldset style="border:1px dotted black; margin-top: 10px;">
            <legend>Employment Information</legend>
            <table>

                <tr>
                    <td>Employee Organization</td>
                    <td>      : <select id="list_org" name="emp_org">
                            <option value="0">--Pilih--</option>
                            <?php
                            foreach ($org->result() as $row3) {
                                ?>
                                <option value="<?php echo $row3->org_num; ?>"><?php echo $row3->org_name; ?></option>
                                <?php
                            }
                            ?>

                        </select></td>
                </tr>
                <tr>
                    <td>Employee Job</td>
                    <td> : <select id="list_job" onchange="load_manager()" name="emp_job">
                            <option value="0">--Pilih--</option>
                        </select><a href="<?php echo base_url(); ?>/index.php/jobs/form_job">Add new Job</a></td>
                </tr>
                <tr>
                    <td>Manager</td>
                    <td> :  <input type="text" id="mgr_name" name="mgr_name" disabled="disabled"/></td>
                <input type='hidden' name='mgr_num' id="mgr_num" />
                <input type='hidden' name='org_code' id="org_code" />
                <input type='hidden' name='job_code' id="job_code" />
                </tr>
                <tr>
                    <td>Regular Salary</td>
                    <td> : <input type="text" id="reg_salary" name="reg_salary2"/></td>
                    <input type="hidden" id="reg_salary_send" name="reg_salary"/>
                    <input type="hidden" id="over_salary_send" name="over_salary"/>
                </tr>
                <tr>
                    <td>Overtime Salary : </td>
                    <td> : <input type="text" id="over_salary" name="over_salary2"/></td>
                </tr>
            </table>
        </fieldset>
        <fieldset style="border:1px dotted black; margin-top: 10px;">
            <legend>Login Information</legend>
            <table>
                <tr>
                    <td>Username</td>
                    <td> : 
                        <?php
                        $data = array(
                            'name' => 'username',
                            'size' => '30',
                            'value' => $emp_curr_num,
                            'readonly'=>'readonly'
                        );

                        echo form_input($data);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td> : 
                        <?php
                        $data = array(
                            'name' => 'password',
                            'size' => '30'
                        );

                        echo form_password($data);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td> : 
                        <?php
                        $data = array(
                            'name' => 'cpassword',
                            'size' => '30'
                        );
                        echo form_password($data);
                        ?>
                    </td>
                </tr>

            </table>
        </fieldset>
        <div style="text-align: center; margin-top: 20px;">
            <?php echo form_submit('simpan', 'Simpan'); ?>
        </div>
    </form>

</div>
