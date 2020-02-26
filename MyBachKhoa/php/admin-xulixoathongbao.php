<?php
    session_start();
    include('../include/mysql_connect.php');
    if (isset($_GET['id']))
    {
        $id=$_GET['id'];
        $query="DELETE from tblthongbao where id='$id'";
        $result=mysqli_query($dbc,$query) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
        if (mysqli_affected_rows($dbc)==1)
        {
            header('Location: admin-xemthongbao.php?flag=1');
        }
        
        
        
    }
    else
    {
        header('Location: admin-xemthongbao.php');
    }


?>