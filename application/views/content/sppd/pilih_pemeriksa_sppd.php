<html>
    <head>
        <title><?php echo $title; ?></title>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.8.1.min.js"></script>
        <style>
            body {
                font-family: calibri;
            }
        </style>

        <script type="text/javascript">
            $(function(){
                var nama="";
                var jobcode="";
                var jobname="";
                var empid="";
                var empnum="";
                var orgname="";
               $('.pem').click(function(){
                  var id = $(this).attr('id').split('-')[1];
                  var data = $('#nama-'+id).html();
                  nama = data.split('/')[0];
                  jobcode = data.split('/')[1].split('-')[0];
                  empid = data.split('/')[1].split('-')[1];
                  empnum = $('#emp_num-'+id).html();
                  jobname = $('#job-'+id).html();
                  orgname = $('#org-'+id).html();
                  
                  return false;
                  
               });
               
               $('#btnPilih').click(function(){
                  
                  var x = opener.document.getElementById("pemeriksa");
                  var option = document.createElement("option");
                  option.text = jobname;
                  option.value= empnum;
                  x.add(option, x.options[null]);
                  
                  window.close();
                  return false;
               });
            });
        </script>
    </head>

    <body>
        <div id='header' style='background-color: #000; color: white;'>
            <h2>Pilih Semua Pemeriksa :</h2>
        </div>

        <div id='content' style='min-height: 370px; text-align: center;'>
            <p><b>Search By Name:</b></p>
            <?php
            $this->load->helper('form');
            echo form_open('sppd/show_exam');
            echo form_input('keyword');
            echo form_submit('submit', 'Search');
            ?>
            <br/>
            <p><b>List Atasan : </b></p>
            
            <table style='width:600px; margin-top: 10px; margin-left: 80px; border: 1px dotted black; text-align: center;'>
                <thead style='background-color: #1f2024; color:white;'>
                <th>Employee Details</th>
                <th>Jabatan</th>
                <th>Pilih</th>
                </thead>

                <?php
                $i = 1;
                foreach ($all_atasan->result() as $row) {
                    ?>
                    <tr>
                        
                    <p id="emp_num-<?php echo $i; ?>" style="display:none;"><?php echo $row->emp_num; ?></p>
                        <td id="nama-<?php echo $i; ?>"><?php echo $row->emp_firstname . " " . $row->emp_lastname . "/" . $row->job_code . "-" . $row->emp_id . "/" . $row->org_code; ?></td>
                        <td id="job-<?php echo $i; ?>"><?php echo $row->job_name ?></td>
                        <td id="org-<?php echo $i; ?>" style="display: none;"><?php echo $row->org_name; ?></td>
                        <td><?php
                            $data = array(
                                "name" => "pemohon",
                                "class" => "pem",
                                "id" => "pem-" . $i,
                                "value" => $row->emp_num
                            );
                            echo form_radio($data);
                            ?></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td><button id="btnPilih" onclick="javascript:setValueInParent();">Pilih</button></td>
                </tr>
            </table>
        </div>
        <div id='footer' style='height: 40px; background-color: #000; color: white;'>

        </div>
    </body>
</html>

