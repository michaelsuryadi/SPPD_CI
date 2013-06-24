<div id="banner-top">
    <script type="text/javascript">
        function updateClock() {
                // Gets the current time
                var now = new Date();
                
                // Get the hours, minutes and seconds from the current time
                var day = now.getDate() +"/"+now.getMonth()+"/"+now.getFullYear();
                var hours = now.getHours();
                var minutes = now.getMinutes();
                var seconds = now.getSeconds();
 
                // Format hours, minutes and seconds
                if (hours < 10) {
                    hours = "0" + hours;
                }
                if (minutes < 10) {
                    minutes = "0" + minutes;
                }
                if (seconds < 10) {
                    seconds = "0" + seconds;
                }
 
                // Gets the element we want to inject the clock into
                var elem = document.getElementById('clock');
 
                // Sets the elements inner HTML value to our clock data
                elem.innerHTML = "Date/Time : "+day+" "+hours + ':' + minutes + ':' + seconds;
            }

    </script>
    <h1>HRM Application</h1>
    <p style="margin-left: 10px;">
        <?php
        $this->load->helper('date');
        
        foreach ($result->result() as $row) {
            echo $row->emp_firstname . " " . $row->emp_lastname." / ".$row->job_code."-".$row->id_emp."/".$row->org_code;
        
            if($row->emp_role==1){
                echo ' - Administrator';
            }
        }
        ?>
    </p>
        <?php
        $datestring = "%d-%m-%Y - %h:%i %A";
         $time = time();
         $timezone = 'UP7';
         $timedata=  gmt_to_local($time, $timezone, FALSE);
         echo unix_to_human($timedata);
//        echo mdate($datestring, $gmt);
        ?>
    <p style="margin-left: 10px;" id="clock">
        
    <?php
        // $datestring = "%d-%m-%Y - %h:%i %A";
        // $time = time();
        // $timezone = 'UP7';
        // $timedata=  gmt_to_local($time, $timezone, FALSE);
        // echo unix_to_human($timedata);
//        echo mdate($datestring, $gmt);
        ?>
    </p>
</div>
<?php $this->load->view('content/sidemenu3'); ?>