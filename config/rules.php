<?php

$rules = array(
    
    "act_login" => base_url("login.php"),
    "act_logout" => base_url("logout.php"),
    
    //Acara Action
    "act_insert_acara" => base_url("data.php?module=mod_acara&t=acara&op=create&token=".$_SESSION['token']),
    "act_delete_acara" => base_url("data.php?module=mod_acara&t=acara&op=delete&token=".$_SESSION['token']),
    "act_read_acara" => base_url("data.php?module=mod_acara&t=acara&op=read&token=".$_SESSION['token']),
    "act_update_acara" => base_url("data.php?module=mod_acara&t=acara&op=update&token=".$_SESSION['token']),
	"act_read_acara_thn" =>base_url("data.php?module=mod_acara&op=reads&token=".$_SESSION['token']),
	"act_div_jadwal" => base_url("data.php?module=mod_div_room_sesi&op=div&token=".$_SESSION['token']),
    "act_jadwal_reset" =>  base_url("data.php?module=mod_div_room_sesi&op=reset&token=".$_SESSION['token']),
    "act_insert_acara_tahun" => base_url("data.php?module=mod_acara&t=acara_tahun&op=create&token=".$_SESSION['token']),
    "act_delete_acara_tahun" => base_url("data.php?module=mod_acara&t=acara_tahun&op=delete&token=".$_SESSION['token']),
    "act_read_acara_tahun" => base_url("data.php?module=mod_acara&t=acara_tahun&op=read&token=".$_SESSION['token']),
    "act_update_acara_tahun" => base_url("data.php?module=mod_acara&t=acara_tahun&op=update&token=".$_SESSION['token']),
    "act_read_jam" => base_url("data.php?module=mod_acara&op=read_jam_oh&token=".$_SESSION['token']),
    "act_read_sesi_oh" => base_url("data.php?module=mod_acara&op=read_sesi_oh&token=".$_SESSION['token']),
    "act_read_sesi_oh_mn" => base_url("data.php?module=mod_acara&op=read_sesi_oh_mn&token=".$_SESSION['token']),
//Admin Action
    "act_insert_admin" => base_url("data.php?module=mod_admin&op=create&token=".$_SESSION['token']),
    "act_delete_admin" => base_url("data.php?module=mod_admin&op=delete&token=".$_SESSION['token']),
    "act_read_admin" => base_url("data.php?module=mod_admin&op=read&token=".$_SESSION['token']),
    "act_update_admin" => base_url("data.php?module=mod_admin&op=update&token=".$_SESSION['token']),
    
    

    //Agama Action
    "act_insert_agama" => base_url("data.php?module=mod_agama&op=create&token=".$_SESSION['token']),
    "act_delete_agama" => base_url("data.php?module=mod_agama&op=delete&token=".$_SESSION['token']),
    "act_read_agama" => base_url("data.php?module=mod_agama&op=read&token=".$_SESSION['token']),
    "act_update_agama" => base_url("data.php?module=mod_agama&op=update&token=".$_SESSION['token']),
    
    //Prestasi Action
    "act_insert_prestasi" => base_url('data.php?module=mod_prestasi&op=create&token='.$_SESSION['token']),
    "act_delete_prestasi" => base_url('data.php?module=mod_prestasi&op=delete&token='.$_SESSION['token']),
    "act_read_prestasi" => base_url('data.php?module=mod_prestasi&op=read&token='.$_SESSION['token']),
    "act_update_prestasi" => base_url('data.php?module=mod_prestasi&op=update&token='.$_SESSION['token']),
    
    //Potensi Action (Created Mei 2022)
    "act_insert_potensi" => base_url('data.php?module=mod_potensi&op=create&token='.$_SESSION['token']),
    "act_delete_potensi" => base_url('data.php?module=mod_potensi&op=delete&token='.$_SESSION['token']),
    "act_read_potensi" => base_url('data.php?module=mod_potensi&op=read&token='.$_SESSION['token']),
    "act_update_potensi" => base_url('data.php?module=mod_potensi&op=update&token='.$_SESSION['token']),
    
    //Daerah Action
    "act_insert_daerah" => base_url('data.php?module=mod_daerah&op=create&token='.$_SESSION['token']),
    "act_delete_daerah" => base_url('data.php?module=mod_daerah&op=delete&token='.$_SESSION['token']),
    "act_read_daerah" => base_url('data.php?module=mod_daerah&op=read&token='.$_SESSION['token']),
    "act_update_daerah" => base_url('data.php?module=mod_daerah&op=update&token='.$_SESSION['token']),

    //Fakultas
    "act_insert_fakultas" => base_url('data.php?module=mod_fakultas&op=create&token='.$_SESSION['token']),
    "act_delete_fakultas" => base_url('data.php?module=mod_fakultas&op=delete&token='.$_SESSION['token']),
    "act_read_fakultas" => base_url('data.php?module=mod_fakultas&op=read&token='.$_SESSION['token']),
    "act_update_fakultas" => base_url('data.php?module=mod_fakultas&op=update&token='.$_SESSION['token']),

    //Prodi
    "act_insert_prodi" => base_url('data.php?module=mod_prodi&op=create&token='.$_SESSION['token']),
    "act_delete_prodi" => base_url('data.php?module=mod_prodi&op=delete&token='.$_SESSION['token']),
    "act_read_prodi" => base_url('data.php?module=mod_prodi&op=read&token='.$_SESSION['token']),
    "act_update_prodi" => base_url('data.php?module=mod_prodi&op=update&token='.$_SESSION['token']),

    //sesi kloter
    "act_insert_sesi_kloter" => base_url('data.php?module=mod_sesi_kloter&op=create&token='.$_SESSION['token']),
    "act_delete_sesi_kloter" => base_url('data.php?module=mod_sesi_kloter&op=delete&token='.$_SESSION['token']),
    "act_read_sesi_kloter" => base_url('data.php?module=mod_sesi_kloter&op=read&token='.$_SESSION['token']),
    "act_update_sesi_kloter" => base_url('data.php?module=mod_sesi_kloter&op=update&token='.$_SESSION['token']),
    
    //Kloter
    "act_insert_kloter" => base_url('data.php?module=mod_kloter&op=create&token='.$_SESSION['token']),
    "act_delete_kloter" => base_url('data.php?module=mod_kloter&op=delete&token='.$_SESSION['token']),
    "act_read_kloter" => base_url('data.php?module=mod_kloter&op=read&token='.$_SESSION['token']),
    "act_update_kloter" => base_url('data.php?module=mod_kloter&op=update&token='.$_SESSION['token']),

    //Kelompok
    "act_insert_kelompok" => base_url('data.php?module=mod_kelompok&op=create&token='.$_SESSION['token']),
    "act_delete_kelompok" => base_url('data.php?module=mod_kelompok&op=delete&token='.$_SESSION['token']),
    "act_read_kelompok" => base_url('data.php?module=mod_kelompok&op=read&token='.$_SESSION['token']),
    "act_update_kelompok" => base_url('data.php?module=mod_kelompok&op=update&token='.$_SESSION['token']),

    //Kabupaten Action
    "act_insert_kab" => base_url('data.php?module=mod_kabupaten&op=create&token='.$_SESSION['token']),
    "act_delete_kab" => base_url('data.php?module=mod_kabupaten&op=delete&token='.$_SESSION['token']),
    "act_read_kab" => base_url('data.php?module=mod_kabupaten&op=read&token='.$_SESSION['token']),
    "act_update_kab" => base_url('data.php?module=mod_kabupaten&op=update&token='.$_SESSION['token']),
    
    //Negara Action
    "act_insert_negara" => base_url('data.php?module=mod_negara&op=create&token='.$_SESSION['token']),
    "act_delete_negara" => base_url('data.php?module=mod_negara&op=delete&token='.$_SESSION['token']),
    "act_read_negara" => base_url('data.php?module=mod_negara&op=read&token='.$_SESSION['token']),
    "act_update_negara" => base_url('data.php?module=mod_negara&op=update&token='.$_SESSION['token']),
    
    //Keluarga Action
    "act_insert_klg" => base_url('data.php?module=mod_keluarga&op=create&token='.$_SESSION['token']),
    "act_delete_klg" => base_url('data.php?module=mod_keluarga&op=delete&token='.$_SESSION['token']),
    "act_read_klg" => base_url('data.php?module=mod_keluarga&op=read&token='.$_SESSION['token']),
    "act_update_klg" => base_url('data.php?module=mod_keluarga&op=update&token='.$_SESSION['token']),
    
    //Mahasiswa Action
    "act_insert_mhs" => base_url("data.php?module=mod_mahasiswa&op=create&token=".$_SESSION['token']),
    "act_delete_mhs" => base_url("data.php?module=mod_mahasiswa&op=delete&token=".$_SESSION['token']),
    "act_read_mhs" => base_url("data.php?module=mod_mahasiswa&op=read&token=".$_SESSION['token']),
    "act_read_mhs_jumlah" => base_url("data.php?module=mod_mahasiswa&op=read_sumaries"),
    "act_update_mhs" => base_url("data.php?module=mod_mahasiswa&op=update&token=".$_SESSION['token']),
    "act_conf_mhs" => base_url("data.php?module=mod_mahasiswa&op=conf&token=".$_SESSION['token']),
    "act_reset_pass" => base_url("data.php?module=mod_mahasiswa&op=reset_passwd&token=".$_SESSION['token']),
    "act_kirim_email" => base_url("kirim_email.php"),
    "act_aktifkan_tahun_ini" => base_url("data.php?module=mod_mahasiswa&op=aktifkan_tahun_ini&token=".$_SESSION['token']),

    //Panitia Action
    "act_insert_panitia" => base_url("data.php?module=mod_panitia&op=create&token=".$_SESSION['token']),
    "act_delete_panitia" => base_url("data.php?module=mod_panitia&op=delete&token=".$_SESSION['token']),
    "act_read_panitia" => base_url("data.php?module=mod_panitia&op=read&token=".$_SESSION['token']),
    "act_read_panitia_full" => base_url("data.php?module=mod_panitia&op=read_full_panitia&token=".$_SESSION['token']),
    "act_update_panitia" => base_url("data.php?module=mod_panitia&op=update&token=".$_SESSION['token']),
    
    //Penyakit Action
    "act_insert_penyakit" => base_url("data.php?module=mod_penyakit&op=create&token=".$_SESSION['token']),
    "act_delete_penyakit" => base_url("data.php?module=mod_penyakit&op=delete&token=".$_SESSION['token']),
    "act_read_penyakit" => base_url("data.php?module=mod_penyakit&op=read&token=".$_SESSION['token']),
    "act_update_penyakit" => base_url("data.php?module=mod_penyakit&op=update&token=".$_SESSION['token']),
    
    //Tahun Action
    "act_insert_thn" => base_url("data.php?module=mod_tahun&op=create&token=".$_SESSION['token']),
    "act_delete_thn" => base_url("data.php?module=mod_tahun&op=delete&token=".$_SESSION['token']),
    "act_read_thn" => base_url("data.php?module=mod_tahun&op=read&token=".$_SESSION['token']),
    "act_update_thn" => base_url("data.php?module=mod_tahun&op=update&token=".$_SESSION['token']),
    
    //Ruang Action
    "act_insert_ruang" => base_url("data.php?module=mod_ruang&op=create&token=".$_SESSION['token']),
    "act_delete_ruang" => base_url("data.php?module=mod_ruang&op=delete&token=".$_SESSION['token']),
    "act_read_ruang" => base_url("data.php?module=mod_ruang&op=read&token=".$_SESSION['token']),
    "act_update_ruang" => base_url("data.php?module=mod_ruang&op=update&token=".$_SESSION['token']),
    
    //Sesi Action
    "act_insert_sesi" => base_url("data.php?module=mod_sesi&op=create&token=".$_SESSION['token']),
    "act_insert_sesi_mn" => base_url("data.php?module=mod_sesi_mn&op=create&token=".$_SESSION['token']),
    "act_delete_sesi" => base_url("data.php?module=mod_sesi&op=delete&token=".$_SESSION['token']),
    "act_read_sesi" => base_url("data.php?module=mod_sesi&op=read&token=".$_SESSION['token']),
    "act_update_sesi" => base_url("data.php?module=mod_sesi&op=update&token=".$_SESSION['token']),

    //Div Room Action
    "act_insert_divroom" => base_url("data.php?module=mod_divroom&op=create&token=".$_SESSION['token']),
    "act_delete_divroom" => base_url("data.php?module=mod_divroom&op=delete&token=".$_SESSION['token']),
    "act_read_divroom" => base_url("data.php?module=mod_divroom&op=read&token=".$_SESSION['token']),
    "act_update_divroom" => base_url("data.php?module=mod_divroom&op=update&token=".$_SESSION['token']),

    //Kuisioner Action
    "act_insert_kuisioner" => base_url("data.php?module=mod_kuisioner&op=create&token=".$_SESSION['token']),
    "act_delete_kuisioner" => base_url("data.php?module=mod_kuisioner&op=delete&token=".$_SESSION['token']),
    "act_read_kuisioner" => base_url("data.php?module=mod_kuisioner&op=read&token=".$_SESSION['token']),

    //Others Link
    "reg_mhs" => base_url('media.php?page=reg_mhs'),
    "check_npm" => base_url('module/mod_generic.php?op=check_npm'),
    "home_mhs" => base_url('media.php'),
    "cert" => base_url('media.php?page=cek_cert'),
    "detail_mhs" => base_url('media.php?page=detail_mhs'),
    "info_ppm" => base_url('media.php?page=info_ppm'),
    "kritik_saran" => base_url('media.php?page=kritik_saran'),
    "list_pesan" => base_url('media.php?page=list_pesan'),
    "survey_build" => base_url('media.php?page=survey_build'),
    "faq" => base_url('media.php?page=faq'),
    "pengumuman" => base_url('media.php?page=pengumuman'),
    "notice" => base_url('media.php?page=notice'),
    "binvan" => base_url('media.php?page=binvan'),
    "konfirmasi_aja" => base_url('media.php?page=konfirmasi_npm'),
    "lupa_password" => base_url('media.php?page=lupa_password'),

    //FAQ
    "act_add_faq" => base_url("data.php?module=mod_faq&op=create"),
    "act_del_faq" => base_url("data.php?module=mod_faq&op=delete"),
    
    //Pengumuman
    "act_add_pengumuman" => base_url("data.php?module=mod_pengumuman&op=create"),
    "act_del_pengumuman" => base_url("data.php?module=mod_pengumuman&op=delete"),
    
    //Temporary Storage
    "act_add_temporary_storage" => base_url("data.php?module=mod_temporary_storage&op=create"),
    "act_del_temporary_storage" => base_url("data.php?module=mod_temporary_storage&op=delete"),

    //Admin Link
    "data_mhs" => base_url('media.php?page=data_mhs'),
    "data_mhs_prestasi" => base_url('media.php?page=data_mhs_prestasi'),
    "daftar_ruangan" => base_url('media.php?page=d_ruangan'),
    "daftar_acara" => base_url('media.php?page=d_acara'),
    "daftar_kelompok" => base_url('media.php?page=data_kelompok'),
    "sesi" => base_url('media.php?page=sesi'),
    "data_pendukung" => base_url('media.php?page=data_pendukung'),
    // "login_sbg_mhs" => base_url('media.php?page=login_sbg_mhs'),
    "berita" => base_url('media.php?page=data_mhs'),
    "data_panitia" => base_url('media.php?page=data_panitia'),
    "data_admin" => base_url('media.php?page=data_admin'),
    "peserta_oh" => base_url('media.php?page=peserta_oh'),
    "peserta_om" => base_url('media.php?page=peserta_om'),
    "peserta_pk" => base_url('media.php?page=peserta_pk'),
    "daftar_peserta_acara" => base_url('media.php?page=peserta_acara'),

    //Mahasiswa Link
    "data_mhs_current" => base_url('media.php?page=data_mhs_current'),
    "data_prestasi" => base_url('media.php?page=data_mhs_prestasi'),
    "data_potensi" => base_url('media.php?page=data_mhs_potensi'),
    "data_penyakit" => base_url('media.php?page=data_mhs_penyakit'),
    "data_kel" => base_url('media.php?page=data_mhs_kel'),
    "reg_oh" => base_url('media.php?page=data_mhs_reg_oh'),
    "survey_mhs" => base_url('media.php?page=survey_mhs'),
    "jadwal_acara" => base_url('media.php?page=data_mhs_acara'),

    "ganti_passwd" => base_url('media.php?page=ganti_passwd'),
    "act_change_passwd" => base_url('data.php?module=mod_password&op=update&token='.$_SESSION['token']),

    //Module Data
    "get_kabupaten" => base_url('data.php?module=mod_kabupaten&op=read'),
    "get_provinsi" => base_url('data.php?module=mod_daerah&op=read'),
    "get_potensi_bidang" => base_url('data.php?module=mod_potensi&op=select_jenis')
);
