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
    <h2 style="margin: 0px; padding: 20px; text-align: left;">List Employees</h2>
    
    <?php
        $this->load->view('filter/employee_filter');
    ?>
    <table style="width: 900px; text-align: center; margin-left: 30px; border-spacing: 0px;">
        <thead style="background-color: black; color:white; padding-bottom: 1em">
            <th>Employee ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Date Of Birth</th>
            <th>Telp</th>
            <th>Email</th>
        </thead>
    <?php
        foreach($employees->result() as $row){  
            ?>
        <tr class="emp-data" >
            <td><a style="color:black;" href="emp/view/id/<?php echo $row->emp_num; ?>"><?php echo $row->emp_id; ?></a></td>
            <td><a style="color:black;" href="emp/view/id/<?php echo $row->emp_num; ?>"><?php echo $row->emp_firstname; ?></a></td>
            <td><a style="color:black;" href="emp/view/id/<?php echo $row->emp_num; ?>"><?php echo $row->emp_lastname; ?></a></td>
            <td><a style="color:black;" href="emp/view/id/<?php echo $row->emp_num; ?>"><?php echo $row->emp_dob; ?></a></td>
            <td><a style="color:black;" href="emp/view/id/<?php echo $row->emp_num; ?>"><?php echo $row->emp_work_telp; ?></a></td>
            <td><a style="color:black;" href="emp/view/id/<?php echo $row->emp_num; ?>"><?php echo $row->emp_email; ?></a></td>
            
        </tr>
            <?php
        }
    ?>
    </table>
    <?php
        

        $config['base_url'] = 'http://127.0.0.1/index.php/emp/page/';
        $config['total_rows'] = $employees->num_rows();
        $config['per_page'] = 20;

        $this->pagination->initialize($config);

        echo $this->pagination->create_links();
    
    ?>
    <br/><br/>
    <a href="emp/add_emp" style="margin-left: 20px;">Add New Employee...</a>
</div>
