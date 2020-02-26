<?php
    session_start();
    include ('../include/mysql_connect.php');
    include('../include/header.php');
    if (!isset($_SESSION['id']))
    {
        header('Location: dangnhap.php');
    }
    
    
    if (isset($_POST['submit']))
    {
        $errors=array();
       
        if (empty($_POST['matkhaucu']))
        {
            $errors[]='matkhaucu';
        }
        else{
            $matkhaucu=md5($_POST['matkhaucu']);
        }
        if (empty($_POST['matkhaumoi']))
        {
            $errors[]='matkhaumoi';
        }
        else{
            $matkhaumoi=md5($_POST['matkhaumoi']);
        }
        if (empty($_POST['xacnhanmatkhau']))
        {
            $errors[]='xacnhanmatkhau';
        }
        else{
            $xacnhanmatkhau=md5($_POST['xacnhanmatkhau']);
        }
        if (empty($errors))
        {
            $taikhoan=$_SESSION['taikhoan'];
            $query="SELECT password from tbluser where user='$taikhoan' and password='$matkhaucu'";
            $result=mysqli_query($dbc,$query) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
            if (mysqli_num_rows($result)==1)
            {
                if ($matkhaumoi==$xacnhanmatkhau)
                {
                    $query2="UPDATE tbluser SET password='$matkhaumoi' where user='$taikhoan'";
                    $result2=mysqli_query($dbc,$query2) or die ("Query: $query2 \n <br> Mysql_error: ".mysqli_error($dbc));
                    if (mysqli_affected_rows($dbc)==1)
                    {
                        $message="<p style='color:green;'>Đổi mật khẩu thành công</p>";
                        $_POST['matkhaucu']='';
                        $_POST['matkhaumoi']='';
                        $_POST['xacnhanmatkhau']='';
                    }
                    else
                    {
                        $message="<p class='required'>Đổi mật khẩu thất bại</p>";
                    }
                }
                else
                {
                    $message="<p class='required'>Mật khẩu không trùng nhau!</p>";
                    $_POST['matkhaumoi']='';
                    $_POST['xacnhanmatkhau']='';
                }
            }
            else
            {
                $message ="<p class='required'>Mật khẩu cũ không đúng. Vui lòng kiểm tra lại!</p>";
                $_POST['matkhaucu']='';
            }
            
            
        }
        
    }



?>



<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đổi mật khẩu</title>
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
                        <a href="./main_student.php" class="list-group-item list-group-item-action ">Xin chào: <?php if (isset($_SESSION['taikhoan'])) echo $_SESSION['taikhoan'] ; ?> </a>
                        <a href="./student-dangkimonhoc.php" class="list-group-item list-group-item-action">Đăng kí môn học</a>
                  
                        <a href="./student-xemmondadangki.php" class="list-group-item list-group-item-action">Xem môn đã đăng kí</a>
                        <a href="./student-xemdiem.php" class="list-group-item list-group-item-action">Xem điểm</a>
                        <div class="dropdown">
                            <a href="#" class="list-group-item list-group-item-action active dropdown-toggle"
                                data-toggle="dropdown">
                                Quản lí tài khoản <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu ">
                                <li><a  href="./student-suathongtincanhan.php">Sửa thông tin cá nhân</a>
                                </li>
                                <li ><a  href="./student-doimatkhau.php">Đổi mật khẩu</a>
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
                    <div class="align">
                        <form method="POST">
                            <h3>Đổi mật khẩu</h3>
                            <?php
                        if(isset($message))
                        {
                            echo $message;
                        }
                            ?>
                            <div class="form-group">
                                <label for="">Mật khẩu cũ</label>
                                <input value="<?php if(isset($_POST['matkhaucu'])) echo $_POST['matkhaucu'] ; ?>"
                                    name="matkhaucu" type="password" class="form-control" placeholder="Mật khẩu cũ">
                                <?php
                                if(isset($errors) && in_array('matkhaucu',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập mật khẩu cũ</p>";
                                }
                            ?>
                            </div>
                            
                            <div class="form-group">
                                <label for="">Mật khẩu mới</label>
                                <input value="<?php if(isset($_POST['matkhaumoi'])) echo $_POST['matkhaumoi'] ; ?>"
                                    name="matkhaumoi" type="password" class="form-control" placeholder="Mật khẩu mới">
                                <?php
                                if(isset($errors) && in_array('matkhaumoi',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập mật khẩu mới</p>";
                                }
                            ?>
                            </div>
                            <div class="form-group">
                                <label for="">Xác nhận mật khẩu</label>
                                <input
                                    value="<?php if(isset($_POST['xacnhanmatkhau'])) echo $_POST['xacnhanmatkhau'] ; ?>"
                                    name="xacnhanmatkhau" type="password" class="form-control"
                                    placeholder="Xác nhận mật khẩu">
                                <?php
                                if(isset($errors) && in_array('xacnhanmatkhau',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa xác nhận mật khẩu</p>";
                                }
                            ?>
                            </div>

                            <button name="submit" type="submit" class="btn btn-primary">Xác nhận</button>
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