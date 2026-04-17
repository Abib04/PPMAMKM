<!DOCTYPE html>
<html>
<head>
	<title>
		KEPOOOOOOOOOO
	</title>
</head>
<body>
<?php
include('lib/db_lib.php');

/*
$data = db_read("SELECT npm,hp,nama FROM mahasiswa WHERE jk='perempuan' and id_thn = 10 AND id_prodi = 4"); //
foreach ($data as $key => $value) 
{
    echo '<img src="http://ppm.amikom.ac.id/resource/mahasiswa/foto_mhs/'.$value['npm'].'.jpg" title="'.$value['nama'].'('.$value['npm'].') : '.$value['hp'].'" alt="'.$value['nama'].'('.$value['npm'].')" height="150" width="150"/>';
}
*/
$data2 = db_read("SELECT npm,hp,nama FROM mahasiswa WHERE jk='perempuan' and npm like '16.%'");
foreach ($data2 as $key2 => $value2) 
{
    // echo '<img src="https://fotomhs.amikom.ac.id/2016/'.str_replace('.','_',$value2['npm']).'.jpg" title="'.$value2['nama'].'('.$value2['npm'].') : '.$value2['hp'].'" alt="'.$value2['nama'].'('.$value2['npm'].')" height="150" width="150"/>';
}

echo "<br>================================================================<br>";

?>
<?php
$data4 = db_read("SELECT npm,hp,nama FROM mahasiswa WHERE jk='perempuan' and npm like '17.%'");
foreach ($data4 as $key4 => $value4) 
{
    // echo '<img src="https://fotomhs.amikom.ac.id/2017/'.str_replace('.','_',$value4['npm']).'.jpg" title="'.$value4['nama'].'('.$value4['npm'].') : '.$value4['hp'].'" alt="'.$value4['nama'].'('.$value4['npm'].')" height="150" width="150"/>';
}

echo "<br>================================================================<br>";

$data1 = db_read("SELECT npm,hp,nama FROM mahasiswa WHERE jk='perempuan' and npm like '18.%'");
foreach ($data1 as $key1 => $value1) 
{
    // echo '<img src="https://fotomhs.amikom.ac.id/2018/'.str_replace('.','_',$value1['npm']).'.jpg" title="'.$value1['nama'].'('.$value1['npm'].') : '.$value1['hp'].'" alt="'.$value1['nama'].'('.$value1['npm'].')" height="150" width="150"/>';
}

echo "<br>================================================================<br>";

$data3 = db_read("SELECT npm,hp,nama FROM mahasiswa WHERE jk='perempuan' and npm like '19.%'");
foreach ($data3 as $key3 => $value3) 
{
    // echo '<img src="https://fotomhs.amikom.ac.id/2019/'.str_replace('.','_',$value3['npm']).'.jpg" title="'.$value3['nama'].'('.$value3['npm'].') : '.$value3['hp'].'" alt="'.$value3['nama'].'('.$value3['npm'].')" height="150" width="150"/>';
}

echo "<br>================================================================<br>";

$data3 = db_read("SELECT npm,hp,nama FROM mahasiswa WHERE jk='perempuan' and npm like '20.%'");
foreach ($data3 as $key3 => $value3) 
{
    // echo '<img src="https://fotomhs.amikom.ac.id/2020/'.str_replace('.','_',$value3['npm']).'.jpg" title="'.$value3['nama'].'('.$value3['npm'].') : '.$value3['hp'].'" alt="'.$value3['nama'].'('.$value3['npm'].')" height="150" width="150"/>';
}

echo "<br>================================================================<br>";

$data3 = db_read("SELECT npm,hp,nama FROM mahasiswa WHERE jk='perempuan' and npm like '21.%'");
foreach ($data3 as $key3 => $value3) 
{
    // echo '<img src="https://fotomhs.amikom.ac.id/2021/'.str_replace('.','_',$value3['npm']).'.jpg" title="'.$value3['nama'].'('.$value3['npm'].') : '.$value3['hp'].'" alt="'.$value3['nama'].'('.$value3['npm'].')" height="150"/>';
}

echo "<br>================================================================<br>";

$data3 = db_read("SELECT npm,hp,nama FROM mahasiswa WHERE jk='perempuan' and npm like '22.%'");
foreach ($data3 as $key3 => $value3) 
{
    // echo '<img src="https://fotomhs.amikom.ac.id/2022/'.str_replace('.','_',$value3['npm']).'.jpg" title="'.$value3['nama'].'('.$value3['npm'].') : '.$value3['hp'].'" alt="'.$value3['nama'].'('.$value3['npm'].')" height="150"/>';
}

echo "<br>================================================================<br>";

$data3 = db_read("SELECT npm,hp,nama FROM mahasiswa WHERE jk='perempuan' and npm like '23.%'");
foreach ($data3 as $key3 => $value3) 
{
    // echo '<img src="https://fotomhs.amikom.ac.id/2023/'.str_replace('.','_',$value3['npm']).'.jpg" title="'.$value3['nama'].'('.$value3['npm'].') : '.$value3['hp'].'" alt="'.$value3['nama'].'('.$value3['npm'].')" height="150"/>';
}

echo "<br>================================================================<br>";

$data3 = db_read("SELECT npm,hp,nama FROM mahasiswa WHERE jk='perempuan' and npm like '24.%'");
foreach ($data3 as $key3 => $value3) 
{
    // echo '<img src="https://fotomhs.amikom.ac.id/2024/'.str_replace('.','_',$value3['npm']).'.jpg" title="'.$value3['nama'].'('.$value3['npm'].') : '.$value3['hp'].'" alt="'.$value3['nama'].'('.$value3['npm'].')" height="150"/>';
}
?>
</body>
</html>
