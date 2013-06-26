<div id="content">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css"/>
    <h2 style="margin: 0px; padding: 20px; text-align: left;">SPPD Telah Diproses</h2>
    
    <div id="content-sppd-left" style='border-top: 1px dotted black;'>
        <div id="sppd-right-title" style="">
            <p style="margin-left: 20px; margin-top: 10px;"><b>Search SPPD</b></p>
            <table>
                <tr>
                    <td><input style='margin-left: 20px;' type='text' name='keyword'/></td>
                </tr>
                <tr>
                    <td><button style='margin-left: 20px;' id='search-btn'>Search</button></td>
                </tr>
                
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><b style='margin-left: 20px;'>Sort SPPD By :</b></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <select style="margin-left:20px;">
                            <option value="0">--Select Month--</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <select style="margin-left:20px;">
                            <option value="0">--Select Year--</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><button style="margin-left: 20px;">Process</button></td>
                </tr>
                
            </table>
        </div>
    </div>
    
    <div id="content-sppd-right" style='border-top: 1px dotted black;'>
        <div id="sppd-right-title" style="">
            <p style="margin-left: 20px; margin-top: 10px;"><b>List Seluruh SPPD Telah Diproses : </b></p>
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
        if($sppd_list->num_rows()==0){
            ?>
        <p style='text-align: center;'><b>Data Tidak Ada</b></p>
        <?php
        }
        
        else {
            
            foreach ($sppd_list->result() as $row) {
        ?>
                <div class='sppd-content'>
                    <div class='sppd-img'>
                        <img style="margin-left: 15px; margin-top: 15px;" height="100" width="100" src='<?php echo base_url(); ?>css/paper-sppd.png' h/>
                    </div>
                    <div class='sppd-data'>
                        <p style='margin-left: 10px;'><b><?php echo $row->sppd_id; ?> - <?php echo $row->sppd_tuj; ?></b></p>
                        <p style='margin-left:10px; font-size: smaller'>Tanggal : <?php echo $row->sppd_tgl; ?> | Pemohon : <?php echo $row->emp_id . "-" . $row->emp_firstname . ' ' . $row->emp_lastname; ?> | Pembuat : <?php echo $row->pem_fname . " " . $row->pem_lname; ?></p>
                        <p style='margin-left:10px; font-size: smaller'>Last Approved By : -</p>
                    </div>
                    <div class='sppd-opsi'>
                        <p style='padding-top: 30px; margin-left: 0px;'><a href='<?php echo base_url(); ?>index.php/sppd/view_telah_proses_sppd/id/<?php echo $row->sppd_num; ?>' style='color:black;'>View</a></p>
                    </div>
                </div>
    <?php }
        }?>
        
   </div>
    
</div>