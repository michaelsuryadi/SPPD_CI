<div id="content">
    <h2 style="margin: 0px; padding: 20px; text-align: left;">Notifications</h2>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css"/>
    
    <div id="content-sppd-left" style='border-top: 1px dotted black;'>
        <div id="sppd-right-title" style="">
            <p style="margin-left: 20px; margin-top: 10px;"><b>Filter Notifications</b></p>
            <table>
                <tr>
                    <td><select name="filter" style="margin-left: 20px;">
                            <option value="0">--Pilih--</option>
                            <option value="1">Recent Notifications</option>
                            <option value="2">Unread Notifications</option>
                        </select></td>
                </tr>
                <tr>
                    <td><button style='margin-left: 20px;' id='search-btn'>Filter</button></td>
                </tr>
                
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><b style='margin-left: 20px;'>Filter By : </b></td>
                </tr>
                
                <tr>
                    <td><p style='margin-left: 20px; font-size: smaller;'>SPPD Selesai</p></td>
                </tr>
                <tr>
                    <td><p style='margin-left: 20px; font-size: smaller;'>SPPD Perlu Diproses</p></td>
                </tr>
                <tr>
                    <td><p style='margin-left: 20px; font-size: smaller;'>Pengajuan CUTI</p></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><b style='margin-left: 20px;'>Clear All Notifications</b></td>
                </tr>
                
            </table>
        </div>
    </div>
    
    <div id="content-sppd-right" style='border-top: 1px dotted black;'>
        <div id="sppd-right-title" style="">
            <p style="margin-left: 20px; margin-top: 10px;"><b>List Seluruh Notifications : </b></p>
        </div>
        <div id="sppd-right-filter">
            <div id='filter-left'>
                <p style='font-size: smaller; margin-left: 20px; margin-bottom: 3px; margin-top: 3px;'><i>Filter By : All</i></p>
            </div>
            <div id='filter-right' style="background-color: black; color:white;">
                <p style='margin-top: 3px; margin-left: 40px;'>Page : < <b>1</b> 2 3 4 5 ></p>
            </div>
            
        </div>
        <?php 
        if($notif->num_rows()==0){
            ?>
        <p style='text-align: center;'><b>Data Tidak Ada</b></p>
        <?php
        }
        
        else {
            foreach ($notif->result() as $row) {
        ?>
                <div class='sppd-content'>
                    <div class='sppd-img'>
                        <img style="margin-left: 15px; margin-top: 15px;" height="100" width="100" src='<?php echo base_url(); ?>css/paper-sppd.png' h/>
                    </div>
                    <div class='sppd-data'>
                        <?php
                            if($row->status==0){
                                echo '<b>';
                            }
                        ?>
                        <p style='margin-left: 10px;'><a href="<?php echo $row->type_url.$row->notif_link; ?>" style="color:black;">[<?php echo $row->type_name; ?>] - <?php echo $row->notif_desc; ?>
                        <?php if($row->status==0){
                            echo '[NEW]</b>';
                        }
                        ?>
                            </a></p>
                        <p style='margin-left:10px; font-size: smaller'>Tanggal : <?php echo $row->date_post ?> | Pk. <?php echo $row->time_post; ?></p>
                        <p style='margin-left:10px; font-size: smaller'><a href="#" style="color:black;"><b>View <?php echo $row->type_name; ?></b></a></p>
                        
                    </div>
                    <div class='sppd-opsi'>
                        <p style='padding-top: 30px; margin-left: 0px;'><a href='<?php echo base_url(); ?>index.php/notif/delete_notif/id/<?php echo $row->notif_id; ?>' style='color:black;'>Hapus</a></p>
                    </div>
                </div>
    <?php }
        }?>
   </div>
</div>
