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
        if (empty($_POST['matkhau']))
        {
            $errors[]='matkhau';
        }
        else{
            $matkhau=md5($_POST['matkhau']);
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
            if ($matkhau!=$xacnhanmatkhau)
            {
                $message ="<p class='required'>Mật khẩu không trùng khớp</p>";
                $_POST['taikhoan']='';
                $_POST['matkhau']='';
                $_POST['xacnhanmatkhau']='';
            }
            else{
                $query="SELECT id from tbluser where user='$taikhoan'";
                $result=mysqli_query($dbc,$query) or die("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
                if (mysqli_num_rows($result)==1)
                {
                    list($id)=mysqli_fetch_array($result);
                    $query2="UPDATE tbluser SET password='$matkhau' where id='$id'";
                    $result2=mysqli_query($dbc,$query2) or die ("Query: $query2 \n <br> Mysql_error: ".mysqli_error($dbc));
                    if (mysqli_affected_rows($dbc)==1)
                    {
                        $message="<p style='color:green;'>Đổi mật khẩu user thành công</p>";
                    }
                    else{
                        $message="<p class='required'>Đổi mật khẩu user thất bại</p>";
                    }
                    $_POST['taikhoan']='';
                    $_POST['matkhau']='';
                    $_POST['xacnhanmatkhau']='';
                } 
                else
                {
                    $message="<p class='required'>Tên tài khoản không tồn tại. Vui lòng kiểm tra lại!!</p>";
                }
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
                        <a href="./main_admin.php" class="list-group-item list-group-item-action ">Xin chào:
                            <?php if (isset($_SESSION['taikhoan'])) echo $_SESSION['taikhoan'] ; ?> </a>
                        <a href="./doimatkhauuser.php" class="list-group-item list-group-item-action active">Đổi mật
                            khẩu User</a>
                        <a href="./themuser.php" class="list-group-item list-group-item-action">Thêm User</a>
                        <div class="dropdown">
                            <a href="#" class="list-group-item list-group-item-action dropdown-toggle"
                                data-toggle="dropdown">
                                Tìm kiếm User <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu ">
                                <li><a class="" href="./timkiemtheoid.php">Theo ID</a>
                                </li>
                                <li><a class="" href="./timkiemtheoten.php">Theo tên</a>
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
                            <h3>Đổi mật khẩu User</h3>
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
                                <label for="">Mật khẩu</label>
                                <input value="<?php if(isset($_POST['matkhau'])) echo $_POST['matkhau'] ; ?>"
                                    name="matkhau" type="password" class="form-control" placeholder="Mật khẩu">
                                <?php
                                if(isset($errors) && in_array('matkhau',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập mật khẩu</p>";
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