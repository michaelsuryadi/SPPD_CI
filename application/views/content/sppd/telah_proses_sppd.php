<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">SPPD Telah Diproses</h2>

    <?php
    $this->load->view('filter/sppd_filter');
    ?>
    
    <?php
        if ($sppd_list->num_rows() == 0) {
            ?>
    <p style="text-align: center; margin-top: 40px;"><b>Data Tidak Ada</b></p>
    <?php
        }
        else {
         ?>
    <h4 style="margin: 0px; padding: 20px; text-align: left;">List Semua SPPD Selesai : </h4>
    <table style="margin-left: 30px; text-align: center; width: 940px;">
        <thead style="background-color: black; color: white;">
        <th>Nomor SPPD</th>
        <th>Tanggal Pembuatan</th>
        <th>Pembuat</th>
        <th>Pemohon</th>
        <th>Berangkat</th>
        <th>Kembali</th>
        <th>SPPD Description</th>
        <th>Status</th>
        </thead>

        <?php
         
            foreach ($sppd_list->result() as $row) {
                if($row->sppd_read_stat == 0){
                    echo "<tr style='font-weight:bold' >";
                }
                else {
                    echo "<tr>";
                }
                ?>
                
                    <td><a href="<?php echo base_url(); ?>index.php/sppd/view_sedang_proses_sppd/id/<?php echo $row->sppd_num; ?>"><?php echo $row->sppd_id; ?></a></td>
                    <td><?php echo $row->sppd_tgl; ?></td>
                    <td><?php echo $row->pem_id."-".$row->pem_firstname." ".$row->pem_lastname; ?></td>
                    <td><?php echo $row->emp_id."-".$row->emp_firstname." ".$row->emp_lastname; ?></td>
                    <td><?php echo $row->sppd_depart; ?></td>
                    <td><?php echo $row->sppd_arrive; ?></td>
                    <td><?php echo $row->sppd_tuj; ?></td>
                    <td><i>Selesai</i></td>
                </tr>
        <?php
    }
        }
    ?>
    


    </table>
</div>