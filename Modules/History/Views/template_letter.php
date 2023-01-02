<html>
    <head>
        <style type="text/css">
            @page{margin:0}
            table{
                width: 100%;
            }
            h4{
                font: 20px/21px "Arial Black","Arial Bold",Gadget,sans-serif;
                margin-bottom: 0 !important;
                text-decoration:underline;
            }
            table tr{
                vertical-align:top;
            }
            table td, p{
                font: 12px/13px "Arial Narrow",Arial,sans-serif;
                padding:2px;
            }
            table th{
                font: 15px/17px "Arial Narrow",Arial,sans-serif;
                font-weight:bold;
                padding:2px;
            }
            .small{
                font: 12px/13px "Arial Narrow",Arial,sans-serif;
            }
            .text-right{
              text-align: right;
            }
        </style>
    </head>
    <body style="padding:0;margin:0;">
        <div style="position: fixed; left: 0px; top: 0px; right: 0px; bottom: 0px; text-align: center;z-index: -1000;">
            <img src="images/kop-surat.jpg" style="width: 100%;">
        </div>
        <br/></br>
        <table style="border-bottom:2px solid #666;">
          <tr>
            <td style="width:25%;">
              
            </td>
            <td style="text-align:center;">
                <br/><br/><br/><br/><br><br><h4><?=strtoupper($title)?></h4>
                No.<?=$employee['number']?>
            </td>
            <td style="width:25%;text-align:right;" class="small"><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/></td>
          </tr>
        </table>
        <table align="center" style="width:500px;">
            <tr>
                <td><b>I.</b></b></td>
                <td><b>Pertimbangan</b></td><td>:</td>
                <td>Untuk Kepentingan dinas dan kelancaran tugas operasional <b><?=$company['name']?></b>
                    dengan Management <strong><?=$employee['project_name']?></strong>
                </td>
            </tr>
            <tr><td colspan=4>&nbsp;</td></tr>
            <tr>
                <td><b>II.</b></td>
                <td><b>Dasar</b></td><td>:</td>
                <td>Kesepakatan <b><?=$company['name']?></b> dengan Managemen <b><?=$employee['project_name']?></b>
                </td>
            </tr>
            <tr><td colspan=4>&nbsp;</td></tr>
            </tr>
            <tr>
                <td><b>III.</b></td>
                <td><b>Kepada</b></td><td>:</td>
                <td>
                    <table style="width:100%;">
                        <tr>
                            <td>Nama Lengkap</td><td>:</td><td><?=$employee['fullname']?></td>
                        </tr>
                        <tr>
                            <td style="width:100px;">Nomor induk</td><td style="width:10px;">:</td><td><?=$employee['eid_number']?></td>
                        </tr>
                        <tr>
                            <td>Jabatan</td><td>:</td><td><?=$employee['jobtitle']?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td colspan=4>&nbsp;</td></tr>
            <tr>
                <td><b>IV.</b></td>
                <td><b>Untuk</b></td><td>:</td>
                <td>Melaksanakan Tugas di:
                <?php
                $date=date_create($employee['start_date']);
                $tgl_=date_format($date,"d F Y");
                ?>
                    <ul>
                        <li>Lokasi <b><?=$employee['project_name']?></b></li>
                        <li>Mulai Tugas <?=$tgl_?></li>
                        <li>Akhir Tugas s/d Waktu tertentu/dibutuhkan</li>
                    </ul>
                </td>
            </tr>
            <tr><td colspan=4>&nbsp;</td></tr>
            <tr>
                <td><b>V.</b></td>
                <td><b>Hal-Hal Lain</b></td><td>:</td>
                <td>Prosedur:
                    <ul>
                        <li>Setelah menerima surat tugas ini segera melapor kepada: <strong>Site Commander</strong>.</li>
                        <li>Selalu Menjaga Nama Baik Corp, Perusahaan dan Managemen Pengguna Jasa.</li>
                        <li>Melaporkan kejadian dan masalah yang ada di lokasi ke pimpinan.</li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td colspan=4>
                    <p>Demikian surat perintah tugas ini dibuat agar dilaksanakan dengan penuh rasa hormat dan tanggung jawab.</p>
                </td>
            </tr>
        </table>
        <table  align="center" style="width:500px;">
            <tr>
                <td>
                    <b>Jakarta, <?=$tgl_?></b><br>
                    <?=$company['name']?><br>
                    <br><br><br><br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="font-size:12px;">
                    <b>Human Resource Management</b><br/>
                    CC:
                    <ul>
                        <li>Management <?=$employee['project_name']?></li>
                        <li>Direksi <?=$company['name']?></li>
                        <li>Operational Manager <?=$company['name']?></li>
                        <li>Arsip</li>
                    </p>
                </td>
            </tr>
        </table>
    </body>
</html>