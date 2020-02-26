<?php
    session_start();
    include ('../include/mysql_connect.php');
    include('../include/header.php');
    if (!isset($_SESSION['id']))
    {
        header('Location: dangnhap.php');
    }
    if (isset($_GET['user']))
    {
        $taikhoan=$_GET['user'];
        
    }
    else{
        header('Location: ./main_admin.php');
        exit();
    }
    if (isset($_POST['submit']))
        {
            $errors=array();
        
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
        $taikhoan=$_GET['user'];
        
       
            if (empty($errors))
            {
                
                $query2="UPDATE tblinfo Set hoten='$hoten',dienthoai='$dienthoai',diachi='$diachi',ngaysinh='$ngaysinh'
                where user='$taikhoan'";
                $result2=mysqli_query($dbc,$query2) or die ("Query: $query2 \n <br> Mysql_error: ".mysqli_error($dbc));
                if (mysqli_affected_rows($dbc)==1)
                {
                    $message="<p style='color:green;'>Cập nhật thông tin thành công</p>";
                }
                else{
                    $message="<p class='required'>Cập nhật thông tin thất bại</p>";
                }
                
            }
        }
        $query="SELECT hoten,ngaysinh,dienthoai,diachi FROM tblinfo WHERE user='$taikhoan'";
        $result=mysqli_query($dbc,$query) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
        if (mysqli_num_rows($result)==1)
        {
            list($hoten,$ngaysinh,$dienthoai,$diachi)=mysqli_fetch_array($result);
        }
        else{
            $message="<p class='required'>ID không hợp lệ</p>";
            header('Location: ./main_admin.php');
            exit();

        }
    
    
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chỉnh sửa thông tin</title>
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
                        <a href="./themuser.php" class="list-group-item list-group-item-action  ">Thêm User</a>
                        <div class="dropdown">
                            <a href="#" class="list-group-item list-group-item-action active dropdown-toggle"
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
                            <h3>Chỉnh sửa thông tin</h3>
                            <?php
                        if(isset($message))
                        {
                            echo $message;
                        }
                            ?>
                            <div class="form-group">
                                <label for="">Tên tài khoản</label>
                                <input disabled="disabled" value="<?php if(isset($taikhoan)) echo $taikhoan ; ?>"
                                    name="taikhoan" type="text" class="form-control" placeholder="Tên tài khoản">

                            </div>
                            <div class="form-group">
                                <label for="">Họ và tên</label>
                                <input value="<?php if(isset($hoten)) echo $hoten ; ?>" name="hoten" type="text"
                                    class="form-control" placeholder="Họ và tên">
                                <?php
                                if(isset($errors) && in_array('hoten',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập họ tên</p>";
                                }
                            ?>
                            </div>
                            <div class="form-group">
                                <label for="">Ngày sinh</label>
                                <input value="<?php if(isset($ngaysinh)) echo $ngaysinh ; ?>" name="ngaysinh"
                                    type="date" class="form-control" placeholder="">
                                <?php
                                if(isset($errors) && in_array('ngaysinh',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập ngày sinh</p>";
                                }
                            ?>
                            </div>
                            <div class="form-group">
                                <label for="">Điện thoại</label>
                                <input value="<?php if(isset($dienthoai)) echo $dienthoai  ; ?>" name="dienthoai"
                                    type="text" class="form-control" placeholder="Điện thoại">
                                <?php
                                if(isset($errors) && in_array('dienthoai',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập số điện thoại</p>";
                                }
                            ?>
                            </div>
                            <div class="form-group">
                                <label for="">Địa chỉ</label>
                                <input value="<?php if(isset($diachi)) echo $diachi ; ?>" name="diachi" type="text"
                                    class="form-control" placeholder="Địa chỉ">
                                <?php
                                if(isset($errors) && in_array('diachi',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập địa chỉ</p>";
                                }
                            ?>
                            </div>



                            <button name="submit" type="submit" class="btn btn-primary">Sửa</button>
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