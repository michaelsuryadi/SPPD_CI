<script type="text/javascript">
    $('document').ready(function() {
        $("#dialog-form").dialog({
            autoOpen: false,
            width: 350,
            modal: true,
            position: 'top',
            buttons: {
                "Close": function() {
                    $(this).dialog("close");
                }
            },
            close: function() {
                $(this).dialog("close");
            }
        }).css("font-size", "15px");

        $('.desc-button').click(function() {
            var id = $(this).attr('id');
            $('#dialog-form').dialog('open');
            $.ajax({
                type: "POST",
                url: "http://127.0.0.1/sppd_ci/index.php/reservation/load_request",
                data: "req_id="+id,
                success: function(data) {
                    var flight = data.split('!@#')[0];
                    var time = data.split('!@#')[1];
                    var hotel = data.split('!@#')[2];
                    
                    $('#flight-desc').html(flight);
                    $('#time-desc').html(time);
                    $("#hotel-desc").html(hotel);
                }
            });
        });
    });


</script>

<div id="dialog-form" title="View Description">
    <fieldset>
        <legend>Flight Description</legend>
        <p id="flight-desc" style="font-size: smaller;"></p>
    </fieldset>
    <fieldset>
        <legend>Time Request</legend>
        <p id="time-desc" style="font-size: smaller;"></p>
    </fieldset>
    <fieldset>
        <legend>Hotel Description</legend>
        <p id="hotel-desc" style="font-size: smaller;"></p>
    </fieldset>
</div>


<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">List Reservation Request</h2>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css"/>
    <div id="content-sppd-left" style='border-top: 1px dotted black;'>
        <div id="sppd-right-title" style="">
            <p style="margin-left: 20px; margin-top: 10px;"><b>Search</b></p>
            <table>
                <tr>
                    <td><input style='margin-left: 20px;' type='text' name='keyword'/></td>
                </tr>
                <tr>
                    <td><button style='margin-left: 20px;' id='search-btn'>Search</button></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><b style='margin-left: 20px;'>Sort Request By :</b></td>
                </tr>

                <tr>
                    <td><p style='margin-left: 20px; font-size: smaller;'>Employee ID</p></td>
                </tr>
                <tr>
                    <td><p style='margin-left: 20px; font-size: smaller;'>Create Date</p></td>
                </tr>
                <tr>
                    <td><p style='margin-left: 20px; font-size: smaller;'>Depart Date</p></td>
                </tr>


            </table>
        </div>
    </div>

    <div id="content-sppd-right" style='border-top: 1px dotted black;'>
        <div id="sppd-right-title" style="">
            <p style="margin-left: 20px; margin-top: 10px;"><b>List Seluruh Request : </b></p>
        </div>
        <div id="sppd-right-filter">
            <div id='filter-left'>
                <p style='font-size: smaller; margin-left: 20px; margin-bottom: 3px; margin-top: 3px;'><i>Filter By : All</i></p>
            </div>
            <div id='filter-right' style="background-color: black; color:white;">
                <p style='margin-top: 3px; margin-left: 40px;'>Page : < <b>1</b> 2 3 4 5 ></p>
            </div>

        </div>
        <table style="width:760px; margin-left: 20px; margin-top: 10px;">
            <thead style="background-color: black; color: white;">
            <th>No</th>
            <th>Nama</th>
            <th>NIK</th>
            <th>Jabatan</th>
            <th>Tanggal Berangkat</th>
            <th>Tanggal Kembali</th>
            <th>Deskripsi Perjalanan</th>
            <th>Status</th>
            <th>Opsi</th>
            </thead>

            <?php
            $i = 1;
            foreach ($reservation->result() as $row) {
                ?>
                <tr style="text-align: center; font-size: 14px;">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row->emp_firstname . " " . $row->emp_lastname; ?></td>
                    <td><?php echo $row->emp_id; ?></td>
                    <td><?php echo $row->job_name; ?></td>
                    <td><?php echo $row->sppd_depart; ?></td>
                    <td><?php echo $row->sppd_arrive; ?></td>
                    <td><button id="<?php echo $row->req_id; ?>" class="desc-button" style="font-size: smaller;">View Deskripsi</button></td>
                    <td><?php if ($row->status == 1) {
                echo 'Belum Di Proses';
            } else {
                echo 'Sudah Di proses';
            } ?></td>
                    <td><button>Proses</button></td>
                </tr>
                <?php
            }
            ?>

        </table>



    </div>
</div>