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
        if (empty($_POST['taikhoan']))
        {
            $errors[]='taikhoan';
        }
        else{
            $taikhoan=$_POST['taikhoan'];
        }
        if (empty($_POST['hoten']))
        {
            $errors[]='hoten';
        }
        else{
            $hoten=$_POST['hoten'];
        }
        if (empty($_POST['ngaysinh']))
        {
            $errors[]='ngaysinh';
        }
        else{
            $ngaysinh=$_POST['ngaysinh'];
        }
        if (empty($_POST['dienthoai']))
        {
            $errors[]='dienthoai';
        }
        else{
            $dienthoai=$_POST['dienthoai'];
        }
        if (empty($_POST['diachi']))
        {
            $errors[]='diachi';
        }
        else{
            $diachi=$_POST['diachi'];
        }
        if (empty($_POST['actor']))
        {
            $errors[]='actor';
        }
        else{
            $actor=$_POST['actor'];
        }
        $matkhau=md5($_POST['taikhoan']);
        if (empty($errors))
        {
            $query3="SELECT * from tbluser where user='$taikhoan'";
            $result3=mysqli_query($dbc,$query3) or die ("Query: $query3 \n <br> Mysql_error: ".mysqli_error($dbc));

            if (mysqli_num_rows($result3)!=1)
            {
                $query="INSERT into tblinfo(user,hoten,ngaysinh,dienthoai,diachi) values('$taikhoan','$hoten','$ngaysinh','$dienthoai','$diachi')";
                $result=mysqli_query($dbc,$query) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
                if (mysqli_affected_rows($dbc)==1)
                {
                    $query2="INSERT into tbluser(user,password,actor) values('$taikhoan','$matkhau','$actor')";
                    $result2=mysqli_query($dbc,$query2) or die ("Query: $query2 \nb <br> Mysql_error: ".mysqli_error($dbc));
                    if (mysqli_affected_rows($dbc)==1)
                    {
                        $message="<p style='color:green'>Thêm user thành công</p>";
                    }
                    else{
                        $message="<p class='required'>Thêm user thất bại</p>";
                    }
                    $_POST['taikhoan']='';
                    $_POST['hoten']='';
                    $_POST['ngaysinh']='';
                    $_POST['dienthoai']='';
                    $_POST['diachi']='';
                   
                }
                else
                {
                    $message="<p class='required'>Thêm user thất bại</p>";
                    $_POST['taikhoan']='';
                    $_POST['hoten']='';
                    $_POST['ngaysinh']='';
                    $_POST['dienthoai']='';
                    $_POST['diachi']='';
                }
            }
            else{
                $message="<p class='required'>Tên tài khoản đã tồn tại</p>";
            
            }
           

        }
    }
    
    
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thêm User</title>
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
                        <a href="./main_admin.php" class="list-group-item list-group-item-action">Xin chào:
                            <?php if (isset($_SESSION['taikhoan'])) echo $_SESSION['taikhoan'] ; ?> </a>
                        <a href="./doimatkhauuser.php" class="list-group-item list-group-item-action">Đổi mật khẩu
                            User</a>
                        <a href="./themuser.php" class="list-group-item list-group-item-action  active">Thêm User</a>
                        <div class="dropdown">
                            <a href="#" class="list-group-item list-group-item-action dropdown-toggle"
                                data-toggle="dropdown">
                                Tìm kiếm User <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu ">
                                <li><a class="timkiemuser" href="./timkiemtheoid.php">Theo ID</a>
                                </li>
                                <li><a class="timkiemuser" href="./timkiemtheoten.php">Theo tên</a>
                                </li>
                            </ul>

                        </div>
                        <div class="dropdown">
                            <a href="#" class="list-group-item list-group-item-action dropdown-toggle"
                                data-toggle="dropdown">
                                Xóa User <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu ">
                                <li><a  href="./xoatheoid.php">Theo ID</a>
                                </li>
                                <li ><a  href="./xoatheoten.php">Theo tên</a>
                                </li>
                                <li ><a  href="./xoatheonamsinh.php">Theo năm sinh</a>
                                </li>
                            </ul>

                        </div>
                        <div class="dropdown">
                            <a href="#" class="list-group-item list-group-item-action dropdown-toggle"
                                data-toggle="dropdown">
                                Thông báo <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu ">
                                <li><a  href="./admin-xemthongbao.php">Xem thông báo</a>
                                </li>
                                <li ><a  href="./admin-guithongbao.php">Gửi thông báo</a>
                                </li>
                            </ul>

                        </div>
                        <a href="./dangxuat.php" class="list-group-item list-group-item-action">Đăng xuất</a>

                    </div>
                </div>

                <div class="col-md-10">
                    <div class="align">
                        <form method="POST">
                            <h3>Thêm User</h3>
                            <?php
                        if(isset($message))
                        {
                            echo $message;
                        }
                            ?>
                            <div class="form-group">
                                <label for="">Tên tài khoản</label>
                                <input value="<?php if(isset($_POST['taikhoan'])) echo $_POST['taikhoan'] ; ?>"
                                    name="taikhoan" type="text" class="form-control" placeholder="Tên tài khoản">
                                <?php
                                if(isset($errors) && in_array('taikhoan',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập tài khoản</p>";
                                }
                            ?>
                            </div>
                            <div class="form-group">
                                <label for="">Họ và tên</label>
                                <input value="<?php if(isset($_POST['hoten'])) echo $_POST['hoten'] ; ?>" name="hoten"
                                    type="text" class="form-control" placeholder="Họ và tên">
                                <?php
                                if(isset($errors) && in_array('hoten',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập họ tên</p>";
                                }
                            ?>
                            </div>
                            <div class="form-group">
                                <label for="">Ngày sinh</label>
                                <input value="<?php if(isset($_POST['ngaysinh'])) echo $_POST['ngaysinh'] ; ?>"
                                    name="ngaysinh" type="date" class="form-control" placeholder="">
                                <?php
                                if(isset($errors) && in_array('ngaysinh',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập ngày sinh</p>";
                                }
                            ?>
                            </div>
                            <div class="form-group">
                                <label for="">Điện thoại</label>
                                <input value="<?php if(isset($_POST['dienthoai'])) echo $_POST['dienthoai'] ; ?>"
                                    name="dienthoai" type="text" class="form-control" placeholder="Điện thoại">
                                <?php
                                if(isset($errors) && in_array('dienthoai',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập số điện thoại</p>";
                                }
                            ?>
                            </div>
                            <div class="form-group">
                                <label for="">Địa chỉ</label>
                                <input value="<?php if(isset($_POST['diachi'])) echo $_POST['diachi'] ; ?>"
                                    name="diachi" type="text" class="form-control" placeholder="Địa chỉ">
                                <?php
                                if(isset($errors) && in_array('diachi',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập địa chỉ</p>";
                                }
                            ?>
                            </div>
                            <div class="form-group">
                                <label for="">Công việc: </label>
                                <br>
                                <input checked="checked" value="student" name="actor" type="radio" class=""
                                    placeholder="">Sinh viên
                                <input value="teacher" name="actor" type="radio" class="" placeholder="">Giảng viên
                                <?php
                                if(isset($errors) && in_array('actor',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa chọn công việc</p>";
                                }
                            ?>
                            </div>


                            <button name="submit" type="submit" class="btn btn-primary">Thêm</button>
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