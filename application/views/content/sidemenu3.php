<div id="side-menu" style='background-color: #1f2024; margin-bottom: 0px;'>
    <ul id="css3menu1" class="topmenu">
        <?php
        $dat = $result->row();
        if ($dat->emp_role == 1) {
            ?>
            <li class="topfirst"><a href="<?php echo base_url() ?>index.php/site/admin_index" style="height:15px;line-height:15px;">Home</a></li>
            <li class="topmenu"><a href="#" style="height:15px;line-height:15px;"><span>Organisasi</span></a>
                <ul>
                    <li class="subfirst"><a href="<?php echo base_url() ?>index.php/org">Lihat Struktur Organisasi</a></li>
                    <li><a href="#">Tambah Organisasi Baru</a></li>
                </ul>
            </li>
            <li class="topmenu"><a href="#" style="height:15px;line-height:15px;">Jabatan</a>
                <ul>
                    <li class="subfirst"><a href="<?php echo base_url() ?>index.php/jobs">Manage jabatan</a></li>
                    <li><a href="<?php echo base_url() ?>index.php/jobs/form_job">Tambah jabatan baru</a></li>
                </ul>
            </li>
            <li class="toplast"><a href="#" style="height:15px;line-height:15px;">Pegawai</a>
                <ul>
                    <li class="subfirst"><a href="<?php echo base_url() ?>index.php/emp">Lihat List Pegawai</a></li>
                    <li><a href="<?php echo base_url() ?>index.php/emp/add_emp">Tambah Pegawai Baru</a></li>
                </ul>
            </li>
            <?php
        }
        ?>
        <?php
        if ($dat->emp_role == 1) {
            ?>
            <li class="topmenu"><a href="#" style="height:15px;line-height:15px;">Application Config</a>
                <ul>
                    <li class="subfirst"><a href="<?php echo base_url() ?>index.php/sppd_config">SPPD Flow Configuration</a></li>
                    <li><a href="#">Nota Dinas Flow Configuration</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/admin">HRM Admin Configuration</a></li>
                    <li><a href="#">Aplikasi Cuti Flow Configuration</a></li>
                    <li><a href="#">Assign Fiatur</a></li>
                </ul>
            </li>
            <li class="toplast"><a href="<?php echo base_url(); ?>index.php/utilities/change_password_view" style="height:15px;line-height:15px;">Change Password</a></li>
            <?php
        } else {
            if($dat->emp_role == 3){
                ?>
            <li class="topfirst"><a href="<?php echo base_url() ?>index.php/site/home_reservation" style="height:15px;line-height:15px;">Home</a></li>
            <li class="topmenu"><a href="<?php echo base_url(); ?>index.php/reservation/view_all_reservation" style="height:15px;line-height:15px;">View All Reservation Request</a>
                
                <?php
            }
            else {
            ?>
            <li class="topfirst"><a href="<?php echo base_url() ?>index.php/site" style="height:15px;line-height:15px;">Home</a></li>
            <li class="topmenu"><a href="#" style="height:15px;line-height:15px;">SPPD</a>
                <ul>
                    <li class="subfirst"><a href="<?php echo base_url() ?>index.php/sppd/new_sppd">Create New SPPD</a></li>
                    <li><a href="<?php echo base_url() ?>index.php/sppd/draft_sppd">SPPD Draft</a></li>
                    <li><a href="<?php echo base_url() ?>index.php/sppd/proses_sppd">SPPD Sedang Diproses</a></li>
                    <li><a href="<?php echo base_url()?>index.php/sppd/perlu_proses_sppd">SPPD Perlu Diproses</a></li>
                    
                    <li><a href="<?php echo base_url()?>index.php/sppd/telah_proses_sppd">SPPD Telah Diproses</a></li>
                </ul></li>
            <li class="toplast"><a href="#" style="height:15px;line-height:15px;">Nota Dinas</a></li>
            
            <li class="toplast"><a href="#" style="height:15px;line-height:15px;">Pengajuan Cuti</a></li>
            <li class="toplast"><a href="#" style="height:15px;line-height:15px;">View Gaji</a></li>
            <li class="topmenu"><a href="#" style="height:15px;line-height:15px;">Utilitas</a>
                <ul>
                    <li class="subfirst"><a href="<?php echo base_url() ?>index.php/utilities/edit_profile_view">Edit Profile</a></li>
                    <li><a href="#">Delegasi Jabatan</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/utilities/change_password_view">Change Password</a></li>
                    <li><a href="#">Help</a></li>
                </ul>
            </li>
                <?php
            }
        }
        ?>
        <li class="toplast"><a href="<?php echo base_url() ?>index.php/login/signout" style="height:15px;line-height:15px;">Log Out</a></li>
      </ul>
</div>