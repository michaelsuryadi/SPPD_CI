<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">Welcome To e-Office System</h2>
    <div id="content-left">
        <div class="content-left-data" id="top-left-content">
            <div class="content-left-img">
                <img width="100" style="margin-left: 20px; margin-top: 20px;" height="100" src="<?php echo base_url();?>css/employee.jpg"/>
            </div>
            <div class="content-left-2">
                <p><b>Employees :</b></p>
                <a href="<?php echo base_url(); ?>index.php/emp/add_emp">Add New Employees</a><br/>
                <a href="<?php echo base_url(); ?>index.php/emp">View & Edit Employees</a><br/>
            </div>
        </div>
        <div class="content-left-data">
            <div class="content-left-img">
                <img width="90" style="margin-left: 25px; margin-top: 20px;" height="90" src="<?php echo base_url();?>css/suitcase.png"/>
            </div>
            <div class="content-left-2" id="content-left-2">
                <p><b>Jobs :</b></p>
                <a href="<?php echo base_url(); ?>index.php/jobs/form_job">Add New Jobs</a><br/>
                <a href="<?php echo base_url(); ?>index.php/jobs">View & Edit Jobs</a><br/>
            </div>
        </div>
        <div class="content-left-data">
            <div class="content-left-img">
                <img width="100" style="margin-left: 25px; margin-top: 20px;" height="100" src="<?php echo base_url();?>css/organization.jpg"/>
            </div>
            <div class="content-left-2">
                <p><b>Organization : </b></p>
                <a href="#">Add New Organization</a><br/>
                <a href="#">View & Edit Organizations</a><br/>
            </div>
        </div>
        <div class="content-left-data">
            <div class="content-left-img">
                <img width="100" style="margin-left: 20px; margin-top: 20px;" height="100" src="<?php echo base_url();?>css/nodin.png"/>
            </div>
            <div class="content-left-2">
                <p><b>Configurations :</b></p>
                    <a href="<?php echo base_url(); ?>index.php/admin">Admin Configuration</a><br/>
                <a href="<?php echo base_url(); ?>index.php/sppd_config">SPPD Flow Configuration</a><br/>
                <a href="#">Nota Dinas Flow Configuration</a><br/>
                <a href="#">Pengajuan Cuti Flow Configuration</a><br/>
            </div>
        </div>
    </div>
    <div id="content-right">
        <div id="content-right-data">
            <p><b>Your Account :</b></p>
             <img width="80" style="margin-left: 105px; margin-top: 20px;" height="80" src="<?php echo base_url();?>css/unknown-prof-pic.png"/>
             <table style="margin-left: 20px; margin-top: 40px;">
                 <?php $row = $result->row(); ?>
                 
                 <tr>
                     <td>Nama</td>
                     <td> : <?php echo $row->emp_firstname." ".$row->emp_lastname; ?></td>
                 </tr>
                 <tr>
                     <td>Account Type</td>
                     <td> : Administrator</td>
                 </tr>
                 <tr>
                     <td>Organisasi</td>
                     <td> : <?php echo $job->org_name; ?></td>
                 </tr>
                 <br/>
                 <tr>
                     <td>&nbsp;</td>
                     <td></td>
                 </tr>
             </table>
        </div>
        
    </div>

</div>