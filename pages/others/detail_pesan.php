<?php
/**
 * Created by PhpStorm.
 * User: bvrhan
 * Date: 16/06/16
 * Time: 23:23
 */

$id = cleanchar($_GET['id']);
$q = db_read("select * from kritik_saran where id_ks='$id' limit 1");
?>

<table class="table">
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td><?php echo $q[0]['nama']?></td>
    </tr>
    <tr>
        <td>E-mail</td>
        <td>:</td>
        <td><a href="mailto:<?php echo $q[0]['email']; ?>"><?php echo $q[0]['email']; ?></a></td>
    </tr>
    <tr>
        <td>Waktu</td>
        <td>:</td>
        <td><?php echo $q[0]['waktu']; ?></td>
    </tr>
    <tr>
        <td>Pesan</td>
        <td>:</td>
        <td><?php echo $q[0]['pesan']; ?></td>
    </tr>
</table>


