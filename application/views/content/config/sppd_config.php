<script type="text/javascript">
    $("document").ready(function() {
        var i = 1;
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
                    <p>Belum Ada Pemeriksa</p>
                </div>
                <div id="tambah">   
                    
                </div>
                <div id="pilihan">
                    
                </div>
                
                <div id="inputan">
                    
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
