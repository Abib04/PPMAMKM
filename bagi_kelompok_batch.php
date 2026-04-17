<?php 
session_start();

function konek_db()
{
  // query ambil mahasiswa terkonfirmasi
//   $servername = "localhost";
//   $username = "root";
//   $password = "";
//   $dbname = "ppm_2023";

            $servername = "localhost";
            $username = "ppm_2020";
            $password = "";
            $dbname = "ppm_2020";

            // $servername = "localhost";
            // $username = "root";
            // $password = "";
            // $dbname = "ppm_2020";

            // Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  } else {
    return $conn;
  }
}

if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")){   

  $conn = konek_db();   

  $id_thn = get_id_active_year();

  // var_dump($id_thn);

    // diambil yang nim depannya 25. Untuk mahasiswa ngulang dan "khusus" ada mentor tersendiri
//   $sql = "SELECT mahasiswa.*, potensi.id_potensi FROM mahasiswa JOIN potensi ON potensi.npm = mahasiswa.npm WHERE mahasiswa.id_thn = '$id_thn' AND mahasiswa.konfirmasi = 'Y' AND id_kelompok is NULL AND LEFT(mahasiswa.npm, 2) = '25' GROUP BY potensi.npm ORDER BY rand()";
    $sql = "SELECT mahasiswa.*, potensi.id_potensi FROM mahasiswa JOIN potensi ON potensi.npm = mahasiswa.npm WHERE mahasiswa.id_thn = '$id_thn' AND mahasiswa.konfirmasi = 'Y' AND id_kelompok is NULL GROUP BY potensi.npm ORDER BY rand()";
  $result = mysqli_query($conn, $sql);

  $gagal = 0;

  if (mysqli_num_rows($result) > 0) {
              // output data of each row
    $no = 1;
    $urut_kel = 1;
    while($row = mysqli_fetch_assoc($result)) {
      $nim = $row["npm"];
      $id_kelompok = get_kelompok();

      $sql_update = "UPDATE mahasiswa SET id_kelompok = $id_kelompok WHERE npm = '$nim'";

      if ($conn->query($sql_update) !== TRUE) {
        $gagal++;
      }     

      echo $no.'. ~ '.$urut_kel.' #ID_KEL : '.$id_kelompok.' - '.$nim.'<br/>';
      $no++;
      $urut_kel++;

      if ($no % 60 == 0 ) {
        $urut_kel = 1;
      }
    }
  } else {
    echo "0 results";
  }

  mysqli_close($conn);



  if($gagal == 0){
    echo "Sukses Semua";
  }  else {
   echo 'Ada '.$gagal.' Yang Gagal !';
 }


} else {
  echo "<script>
  alert('Anda tidak diperkenankan melakukan aksi ini.');
  </script>";
}


function get_id_active_year(){
  if(!array_key_exists('active_thn',$_SESSION)){
    $year = db_read("select id_thn from tahun where status='Y'");
    if(count($year) > 0){
      $_SESSION['active_thn'] = $year[0]['id_thn'];
    }
  }
  return $_SESSION['active_thn'];
}

function get_kelompok(){
    $id_kelompok = get_least_kelompok(get_least_kloter());
    return $id_kelompok;
}

function get_least_kelompok($id_kloter){
    //kel by bagi kloter
    //$kelompok = db_read("SELECT id as last from kelompok left join mahasiswa on kelompok.id = mahasiswa.id_kelompok where kelompok.id_kloter = $id_kloter GROUP by kelompok.id ORDER BY count(mahasiswa.npm) asc limit 1");
    
    $maks_anggota = 40; // nanti bisa dirubah ke 45 kalau peserta diatas 1400
    //kel hanya 1 kloter
    $sql = "SELECT id as last, count(mahasiswa.npm) as jml from kelompok left join mahasiswa on kelompok.id = mahasiswa.id_kelompok where `id_kloter`=$id_kloter GROUP by kelompok.id having jml<$maks_anggota ORDER BY count(mahasiswa.npm) desc, id asc limit 1";

    $kelompok = db_read($sql);

    // var_dump($sql);
    if($kelompok >= 0){
        return $kelompok[0]['last'];
    }
}

function get_least_kloter(){
    // $kloter = db_read("SELECT kloter.id as last from kloter left join kelompok on kloter.id=kelompok.id_kloter left join mahasiswa on kelompok.id = mahasiswa.id_kelompok GROUP by kloter.id ORDER BY count(mahasiswa.npm) asc limit 1");


    $kloter = db_read("SELECT kloter.id as last from kloter left join kelompok on kloter.id=kelompok.id_kloter left join mahasiswa on kelompok.id = mahasiswa.id_kelompok WHERE kloter.id_thn='".get_id_active_year()."' GROUP by kloter.id ORDER BY count(mahasiswa.npm) asc LIMIT 1");
    return $kloter[0]['last'];
}

function db_read($query){

    $conn = konek_db();  

    if(!is_null($query)){

        mysqli_set_charset($conn, "utf8");

        $sql = mysqli_query($conn, $query);

        $buffer = array();

        while($row = mysqli_fetch_assoc($sql)){

            $buffer[] = $row;

        }  

        return $buffer;

    }

}

?>
