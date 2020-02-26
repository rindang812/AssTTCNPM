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
    if (isset($_GET['idmonhoc']) && isset($_GET['idsinhvien']) && isset($_GET['idgiangvien']))
    {
        $idmonhoc=$_GET['idmonhoc'];
        $idsinhvien=$_GET['idsinhvien'];
        $idgiangvien=$_GET['idgiangvien'];
    }
    else
    {
        header('Location: ./teacher-quanlidiem.php');
    }
    if (isset($_POST['submit']))
        {
            $errors=array();
        
        if (empty($_POST['diem']))
        {
            $errors[]='diem';
        }
        else{
            $diem=$_POST['diem'];
        }
        
       
            if (empty($errors))
            {
               $query2="UPDATE tblbangdiem set diem='$diem'
                        where idmonhoc='$idmonhoc' and userstudent='$idsinhvien' and userteacher='$idgiangvien'";
                $result2=mysqli_query($dbc,$query2) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
                if (mysqli_affected_rows($dbc)==1)
                {
                    header ('Location: ./teacher-quanlidiem.php?flag=1');
                } 
               
               
                
            }
        }
    





    $query="SELECT hoten FROM tblinfo WHERE user='$idsinhvien'";
    $result=mysqli_query($dbc,$query) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
    if (mysqli_num_rows($result)==1)
    {
        list($hoten)=mysqli_fetch_array($result);
    }
    
    
    
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ghi điểm</title>
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
                        
                        <a href="./teacher-quanlidiem.php" class="list-group-item list-group-item-action active">Quản lí điểm</a>
                        <a href="./teacher-momonhoc.php" class="list-group-item list-group-item-action">Mở môn học</a>
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
                            <h3>Ghi điểm</h3>
                            <?php
                        if(isset($message))
                        {
                            echo $message;
                        }
                            ?>
                            
                            <div class="form-group">
                                <label for="">Họ và tên</label>
                                <input disabled="disabled" value="<?php if(isset($hoten)) echo $hoten ; ?>" name="hoten" type="text"
                                    class="form-control" placeholder="Họ và tên">
                                
                            </div>
                            
                            
                            <div class="form-group">
                                <label for="">Điểm</label>
                                <input value="<?php if(isset($diem)) echo $diem ; ?>" name="diem" type="text"
                                    class="form-control" placeholder="Điểm">
                                <?php
                                if(isset($errors) && in_array('diem',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập điểm</p>";
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