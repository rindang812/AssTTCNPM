<?php
    session_start();
    include('../include/mysql_connect.php');
    if (isset($_GET['idmonhoc']) && isset($_GET['idgiangvien']))
    {
        $idmonhoc=$_GET['idmonhoc'];
        $idgiangvien=$_GET['idgiangvien'];
        $idsinhvien=$_SESSION['taikhoan'];
        $query3="SELECT count(id) from tblbangdiem where idmonhoc='$idmonhoc' and userteacher='$idgiangvien'
        and userstudent='$idsinhvien' and diem!='-1'";
        $result3=mysqli_query($dbc,$query3) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
        list($count)=mysqli_fetch_array($result3);
        if ($count!=0)
        {
            header ('Location: ./student-xemmondadangki.php?flag=1');
        }
        else
        {
            $query="SELECT soluongchodadangki from tblmonhoc where idmonhoc='$idmonhoc' and userteacher='$idgiangvien'";
            $result=mysqli_query($dbc,$query) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
            list($soluongchodadangki)=mysqli_fetch_array($result);
            $soluongchodadangki-=1;
            $query2="UPDATE tblmonhoc set soluongchodadangki='$soluongchodadangki' where idmonhoc='$idmonhoc' and userteacher='$idgiangvien'";
            $result2=mysqli_query($dbc,$query2) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
            $query4="DELETE FROM tblbangdiem where idmonhoc='$idmonhoc' and userstudent='$idsinhvien' and userteacher='$idgiangvien'";
            $result4=mysqli_query($dbc,$query4) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
            if (mysqli_affected_rows($dbc)==1)
            {
                header ('Location: ./student-xemmondadangki.php?check=1');
            }
            
        }
       
    }
    else
    {
        header ('Location: ./student-xemmondadangki.php');
    }

?>