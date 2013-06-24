<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">Change Password</h2>
    
    <fieldset>
        <legend>Your Login Information</legend>
        <table>
            <?php 
            $this->load->helper('form');
            echo form_open("utilities/process_change_password"); ?>
            <tr>
                <td>Old Password : </td>
                <td><input type="password" name="old" /></td>
            </tr>
            <tr>
                <td>New Password : </td>
                <td><input type="password" name="new" /></td>
            </tr>
            <tr>
                <td>Confirm New Password : </td>
                <td><input type="password" name="confirm" /></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Save" style="width: 100px;"/></td>
            </tr>
            <?php echo form_close(); ?>
        </table>
        
    </fieldset>
</div>