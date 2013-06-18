<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">SPPD Perlu Diproses</h2>

    <?php
    $this->load->view('filter/sppd_filter');
    ?>
    
    <?php
        if ($sppd_list->num_rows() == 0) {
            ?>
    <p style="text-align: center; margin-top: 40px;"><b>Tidak Ada SPPD yang harus di confirm</b></p>
    <?php
        }
        else {
         ?>
    <table style="margin-left: 45px; text-align: center; width: 900px;">
        <thead style="background-color: black; color: white;">
        <th>Nomor SPPD</th>
        <th>Yang Mengajukan</th>
        <th>Tanggal Pembuatan</th>
        <th>SPPD Description</th>
        <th>Status</th>
        </thead>

        <?php
         
            foreach ($sppd_list->result() as $row) {
                ?>
                <tr>
                    <td><?php echo $row->sppd_id; ?></td>
                    <td><?php echo $row->emp_firstname." ".$row->emp_lastname."/".$row->job_code." - ".$row->emp_id."/".$row->org_code; ?></td>
                    <td><?php echo $row->sppd_tgl; ?></td>
                    <td><?php echo $row->sppd_tuj; ?></td>
                    <td><a href="<?php echo base_url(); ?>index.php/sppd/view_sppd/id/<?php echo $row->sppd_num; ?>">Belum Di Confirm</a></td>
                </tr>
        <?php
    }
        }
    ?>


    </table>
</div>