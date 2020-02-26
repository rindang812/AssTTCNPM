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
        $message="<p style='color:green;'>Xóa thông báo thành công</p>";
        $_GET['flag']=0;
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Xem thông báo</title>
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

                        <a href="./student-xemmondadangki.php" class="list-group-item list-group-item-action  ">Xem môn đã
                            đăng kí</a>
                        <a href="./student-xemdiem.php" class="list-group-item list-group-item-action ">Xem điểm</a>
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
                            <a href="#" class="list-group-item list-group-item-action active dropdown-toggle"
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
                        
                            <h3>Thông báo</h3>
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
                                    <th>Số thứ tự</th>
                                    
                                    <th>Người gửi</th>
                                    <th>Thông báo</th>
                                    <th>Phản hồi </th>
                                    <th>Xóa </th>

                                </tr>


                            </thead>
                            <tbody>
                               <?php
                                    $idnguoinhan=$_SESSION['taikhoan'];
                                    $query="SELECT id,idnguoigui,tennguoigui,thongbao from tblthongbao where idnguoinhan='$idnguoinhan'";
                                    $result=mysqli_query($dbc,$query) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
                                    $sothutu=1;
                                    while($records=mysqli_fetch_array($result))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $sothutu;  ?></td>
                                            <td><?php echo $records['tennguoigui']; ?></td>
                                            <td><?php echo $records['thongbao']; ?></td>
                                            <td><a href="./student-xuliphanhoithongbao.php?idnguoinhan=<?php echo $records['idnguoigui']."&tennguoinhan=".$records['tennguoigui']; ?>"><img width="30px;" src="../images/icon_phanhoi.png" alt=""></a></td>
                                            <td><a onclick="return confirm('Bạn muốn xóa thông báo này?');" href="./student-xulixoathongbao.php?id=<?php echo $records['id']; ?>"><img width="30px;" src="../images/icon_huy.png" alt=""></a></td>
                                        </tr>
                                        <?php
                                        $sothutu+=1;
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