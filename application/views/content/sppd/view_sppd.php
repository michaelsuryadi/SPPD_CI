<style type="text/css">
    #table-karyawan td, #table-karyawan-2 td, #table-karyawan-3 td {
        padding-left: 20px;
        width: 150px;
        text-align: center;
    }
    #table-karyawan tr {

    }
</style>
<?php
$sppd = $data_sppd->row();
?>
<script type="text/javascript">
    $('document').ready(function() {
        $('#setuju-btn').click(function() {
            var isi = $('#komentar').val();
            var sppdnum = $('#sppd_number').val();
            var empnum = $('#emp_number').val();
            if (isi == "") {
                alert("Komentar Tidak Boleh Kosong");
            }
            else {
                $('#form-sppd').submit();
                alert('SPPD berhasil di approve');
            }
            return false;
        });

//        $('#komentar').keyup(function() {

//            if ($('#komentar').val() != "") {
//                $('#simpan-btn').attr('disabled', false);
//                $('#setuju-btn').attr('disabled', false);
//                $('#return-btn').attr('disabled', false);
//                $('#reject-btn').attr('disabled', false);
//            }
//            else {
//                $('#simpan-btn').attr('disabled', true);
//                $('#setuju-btn').attr('disabled', true);
//                $('#return-btn').attr('disabled', true);
//                $('#reject-btn').attr('disabled', true);
//            }
//        });

        $('#return-btn').click(function() {
            var isi_komentar = $('#komentar').val();
            $('#komentar2').val(isi_komentar);
            $('#frm-reject').submit();
            
            return false;
        });

        $('#reject-btn').click(function() {
            $('#frm-tolak').submit();
            return false;
        });

//        $("#cancel-btn").click(function() {
//
//            $('#frm-reject').submit();
//            return false;
//        });
//
        $('#edit-btn').click(function() {

            var id = $('#sppd_number').val();
            window.location = "<?php echo base_url(); ?>index.php/sppd/edit_sppd_by_pemeriksa/id/" + id;
            return false;
        });

//        $('#simpan-btn').click(function(){
//            return false;
//        });

    });

</script>

<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">Perlu Proses SPPD</h2>
    <div style="text-align: right; margin-left: 570px;">
        <?php
        $this->load->helper('form');
        ?>
        <form id="form-sppd" method="post" action="<?php echo base_url(); ?>index.php/sppd/approve_sppd">
            <table>
                <tr><td><b>Status Dokumen</b></td><td>: Sedang Diproses</td></tr>
                <tr><td><b>Pembuat Dokumen</b></td>
                    <td>: 
                        <?php
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
            <input type="hidden" id="sppd_number" name="sppd_num3" value="<?php echo $sppd->sppd_num; ?>" />
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
        <button style="margin-left: 20px;" id="edit-btn">Edit</button>
    </fieldset>
    <fieldset>
        <legend>Urutan Pemeriksa</legend>

        <table>
            <?php
            foreach ($pemeriksa->result() as $rowdata) {
                if ($rowdata->emp_num != null) {
                    ?>
                    <tr>
                        <td>Pemeriksa <?php echo $rowdata->job_name; ?></td>
                        <td> : <?php echo $rowdata->emp_firstname . " " . $rowdata->emp_lastname . "/" . $rowdata->job_code . "-" . $rowdata->emp_id . "/" . $rowdata->org_code; ?></td>
                    <input type="hidden" name="pemeriksa[]" value="<?php echo $rowdata->emp_num; ?>"/>
                    </tr>
                    <?php
                } else {
                    ?>
                    <tr>
                        <td>Pemeriksa : </td>
                        <td><select name="Pemeriksa" id="pemeriksa" style="margin-left:125px; width: 300px;" multiple></select></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><p style="margin-left:125px;"><a href="javascript:window.open('<?php echo base_url(); ?>index.php/sppd/show_exam','Pilih Pemeriksa','height=500,width=800')">Add Person</a></p></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><p style="margin-left:105px;"><?php
//            echo form_open('sppd/save_profile');
                                echo form_checkbox('save_check');
                                ?>  Save Profile</p></td>
                    </tr>
                    <?php
//                    echo form_close();
                }
            }
            ?>
        </table>

    </fieldset>

    <fieldset>
        <legend>Komentar</legend>
        <table id="table-karyawan-3" style="width: 800px;">
            <?php
            if ($data_komentar->num_rows() > 0) {
                ?>

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
            }
            ?>
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
                'id' => 'komentar',
                'name' => 'komentator',
                'size' => '74'
            );
            ?>
            <tr>
                <td style="text-align: left;">Komentator Baru : </td>
                <td colspan="4" style="text-align: left;"><?php echo form_input($data); ?>
            </tr>

            <input type="hidden" name="approved" value="1" id="app"/>
            <input type="hidden" name="pem_id" value="<?php echo $res->emp_num; ?>"/>


        </table>
    </fieldset>
    <br/>

    <table id="table-karyawan-3" style="width: 800px">
        <tr>
            <td></td>
            <td></td>
            <td style="width: 500px;">
                <?php if ($order != 0) {
                    ?>
                    <button id="simpan-btn">Simpan</button>
                    <button id="setuju-btn">Setuju</button>
                    <button id="return-btn">Kembalikan</button>
                    <button id="reject-btn">Tolak</button>
                    <button  id="tutup-btn">Tutup</button>
                    <?php
                }
                else {
                    
                    ?>
                    <button id="simpan-btn">Kirim</button>
                    <button  id="tutup-btn">Tutup</button>
                    <?php
                }
                ?>
            </td>
            <td></td>
            <td></td>
        </tr>
    </table>
</form>
<form id="frm-reject" method="post" action="<?php echo base_url(); ?>index.php/sppd/reject_sppd">
    <input type="hidden" name="sppd_num" value="<?php echo $sppd->sppd_num; ?>"/>
    <input type="hidden" name="komentator" id="komentar2" value=""/> 
    
</form>
<form id="frm-tolak" method="post" action="<?php echo base_url(); ?>index.php/sppd/tolak_sppd">
    <input type="hidden" name="sppd_num" value="<?php echo $sppd->sppd_num; ?>"/>
    <input type="hidden" name="emp_num" value="<?php echo $sppd->emp_num; ?>"/>
</form>
</div>