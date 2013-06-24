<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">Welcome To e-Office System</h2>

    <div id="content-left">
        <div class="content-left-data" id="top-left-content">
            <div class="content-left-img">
                <img width="100" style="margin-left: 20px; margin-top: 20px;" height="100" src="<?php echo base_url();?>css/notification.png"/>
            </div>
            <div class="content-left-2">
                <p><b>Notifications :</b></p>
                <?php foreach($notif->result() as $rownotif){
                    
                    ?>
                <a href="<?php echo $rownotif->notif_link; ?>"><?php
                
                if($rownotif->status == 0){
                    echo '<b>';
                }
                
                echo $rownotif->date_post." pk.".$rownotif->time_post." - ".$rownotif->notif_desc; ?>
                <?php
                
                if($rownotif->status == 0){
                    echo '[NEW]</b></a><br/>';
                }
                else {
                    echo '</a><br/>';
                }
                
                }
                ?>
                
                <?php
                    if($notif->num_rows() > 0){
                        ?>
                        <br/><a href="#">See All Notifications..</a>
                    <?php
                        }
                        else {
                            echo "<p id='notif'>Tidak ada notifikasi baru</p>";
                        }
                ?>
                
            </div>
        </div>
        <div class="content-left-data">
            <div class="content-left-img">
                <img width="120" style="margin-left: 15px; margin-top: 20px;" height="100" src="<?php echo base_url();?>css/sppd.jpg"/>
            </div>
            <div class="content-left-2" id="content-left-2">
                <p><b>SPPD :</b></p>
                <a href="<?php echo base_url(); ?>index.php/sppd/new_sppd">Buat SPPD Baru</a><br/>
                <a href="#">Lihat Semua SPPD</a><br/>
                <a href="#">Lihat Draft SPPD</a><br/>
                <a href="#">Proses SPPD</a><br/>
            </div>
        </div>
        <div class="content-left-data">
            <div class="content-left-img">
                <img width="100" style="margin-left: 25px; margin-top: 20px;" height="100" src="<?php echo base_url();?>css/nodin.png"/>
            </div>
            <div class="content-left-2">
                <p><b>Nota Dinas : </b></p>
                <a href="#">Buat Nota Dinas Baru</a><br/>
                <a href="#">Proses Nota Dinas</a><br/>
                <a href="#">Lihat semua Nota Dinas</a><br/>
            </div>
        </div>
        <div class="content-left-data">
            <div class="content-left-img">
                <img width="100" style="margin-left: 20px; margin-top: 20px;" height="100" src="<?php echo base_url();?>css/cuti.jpg"/>
            </div>
            <div class="content-left-2">
                <p><b>Pengajuan Cuti : </b></p>
                <a href="#">Buat Surat Pengajuan Cuti</a><br/>
            </div>
        </div>
    </div>
    <div id="content-right">
        <div id="content-right-data">
            <p><b>Your Account :</b></p>
             <img width="80" style="margin-left: 105px; margin-top: 20px;" height="80" src="<?php echo base_url();?>css/unknown-prof-pic.png"/>
             <table style="margin-left: 20px; margin-top: 40px;">
                 <tr>
                     <td>NIK</td>
                     <td> : <?php $row = $result->row(); echo $row->id_emp; ?></td>
                 </tr>
                 <tr>
                     <td>Nama</td>
                     <td> : <?php echo $row->emp_firstname." ".$row->emp_lastname; ?></td>
                 </tr>
                 <tr>
                     <td>Jabatan</td>
                     <td> : <?php echo $job->job_name; ?></td>
                 </tr>
                 <tr>
                     <td>Organisasi</td>
                     <td> : <?php echo $job->org_name; ?></td>
                 </tr>
                 <br/>
                 <tr>
                     <td>&nbsp;</td>
                     <td></td>
                 </tr>
                 <tr>
                     <td><a href="#">Edit Profile</a></td>
                     <td></td>
                 </tr>
             </table>
        </div>
        
        
    </div>

</div>