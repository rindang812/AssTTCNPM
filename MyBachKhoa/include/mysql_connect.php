<?php
    $dbc=mysqli_connect('localhost','root','','mybachkhoa');
    if ($dbc==NULL)
    {
        echo "<p class='required'>Kết nối không thành công</p>";
    }
    else{
        mysqli_set_charset($dbc,'utf8');
    }
?>