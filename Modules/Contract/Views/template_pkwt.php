<html moznomarginboxes mozdisallowselectionprint>
    <head>
    <title><?=$title?></title>
	<link rel="stylesheet" href="<?=base_url("themes/normalize.min.css")?>">
	<link rel="stylesheet" href="<?=base_url("themes/paper.min.css")?>">
	<style>
	@page {
		size: "Letter";
	}
	.sheet{
		padding:1em 5.5em;
	}
	table{
		width:100%;
	}
	tr{
		border-bottom:1px solid #000;
	}
	body, td{
		font-size:12.5px;
		font-family: Arial,sans-serif;
	}
	th,td{
		padding:0.5em;
	}
	ul{
		padding-left:20px;
	}
	.center{
		text-align:center
	}
	h2{
		margin:0;
	}
	h3{
		margin-top:2em;
	}
	h3,h4{
		text-align:center;
	}
	table.no-padding td{
		padding:2px;
	}
	table.bd-all {
		border-collapse: collapse;
	}

	table.bd-all,table.bd-all th,table.bd-all td {
		border: 1px solid black;
	}
	p{
		text-align:justify;
	}
	span.isi{
		text-decoration:underline;
	}
	ol{
		padding-left: 1em;
	}

	</style>
	<script>
		window.print();
	</script>
</head>
<body class="Letter">
	<section class="sheet">
		<div style="text-align:center;">
            <img style="width:100px;" src="<?=base_url("uploads/companies/logo/".$company['img_logo'])?>">
        </div>
		<br/>
		<h2 style="text-align:center;text-decoration:underline;padding:0;">PERJANJIAN  KERJA WAKTU TERTENTU (PKWT)</h2>
		<h4 style="text-align:center;margin-top:0;font-weight:normal;">NO:<?=$employee['number']?></h4>
		<p>Pada Tanggal, Bulan dan Tahun seperti yang tercantum di akhir perjanjian ini,
		bertempat di Kantor PT. Cakra Satya Internusa yang beralamatkan di Citi Square Business Park Blok A 20-21
		Jl. Peta Selatan Kalideres Jakarta Barat, telah terjadi kesepakatan kerja untuk  Perjanjian Kerja Waktu Tertentu antara  karyawan dengan  PT. Cakra Satya Internusa, yang dalam hal ini diwakili oleh :</p>
		<table style="width:100%;" class="no-padding">
            <tr><td style="width:20%;">Nama</td><td>: <strong>HEKSI MULIYAMIN</strong></td></tr>
            <tr><td>Jabatan</td><td>: HR & PERSONNEL MANAGER</td></tr>
            <tr><td>Berkedudukan di</td><td>: Jakarta</td></tr>
		</table>
		<p>yang selanjutnya disebut sebagai PIHAK PERTAMA, bertindak untuk dan atas nama Direksi dan atau Perusahaan, serta dengan penuh kesadaran, tanggung jawab, dan sukarela, untuk mengikatkan diri dalam perjanjian kerja ini, dengan:</p>
		<table style="width:100%;" class="no-padding">
			<tr><td style="width:20%;">Nama Lengkap</td><td style="width:2px;">:</td><td><strong><span class="isi"><?=$employee['fullname']?></span></strong></td></tr>
			<tr><td>Jenis Kelamin</td><td style="width:2px;">:</td><td> <span class="isi"><?=$employee['gender']?></span></td></tr>
			<tr><td>Tempat/Tgl.lahir</td><td style="width:2px;">:</td><td> <span class="isi"><?=$employee['place_date_birth']?></span></td></tr>
			<tr><td>No. KTP</td><td style="width:2px;">:</td><td> <span class="isi"><?=$employee['ektp_number']?></span></td></tr>
			<tr><td>Alamat KTP</td><td style="width:2px;">:</td><td> <span class="isi"><?=$employee['address']?></span></td></tr>
			<tr><td>No. Telp/Hp</td><td style="width:2px;">:</td><td> <span class="isi"><?=$employee['phone']?></span></td></tr>
			<tr><td>Status</td><td style="width:2px;">:</td><td> <span class="isi"><?=$employee['marital_status']?></span></td></tr>
		</table>
		<p>Yang dalam hal ini disebut sebagai PIHAK KEDUA, bertindak untuk dan atas namanya sendiri, serta dengan penuh kesadaran, tanggung jawab, dan sukarela, untuk mengikatkan diri dalam perjanjian kerja ini.</p>
		<p>Maka dengan demikian, bahwa PIHAK PERTAMA dan PIHAK KEDUA sepakat untuk menandatangani Perjanjian Kerja ini berdasarkan ketentuan dan persyaratan sebagaimana tersebut dalam pasal-pasal berikut:</p>

		<h4>PASAL 1<br/>DEFINISI</h4>
		<ol>
			<li>Perusahaan adalah PT. Cakra Satya Internusa atau yang di kenal dengan CSI yang didirikan berdasarkan akta notaries no. 3 tanggal 4 April 2005, dengan cabang cabangnya di Indonesia.</li>
			<li>PIHAK PERTAMA adalah perwakilan dari Perusahaan, yang bergerak dalam bidang penyedia sumber daya manusia.</li>
			<li>Karyawan adalah  orang perorangan individu yang bekerja di PT. Cakra Satya Internusa dengan perjanjian kerja secara tertulis antara kedua belah Pihak, yang pelaksanaannya berpedoman pada peraturan perundang-undangan yang berlaku.</li>
			<li>PIHAK KEDUA adalah pribadi pria ataupun wanita yang secara sah telah cukup usia kerja, berkemampuan membaca dan menulis, sehat mental maupun fisiknya, serta sehat jasmani maupun rohaninya, tidak sedang tersangkut dalam perkara hukum di Negara Republik Indonesia, bertindak untuk dan atas namanya sendiri, serta secara sukarela mengikatkan dirinya kepada perjanjian kerja dengan PT. Cakra Satya Internusa, untuk kepentingan penempatan dirinya, guna dapat ditugaskan untuk mengisi, melaksanakan, mengerjakan, menyelesaikan tugas dan pekerjaan-pekerjaan yang diberikan dan atau ditugaskan kepadanya oleh PIHAK PERTAMA, sesuai dengan penempatannya yang diatur, direncanakan oleh PT. Cakra Satya Internusa.</li>
			<li>Lokasi kerja adalah area atau lingkungan atau daerah yang menjadi tempat kerja PT. Cakra Satya Internusa dan lingkungan sekitarnya yang masih menjadi tanggung jawab dari PT. Cakra Satya Internusa.</li>
			<li>Waktu kerja adalah hari dan/atau jam kerja yang telah ditetapkan oleh Perusahaan bagi karyawan untuk melaksanakan tugas dan tanggung jawabnya.</li>
			<li>Pelanggaran adalah suatu tindakan yang tidak sesuai dengan ketentuan atau tata tertib atau peraturan perusahaan yang mana dilakukan dengan tujuan atau maksud tertentu yang dapat merugikan perusahaan atau pihak lain.</li>
		</ol>
		<br/><br/><br/>
		<p style="text-align:center;">1</p>
	</section>
	<section class="sheet">
		<h4>PASAL 2<br/>TUGAS</h4>
		<ol>
			<li>PIHAK PERTAMA bertugas mengelola Sumber Daya Manusia dan administrasi PIHAK KEDUA selama masa Perjanjian Kerja ini berlangsung.</li>
			<li>Pihak Kedua mengakui bahwa Pihak Pertama mempunyai wewenang dalam mengatur dan mengelola Perusahaan, Karyawan dan termasuk Pihak kedua.</li>
			<li>PIHAK KEDUA bertugas sesuai dengan Perintah Tugas maupun Kebutuhan Pekerjaan yang ditugaskan oleh PIHAK PERTAMA dalam hal ini sebagai :
				<table style="width:100%;" class="no-padding">
					<tr><td style="width:100px;"><strong>Jabatan</strong></td><td><strong>: <?=$employee['jobtitle']?></td></tr>
					<tr><td><strong>Divisi<strong></td><td><strong>: <?=$employee['department_name']?><strong></td></tr>
				</table>
				Dengan tetap memperlihatkan kondisi yang ada, PIHAK KEDUA bersedia ditempatkan pada Departemen atau divisi lain,
				bersedia melakukan perjalanan dinas dan atau ditempatkan di luar kota atau di luar pulau.
				Tunjangan dan kompensasi akan diberikan sesuai dengan ketentuan yang berlaku/ Peraturan Perusahaan.
			</li>
		</ol>


		<h4>PASAL 3<br/>KEWAJIBAN DAN TANGGUNG JAWAB</h4>
		<ol>
			<li>PIHAK PERTAMA berkewajiban dan bertanggung jawab atas:</li>
			<ol type="a">
				<li>Pengelolaan administratif dan atau penggajian PIHAK KEDUA.</li>
				<li>Pembinaan sumber daya manusia bagi PIHAK KEDUA.</li>
				<li>Melakukan standarisasi kerja bagi PIHAK KEDUA.</li>
			</ol>
			<li>PIHAK KEDUA berkewajiban dan bertanggung jawab atas:</li>
			<ol type="a">
				<li>Pekerjaan yang ditugaskan, serta kewajiban-kewajiban yang dibebankan kepadanya.</li>
				<li>Dapat memenuhi Batas Minimum Target (BMT) yang akan diatur atau ditetapkan oleh atasan.</li>
				<li>Peningkatan Mutu Hasil Kerja dirinya sendiri dalam masa penugasannya.</li>
				<li>Keselamatan dirinya dan rekan kerjanya selama bertugas.</li>
				<li>Mematuhi segala peraturan dan atau tata tertib yang ada di tempat penugasan.</li>
				<li>Menjalankan perintah atasannya atau pimpinan atau dari yang berwenang di tempat penugasan.</li>
				<li>Mematuhi dan menjalankan segala Peraturan Perundangan yang berlaku di Indonesia, Peraturan Perusahaan dan atau Tata Tertib  Perusahaan PIHAK PERTAMA.</li>
				<li>PIHAK KEDUA tidak diperkenankan memberi Press Release (pernyataan tertulis atau verbal),
					wawancara dengan Wartawan,memberikan keterangan kepada klien baik secara lisan ataupun tertulis dan atau menulis dalam media sosial termasuk surat elektronik mengenai keadaan Perusahaan PIHAK PERTAMA tanpa seijin PIHAK PERTAMA , terkecuali untuk kepentingan Negara dengan sepengetahuan PIHAK PERTAMA.</li>
				<li>Semua hasil kerja PIHAK KEDUA yang berkaitan dengan tugas dan tanggung jawab PIHAK KEDUA baik yang berbentuk karya tulis maupun yang berwujud kebendaan lainnya adalah merupakan hak milik yang sah dari PIHAK PERTAMA, oleh karena itu PIHAK KEDUA dilarang membawa, memperbanyak atau    menggandakan, menyebarluaskan atau memberikan
				kepada Pihak lain tanpa seijin dan sepengetahuan PIHAK PERTAMA, kecuali untuk kepentingan Negara dengan sepengetahuan PIHAK PERTAMA.</li>
				<li>PIHAK KEDUA wajib melaksanakanTanggung Jawab kerja dan Target Kerjayang dijabarkan oleh  atasan langsungDan tugas tugas lain yang diberikan oleh Atasan.</li>
				<li>PIHAK KEDUA wajib Melaporkan hasil pekerjaan dan bertanggung jawab kepada atasan langsung atau Manager dan atau Manajemen Perusahaan. </li>
				<li>Pihak Kedua wajib menjaga serta memelihara dengan baik semua asset milik Perusahaan dan segera melaporkan kepada Pimpinan Perusahaan / Atasannya apabila mengetahui hal-hal yang dapat menimbulkan bahaya dan atau kerugian Perusahaan.</li>
				<li>Pihak Kedua wajib melapor kepada Pimpinan Perusahaan dan atau HRD apabila ada perubahan-perubahan atas status dirinya, susunan keluarganya, perubahan alamat dan sebagainya.</li>
				<li>Pihak Kedua wajib memeriksa semua alat-alat kerja masing-masing sebelum bekerja dan sebelum meninggalkan Pekerjaan sehingga benar-benar tidak menimbulkan kerusakan / bahaya yang mengganggu Pekerjaan</li>
			</ol>
		</ol>
		<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		<p style="text-align:center;">2</p>
	</section>
	<section class="sheet">
		<h4>PASAL 4<br/>HUBUNGAN KERJA</h4>
		<ol>
			<li>PIHAK PERTAMA dapat mengambil dan atau membuat segala keputusan dan atau kebijakan, cara dan alasan untuk menghindari dan atau mengantisipasi timbulnya kondisi yang dapat berakibat kepada Konflik Kepentingan dari dan antara:
				<ol type="a">
                    <li>PIHAK KEDUA dengan dan atau dengan karyawan PIHAK PERTAMA, dan atau sebaliknya.</li>
					<li>PIHAK KEDUA dengan Pelanggan atau Customer atau Client atau Vendor PIHAK PERTAMA, dan atau sebaliknya.</li>
                </ol>
			</li>
			<li>PIHAK KEDUA tidak diperkenankan bertindak untuk dan atau atas nama PIHAK PERTAMA, tanpa sepengetahuan dan seijin dari PIHAK PERTAMA.</li>
			<li>PKWT ini berakhir apabila  :
				<ol type="a">
                    <li>Pihak Kedua meninggal dunia.</li>
					<li>PIHAK KEDUA melakukan tindak pidana atau melanggar Peraturan Perusahaan.</li>
					<li>Perusahaan pailit.</li>
					<li>Surat Perjanjian Kerjasama PT. Cakra Satya Internusa dengan Klien berakhir.</li>
					<li>Pihak Kedua mengundurkan diri maka Pihak kedua berkewajiban membayar kepada Pihak Pertama selisih upah dalam masa berlakunya Perjanjian Kerja Waktu Tertentu ini.</li>
					<li>Permintaan atau penilaian dari Klien selaku pengguna jasa terhadap Pihak Kedua.</li>
					<li>Pihak Kedua dinyatakan tidak mampu lg bekerja berdasarkan rekomendasi Medis.</li>
					<li>Force Majeure, keadaan kacau dan tidak terkendali serta di luar batas kemampuan semua orang, seperti Bencana Alam, Kebakaran, Perang, Huru-Hara, Kerusuhan, Pemberontakan, Pemogokan, atau Wabah yang berhubungan nyata.</li>
                </ol>
			</li>
			<li>PKWT adalah kesepakatan kerja antara Pihak Kedua dengan Perusahaan untuk mengadakan hubungan kerja dalam waktu tertentu.</li>
			<li>Atas kesepakatan bersama PKWT ini akan diberlakukan terhitung mulai tanggal disepakati dan ditandatangani oleh kedua belah pihak.</li>
			<li>Pihak Kedua wajib memberikan pelayanan yang baik kepada Pengguna Jasa PT. Cakra Satya Internusa.</li>
		</ol>
		<h4>Pasal 5<br/>PENEMPATAN DAN MUTASI</h4>

		<ol>
			<li>Pihak Kedua harus siap ditempatkan di wilayah manapun selama dalam lingkungan kerja PT. Cakra Satya Internusa.</li>
			<li>Lokasi kerja, Departemen, Divisi, dan Jabatan Pihak Kedua ditetapkan oleh HRD.</li>
			<li>Pihak Pertama berhak untuk melakukan Mutasi Jabatan dan Mutasi Lokasi Kerja kepada Pihak Kedua, apabila Pihak Kedua menolak Keputusan Pihak Pertama maka Pihak Kedua dianggap mengundurkan diri.</li>
			<li>Promosi hanya bisa dilakukan atas dasar persetujuan dan proses melalui HRD.</li>
			<li>Apabila Pihak Pertama melakukan Mutasi kepada Pihak Kedua, upah dan fasilitasnya akan disesuaikan dengan jabatan pdan lokasi yang baru sesuai dengan Peraturan Perusahaan.</li>
		</ol>

		<h4>Pasal 6<br/>PROMOSI DAN DEMOSI</h4>
		<ol>
			<li>Promosi dan Demosi dapat dilakukan berdasarkan kebutuhan Organisasi Perusahaan atau Penilaian Kinerja Pihak Kedua.</li>
			<li>Pihak Pertama akan melakukan Penilaian Kinerja secara Periodik kepada Pihak Kedua. Hasil Penilaian tersebut dapat digunakan untuk Promosi atau Demosi Pihak Kedua.</li>
			<li>Dalam perihal dilakukannya Promosi ataupun Demosi kepada Pihak Kedua maka upah dan fasilitas yang diterima oleh Pihak Kedua akan disesuaikan dengan Jabatan yang baru sesuai dengan Peraturan Perusahaan.</li>
			<li>Pihak Kedua dapat didemosi apabila Melanggar Peraturan Perusahaan dan turunannya, Merugikan Perusahaan dan Klien, Alpa ( Lalai dalam Kewajiban ).</li>
			<li>Dalam setiap promosi jabatan akan dicantumkan dengan jelas jabatan apa, uraian tugas dan pangkat Pihak Kedua yang bersangkutan, serta upah dan fasilitas yang akan diterima secara tertulis.</li>
			<li>Dalam setiap promosi jabatan, Perusahaan selalu memperhatikan  : kecakapan, konduite, integritas, dan loyalitas masing-masing Pihak Kedua.</li>
		</ol>

		<h4>Pasal 7<br/>WAKTU KERJA DAN JADWAL KERJA</h4>
		<ol>
			<li>Waktu kerja dan jam kerja serta jam istirahat karyawan diatur sesuai dengan jadwal yang diberlakukan dimasing-masing wilayah/ lokasi dimana PIHAK KEDUA ditugaskan oleh PIHAK PERTAMA.</li>
			<li>Pihak Kedua harus telah berada atau hadir di tempat tugas masing-masing tepat pada waktu yaitu 30 menit sebelum jam kerja yang telah ditentukan oleh Perusahaan, dan wajib pula untuk masing-masing setelah serah terima pekerjaan yang telah dilakukan oleh masing-masing pengganti berikut.</li>
			<li>Pihak Kedua wajib mengisi kartu absensi atau menyerahkan kartu absensi pada tempat yang telah ditentukan baik pada waktu masuk maupun pada waktu pulang bekerja, dan kartu absensi harus diisi atau diserahkan oleh Pihak Kedua sendiri.</li>
		</ol>
		<br/>
		<p style="text-align:center;">3</p>
	</section>
	<section class="sheet">
		<h4>Pasal 8<br/>IZIN DAN CUTI KARYAWAN</h4>
		<p>Dalam kurun waktu 1 (satu) tahun Pihak Kedua tidak boleh ijin lebih dari 3 (tiga) hari kerja, apabila lebih dari 3 (tiga) hari kerja maka Pihak Pertama akan mempertimbangan untuk perpanjangan kontrak kerja tahun ke depannya.
			Perusahaan dapat memberi ijin kepada Pihak Kedua yang meninggalkan pekerjaan untuk keperluan di bawah ini :</p>
		<ol>
			<li>Pernikahan Pihak Kedua  : 3 (tiga) hari kerja.</li>
			<li>Pernikahan anak Pihak Kedua  : 2 (dua) hari kerja.</li>
			<li>Menikahkan, mengkhitanan, membabtiskan anak Pihak Kedua  : 2(dua) hari kerja.</li>
			<li>Istri Pihak Kedua melahirkan atau keguguran  : 2 (dua) hari kerja.</li>
			<li>Suami atau istri atau anak atau orang tua atau mertua atau menantu meninggal dunia : 2 (dua) hari kerja.</li>
		</ol>
		<p>Ijin meninggalkan pekerjaan tersebut harus diperoleh terlebih dahulu dari Perusahaan, kecuali dalam keadaan mendesak dengan memberikan informasi yang akurat kepada Pimpinan di Lokasi Kerja. Bukti-bukti tertulis tersebut dapat diajukan kemudian. Atas pertimbangan Perusahaan, ijin meninggalkan pekerjaan diluar ketentuan tersebut di atas tidak dapat diberikan upah.
			Setiap Pihak Kedua yang meninggalkan pekerjaan tanpa ijin dari Perusahaan atau surat-surat keterangan tertulis dan resmi atau alasan yang dapat diterima oleh Perusahaan dianggap Disersi.
		</p>
		<ol>
			<li>Perusahaan dapat memberikan cuti tahunan kepada karyawan setelah hak cuti karyawan timbul/setelah karyawan bekerja selama 12 bulan berturut-turut.</li>
			<li>Hak cuti karyawan akan di atur oleh perusahaan secara bergantian sesuai dengan jadwal dan team kerja yang sudah dijadwalkan cuti tahunanya.</li>
		</ol>

		<h4>Pasal 9<br/>TATA TERTIB PERUSAHAAN</h4>
		<p>Tata Tertib Perusahaan berupa larangan dan kewajiban pihak kedua, bilamana dilanggar mengakibatkan pemberian sanksi :</p>
		<ol>
			<li>Kategori Peringatan Pertama :
				<ol type="a">
					<li>Tidak masuk kerja tanpa ijin dan tanpa keterangan.</li>
					<li>Tidak mentaati waktu kerja yang telah ditetapkan, terlambat datang atau pulang sebelum waktunya.</li>
					<li>Berucap, bersikap dan berbuat hal-hal yang mengakibatkan citra yang kurang baik bagi Karyawan dan Perusahaan.</li>
					<li>Tidak melaporkan terjadinya kerusakan pada peralatan / asset Perusahaan yang diketahui, yang menjadi tanggung jawabnya.</li>
					<li>Menggunakan asset milik Perusahaan dan asset Klien tanpa sepengetahuan atasan, seizin Perusahaan atau Klien untuk kepentingan pribadi.</li>
					<li>Melakukan perbuatan yang mengakibatkan terganggunya suasana kerja atau menimbulkan keonaran.</li>
					<li>Merokok ditempat terlarang.</li>
					<li>Tidak menandatangani daftar hadir / absensi baik sengaja maupun tidak disengaja.</li>
					<li>Menghilangkan kartu absensi / ID Card.</li>
					<li>Meninggalkan tempat tugas tanpa izin atasannya.</li>
				</ol>
			</li>
			<li>Kategori Peringatan Kedua :
				<ol type="a">
					<li>Tidak mengenakan seragam dan atribut lengkap pada saat bertugas.</li>
					<li>Melakukan pelanggaran dalam masa berlakunya Surat Peringatan Tertulis Pertama.</li>
					<li>Selama waktu kerja melakukan kegiatan bertentangan dengan kepentingan Perusahaan.</li>
					<li>Mangkir baik secara berurutan ataupun tidak berurutan.</li>
					<li>Pelanggaran terhadap peraturan-peraturan Keselamatan dan Kesehatan Kerja (K3).</li>
					<li>Alpa(Lalai terhadap kewajiban).</li>
				</ol>
			</li>
			<li>Peringatan Ketiga :
				<ol type="a">
					<li>Melakukan pelanggaran dalam masa berlakunya Surat Peringatan Tertulis Pertama maupun Kedua.</li>
					<li>Terlibat pengedaran atau pengguna narkoba atau obat-obat terlarang.</li>
					<li>Melanggar Hak Asasi Manusia dan melakukan SARA.</li>
					<li>Menghina atau Bullying.</li>
					<li>Berkelahi, Merusak asset Perusahaan, Klien ataupun milik orang lain, Tersangkut masalah narkoba/obat-obat terlarang lainnya, Menghina, Menganiaya, Desersi (meninggalkan tugas tanpa keterangan), Menjarah, Penyogokan dalam bentuk uang / barang / material lainnya, Pemalsuan laporan / dokumen / informasi dalam bentuk apapun, Tidak memberikan pertolongan kepada yang membutuhkan di lokasi kerja, Membuka rahasia Perusahaan, Memeras, Mengancam, Berhutang yang bermasalah, Penadah barang / material hasil kejahatan, Menyerang secara fisik.</li>
					<li>Mencuri, menipu, merampok, penggelapan barang, menghasut, melakukan tindak pidana.</li>
					<li>Melakukan pencemaran nama baik Perusahaan.</li>
					<li>Tidur atau Merokok dilingkungan kerja pada saat bertugas.</li>
					<li>Melakukan tindak Asusila.</li>
					<li>Melakukan Demonstrasi dan bertindak Anarkis.</li>
					<li>Menolak Perintah dan Penugasan dari atasan, Perusahaan, dan Klien.</li>
				</ol>
			</li>
		</ol>
		<br/><br/>
		<p style="text-align:center;">4</p>
	</section>
	<section class="sheet">
		<h4>PASAL 10<br/>PENGGUNAAN LOGO, ATRIBUT DAN NAMA PERUSAHAAN</h4>

		<ol>
			<li>PIHAK KEDUA harus dapat menjaga dan menggunakan segala sesuatu yang berkaitan langsung ataupun tidak langsung atas penggunaan logo atau simbol-simbol atau tanda-tanda atau gambar-gambar atau perangkat atau seragam, dan atau merek, dan atau nama PIHAK PERTAMA, yang dikuasakan kepadanya selama masa Perjanjian Kerja Sama ini.</li>
			<li>PIHAK KEDUA tidak diperkenankan menggunakan segala sesuatu yang berkaitan langsung ataupun tidak langsung dengan penggunaan logo atau simbol-simbol atau tanda-tanda atau gambar-gambar atau perangkat atau seragam, dan atau merek, dan atau nama PIHAK PERTAMA, yang dikuasakan kepadanya selama masa Perjanjian Kerja Sama ini, untuk kepentingan dan keperluan pribadi dan atau kelompoknya, tanpa ijin dan persetujuan tertulis dari PIHAK PERTAMA.</li>
			<li>Pada saat Perjanjian Kerja Waktu Tertentu ini berakhir maka PIHAK KEDUA wajib mengembalikan logo atau simbol-simbol atau tanda-tanda atau gambar-gambar atauperangkat  atau seragam, dan atau merek Perusahaan kepada PIHAK PERTAMA.</li>
		</ol>

		<h4>PASAL 11<br/>KEPEMILIKAN INFORMASIDAN KERAHASIAAN INFORMASI</h4>

		<p>Semua dan segala sesuatu yang berhubungan dengan Informasi yang berkaitan dengan pekerjaan,
		baik Informasi secara jelas maupun sebagian darinya adalah menjadi milik PIHAK PERTAMA,
		termasuk juga salinan dari padanya, penggunaannya, perubahan akan halnya, ataupun bagian dari padanya, tanpa menghitung jumlahnya,
		dalam bentuk maupun format yang dimaksud PIHAK PERTAMA, baik dengan Hak Paten ataupun Hak Kepemilikan Merek Dagang yang telah ada,
		maupun yang akan ada, baik diadakan bersama dengan PIHAK KEDUA, kesemua Informasi tersebut agar dikembalikan kepada PIHAK PERTAMA,
		sesuai dengan permintaan PIHAK PERTAMA pada waktu kapanpun atau termasuk pada akhir masa Perjanjian Kerja Sama ini.</p>
		<ol>
			<li>Untuk kepentingan Perjanjian Kerja Sama ini, maksud dari Informasi adalah, apapun dan semua bentuk informasi dan atau data produk dari pekerjaan secara langsung ataupun tidak langsung yang diterima oleh PIHAK KEDUA, dalam hubungannya dengan pekerjaan yang ada termasuk di dalamnya dan tidak terbatas pada informasi dan atau data dari Pelanggan atau Customer atau Klient atau Vendor dari PIHAK PERTAMA.</li>
			<li>PIHAK KEDUA dengan adanya Klausul ini, berjanji  untuk merahasiakan dan tidak menyebarluaskan kepada PIHAK manapun dan atau menggunakannya untuk kepentingan PIHAK KEDUA sendiri terkecuali PIHAK PERTAMA mengijinkan untuk kepentingan pekerjaan berdasarkan Perjanjian Kerja Sama ini.</li>
		</ol>

		<h4>PASAL 12<br/>HAK DAN REMUNERASI</h4>
		<ol>
			<li>PIHAK PERTAMA akan memberikan Upah/ atau Gaji kepada PIHAK KEDUA secara bulanan dengan rincian:
				<br/>
			</li>
			<li>PIHAK PERTAMA akan memberikan Tunjangan Hari Raya (THR) kepada PIHAK KEDUA prorata di bawah masa kerja 1 tahun dan maksimal 1 bulan dari gaji pokok.</li>
			<li>PIHAK PERTAMA akan mengikutsertakan PIHAK KEDUA dalam program BPJS yang terdiri dari:
				<ol type="a">
					<li>BPJS Kesehatan</li>
					<li>BPJS Ketenagakerjaan</li>
				</ol>
			</li>
			<!--<li>Penerimaan gaji jatuh pada setiap awal bulan, pada bulan berjalan dan apabila pada awal bulan tersebut jatuh pada hari libur, maka gaji akan  dibayarkan pada hari kerja terdekat.</li>-->
			<li>Penggajian dibayarkan melalui payroll dengan Bank BRI, sehingga PIHAK KEDUA diwajibkan memiliki rekening bank tersebut.</li>
			<li>PIHAK PERTAMA tidak akan membayar apapun selain yang diatur dalam Perjanjian ini, dan PIHAK KEDUA tidak berhak atas pembayaran  apapun selain yang diatur oleh Perjanjian Kerja ini.</li>
		</ol>
		<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		<p style="text-align:center;">5</p>
	</section>
	<section class="sheet">
		<h4>PASAL 13<br/>JANGKA WAKTU</h4>
		<ol>
			<li>PIHAK KEDUA mulai aktif bekerja sejak tanggal <?=$employee['start_date']?> sampai dengan <?=$employee['end_date']?>.</li>
			<li>PIHAK PERTAMA dapat sewaktu-waktu mengakhiri Perjanjian Kerja Waktu Tertentu  ini dengan pemberitahuan terlebih dahulu secara tertulis yang selambat lambatnya diberitahukan 2 (dua) minggu sebelumnya . PIHAK KEDUA pun dapat sewaktu-waktu mengakhiri Perjanjian Kerja Waktu Tertentu  ini dengan pemberitahuan terlebih dahulu secara tertulis yang sekurang-kurangnya diberitahukan 1 (satu) bulan atau 30 (tiga puluh) hari sebelum hari terakhir aktif bekerja.</li>
			<li>Apabila hubungan kerja berakhir karena sebab apapun juga, maka :
				<ol type="a">
					<li>PIHAK KEDUA wajib mengembalikan/ menyerahkan kembali barang-barang inventaris, pakaian kerja, atribut dan lain-lain dan apabila PIHAK KEDUA tidak mengembalikan maka dianggap melakukan penggelapan barang milik PIHAK PERTAMA.</li>
					<li>PIHAK KEDUA tidak berhak untuk meminta atau menuntut sisa gaji atau tunjangan apapun dari PIHAK PERTAMA.</li>
				</ol>
			</li>
			<li>Apabila PIHAK KEDUA tidak dapat memenuhi target/ persyaratan/ performance/ kinerja yang ditetapkan di divisi atau departemen, maka PIHAK PERTAMA setiap saat dapat menghentikan perjanjian kerja ini.</li>
			<li>PIHAK KEDUA wajib membayar sejumlah Rp 500,000 kepada PIHAK PERTAMA apabila mengakhiri Perjanjian Kerja Waktu Tertentu dibawah masa kerja 2 Tahun berturut-turut.</li>
		</ol>
		<h4>PASAL 14<br/>PENYELESAIAN PERSELISIHAN/ KESALAH -<br/>PAHAMAN/ PENGERTIAN</h4>
		<ol>
			<li>Bila timbul salah pengertian dalam penerapan dari pasal-pasal perjanjian kerja ini oleh kedua belah pihak, tidak dibenarkan adanya tindakan yang dilakukan oleh salah satu pihak yang mengakibatkan kerugian pihak lain.</li>
			<li>Bila salah pengertian tersebut di atas tidak dapat diselesaikan oleh kedua belah pihak secara musyawarah, maka persoalannya akan diajukan kepada yang berwenang dalam hal ini Suku Dinas Tenaga Kerja dan Transmigrasi atau Kementerian Tenaga Kerja dan Transmigrasi.</li>
		</ol>
		<h4>PASAL 15<br/>PENUTUP</h4>
		<ol>
			<li>Demikian  Perjanjian  ini dibuat dan setelah dibaca dan dimengerti isinya, masing-masing PIHAK menandatanganinya dalam keadaan sehat jasmani maupun rohani, dan tanpa ada sedikitpun paksaan dari pihak manapun juga.</li>
			<li>Perjanjian Kerja ini dibuat rangkap 2(dua), dan masing-masing rangkapnya memiliki kekuatan hukum yang sama.</li>
			<li>Perjanjian Kerja ini dapat sewaktu-waktu dirubah atas persetujuan kedua belah PIHAK dan akan di tuangkan dalam Aturan Tambahan dan Aturan Peralihan dari  Perjanjian Kerja Waktu Tertentu ini serta memiliki kekuatan Hukum yang sama.</li>
			<li>Perjanjian Kerja ini mulai berlaku sesuai dengan masa berlaku dan sebagainya seperti yang telah diatur dalam Pasal 13 ayat 1 Perjanjian Kerja ini, dan/ atau sesuai dengan tanggal ditanda tanganinya Perjanjian Kerja ini. </li>
			<li>PIHAK PERTAMA dan atau PIHAK KEDUA tidak terikat pada janji lisan maupun tulisan yang diberikan oleh siapapun, kecuali yang tercantum di dalam ikatan Perjanjian Kerja ini.</li>
		</ol>
		<br/><br/><br/><br/><br/><br/><br/>
		<table style="width:100%;" cellpadding="0" cellspacing="0">
			<tr><td colspan="3" style="text-align: center">Dibuat di Jakarta, Pada hari <?=$employee['created_at']?></td></tr>
			<tr>
				<td style="width:200px;"><strong>Pihak Pertama</strong></td>
				<td>&nbsp;</td>
				<td style="width:200px;"><strong>Pihak Kedua</strong></td>
			</tr>
			<tr>
				<td style="height:120px;">
					
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
                <td><span style="text-decoration:underline;"><strong>HEKSI MULIYAMIN</strong></span><br/><span><strong>HR & PERSONNEL MANAGER</strong></span></td>
				<td>&nbsp;</td>
				<td><span style="text-decoration:underline;"><strong><?=$employee['fullname']?></strong></span></td>
			</tr>
			<tr>
				<td colspan=3 align="right"><?=$employee['project_name']?></td>
			</tr>
		</table>
		<br/>
		<p style="text-align:center;">6</p>
	</section>
</body>
</html>