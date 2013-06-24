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
            var isi = $('#komentar').val();
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
                            $("#content2").append(data+"<br/>");
                            $("#komentar").val("");
                        }
                    }
                });
            }

            return false;
        });
        
        $("#cancel-btn").click(function(){
        
        });
    });

</script>

<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">Proses SPPD</h2>
    <div style="text-align: right; margin-left: 570px;">
        <?php
        $this->load->helper('form');
        echo form_open("sppd/approve_sppd");
        ?>
        <table>
            <tr><td><b>Status Dokumen</b></td><td>: Sedang Diproses</td></tr>
            <tr><td><b>Pembuat Dokumen</b></td>
                <td>: 
                    <?php
                    $sppd = $data_sppd->row();
                    $res = $result->row();
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
            <input type="hidden" id="emp_number" name="emp_num" value="<?php echo $res->emp_num; ?>" />

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
        <legend>Komentar</legend>
        <table id="table-karyawan-3" style="width: 800px;">
            <tr>
                <td style="text-align: left;">Komentar :</td>
                <td colspan="4" id="content4" style="text-align: left;"><?php
        foreach ($data_komentar->result() as $rowkomentar) {
            ?>
                        <?php echo $rowkomentar->date_comment . " - " . $rowkomentar->time_comment . " - " . $rowkomentar->emp_firstname . " " . $rowkomentar->emp_lastname . " - <i>" . $rowkomentar->comment . "</i><br/>"; ?>
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
            <tr>
                <td style="text-align: left;">Tanggal/Komentator :</td>
                <td colspan="4" style="text-align: left;"><?php
                    $datestring = "%d-%m-%Y";
                    $time = time();
                    echo mdate($datestring, $time) . " - ";
                    echo $res->emp_firstname . " " . $res->emp_lastname . "/" . $res->job_code . "-" . $res->id_emp . '/' . $res->org_code;
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
            $data = array(
                'id' =>'komentar',
                'name' => 'komentator',
                'size' => '74'
            );
            ?>
            <tr>
                <td style="text-align: left;">Komentator Baru : </td>
                <td colspan="4" style="text-align: left;"><?php echo form_input($data); ?><button id="send-btn">Kirim</button></td>
            </tr>

            <input type="hidden" name="approved" value="1" id="app"/>
            <input type="hidden" name="pem_id" value="<?php echo $res->emp_num; ?>"/>
            <input type="hidden" name="sppd_num" value="<?php echo $sppd->sppd_num; ?>" />

        </table>
    </fieldset>
    <br/>
    <table id="table-karyawan-3" style="width: 800px">
        <tr>
            <td></td>
            <td></td>
            <td style="width: 300px;"><button id="cancel-btn">Reject</button><?php echo form_submit('submit', 'Approve'); ?></td>
            <td></td>
            <td></td>
        </tr>
    </table>

</div>