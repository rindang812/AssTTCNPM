<?php
    session_start();
    error_reporting(0);
    include ('../include/mysql_connect.php');
    include('../include/header.php');
    if (!isset($_SESSION['id']))
    {
        header('Location: dangnhap.php');
    }
    if(isset($_GET['idnguoinhan']) && isset($_GET['tennguoinhan']))
    {
        $idnguoinhan=$_GET['idnguoinhan'];
        $tennguoinhan=$_GET['tennguoinhan'];
        $idnguoigui=$_SESSION['taikhoan'];
       
    }
    else
    {
        header ('Location: ./student-xemthongbao.php');
    }
    if(isset($_POST['submit']))
    {
        $errors=array();
        if(empty($_POST['thongbao']))
        {
            $errors[]='thongbao';
        }
        else{
            $thongbao=$_POST['thongbao'];
        }
        if (empty($errors))
        {
            $query="SELECT hoten from tblinfo where user='$idnguoigui'";
            $result=mysqli_query($dbc,$query) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
            list($tennguoigui)=mysqli_fetch_array($result);
            $query2="INSERT INTO tblthongbao(idnguoigui,tennguoigui,idnguoinhan,tennguoinhan,thongbao)
                        values ('$idnguoigui','$tennguoigui','$idnguoinhan','$tennguoinhan','$thongbao')";
            $result2=mysqli_query($dbc,$query2) or die ("Query: $query2 \n <br> Mysql_error: ".mysqli_error($dbc));
            if (mysqli_affected_rows($dbc)==1)
            {
                $message = "<p style='color:green;'>Gửi thông báo thành công</p>";
            }
            else
            {
                $message="<p class='required'>Gửi thông báo thất bại</p>";
            }
            

        }
       

    }
    
    
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Phản hồi thông báo</title>
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

                        <a href="./student-xemmondadangki.php" class="list-group-item list-group-item-action  ">Xem môn
                            đã
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
                                <li><a href="./student-xemthongbao.php">Xem thông báo</a>
                                </li>
                                <li><a href="./student-guithongbao.php">Gửi thông báo</a>
                                </li>
                            </ul>

                        </div>
                        <a href="./dangxuat.php" class="list-group-item list-group-item-action">Đăng xuất</a>

                    </div>
                </div>

                <div class="col-md-10">
                    <div class="form">
                        <form method="POST">
                            <h3>Phản hồi thông báo</h3>
                            <?php
                        if(isset($message))
                        {
                            echo $message;
                        }
                            ?>
                            <div class="form-group">
                                <label for="">Nhập thông báo: </label>
                                <textarea name="thongbao" placeholder="Nhập thông báo ..." class="form-control" rows="5"></textarea>
                                <?php
                                if(isset($errors) && in_array('thongbao',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập thông báo</p>";
                                }
                            ?>
                            </div>



                            <button name="submit" type="submit" class="btn btn-primary">Gửi</button>
                        </form>
                    </div>


                   


                </div>


            </div>






        </div>



</body>
<?php
    include('../include/footer.php');
?>

</html>