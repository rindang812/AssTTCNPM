<?php
    include('../include/mysql_connect.php');
    for ($i=1;$i<=1002;$i++)
    {
        $query="SELECT password from tbluser where id='$i'";
        $result=mysqli_query($dbc,$query) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
        list($password)=mysqli_fetch_array($result);
        $password=md5($password);
        $query2="UPDATE tbluser set password='$password' where id='$i'";
        $result2=mysqli_query($dbc,$query2) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));

    }




?>