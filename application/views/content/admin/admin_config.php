<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">Admin Configuration</h2>

    <fieldset>
        <legend>Basic Settings</legend>
        <table>
            <tr>
                <td>Application title : </td>
                <td> : <input style="width: 300px;" type="text" name="tech_support" /></td>
            </tr>
            <tr>
                <td>Technical Support : </td>
                <td> : <input style="width: 300px;" type="text" name="tech_support" /></td>
            </tr>
            <tr>
                <td>Customize Application Banner : </td>
                <td> : <input type="file" name="company_banner" /></td>
            </tr>
            <tr>
                <td>Customize Company Logo Login Page</td>
                <td> : <input type="file" name="company_logo" /></td>
            </tr>
            <tr>
                <td>Related Links : </td>
                <td>&nbsp; &nbsp;<select name="rel_links" multiple style="width:200px;">
                    </select></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Simpan"/></td>
            </tr>
        </table>
    </fieldset>
    <fieldset>
        <legend>HRM Settings</legend>
        <?php
        $this->load->helper('form');
        $totalrow = $config->num_rows();
        $conf_data = $config->row();
        echo form_open("admin/upd_config");
        ?>
        <table>
            <tr>
                <td>Employee Start Number : </td>
                <td><input type="text" name="emp_start" <?php if($totalrow>0){
                echo "value='".$conf_data->emp_start_num."'";
                    
                } ?>/></td>
            </tr>
            <tr>
                <td>SPPD Start Number : </td>
                <td><input type="text" name="sppd_start" <?php if($totalrow>0){
                echo "value='".$conf_data->sppd_start_num."'";
                    
                } ?> /></td>
            </tr>
            <tr>
                <td>Job Start Number : </td>
                <td><input type="text" name="job_start" <?php if($totalrow>0){
                echo "value='".$conf_data->job_start_num."'";
                    
                } ?>/></td>
            </tr>

        </table>

    <div style="text-align: center; margin-top: 10px;">
        <?php echo form_submit('submit', 'Simpan'); ?>
    </div>
    <?php
    echo form_close();
    ?>
    </fieldset>
    
</div>
