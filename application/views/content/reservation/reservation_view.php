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
<script src="<?php echo base_url(); ?>js/number-format.js" type="text/javascript"></script>

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
            width: 850,
            height: 650,
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
            width: 800,
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

        $('#flight-to').change(function() {
            var from = $('#flight-from').val();
            var to = $('#flight-to').val();

            $.ajax({
                type: "POST",
                url: "http://127.0.0.1/sppd_ci/index.php/reservation/get_available_airline",
                dataType: "JSON",
                data: "from_city=" + from + " &to_city=" + to,
                success: function(data) {
                    $('#list-airline')
                            .find('option')
                            .remove()
                            .end()
                            .append('<option value="0">--Pilih--</option>');
                    $.each(data, function(i, n) {
                        var x = document.getElementById("list-airline");
                        var option = document.createElement("option");
                        option.text = n['label'] + " (" + n['code'] + ")";
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
            dateFormat: "dd/mm/yy",
            onSelect: function(dateText, inst) {
                var date = $(this).datepicker('getDate');
                $('#depart_date').html($.datepicker.formatDate('D', date))
            }
        });
        $("#arrive").datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url(); ?>css/calendar.png",
            buttonImageOnly: true,
            dateFormat: "dd/mm/yy"
        });

        $('#search-btn').click(function() {
            $('#loading-text').show();
            var from = $('#flight-from').val();
            var to = $('#flight-to').val();
            var airline = $('#list-airline').val();
            var tglflight = $('#depart').val();
            var jmlpenumpang = $('#adl').val();
            var jmlchildren = $('#chl').val();
            var jmlinfant = $('#inf').val();
            var dt = "airline=" + airline + "&from_city=" + from + "&to_city=" + to + "&tgl_flight=" + tglflight + "&jml_penumpang=" + jmlpenumpang + "&jml_children=" + jmlchildren + "&jml_infant=" + jmlinfant;
            $('body').css('cursor', 'wait');

            $.ajax({
                type: "POST",
                url: "http://127.0.0.1/sppd_ci/index.php/reservation/search_flight",
                data: dt,
                success: function(data) {
                    $('#search-form').hide();
                    $('#form-search-result').fadeIn();
                    $('body').css('cursor', 'auto');
                    $('#data').html(data);
                    $('#dialog-form').css('min-height', '500px');

                    var content = JSON.parse(data);
                    var fromcity = content.flight.result_summary.dep_route.depart.airport_name;
                    var fromiata = content.flight.result_summary.dep_route.depart.airport_iata;
                    var tocity = content.flight.result_summary.dep_route.arrival.airport_name;
                    var toiata = content.flight.result_summary.dep_route.arrival.airport_iata;
                    var day = $('#depart_date').html();
                    var destination_text = fromcity + " (" + fromiata + ") Ke " + tocity + " (" + toiata + ") - " + day + "," + tglflight;

                    $('#destination-text').html(destination_text);
                    $('#jsondata').html(data);


                    var total = content.flight.departures.result.length;
                    var i = 0;
                    for (i = 0; i < total; i++) {
                        var isi = "<tr>";
                        isi += "<td><img src=\"<?php echo base_url(); ?>css/JT.gif\"/>" + content.flight.departures.result[i].airline_name + " - " + content.flight.departures.result[i].flight_number + "</td>";
                        isi += "<td>" + fromcity + "<br/>" + content.flight.departures.result[i].depart_time + "</td>";
                        isi += "<td>" + tocity + "<br/>" + content.flight.departures.result[i].arrival_time + "</td>";
                        isi += "<td>" + content.flight.departures.result[i].class + "</td>";
                        isi += "<td>" + content.flight.departures.result[i].seat + "</td>";
                        isi += "<td>Rp. " + FormatNumberBy3(content.flight.departures.result[i].total_fares, ".", ".") + "</td>";
                        isi += "<td><input id=\"book-" + i + "\" type=\"radio\" name=\"book-flight\" value=\"" + content.flight.departures.result[i].ftid + "\" />";

                        isi += "</tr>";
                        $('#data2').append(isi);

                        $('#book-' + i).click(function() {
                            var ftid = $(this).val();
                            $('#ftid').html(ftid);
                        });
                    }
                }
            });
        });

        $('#booking-btn').click(function() {
            var ftid = $('#ftid').html();
            $('body').css('cursor', 'wait');
            if (ftid != "") {
                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1/sppd_ci/index.php/reservation/get_build_pnr",
                    data: "ftid=" + ftid,
                    success: function(data) {
                        $('#form-search-result').fadeOut();
                        $('#form-pnr-flight').fadeIn();
                        $('body').css('cursor', 'auto');
                        var content = JSON.parse(data);
                        var summary_text = "Total Price for " + content.adult + " Adult, " + content.child + " Child, " + content.infant + " Infant";
                        var summary_price = "<b>Published Fare : IDR " + FormatNumberBy3(content.itinerary.flight_details.total_fares) + "</b>";
                        $('#summary-text').html(summary_text);
                        $('#summary-price').html(summary_price);
                        var note = content.itinerary.flight_details.transit_airport.transit.length;
                        var datanote = "";
                        if (note == 0) {
                            datanote = "Direct Flight";
                        }
                        else {
                            datanote = "Transit";
                        }

                        var itinerary_data = "<tr>";
                        itinerary_data += "<td>" + content.itinerary.flight_details.flight_number + "</td><td>" + content.itinerary.result_summary.dep_route.depart.airport_name + " " + $('#depart_date').html() + " " + content.itinerary.result_summary.dep_route.date + "</td>";
                        itinerary_data += "<td>" + content.itinerary.result_summary.dep_route.arrival.airport_name + " " + $('#depart_date').html() + " " + content.itinerary.result_summary.dep_route.date + "</td>";
                        itinerary_data += "<td>" + content.itinerary.flight_details.class + "</td><td>" + datanote + "</td>";
                        itinerary_data += "</tr>";

                        $('#itinerary-tbl').append(itinerary_data);
                    }
                });
            }
        });

        $('#finish-button').click(function() {
            $('body').css('cursor', 'wait');
            $(this).attr('disabled', 'disabled');
            var ftid = $('#ftid').html();
            var title = $('#title').val();
            var gender = 'male';
            if (title == 'MRS' || title == 'MS') {
                gender = 'female';
            }
            var firstname = $('#firstname').val();
            var lastname = $('#lastname').val();

            var titlecp = $('#title-cp').val();
            var firstnamecp = $('#firstname-cp').val();
            var lastnamecp = $('#lastname-cp').val();
            var countrycode = $('#countrycode-cp').val();
            var phonenumbercp = $('#phonenumber-cp').val();
            var reqid = $('#req_id').html();
            var empnum = $('#emp_num').html();

            $.ajax({
                type: "POST",
                url: "http://127.0.0.1/sppd_ci/index.php/reservation/process_booking",
                data: "ftid=" + ftid + "&titleadlt=" + title + "&firstnameadlt=" + firstname + "&lastnameadlt=" + lastname + "&contacttitle=" + titlecp + "&contactfirstname=" + firstnamecp + "&contactlastname=" + lastnamecp + "&countrycode=" + countrycode + "&contactphone=" + phonenumbercp + "&reqid=" + reqid + "&empnum=" + empnum,
                success: function(data) {
                    $('body').css('cursor', 'auto');
                    var content = JSON.parse(data);
                    var booking_code = content.flight.booking_code;
                    var date_limit = content.flight.date_limit;
                    var time_limit = content.flight.time_limit;

                    alert('Booking Success \nYour booking code : ' + booking_code + '\nDate/Time Limit : ' + date_limit + '/' + time_limit);
                    location.reload();
                }
            });

        });

        $('#cntry').change(function() {
            var country = $(this).val();
            $.ajax({
                type: "POST",
                url: "http://127.0.0.1/sppd_ci/index.php/reservation/get_list_city",
                data: "id_country=" + country,
                success: function(data) {
//                    $('#city')
//                            .find('option')
//                            .remove()
//                            .end()
//                            .append('<option value="0">--Pilih--</option>');

                    alert(data);
//                        var x = document.getElementById("city");
//                        var option = document.createElement("option");
//                        option.text = n['Name'];
//                        option.value = n['IdCity'];
//                        x.add(option, x.options[null]);

                }
            });
        });
    });

</script>
<div id="dialog-form" title="Lihat Deskripsi">

    <?php
    $row = $reservation->row();
    ?>
    <p id="req_id" style="display:none;"><?php echo $row->req_id; ?></p>
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
    <div id="search-form">
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
                <p id="depart_date" style="display:none;"></p>
                <td>Return</td>
                <td> : <input type="text" disabled="disabled" id="arrive" name="arrive" /></td>
                <p id="arrive_date" style="display:none;"></p>
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
                    <td colspan="4"><button id="search-btn">Search Airline</button></td>
                    <td><p id="loading-text" style="font-size: smaller; display: none;"><img src="<?php echo base_url(); ?>css/ajax-loader.gif" style="width: 20px; height:10px;" /> &nbsp; Connecting To Service...</p></td>
                </tr>
            </table>
        </fieldset>

    </div>
    <div id="form-search-result" style="display:none;">
        <p style="font-size: smaller; margin-left:20px;"><b>Search Result : </b></p>
        <div id="tambah" style="padding-left:20px;">
            <p style="font-size: smaller;" id="destination-text"></p>
            <table id="flight-data" style="width:650px; font-size: smaller; text-align: center;">
                <thead style="background-color: black; color: white;">
                <th>Flight</th>
                <th>Depart</th>
                <th>Arrive</th>
                <th>Class</th>
                <th>Available Seats</th>
                <th>Prices</th>
                <th>Select</th>
                </thead>
                <tbody id='data2'>

                </tbody>
                <tbody id='footer'>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><button id='booking-btn'>Booking</button></td>
                    </tr>
                </tbody>
            </table>
            <p id='ftid' style='display:none;'></p>
        </div>

    </div>
    <div id="form-pnr-flight" style="display:none;">
        <h5 style="margin-left:20px">Passanger Name Record - PNR</h5>
        <fieldset style="font-size:smaller;">
            <legend>Itinerary</legend>
            <p style="font-size:smaller;">Depart Flight : </p>
            <table id="itinerary-tbl" style="font-size: smaller; text-align: center; width: 550px;">
                <thead style="background-color: black; color:white; ">
                <th>No Flight</th>
                <th>Depart</th>
                <th>Arrive</th>
                <th>Class</th>
                <th>Note</th>
                </thead>
            </table>
        </fieldset>

        <fieldset style="font-size: smaller;">
            <legend>Summary</legend>
            <p style="margin-left:20px; font-size: smaller;" id="summary-text"></p>
            <p style="margin-left:20px; font-size: smaller;" id="summary-price"></p>
        </fieldset>

        <fieldset style="font-size: smaller;">
            <legend>Passanger</legend>
            <p style="font-size:smaller">Input your personal information : </p>
            <table style="width: 300px; font-size: smaller;">
                <tr>
                    <td>Title : </td>
                    <td><select name="titleadlt1" id="title">
                            <option value="Mr">Mr.</option>
                            <option value="Mrs">Mrs.</option>
                            <option value="Ms">Ms.</option>
                        </select></td>
                </tr>
                <tr>
                    <td>Firstname : </td>
                    <td><input type="text" id="firstname" name="firstnameadlt1" /></td>
                </tr>
                <tr>
                    <td>Lastname : </td>
                    <td><input type="text" id="lastname" name="lastnameadlt1" /></td>
                </tr>
            </table>
        </fieldset>
        <fieldset style="font-size:smaller;">
            <legend>Contact Person</legend>
            <table style="width: 300px; font-size: smaller;">
                <tr>
                    <td>Title : </td>
                    <td><select name="titleadlt1" id="title-cp">
                            <option value="Mr">Mr.</option>
                            <option value="Mrs">Mrs.</option>
                            <option value="Ms">Ms.</option>
                        </select></td>
                </tr>
                <tr>
                    <td>Firstname : </td>
                    <td><input type="text" id="firstname-cp" name="firstnameadlt1" /></td>
                </tr>
                <tr>
                    <td>Lastname : </td>
                    <td><input type="text" id="lastname-cp" name="lastnameadlt1" /></td>
                </tr>
                <tr>
                    <td>Phone Number</td>
                    <td><input type="text" id="countrycode-cp" name="countrycode" style="width:50px;" value="62" /><input type="text" name="contactphone" id="phonenumber-cp"/></td>
                </tr>
            </table>
        </fieldset>
        <div style="text-align: right;">
            <button id="finish-button" style="font-size:smaller;">Finish</button>
        </div>
    </div>


</div>
<div id="dialog-form-hotel" title="Reservasi Hotel">
    <div style="border-bottom: 1px dotted black;">
        <h4 style="margin-left:20px; margin-bottom: 5px;">Form Reservasi Hotel</h4>

    </div>
    <fieldset>
        <legend>Search Hotel</legend>
        <table style="font-size: smaller; margin-top: 5px; width: 750px;">
            <tr>
                <td>Negara : </td>
                <td><select name="country" id="cntry" style="width:150px;">
                        <option value="">--Pilih Negara--</option>
                        <option value="ID">Indonesia</option>
                    </select></td>
                <td>Kota : </td>
                <td><select name="city" id="city" style="width:100px;">
                        <option value="">--Pilih Kota--</option>
                    </select></td>

                <td>Hotel Name : </td>
                <td><input type="text" name="hotel_name" id="hotel_name" style="width:120px;"/></td>
            </tr>
            <tr>
                <td>Check In </td>
                <td><input type="text" name="check_in" id="check_in" /></td>
                <td>Check Out </td>
                <td><input type="text" name="check_out" id="check_out"/></td>
                <td>Bed : </td>
                <td><select name="bed" id="bed" style="width: 120px;">
                        <option value="">Pilih Bed</option>
                    </select></td>
            </tr>
            <tr>
                <td>Rooms</td>
                <td><select name="num_rooms">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select></td>
                <td>Ratings</td>
                <td><select name="ratings">
                        <option value="0">All</option>
                        <option value="1">1 Star</option>
                        <option value="2">2 Star</option>
                        <option value="3">3 Star</option>
                        <option value="4">4 Star</option>
                        <option value="5">5 Star</option>
                    </select></td>

                <td></td>
            </tr>
            <tr>
                <td><button id="search-form-hotel">Search</button></td>
            </tr>

            <tr>

            </tr>

        </table>

    </fieldset>
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
            <p id="sppd_num" style="display:none;"><?php echo $row->sppd_num; ?></p>
            <p id="emp_num" style="display: none;"><?php echo $row->emp_num; ?></p>
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

    <table style="margin-left:25px; width: 950px; text-align: center;">
        <tr style="background-color: black; color: white; text-align: center; font-weight: bold;">
            <td>No.</td>
            <td>Tipe Reservasi</td>
            <td>Tanggal Reservasi</td>
            <td>Booking ID</td>
            <td>Limit Tanggal dan Waktu</td>
            <td>Status Reservasi</td>
            <td>Opsi</td>
        </tr>
        <?php
        if ($booking->num_rows() > 0) {
            $i=1;
            foreach($booking->result() as $dt){
                ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php if($dt->res_type == '1'){
                    echo 'Flight';
                } else { echo 'Hotel';}?></td>
            <td><?php echo $dt->booking_date; ?></td>
            <td><?php echo $dt->booking_id; ?></td>
            <td><?php echo $dt->limit_date; ?></td>
            <td><?php if($dt->status == 1){ echo 'Booked';} ?></td>
            <td><button id="cancel-btn">Cancel</button><button id="issued-btn">Issued</button><button id="details-btn">Details</button></td>
        </tr>
        <?php
        $i++;
            }
            echo "</table>";
        } else {
            ?>
    </table>
            <div id="status" style="text-align: center; min-height: 90px;">
                <p><b>Data Reservasi belum ada</b></p>
            </div>
    <?php
}
?>
    
    

    <fieldset style="padding-left: 45px; margin-top: 60px;">
        <legend>Opsi</legend>
        <button id="flight-btn">Reservasi Airline</button>
        <button id="hotel-btn">Reservasi Hotel</button>
        <button id="keluar-btn">Keluar</button>
    </fieldset>
</div>
