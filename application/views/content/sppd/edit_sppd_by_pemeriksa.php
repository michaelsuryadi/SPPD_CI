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
$("document").ready(function(){
    $("#komentator").keyup(function(){
        var isi = $("#komentator").val();
        if(isi!=""){
            $("#submit_button").attr("disabled",false);
        }
        else {
            $("#submit_button").attr("disabled",true);
        }
    });
    
    $('#send-btn').click(function(){
        var isi = $("#komentator").val();
        if(isi==""){
            alert('Komentar Tidak Boleh Kosong');
        }
        
        return false;
    });
    
    $('#draft-btn').click(function(){
        $('#tipe').val('2');
        $('#form-data').submit();
    });
    
    $('#depart').datepicker();
    $('#arrive').datepicker();
});


</script>


<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">Edit SPPD</h2>
    <div style="text-align: right; margin-left: 560px;">
        <table>
            <tr><td><b>Status Dokumen</b></td><td>: Sedang Diproses</td></tr>
            <tr><td><b>Pembuat Dokumen</b></td>
                <td>: 
                    <?php
                    $row = $result->row();
                    $dataSppd = $data_sppd->row();
                    echo $dataSppd->emp_firstname . " " . $dataSppd->emp_lastname . "/" . $dataSppd->job_code . "-" . $dataSppd->emp_id . '/' . $dataSppd->org_code;
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <form id="form-data" method="post" action="<?php echo base_url() ?>index.php/sppd/process_update">
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
                <?php
                    
                ?>
                <td><?php
                echo form_hidden("emp_num", $dataSppd->emp_num);
                echo form_hidden('sppd_num2',$dataSppd->sppd_num);
    ?>
                    
                    <input type="text" name="first_name" disabled="disabled" value="<?php echo $dataSppd->emp_firstname.' '.$dataSppd->emp_lastname; ?>"/>
                    <input type="text" name="emp_id" disabled="disabled" value="<?php echo $dataSppd->emp_id; ?>"/>
                    <input type="text" name="job_code" disabled="disabled" value="<?php echo $dataSppd->job_code; ?>"/>
        <a href="#">Pilih</a></td>

                <td><?php echo form_input('destination',$dataSppd->sppd_dest); ?></td>
                <td><?php echo form_input(array('id'=>'depart','name' => 'depart', 'size' => '10','value'=>$dataSppd->sppd_depart)); ?></td>
                <td><?php echo form_input(array('id'=>'arrive','name' => 'arrive', 'size' => '10','value'=>$dataSppd->sppd_arrive)); ?></td>
                <td><textarea name="keterangan" cols="20" rows="4"><?php echo $dataSppd->sppd_ket; ?></textarea></td>
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
                    'size' => '74',
                    'value' => $dataSppd->sppd_ket
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
                    'size' => '74',
                    'value'=>$dataSppd->sppd_tuj
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
                    'size' => '74',
                    'value'=>$dataSppd->sppd_catt
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
        <legend>Pemeriksa</legend>
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
                        <td><p style="margin-left:105px;"><?php echo form_open('sppd/save_profile');
                             echo form_checkbox('save_check');
                    ?>  Save Profile</p></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </fieldset>
    
    <br/>
    
    <table id="table-karyawan-3" style="width: 800px">
        <tr>
            <td></td>
            <td></td>
            <?php
            $data = array(
                "id"=>"submit_button",
                "name"=>"submit_button"
            );
            
            ?>
            <td style="width: 300px;"><?php echo form_submit($data,"Update"); ?><button id="cancel-btn">Cancel</button></td>
            <td></td>
            <td></td>
        </tr>
        
    </table>
    </form>
</div>