<script type="text/javascript">
    $("document").ready(function() {
        var i = $("#counter2").html();
        $("#tambah-btn").click(function() {

            $("#first_div").remove();
            var app = "<p id='pem-" + i + "'>Pemeriksa ke- " + i + "&nbsp; &nbsp; <select id='pilih-" + i + "'><option value='0'>--Pilih--</option><option value='1'>Defined</option><option value='2'>Not Defined</option></select></td><td id='pem-" + i + "'><br/><br/></p>";
            $("#pilihan").append(app);

            $("#pilih-" + i).change(function() {
                var id = $(this).attr('id').split("-");

                var value = $(this).val();
                if (value == 1) {
                    var tambah = '<a href=\"javascript:window.open(\'<?php echo base_url(); ?>index.php/sppd_config/show_exam/id/' + id[1] + '\',\'Pilih Pemeriksa\',\'height=500,width=800\')\">Pilih Pemeriksa</a>';
                    var data = $("#pem-" + id[1]).html();
                    $("#pem-" + id[1]).append(tambah);
                }
            });
            i++;
            return false;
        });
    });
</script>


<div id='content'>
    <h2 style="margin: 0px; padding: 20px; text-align: left;">SPPD Configuration</h2>
    <form id="frm-data" method="post" action="<?php echo base_url(); ?>index.php/sppd_config/save_flow_sppd">
    <fieldset>
        <legend>List Urutan Pemeriksa</legend>
        <div id="main_table">
            <div id="awal">
                <div id="first_div">
                    <?php 
                        if($flow->num_rows()==0){
                            
                            ?>
                    <p>Belum Ada Pemeriksa</p>
                    <?php
                        }
                    ?>
                </div>
                <div id="tambah">   
                    <?php
                    $i=1;
                    $total = $flow->num_rows();
                        foreach($flow->result() as $row) {
                            
                            ?>
                    <p><b>Pemeriksa ke <?php echo $i; ?></b></p>
                <div class="content-div">
                    <div class="content-div-image">
                        <img style="margin-left: 10px; margin-top: 10px;" height="80" width="80" src="<?php echo base_url(); ?>css/unknown-prof-pic.png"/>
                    </div>
                    <div class="content-div-data">
                        <table>
                            <tr>
                                <td>NIK</td>
                                <td> : <?php echo $row->emp_id; ?></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td> : <?php echo $row->emp_firstname." ".$row->emp_lastname; ?></td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td> : <?php echo $row->job_name; ?></td>
                            </tr>
                            <tr>
                                <td>Organisasi</td>
                                <td> : <?php echo $row->org_name; ?></td>
                            </tr>
                            
                        </table>
                    </div>
                </div>
                    <?php
                    
                    if($i== $total){
                        ?>
                    <p id="counter2" style="display: none;"><?php echo $i+1; ?></p>
                    <?php
                    }
                    else {
                        if($total==0){
                            ?>
                    <p id="counter2" style="display: none;">1</p>
                    <?php
                        }
                    }
                    $i++;
                        }
                    ?>
                </div>
                <div id="pilihan">
                    
                </div>
                
                <div id="inputan">
                    <?php
                        foreach($flow->result() as $row2) {
                            
                            ?>
                    <input type="hidden" name="fitur_id[]" value="<?php echo $row2->fitur_id; ?>" />
                    <input type="hidden" name="emp_num[]" value="<?php echo $row2->emp_num; ?>" />
                    <?php
                        }
                    ?>
                </div>
            </div>

        </div>
        <button id="tambah-btn">Tambah Pemeriksa</button>
    </fieldset>
    <div style="text-align: center; margin-top: 10px;">
        <input type="submit" value="Simpan"/>
    </div>
    </form>
</div>
