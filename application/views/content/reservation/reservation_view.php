<style>
    .custom-combobox {
        position: relative;
        display: inline-block;
    }
    .custom-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
        /* support: IE7 */
        *height: 1.7em;
        *top: 0.1em;
    }
    .custom-combobox-input {
        margin: 0;
        padding: 0.3em;
    }

    .ui-autocomplete ui-front ui-menu ui-widget ui-widget-content ui-corner-all {
        list-style-type: none;
    }

    ul.ui-autocomplete {
        list-style: none;
    }
</style>
<script src="<?php echo base_url(); ?>js/flight-reservation.js" type="text/javascript"></script>
<script type="text/javascript">
    $('document').ready(function() {

        $("#dialog-form").dialog({
            autoOpen: false,
            width: 350,
            modal: true,
            show: 'fadeIn',
            hide: 'fadeOut',
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

        $("#dialog-form-flight").dialog({
            autoOpen: false,
            width: 950,
            height: 360,
            hide: 'fadeOut',
            show: 'fadeIn',
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

        $("#dialog-form-hotel").dialog({
            autoOpen: false,
            width: 750,
            height: 600,
            hide: 'fadeOut',
            show: 'fadeIn',
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

        $('#detail-reservation-btn').click(function() {
            $('#dialog-form').dialog("open");
            return false;
        });
        $('#flight-btn').click(function() {
            $('#dialog-form-flight').dialog("open");
            return false;
        });

        $('#hotel-btn').click(function() {
            $('#dialog-form-hotel').dialog("open");
            return false;
        });

        $('#keluar-btn').click(function() {
            window.location = '<?php echo base_url(); ?>index.php/reservation/view_all_reservation';
            return false;
        });
        
        $('#flight-to').change(function(){
            var from = $('#flight-from').val();
            var to = $('#flight-to').val();
            
            $.ajax({
                type: "POST",
                url: "http://127.0.0.1/sppd_ci/index.php/reservation/get_available_airline",
                dataType: "JSON",
                data: "from_city=" + from +" &to_city="+to,
                success: function(data) {
                    $('#list-airline')
                            .find('option')
                            .remove()
                            .end()
                            .append('<option value="0">--Pilih--</option>');
                    $.each(data, function(i, n) {
                        var x = document.getElementById("list-airline");
                        var option = document.createElement("option");
                        option.text = n['label'] + " ("+n['code']+")";
                        option.value = n['name'];
                        x.add(option, x.options[null]);
                    });
                }
            });
        });
        
         

        
        $("#depart").datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url(); ?>css/calendar.png",
            buttonImageOnly: true,
            dateFormat: "dd/mm/yy"
        });
        $("#arrive").datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url(); ?>css/calendar.png",
            buttonImageOnly: true,
            dateFormat: "dd/mm/yy"
        });
        
        $('#search-btn').click(function(){
            
            var from = $('#flight-from').val();
            var to = $('#flight-to').val();
            var airline = $('#list-airline').val();
            var tglflight = $('#depart').val();
            var jmlpenumpang = $('#adl').val();
            var jmlchildren = $('#chl').val();
            var jmlinfant = $('#inf').val();
              $.ajax({
                type: "POST",
                url: "http://127.0.0.1/sppd_ci/index.php/reservation/search_flight",
                dataType: "JSON",
                data: "airline="+airline+"&from_city="+from +"&to_city="+to+"&tgl_flight="+tglflight+"&jml_penumpang="+jmlpenumpang+"&jml_children="+jmlchildren+"&jml_infant="+jmlinfant,
                success: function(data) {
                    alert(data);
                }
            });  
            
        });
    });

</script>
<div id="dialog-form" title="Lihat Deskripsi">
    <?php
    $row = $reservation->row();
    ?>

    <fieldset>
        <legend>Flight Description</legend>
        <p id="flight-desc" style="font-size: smaller;"><?php echo $row->flight_desc; ?></p>
    </fieldset>
    <fieldset>
        <legend>Time Request</legend>
        <p id="time-desc" style="font-size: smaller;"><?php echo $row->time_desc; ?></p>
    </fieldset>
    <fieldset>
        <legend>Hotel Description</legend>
        <p id="hotel-desc" style="font-size: smaller;"><?php echo $row->hotel_desc; ?></p>
    </fieldset>
</div>


<div id="dialog-form-flight" title="Reservasi Airline" >
    <div style="border-bottom: 1px dotted black;">
        <h4 style="margin-left:20px; margin-bottom: 5px;">Form Reservasi Airline</h4>

    </div>
    <fieldset>
        <legend style="font-size:smaller">Cari Airline</legend>
    <table style="font-size:smaller; margin-top: 5px; width: 650px;">
        <tr>
            <td>From</td>
            <td> : <input type="text" id="flight-from" style="width: 250px;" /></td>
            <td></td>
            <td>To</td>
            <td> : <input type="text" id="flight-to" style="width: 250px;" /></td>
        </tr>
        <tr>
            <td>Airline</td>
            <td colspan="2"> : <select name="airline" id="list-airline" style="min-width:100px;">
                    <option value="0">--Pilih Airline--</option>
                </select></td>
            <td>Trip Type</td>
            <td> : <select name="trip_type">
                    <option value="1">One Way</option>
                    <option value="2">Round Trip</option>
                </select></td>
        </tr>
        <tr>
            <td>Depart</td>
            <td colspan="2"> : <input type="text" id="depart" name="depart" /></td>
            <td>Return</td>
            <td> : <input type="text" disabled="disabled" id="arrive" name="arrive" /></td>
        </tr>
        <tr>
            <td>Adlt</td>
            <td> : <select name="adl" id="adl">
                    <option value="0" >0</option>
                    <option value="1" selected="selected">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select> Chd : <select name="chl" id="chl">
                    <option value="0" selected="selected">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option></select>
                Inf : <select name="inf" id="inf">
                    <option value="0" selected="selected">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
            
            </td>
        </tr>
        <tr>
            <td colspan="5"><button id="search-btn">Search Airline</button></td>
        </tr>
    </table>
    </fieldset>


</div>
<div id="dialog-form-hotel" title="Reservasi Hotel">

</div>

<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">Detail Reservasi</h2>

    <fieldset>
        <legend>Detail Pemohon</legend>
        <table style="width: 700px;">
            <tr>
                <td><b>No. SPPD</b></td>
                <td> : <?php echo $row->sppd_id; ?></td>
            </tr>
            <tr>
                <td><b>Tanggal SPPD</b></td>
                <td> : <?php echo $row->sppd_tgl; ?></td>
            </tr>
            <tr>
                <td><b>Deskripsi SPPD</b></td>
                <td> : <?php echo $row->sppd_tuj; ?></td>
            </tr>
            <tr>
                <td><b>Pemohon</b></td>
                <td> : <?php echo $row->emp_firstname . " " . $row->emp_lastname . "/" . $row->job_code . "-" . $row->emp_id . "/" . $row->org_code; ?></td>
            </tr>
            <tr>
                <td><b>Dari - Ke</b></td>
                <td> : <?php echo $row->sppd_dest; ?></td>
            </tr>
            <tr>
                <td><b>Tanggal Berangkat - Pulang</b></td>
                <td> : <?php echo $row->sppd_depart . " - " . $row->sppd_arrive; ?></td>
            </tr>
            <tr>
                <td><b>Deskripsi Permintaan Reservasi</b></td>
                <td> : <button id="detail-reservation-btn">Detail Permintaan</button></td>
            </tr>
        </table>
    </fieldset>
    <h3 style="margin: 0px; padding: 20px; text-align: left;">List Proses Reservasi</h3>

    <table style="margin-left:25px; width: 950px;">
        <tr style="background-color: black; color: white; text-align: center; font-weight: bold;">
            <td>No.</td>
            <td>Tipe Reservasi</td>
            <td>Tanggal Reservasi</td>
            <td>Booking ID</td>
            <td>Nama Hotel / Flight</td>
            <td>Dari Tanggal</td>
            <td>Sampai Tanggal</td>
            <td>Status Reservasi</td>
            <td>Opsi</td>
        </tr>

    </table>
    <div id="status" style="text-align: center; min-height: 150px;">
        <p><b>Data Reservasi belum ada</b></p>
    </div>
    <fieldset style="padding-left: 45px;">
        <legend>Opsi</legend>
        <button id="flight-btn">Reservasi Airline</button>
        <button id="hotel-btn">Reservasi Hotel</button>
        <button id="keluar-btn">Keluar</button>
    </fieldset>
</div>
