<style type="text/css">
    #table-karyawan td, #table-karyawan-2 td, #table-karyawan-3 td {
        padding-left: 20px;
        width: 150px;
        text-align: center;
    }
    #table-karyawan tr {

    }
</style>

<script type="text/javascript">
    $('document').ready(function() {
        $('#send-btn').click(function() {
            var isi = $('#komentator').val();
            var sppdnum = $('#sppd_number').val();
            var empnum = $('#emp_number').val();
            if (isi == "") {
                alert("Komentar Tidak Boleh Kosong");
            }
            else {
                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1/sppd_ci/index.php/sppd/send_comment",
                    data: "sppdnum=" + sppdnum + " &isi=" + isi + " &empnum=" + empnum,
                    success: function(data) {
                        if (data != "") {
                            alert("Komentar telah terkirim");
                            $("#content4").append(data + "<br/>");
                            $("#komentator").val("");
                        }
                    }
                });
            }
            return false;
        });

        $("#dialog-form").dialog({
            autoOpen: false,
            width: 550,
            modal: true,
            hide: 'fadeOut',
            show: 'fadeIn',
            position: 'top',
            buttons: {
                "Kirim": function() {
                    var bValid = true;
                    var sppdnum = $('#sppdnum').val();
                    var flight = $('#flight').val();
                    var time = $('#time').val();
                    var hotel = $('#hotel').val();
                    if (bValid) {
                        $.ajax({
                            type: "POST",
                            url: "http://127.0.0.1/sppd_ci/index.php/reservation/process_req",
                            data: "sppdnum=" + sppdnum + " &flight=" + flight + " &time=" + time + "&hotel="+hotel,
                            success: function(data) {
                                if(data=="OK") {
                                    alert('Request Berhasil Dikirim');
                                    $('#reserve-btn').attr('disabled',true);
                                    location.reload();
                                }
                                else {
                                    alert('Request Gagal Dikirim');
                                }
                            }
                        });
                        $(this).dialog("close");
                    }
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            close: function() {
                $(this).dialog("close");
            }
        }).css("font-size", "15px");

        $('#reserve-btn').click(function() {
            $('#dialog-form').dialog('open');
            return false;
        });
        $('#rincian-btn').click(function() {
            $('#dialog-form-rincian').dialog('open');
            return false;
        });
        
        $("#dialog-form-rincian").dialog({
            autoOpen: false,
            width: 900,
            height:500,
            modal: true,
            hide: 'fadeOut',
            show: 'fadeIn',
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
    });

</script>
<?php
$sppd = $data_sppd->row();
?>
<div id="dialog-form" title="Create new Reservation Request">
    <form id="frm-reservation" method="post">
        <fieldset>
            <legend>Deskripsi Perjalanan</legend>
            <fieldset>
                <legend>Flight Request</legend>
                <input type="hidden" id="sppdnum" name="sppdnum" value="<?php echo $sppd->sppd_num; ?>"/>
                <label for="flight">Request Airline : </label>
                <textarea name="flight" id="flight" cols="40" rows="7" class="text ui-widget-content ui-corner-all"></textarea>
                <label for="time">Request Time : </label>
                <textarea name="time" id="time" cols="40" rows="7" class="text ui-widget-content ui-corner-all"></textarea>
            </fieldset>
            <fieldset>
                <legend>Hotel Request</legend>
                <textarea name="hotel" id="hotel" cols="40" rows="7" class="text ui-widget-content ui-corner-all"></textarea>
            </fieldset>
        </fieldset>
    </form>
</div>
<div id="dialog-form-rincian" title="Data Rincian">
    <p style="font-size: smaller;"><b>Rincian Angkutan</b></p>
    <table style="width:850px; text-align: center; font-size: smaller;">
                    <tbody id="main-angkutan-body2">
                        <tr style="background-color: black; color:white;">
                            <th rowspan="2">No.</th>
                            <th colspan="6">Angkutan</th>
                        </tr>
                        <tr style="background-color: black; color: white;">
                            <th>Angkutan</th>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>T.Angkutan</th>
                            <th>X</th>
                            <th>J.Trans</th>
                        </tr>
                        <?php
                        $i = 1;
                        $totalAngkutan = 0;
                        foreach ($rincian_angkutan->result() as $row) {
                            ?>
                            <tr id="row-1" style="border-bottom: 1px dotted black;">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row->transport_name; ?></td>
                                <td><?php echo $row->from_dest; ?></td>
                                <td><?php echo $row->to_dest; ?></td>
                                <td>Rp. <?php echo number_format($row->transport_fee, 0, '.', '.'); ?></td>
                                <td><?php echo $row->transport_amount; ?></td>
                                <td>Rp. <?php echo number_format($row->transport_amount * $row->transport_fee, 0, '.', '.'); ?></td>
            <?php
            $totalAngkutan += $row->transport_amount * $row->transport_fee;
            ?>
                            </tr>
                                <?php
                                $i++;
                            }
                            ?>
                    </tbody>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>

                            <td colspan="2"><b>Total Uang Angkutan : </b></td>
                            <td><b>Rp. <?php echo number_format($totalAngkutan, 0, '.', '.'); ?></b></td>

                        </tr>
                    </tbody>
                </table>
    
    <p style="font-size:smaller;"><b>Rincian Harian</b></p>
    <table style="text-align: center; width: 850px; font-size: smaller;">
                    <tbody id="data-body2">
                        <tr style="background-color: black; color:white;">
                            <th colspan="6">Harian</th>
                        </tr>
                        <tr style="background-color: black; color:white;">
                            <th>Berangkat</th>
                            <th>Kembali</th>
                            <th>Lama (Hari)</th>
                            <th>J.Harian</th>
                            <th>%</th>
                            <th>T.Harian</th>
                        </tr>
                        
                        <?php
                            $totalHarian=0;
                            foreach($rincian_harian->result() as $rowharian){
                                
                                ?>
                        <tr id="row-harian-1">
                            <td><?php echo $rowharian->from_date; ?></td>
                            <td><?php echo $rowharian->to_date; ?></td>
                            <td><?php echo $rowharian->lama; ?></td>
                            <td>Rp. <?php echo number_format($rowharian->day_amount,0,'.','.'); ?></td>
                            <td><?php echo $rowharian->percentage; ?> % </td>
                            <td>Rp. <?php echo number_format($rowharian->lama * $rowharian->day_amount * ($rowharian->percentage / 100),0,'.','.'); ?></td>
                        
                        </tr>
                        <?php
                            $totalHarian += $rowharian->lama * $rowharian->day_amount * ($rowharian->percentage / 100);
                            }
                        ?>
                        
                    </tbody>
                    <tbody id="opsi-body">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"><b>Total Uang Harian : </b></td>
                            <td><b>Rp. <?php echo number_format($totalHarian,0,'.','.'); ?></b></td>
                        </tr>
                    </tbody>
                </table>
                <p style="font-size: small;"><b>Total Biaya SPPD : Rp. <?php echo number_format($totalAngkutan+$totalHarian,0,'.','.'); ?></b></p>
    
</div>



<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">SPPD Telah Diproses</h2>
    <div style="text-align: right; margin-left: 570px;">
        <?php
        $this->load->helper('form');
        echo form_open("sppd/approve_sppd");
        ?>
        <table>
            <tr><td><b>Status Dokumen</b></td><td>: Telah Diproses</td></tr>
            <tr><td><b>Pembuat Dokumen</b></td>
                <td>: 
                    <?php
                    $row = $data_sppd->row();
                    echo $row->pem_fname . " " . $row->pem_lname . "/" . $row->pem_jobcode . "-" . $row->pem_id . '/' . $row->pem_orgcode;
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <?php
    ?>
    <fieldset>
        <legend>SPPD Info</legend>
        <table>
            <tr>
                <td style="padding-left: 20px;">No SPPD</td>
                <td> : <?php echo $sppd->sppd_id; ?></td>
            </tr>
            <tr>
                <td style="padding-left: 20px;">Tanggal Pembuatan</td>
                <td> : <?php echo $sppd->sppd_tgl; ?></td>
            </tr>
        </table>

    </fieldset>
    <fieldset>
        <legend>Data Karyawan</legend>
        <table id="table-karyawan" style="width: 900px;">
            <thead>
            <th>Nama / NIK / Jabatan</th>
            <th>Asal - Tujuan</th>
            <th>Tanggal Berangkat</th>
            <th>Tanggal Kembali</th>
            <th>Keterangan</th>
            </thead>
            <tr style="text-align: center;">
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
            </tr>
            <tr>
            <input type="hidden" id="sppd_number" name="sppd_num" value="<?php echo $sppd->sppd_num; ?>" />
            <input type="hidden" id="emp_number" name="emp_num" value="<?php echo $sppd->emp_num; ?>" />
            <td><?php echo $sppd->emp_firstname . " " . $sppd->emp_lastname . " / " . $sppd->emp_id . "/" . $sppd->job_code ?></td>
            <td><?php echo $sppd->sppd_dest; ?></td>
            <td><?php echo $sppd->sppd_depart; ?></td>                    
            <td><?php echo $sppd->sppd_arrive; ?></td>                    
            <td><?php echo $sppd->sppd_ket; ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: left;">Dasar Perjalanan : </td>

                <td colspan="4" style="text-align: left;"><?php echo $sppd->sppd_dsr; ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: left;">Tujuan Perjalanan : </td>

                <td colspan="4" style="text-align: left;"><?php echo $sppd->sppd_tuj; ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: left;">Catatan : </td>

                <td colspan="4" style="text-align: left;"><?php echo $sppd->sppd_catt; ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <?php
        ?>
    </fieldset>
    <fieldset>
        <legend>Approval Progress</legend>
        <table>
            <?php
            $i = 1;
            foreach ($approval_prg->result() as $rowapp) {
                ?>
                <tr>
                    <td>Pemeriksa ke <?php echo $i . " - " . $rowapp->job_name; ?> </td>
                    <td> : <?php
            echo $rowapp->emp_firstname . " " . $rowapp->emp_lastname . "/" . $rowapp->job_code . "-" . $rowapp->emp_id . "/" . $rowapp->org_code;
            if ($rowapp->status == 1) {
                echo '<b> - Approved</b>';
            } else {
                echo '<b> -    On Progress</b>';
            }
                ?></td>
                </tr>

                <?php
                $i++;
            }
            ?>
        </table>
    </fieldset>

    <fieldset>
        <legend>Histori Komentar</legend>
        <table id="table-karyawan-3" style="width: 800px;">
            <tr>
                <td style="text-align: left;">Komentar :</td>
                <td colspan="4" id="content4" style="text-align: left;"><?php
            foreach ($data_komentar->result() as $rowkomentar) {
                ?>
                        <?php echo $rowkomentar->date_comment . " - " . $rowkomentar->emp_firstname . " " . $rowkomentar->emp_lastname . " - <i>" . $rowkomentar->comment . "</i><br/>"; ?>
                        <?php
                    }
                    ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php
            $res = $result->row();
            ?>


            <input type="hidden" name="approved" value="1" id="app"/>
            <input type="hidden" name="pem_id" value="<?php echo $res->emp_num; ?>"/>
            <input type="hidden" name="sppd_num" value="<?php echo $sppd->sppd_num; ?>" />

        </table>
    </fieldset>
    
    <?php
        if($rservation_detail->num_rows()>0){
    ?>
    
    <fieldset>
        <?php $reserve = $rservation_detail->row(); ?>
        <legend>Reservation</legend>
        <p style="margin-left:20px;"><b>Reservation Request : </b></p>
        <table style="margin-left:20px;">
            <tr>
                <td>Deskripsi Flight : </td>
            </tr>
            <tr>
                <td style="font-size:smaller;"><?php echo $reserve->flight_desc; ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Request Waktu : </td>
            </tr>
            
            <tr>
                <td style="font-size:smaller;"><?php echo $reserve->time_desc; ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Deskripsi Hotel : </td>
            </tr>
            <tr>
                <td style="font-size:smaller"><?php echo $reserve->hotel_desc; ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Request Dikirim Pada : </td>
            </tr>
            <tr>
                <td style="font-size:smaller"><?php echo $reserve->send_date; ?></td>
            </tr>
        </table>
        
    </fieldset>
    <?php
        }
    ?>
    
    <fieldset style="text-align: center;">
        <legend>Options</legend>
        <button id="rincian-btn">Lihat Rincian Biaya</button>
        <button id="reserve-btn" <?php if($sppd->reserve_status == 1){ echo " disabled='disabled' "; } ?>>Request Reservasi</button>
        <button id="reserve-view-btn">Lihat Progress Reservasi</button>
        <button id="print-btn">Lihat dan Cetak Surat Perintah SPPD</button>
    </fieldset>
    <br/>
    <table id="table-karyawan-3" style="width: 800px">
        <tr>
            <td></td>
            <td></td>
            <td style="width: 300px;"></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>