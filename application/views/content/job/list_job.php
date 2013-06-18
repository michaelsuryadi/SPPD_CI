<style type="text/css">
    #table-karyawan td, #table-karyawan-2 td, #table-karyawan-3 td {
        padding-left: 20px;
        width: 150px;
        text-align: center;
    }
    #table-karyawan tr {

    }
</style>

<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">List Jobs</h2>
    
    <?php
        $this->load->view('filter/job_filter');
    ?>
    <table style="width: 900px; text-align: center; margin-left: 30px; border-collapse: collapse;">
        <thead style="background-color: black; color:white;">
            <th>Job ID</th>
            <th>Job Name</th>
            <th>Job Description</th>
            <th>Organization</th>
    </thead>
            <?php
            foreach($job->result() as $row){
                ?>
            <tr class="emp-data">
                <td><a href="jobs/upd/id/<?php echo $row->job_num; ?>"><?php echo $row->job_id; ?></a></td>
                <td><a href="jobs/upd/id/<?php echo $row->job_num; ?>"><?php echo $row->job_name; ?></a></td>
                <td><a href="jobs/upd/id/<?php echo $row->job_num; ?>"><?php echo $row->job_description; ?></a></td>
                <td><a href="jobs/upd/id/<?php echo $row->job_num; ?>"><?php echo $row->org_name; ?></a></td>
            </tr>
            <?php
            }
            ?>
        </thead>
    
    </table>
    <br/><br/>
    <a href="jobs/form_job" style="margin-left: 20px;">Add New Job...</a>
</div>
