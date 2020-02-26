<?php
    session_start();
    error_reporting(0);
    if (!isset($_SESSION['id']))
    {
        header('Location: dangnhap.php');
    }
    include('../include/header.php');
    include('../include/mysql_connect.php');
    if (isset($_GET['flag']) && $_GET['flag']==1)
    {
        $message="<p class='required'>Môn này đã có điểm không thể hủy được!</p>";
        $_GET['flag']=0;
    }
    if (isset($_GET['check']) && $_GET['check']==1)
    {
        $message="<p style='color:green;'>Hủy môn học thành công!</p>";
        $_GET['check']=0;
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Xem môn đã đăng kí</title>
    <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
    <script src="../jquery_321/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="../bootstrap-3.3.7-dist/js/bootstrap.js"></script>

    <link rel="stylesheet" href="../css/trangchu.css">
    <link rel="stylesheet" href="../css/admin.css">
    <style>
    .required {
        color: red;
    }
    </style>
</head>

<body>
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">


                    <div class="list-group">
                        <a href="./main_student.php" class="list-group-item list-group-item-action ">Xin chào:
                            <?php if (isset($_SESSION['taikhoan'])) echo $_SESSION['taikhoan'] ; ?> </a>
                        <a href="./student-dangkimonhoc.php" class="list-group-item list-group-item-action">Đăng
                            kí môn học</a>

                        <a href="./student-xemmondadangki.php" class="list-group-item list-group-item-action  active">Xem môn đã
                            đăng kí</a>
                        <a href="./student-xemdiem.php" class="list-group-item list-group-item-action">Xem điểm</a>
                        <div class="dropdown">
                            <a href="#" class="list-group-item list-group-item-action dropdown-toggle"
                                data-toggle="dropdown">
                                Quản lí tài khoản <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu ">
                                <li><a href="./student-suathongtincanhan.php">Sửa thông tin cá nhân</a>
                                </li>
                                <li><a href="./student-doimatkhau.php">Đổi mật khẩu</a>
                                </li>
                            </ul>

                        </div>
                        <div class="dropdown">
                            <a href="#" class="list-group-item list-group-item-action dropdown-toggle"
                                data-toggle="dropdown">
                                Thông báo <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu ">
                                <li><a  href="./student-xemthongbao.php">Xem thông báo</a>
                                </li>
                                <li ><a  href="./student-guithongbao.php">Gửi thông báo</a>
                                </li>
                            </ul>

                        </div>
                        <a href="./dangxuat.php" class="list-group-item list-group-item-action">Đăng xuất</a>

                    </div>
                </div>

                <div class="col-md-10">
                    <div class="form">
                        
                            <h3>Các môn đã đăng kí</h3>
                            <?php
                             if (isset($message))
                             {
                                 echo $message;
                             }
                            ?>
                           
                       
                    </div>


                    <div class="form">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID môn học</th>
                                    <th>Tên giảng viên</th>
                                    <th>Tên môn học</th>
                                    <th>Số tín chỉ</th>
                                   
                                    <th>Hủy môn</th>

                                </tr>


                            </thead>
                            <tbody>
                                <?php
                               $idsinhvien=$_SESSION['taikhoan'];
                               $query="SELECT count(id) from tblbangdiem where userstudent='$idsinhvien'";
                               $result=mysqli_query($dbc,$query) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
                               list($count)=mysqli_fetch_array($result);
                               $query3="SELECT idmonhoc,userteacher from tblbangdiem where userstudent='$idsinhvien'";
                                $result3=mysqli_query($dbc,$query3) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
                               for($i=0;$i<$count;$i++)
                               {
                                    list($idmons[$i],$idteachers[$i])=mysqli_fetch_array($result3);
                                }
                                for ($i=0;$i<$count;$i++)
                                {
                                    $querys[$i]="SELECT idmonhoc,tenmonhoc,sotinchi from tblmonhoc where idmonhoc='$idmons[$i]' and userteacher='$idteachers[$i]'";
                                    $results[$i]=mysqli_query($dbc,$querys[$i]) or die ("Query: $querys[$i] \n <br> Mysql_error: ".mysqli_error($dbc));
                                    list($idmon[$i],$tenmon[$i],$sotin[$i])=mysqli_fetch_array($results[$i]);
                                }
                                
                                
                                $i=0;

                            while($idmon[$i] && $tenmon[$i] && $sotin[$i])
                            {
                                
                                $query2="SELECT hoten from tblinfo where user='$idteachers[$i]'";
                                $result2=mysqli_query($dbc,$query2) or die ("Query: $query2 \n <br> Mysql_error: ".mysqli_error($dbc));
                                list($tengiangvien)=mysqli_fetch_array($result2);
                            
                            ?>
                                <tr>
                                    <td><?php echo $idmon[$i];  ?></td>
                                    <td><?php echo $tengiangvien;  ?></td>
                                    <td><?php echo $tenmon[$i] ;  ?></td>
                                   
                                    <td align="center"><?php echo $sotin[$i] ;  ?></td>
                                    <div>
                                    <td ><a onclick="return confirm('Bạn có chắc chắn muốn xóa môn này không?')" href="./student-xulihuymon.php?idmonhoc=<?php echo $idmons[$i]."&idgiangvien=".$idteachers[$i]; ?>"><img  width="25px;" src="../images/icon_huy.png" alt=""></a></td>
                                    </div>
                                    
                                   
                                   
                                   


                                </tr>
                                <?php
                                $i++;
                                }
                                ?>
                                
                                





                            </tbody>

                        </table>


                    </div>






                </div>



            </div>






        </div>


</body>
<?php
    include('../include/footer.php');
?>

</html>