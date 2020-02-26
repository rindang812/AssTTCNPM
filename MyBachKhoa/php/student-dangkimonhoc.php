<?php
    session_start();
    error_reporting(0);
    if (!isset($_SESSION['id']))
    {
        header('Location: dangnhap.php');
    }
    include('../include/header.php');
    include('../include/mysql_connect.php');
    if (isset($_POST['submit']))
    {
        $_GET['flag']=0;
        $_GET['check']=0;
        $errors=array();
        if (empty($_POST['idmonhoc']))
        {
            $errors[]='idmonhoc';
        }
        else
        {
            $idmonhoc=$_POST['idmonhoc'];
        }
        if(empty($errors))
        {
            $query="SELECT idmonhoc,userteacher,tenmonhoc,sotinchi,soluongchodadangki,soluongchotoida
                    from tblmonhoc where idmonhoc='$idmonhoc'";
            $result=mysqli_query($dbc,$query) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
           
          
            if (mysqli_num_rows($result)==0)
           {
               $message="<p class='required'>ID môn học không đúng. Vui lòng kiểm tra lại!</p>";
           }
           
        }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng kí môn học</title>
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
                        <a href="./student-dangkimonhoc.php" class="list-group-item list-group-item-action active">Đăng
                            kí môn học</a>

                        <a href="./student-xemmondadangki.php" class="list-group-item list-group-item-action">Xem môn đã
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
                        <form method="POST">
                            <h3>Đăng kí môn học</h3>
                            <?php
                        if(isset($message))
                        {
                            echo $message;
                        }
                        if (isset($_GET['check']) && $_GET['check']==1)
                        {
                            echo "<p style='color:green;'>Đăng kí môn học thành công</p>";
                        }
                        if (isset($_GET['flag']) && $_GET['flag']==1)
                        {
                            echo "<p class='required'>Bạn đã đăng kí môn học này rồi!!</p>";
                            
                            
                        }
                            ?>
                            <div class="form-group">
                                <label for="">Nhập mã môn học </label>
                                <input value="" name="idmonhoc" type="text" class="form-control"
                                    placeholder="Nhập mã môn học">
                                <?php
                                if (isset($errors) && in_array('idmonhoc',$errors))
                                {
                                    echo  "<p class='required'>Bạn chưa nhập ID môn học</p>";
                                }

                                ?>
                            </div>



                            <button name="submit" type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </form>
                    </div>


                    <div class="form">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID môn học</th>
                                    <th>Tên giảng viên</th>
                                    <th>Tên môn học</th>
                                    <th>Số tín chỉ</th>
                                    <th>Số lượng chỗ</th>
                                    <th>Đăng kí</th>

                                </tr>


                            </thead>
                            <tbody>
                                <?php
                               

                            while($courses=mysqli_fetch_array($result))
                            {
                                $idgiangvien=$courses['userteacher'];
                                $query2="SELECT hoten from tblinfo where user='$idgiangvien'";
                                $result2=mysqli_query($dbc,$query2) or die ("Query: $query2 \n <br> Mysql_error: ".mysqli_error($dbc));
                                list($tengiangvien)=mysqli_fetch_array($result2);
                            
                            ?>
                                <tr>
                                    <td><?php echo $courses['idmonhoc'] ;  ?></td>
                                    <td><?php echo $tengiangvien ;  ?></td>
                                    <td><?php echo $courses['tenmonhoc'] ;  ?></td>
                                    <td align="center"><?php echo $courses['sotinchi'] ;  ?></td>
                                    <td align="center"><?php echo $courses['soluongchodadangki']."/".$courses['soluongchotoida'] ;  ?>
                                    </td>
                                   
                                    <?php if ($courses['soluongchodadangki']<=$courses['soluongchotoida'])
                                    {
                                        ?>
                                        <td><a href="./student-xulidangki.php?idmonhoc=<?php echo $courses['idmonhoc']."&idgiangvien=".$idgiangvien."&soluongchodadangki=".$courses['soluongchodadangki']; ?>"><img width="25px" src="../images/icon_dangki.png" alt=""></a></td>
                                        <?php
                                    }
                                    ?>
                                   


                                </tr>
                                <?php
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