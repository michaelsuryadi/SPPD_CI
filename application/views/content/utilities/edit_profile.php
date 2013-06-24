<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/profile-style.css"/>
<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">Edit Profile</h2>
    <div id="right_content">
        <div id="right_content-img">
            <img width="150" style="margin-left: 70px; margin-top: 20px;" height="150" src="<?php echo base_url(); ?>css/unknown-prof-pic.png"/>
        </div>
        <div id="right_content-data" style="text-align: center;">
            <table style="margin-left: 50px; margin-top: 20px;">
                <tr>
                    <td><input type="file" name="profile_pic"/></td>
                </tr>
            </table>
            
        </div>
    </div>
    <div id="left_content">
        <table style="padding-left: 10px;">
            <?php
            $this->load->helper('form');
            echo form_open('utilities/process_edit_profile');
            $row2 = $employee_data->row();
            ?>
            <tr>
                <td>Firstname</td>
                <td> : <?php echo form_input("firstname",$row2->emp_firstname); ?></td>
            </tr>
            <tr>
                <td>Lastname</td>
                <td> : <?php echo form_input("lastname",$row2->emp_lastname); ?></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td> : <select name="gender">
                        <option value="0">--Pilih--</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select></td>
            </tr>
            <tr>
                <td>Date Of Birth</td>
                <td> : <input type="text" name="dob" id="datebirth" value="<?php echo $row2->emp_dob; ?>" /></td>
            </tr>
            <tr>
                <td>Street Address</td>
                <td> : <input type="text" name="address" value="<?php echo $row2->emp_street; ?>" /></td>
            </tr>
            <tr>
                <td>Telp Number</td>
                <td> : <input type="text" name="telp" value="<?php echo $row2->emp_work_telp; ?>" /></td>
            </tr>
            <tr>
                <td>Email</td>
                <td> : <input type="text" name="email" value="<?php echo $row2->emp_email; ?>"/></td>
            </tr>

            <tr>
                <td></td>
                <td><input type="submit" value="Simpan" style="margin-left: 10px;"/></td>
            </tr>
<?php echo form_close(); ?>
        </table>
    </div>

</div>