<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">SPPD Sedang Diproses</h2>

    <?php
    $this->load->view('filter/sppd_filter');
    ?>
    
    <?php
        if ($draft->num_rows() == 0) {
            ?>
    <p style="text-align: center; margin-top: 40px;"><b>Data Tidak Ada</b></p>
    <?php
        }
        else {
         ?>
    <table style="margin-left: 45px; text-align: center; width: 900px;">
        <thead style="background-color: black; color: white;">
        <th>Nomor SPPD</th>
        <th>Tanggal Pembuatan</th>
        <th>Berangkat</th>
        <th>Kembali</th>
        <th>SPPD Description</th>
        <th>Status</th>
        </thead>

        <?php
         
            foreach ($draft->result() as $row) {
                ?>
                <tr>
                    <td><a href="<?php echo base_url(); ?>index.php/sppd/view_sedang_proses_sppd/id/<?php echo $row->sppd_num; ?>"><?php echo $row->sppd_id; ?></a></td>
                    <td><?php echo $row->sppd_tgl; ?></td>
                    <td><?php echo $row->sppd_depart; ?></td>
                    <td><?php echo $row->sppd_arrive; ?></td>
                    <td><?php echo $row->sppd_desc; ?></td>
                    <td><i>Sedang Diproses</i></td>
                </tr>
        <?php
    }
        }
    ?>
    


    </table>
</div>