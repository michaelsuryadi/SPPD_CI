<script src="<?php echo base_url(); ?>js/jquery.numberformatter.js"></script>
<script>
    $(document).ready(function() {
        $("#list_org").change(function() {
            var orgnum = $('#list_org').val();
            alert(orgnum);
            $.ajax({
                type: "POST",
                url: "http://127.0.0.1/sppd_ci/index.php/jobs/load_job",
                dataType: "JSON",
                data: "org=" + orgnum,
                success: function(data) {
                    var count = 1;
                    $('#list_job')
                            .find('option')
                            .remove()
                            .end()
                            .append('<option value="0">--Pilih--</option>');
                    $.each(data, function(i, n) {
                        $("#org_code").val(n['org_code']);
                        var x = document.getElementById("list_job");
                        var option = document.createElement("option");
                        option.text = n['job_name'];
                        option.value = n['job_num'];
                        x.add(option, x.options[null]);
                    });
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
            $("#reg_salary").val("Rp. " + dollars);
        });

        $("#over_salary").change(function() {
            var number = $("#over_salary").val();
            $("#over_salary_send").val(number);

            var dollars = number.split('.')[0],
                    cents = (number.split('.')[1] || '') + '00';
            dollars = dollars.split('').reverse().join('')
                    .replace(/(\d{3}(?!$))/g, '$1.')
                    .split('').reverse().join('');
            $("#over_salary").val("Rp. " + dollars);

        });

        $("#dialog-form").dialog({
            autoOpen: false,
            width: 350,
            modal: true,
            position: 'top',
            buttons: {
                "Add Job": function() {
                    var bValid = true;
                    if (bValid) {
                        var jobid = $('#job_id2').val();
                        var jobname = $('#job_name2').val();
                        var jobcode = $('#job_code2').val();
                        var jobdesc = $('#job_desc2').val();
                        var org = $('#list_org2').val();
                        $.ajax({
                            type: "POST",
                            url: "http://127.0.0.1/sppd_ci/index.php/jobs/process_add_ajax",
                            data: "job_id=" + jobid + "&job_name=" + jobname + "&job_code=" + jobcode + "&job_description=" + jobdesc + "&organization=" + org,
                            success: function(data) {
                                var output = data.split(';')[0];
                                var value = data.split(';')[1];
                                $('#list_job').append(output);
                                $('#list_job').val(value);
                                $("#job_code").val(jobcode);
                            }
                        });

                        $(this).dialog("close");
                    }
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            close: function() {
                $(this).dialog("close");
            }
        }).css("font-size", "15px");
        

        $('#add-job').click(function() {
            $('#dialog-form').dialog("open");
            return false;
        });

    });



</script>

<div id="dialog-form" title="Create new Job">
    <p class="validateTips">All form fields are required.</p>

    <form>
        <fieldset>
            <label for="job_id">Job ID</label>
            <input type="text" name="job_id" id="job_id2" class="text ui-widget-content ui-corner-all" readonly="readonly" value="<?php echo $job_curr; ?>"/>
            <label for="job_name">Job Name</label>
            <input type="text" name="job_name" id="job_name2" value="" class="text ui-widget-content ui-corner-all" />
            <label for="job_code">Job Code</label>
            <input type="text" name="job_code" id="job_code2" value="" class="text ui-widget-content ui-corner-all" />
            <label for="job_code">Job Description</label>
            <textarea name="job_desc" id="job_desc2" class="text ui-widget-content ui-corner-all"></textarea>
            <label for="org">Organization</label>
            <select id="list_org2" name="emp_org" class="text ui-widget-content ui-corner-all">
                <option value="0">--Pilih--</option>
                <?php
                foreach ($org->result() as $row3) {
                    ?>
                    <option value="<?php echo $row3->org_num; ?>"><?php echo $row3->org_name; ?></option>
                    <?php
                }
                ?>

            </select>


        </fieldset>
    </form>
</div>

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
                        'readonly' => 'readonly'
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
                <input type="hidden" name="org_code" id="org_code" value=""/>
                <input type="hidden" name="job_code" id="job_code" value=""/>
                <tr>
                    <td>Employee Job</td>
                    <td> : <select id="list_job" onchange="load_manager()" name="emp_job">
                            <option value="0">--Pilih--</option>
                        </select><a href="#" id="add-job">Add new Job</a></td>
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
                            'readonly' => 'readonly'
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


