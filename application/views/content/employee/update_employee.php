<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">Update Employees</h2>
    <fieldset style="border:1px dotted black;">
        <legend>Basic Information</legend>
        <table>
            <?php
                $this->load->helper('form');
                echo form_open('emp/process_update');
            ?>
            <tr>
                <td>Employee_id</td>
                <?php 
                $row = $employee_data->row();
                
                
                $data = array(
                    'name'=>'emp_id',
                    'size'=>'15',
                    'value'=> $row->emp_id
                );
                ?>
                
                <td> : <?php echo form_input($data); ?></td>
                <?php
                $data5 = array(
                  'name'=>'emp_num',
                  'value'=>$row->emp_num
                );
                echo form_hidden($data5);
                ?>
            </tr>
            <tr>
                <td>First Name</td>
                <td> : <?php
                $data = array(
                    'name'=>'emp_firstname',
                    'size'=>'30',
                    'value'=>$row->emp_firstname
                );
                echo form_input($data);
                ?>
                </td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td> : <?php
                $data = array(
                    'name'=>'emp_lastname',
                    'size'=>'30',
                    'value'=>$row->emp_lastname
                );
                echo form_input($data);
                ?>
                </td>
            </tr>
            <tr>
                <td>Gender</td>
                <td> : <select name="gender">
                        <option value="L">Laki - Laki</option>
                        <option value="P">Perempuan</option>
                    </select></td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td> : <?php
                 $data = array(
                   'id'=>'dob',
                   'name'=>'emp_dob',
                   'size'=>'20',
                   'value'=> $row->emp_dob
                 );
                 
                 echo form_input($data);
                ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td> : <?php
                $data = array(
                    'name'=>'emp_street',
                    'size'=>'50',
                    'value'=> $row->emp_street
                    
                );
                echo form_input($data);
                ?></td>
            </tr>
            <tr>
                <td>Telepon</td>
                <td> : <?php
                $data = array(
                    'name'=>'emp_work_telp',
                    'size'=>'25',
                    'value'=>$row->emp_work_telp
                );
                echo form_input($data);
                ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td> : <?php
                $data = array(
                    'name'=>'emp_email',
                    'size'=>'35',
                    'value'=> $row->emp_email
                );
                echo form_input($data);
                ?></td>
            </tr>
            <tr>
                <td>Foto</td>
                <td> : <?php
                $data = array(
                    'name'=>'emp_foto',
                    'size'=>'35'
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
                <td>      : <select name="emp_org">
                        <option value="0">--Pilih--</option>
                        <?php
                        foreach($org->result() as $row3){
                            
                            ?>
                        <option value="<?php echo $row3->org_num; ?>" <?php
                        if($row->org_id == $row3->org_num){
                            echo 'selected=selected ';
                        }
                        
                        ?>><?php echo $row3->org_name; ?></option>
                        <?php
                        }
                        ?>
                        
                    </select></td>
            </tr>
            <tr>
                <td>Employee Job</td>
                <td> : <select name="emp_job">
                        <option value="0">--Pilih--</option>
                            <?php
                                foreach($job->result() as $row4){
                                    
                                    ?>
                        <option value="<?php echo $row4->job_num; ?>" <?php
                        if($row->emp_job == $row4->job_num){
                            echo 'selected=selected ';
                        }
                        
                        ?>><?php echo $row4->job_name; ?></option>
                        <?php
                                }
                            ?>
                       </select>
                </td>
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
                    $row4 = $user_data->row();
                    
                    $data = array(
                      'name'=>'username',
                      'size'=>'30',
                      'value'=>$row4->emp_username
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
                      'name'=>'password',
                      'size'=>'30'
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
                      'name'=>'cpassword',
                      'size'=>'30'
                    );
                    echo form_password($data);
                    ?>
                </td>
            </tr>
            
        </table>
    </fieldset>
    <div style="text-align: center; margin-top: 20px;">
        <?php echo form_submit('simpan','Simpan'); ?>
    </div>
</div>
