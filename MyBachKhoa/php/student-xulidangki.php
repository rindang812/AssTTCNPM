<?php
    session_start();
    include('../include/mysql_connect.php');
    if (isset($_GET['idmonhoc']) && isset($_GET['idgiangvien']))
    {
        $idmonhoc=$_GET['idmonhoc'];
        $idsinhvien=$_SESSION['taikhoan'];
        $idgiangvien=$_GET['idgiangvien'];
        $soluongchodadangki=$_GET['soluongchodadangki'];
        $soluongchodadangki+=1;
        $query2="SELECT * from tblbangdiem where idmonhoc='$idmonhoc' and userteacher='$idgiangvien' and userstudent='$idsinhvien'";
        $result2=mysqli_query($dbc,$query2) or die ("Query: $query2 \n <br> Mysql_error: ".mysqli_error($dbc));
        if (mysqli_num_rows($result2)==1)
        {
            
            header('Location: ./student-dangkimonhoc.php?flag=1');
        }
        else{
           
            $query="UPDATE tblmonhoc set soluongchodadangki='$soluongchodadangki'
            where idmonhoc='$idmonhoc' and userteacher='$idgiangvien'";
            $result=mysqli_query($dbc,$query) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
            $diem=-1;
            $query3="INSERT INTO tblbangdiem(idmonhoc,userstudent,userteacher,diem) values ('$idmonhoc','$idsinhvien','$idgiangvien','$diem')";
            $result3=mysqli_query($dbc,$query3) or die ("Query: $query3 \n <br> Mysql_error: ".mysqli_error($dbc));
            if (mysqli_affected_rows($dbc)==1)
            {
                header('Location: ./student-dangkimonhoc.php?check=1');
            }
            

        }



        

        

    }
    else
    {
        header ('Location: ./student-dangkimonhoc.php');
    }


?>