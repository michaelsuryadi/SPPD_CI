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
    $("document").ready(function() {
        $("#komentator").keyup(function() {
            var isi = $("#komentator").val();
            if (isi != "") {
                $("#submit_button").attr("disabled", false);
            }
            else {
                $("#submit_button").attr("disabled", true);
            }
        });

        $('#send-btn').click(function() {
            var isi = $("#komentator").val();
            if (isi == "") {
                alert('Komentar Tidak Boleh Kosong');
            }

            return false;
        });

        $('#draft-btn').click(function() {
            $('#tipe').val('2');
            $('#form-data').submit();
        });

        $('#pilih-pemohon').click(function() {
            window.open('http://127.0.0.1/sppd_ci/index.php/sppd/show_emp', 'Pilih Pemeriksa', 'height=500,width=800');
            return false;
        });
        

        $('#pmh').click(function() {
            window.open('http://127.0.0.1/sppd_ci/index.php/sppd/show_emp', 'Pilih Pemeriksa', 'height=500,width=800');
            return false;
        });

        $('#depart').datepicker();
        $('#arrive').datepicker();
    });


</script>


<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">Create New SPPD</h2>
    <div style="text-align: right; margin-left: 560px;">
        <table>
            <tr><td><b>Status Dokumen</b></td><td>: Dokumen Baru</td></tr>
            <tr><td><b>Pembuat Dokumen</b></td>
                <td>: 
                    <?php
                    $row = $result->row();
                    echo $row->emp_firstname . " " . $row->emp_lastname . "/" . $row->job_code . "-" . $row->id_emp . '/' . $row->org_code;
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <form id="form-data" method="post" action="<?php echo base_url() ?>index.php/sppd/process">
        <?php
        $this->load->helper('form');

        echo form_hidden("emp_create_id", $row->emp_num);
        ?>
        <input type="hidden" name="tipe" id="tipe" value="1"/>
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
                <input type="hidden" name="emp_num" id="emp_num" value="<?php echo $row->emp_num; ?>"/>
                <td id="pmh"><?php
        echo form_input(array('name' => 'emp_name2', 'disabled' => 'disabled', 'value' => $row->emp_firstname . " " . $row->emp_lastname, 'id' => 'nama'));
        echo form_input(array('name' => 'emp_id2', 'disabled' => 'disabled', 'value' => $row->id_emp, 'id' => 'emp_id'));
        echo form_input(array('name' => 'job_code2', 'disabled' => 'disabled', 'value' => $row->job_code, 'id' => 'job_code'));
        echo form_hidden(array('name' => 'emp_name', 'value' => $row->emp_firstname . " " . $row->emp_lastname, 'id' => 'nama2'));
        echo form_hidden(array('name' => 'emp_id', 'value' => $row->id_emp, 'id' => 'emp_id2'));
        echo form_hidden(array('name' => 'job_code', 'value' => $row->job_code, 'id' => 'job_code2'));
        ?><a id="pilih-pemohon" href="#">Pilih</a></td>

                <td><?php echo form_input('destination'); ?></td>
                <td><?php echo form_input(array('id' => 'depart', 'name' => 'depart', 'size' => '10')); ?></td>
                <td><?php echo form_input(array('id' => 'arrive', 'name' => 'arrive', 'size' => '10')); ?></td>
                <td><textarea name="keterangan" cols="20" rows="4"></textarea></td>
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
                    <?php
                    $data = array(
                        'name' => 'dasar',
                        'size' => '74'
                    );
                    ?>
                    <td colspan="4" style="text-align: left;"><?php echo form_input($data); ?></td>
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
                    <?php
                    $data = array(
                        'name' => 'tujuan',
                        'size' => '74'
                    );
                    ?>
                    <td colspan="4" style="text-align: left;"><?php echo form_input($data); ?></td>
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
                    <?php
                    $data = array(
                        'name' => 'catt',
                        'size' => '74'
                    );
                    ?>
                    <td colspan="4" style="text-align: left;"><?php echo form_input($data); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>

            <?php ?>
        </fieldset>
        <fieldset>
            <legend>Data Lampiran</legend>
            <table id="table-karyawan-2" style="width: 800px;">
                <tr>
                    <td style="text-align: left;">File Lampiran :</td>
                    <td colspan="4" style="text-align: left;"><?php echo form_upload(); ?></td>
                </tr>
            </table>
        </fieldset>
        <fieldset>
            <legend>Pemeriksa</legend>
            <table>
                <?php
                foreach ($pemeriksa->result() as $rowdata) {
                    if ($rowdata->emp_num != 24) {
                        ?>
                        <tr>
                            <td>Pemeriksa <?php echo $rowdata->job_name; ?></td>
                            <td><p style="margin-left:20px;"> : <?php echo $rowdata->emp_firstname . " " . $rowdata->emp_lastname . "/" . $rowdata->job_code . "-" . $rowdata->emp_id . "/" . $rowdata->org_code; ?></p></td>
                        <input type="hidden" name="pemeriksa[]" value="<?php echo $rowdata->emp_num; ?>"/>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <tr>
                            <td>Pemeriksa : </td>
                            <td><select name="Pemeriksa" id="pemeriksa" style="margin-left:20px; width: 300px;" multiple></select></td>
                        </tr>
                        
                        <tr>
                            <td></td>
                            <td><p style="margin-left:20px;"><a href="javascript:window.open('<?php echo base_url(); ?>index.php/sppd/show_exam','Pilih Pemeriksa','height=500,width=800')">Add Person</a></p>
                            <p id="tambah-input" style="display:none;"></p></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><p style="margin-left:15px;"><?php
                echo form_open('sppd/save_profile');
                echo form_checkbox('save_check');
                        ?>  Save Profile</p></td>
                        </tr>
                        
                        <?php
                    }
                }
                ?>
            </table>
        </fieldset>
        <fieldset>
            <legend>Komentar</legend>
            <table id="table-karyawan-3" style="width: 800px;">
                <tr>
                    <td style="text-align: left;">Tanggal/Komentator :</td>
                    <td colspan="4" style="text-align: left;"><?php
                        $datestring = "%d-%m-%Y";
                        $time = time();
                        echo mdate($datestring, $time) . " - ";
                        echo $row->emp_firstname . " " . $row->emp_lastname . "/" . $row->job_code . "-" . $row->id_emp . '/' . $row->org_code;
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
                    'id' => 'komentator',
                    'name' => 'komentator',
                    'size' => '74'
                );
                ?>
                <tr>
                    <td style="text-align: left;">Komentator Baru : </td>
                    <td colspan="4" style="text-align: left;"><?php echo form_input($data); ?></td>
                </tr>
            </table>
        </fieldset>
        <br/>
        <table id="table-karyawan-3" style="width: 800px; height:50px;">
            <tr>
                <td></td>
                <td></td>
                <?php
                $data = array(
                    "id" => "submit_button",
                    "name" => "submit_button",
                    "disabled" => "disabled"
                );
                ?>
                <td style="width: 300px;"><button id="draft-btn">Draft</button> <?php echo form_submit($data, "Simpan"); ?> <?php echo form_submit('keluar', 'Keluar'); ?></td>
                <td></td>
                <td></td>
            </tr>
            <?php echo form_close(); ?>
        </table>
</div>