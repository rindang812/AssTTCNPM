<?php
    session_start();
    include ('../include/mysql_connect.php');
    include('../include/header.php');
    if (!isset($_SESSION['id']))
    {
        header('Location: dangnhap.php');
    }   
    else{
        $taikhoan=$_SESSION['taikhoan'];
    }
    if (isset($_POST['submit']))
        {
            $errors=array();
        
        if (empty($_POST['idmonhoc']))
        {
            $errors[]='idmonhoc';
        }
        else{
            $idmonhoc=$_POST['idmonhoc'];
        }
        if (empty($_POST['tenmonhoc']))
        {
            $errors[]='tenmonhoc';
        }
        else{
            $tenmonhoc=$_POST['tenmonhoc'];
        }
        if (empty($_POST['sotinchi']))
        {
            $errors[]='sotinchi';
        }
        else{
            $sotinchi=$_POST['sotinchi'];
        }
        if (empty($_POST['soluongsinhvien']))
        {
            $errors[]='soluongsinhvien';
        }
        else{
            $soluongsinhvien=$_POST['soluongsinhvien'];
        }
       
        
       
            if (empty($errors))
            {
                $query2="SELECT * from tblmonhoc where idmonhoc='$idmonhoc' and userteacher='$taikhoan'";
                $result2=mysqli_query($dbc,$query2) or die("Query: $query2 \n <br> Mysql_error: ".mysqli_error($dbc));
                if (mysqli_num_rows($result2)==1)
                {
                    $message="<p class='required'>Bạn đã mở môn học này rồi!!</p>";
                }
                else
                {
                    $soluongchodadangki=0;
                $idgiangvien=$_SESSION['taikhoan'];
                $query="INSERT INTO tblmonhoc(idmonhoc,userteacher,tenmonhoc,sotinchi,soluongchodadangki,soluongchotoida)
                        values('$idmonhoc','$idgiangvien','$tenmonhoc','$sotinchi','$soluongchodadangki','$soluongsinhvien')";
                $result=mysqli_query($dbc,$query) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
                if (mysqli_affected_rows($dbc)==1)
                {
                    $message="<p style='color:green;'>Mở môn học thành công</p>";
                    $_POST['idmonhoc']='';
                    $_POST['tenmonhoc']='';
                    $_POST['sotinchi']='';
                    $_POST['soluongsinhvien']='';
                }
                else
                {
                    $message="<p class='required'>Mở môn học thất bại</p>";
                }
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
        header('Location: ./main_teacher.php');
        exit();

    }
    
    
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mở môn học</title>
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
                        <a href="./main_teacher.php" class="list-group-item list-group-item-action ">Xin chào:
                            <?php if (isset($_SESSION['taikhoan'])) echo $_SESSION['taikhoan'] ; ?> </a>
                        
                        <a href="./teacher-quanlidiem.php" class="list-group-item list-group-item-action">Quản lí điểm</a>
                        <a href="./teacher-momonhoc.php" class="list-group-item list-group-item-action active">Mở môn học</a>
                        <div class="dropdown">
                            <a href="#" class="list-group-item list-group-item-action  dropdown-toggle"
                                data-toggle="dropdown">
                                Quản lí tài khoản <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu ">
                                <li><a href="./teacher-suathongtincanhan.php">Sửa thông tin cá nhân</a>
                                </li>
                                <li><a href="./teacher-doimatkhau.php">Đổi mật khẩu</a>
                                </li>
                            </ul>

                        </div>
                        <div class="dropdown">
                            <a href="#" class="list-group-item list-group-item-action dropdown-toggle"
                                data-toggle="dropdown">
                                Thông báo <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu ">
                                <li><a href="./teacher-xemthongbao.php">Xem thông báo</a>
                                </li>
                                <li><a href="./teacher-guithongbao.php">Gửi thông báo</a>
                                </li>
                            </ul>

                        </div>

                        <a href="./dangxuat.php" class="list-group-item list-group-item-action">Đăng xuất</a>

                    </div>
                </div>

                <div class="col-md-10">
                    <div class="align">
                        <form method="POST">
                            <h3>Mở môn học</h3>
                            <?php
                        if(isset($message))
                        {
                            echo $message;
                        }
                            ?>
                            <div class="form-group">
                                <label for="">ID môn học</label>
                                <input value="<?php if(isset($idmonhoc)) echo $idmonhoc ; ?>"
                                    name="idmonhoc" type="text" class="form-control" placeholder="ID môn học">
                                    <?php
                                if(isset($errors) && in_array('idmonhoc',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập ID môn học</p>";
                                }
                            ?>
                            </div>
                            <div class="form-group">
                                <label for="">Tên môn học</label>
                                <input value="<?php if(isset($tenmonhoc)) echo $tenmonhoc ; ?>" name="tenmonhoc" type="text"
                                    class="form-control" placeholder="Tên môn học">
                                <?php
                                if(isset($errors) && in_array('tenmonhoc',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập tên môn học</p>";
                                }
                            ?>
                            </div>
                            
                            <div class="form-group">
                                <label for="">Số tín chỉ</label>
                                <input value="<?php if(isset($sotinchi)) echo $sotinchi  ; ?>" name="sotinchi"
                                    type="text" class="form-control" placeholder="Số tín chỉ">
                                <?php
                                if(isset($errors) && in_array('sotinchi',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập số tín chỉ</p>";
                                }
                            ?>
                            </div>
                            <div class="form-group">
                                <label for="">Số lượng sinh viên</label>
                                <input value="<?php if(isset($soluongsinhvien)) echo $soluongsinhvien ; ?>" name="soluongsinhvien" type="text"
                                    class="form-control" placeholder="Số lượng sinh viên">
                                <?php
                                if(isset($errors) && in_array('soluongsinhvien',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập số lượng sinh viên</p>";
                                }
                            ?>
                            </div>



                            <button name="submit" type="submit" class="btn btn-primary">Mở môn học</button>
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