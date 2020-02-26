<?php
    session_start();
    error_reporting(0);
    include ('../include/mysql_connect.php');
    include('../include/header.php');
    if (!isset($_SESSION['id']))
    {
        header('Location: dangnhap.php');
    }
    if (isset($_GET['flag']) && $_GET['flag']==1)
    {
        $message="<p style='color:green;'>Ghi điểm thành công</p>";
    }
    if(isset($_POST['submit']))
    {
        
            $idmonhoc=$_POST['mamonhoc'];
            $idgiangvien=$_SESSION['taikhoan'];
            
    
            $query2="SELECT idmonhoc,userstudent,diem from tblbangdiem where idmonhoc='$idmonhoc' and userteacher='$idgiangvien'";
            $result2=mysqli_query($dbc,$query2) or die ("Query: $query2 \n <br> Mysql_error: ".mysqli_error($dbc));
          
        
        
        
            
            
        
       

    }
    
    
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lí điểm</title>
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
                        <a href="./main_teacher.php" class="list-group-item list-group-item-action">Xin chào:
                            <?php if (isset($_SESSION['taikhoan'])) echo $_SESSION['taikhoan'] ; ?> </a>

                        <a href="./teacher-quanlidiem.php" class="list-group-item list-group-item-action  active">Quản
                            lí điểm</a>
                            <a href="./teacher-momonhoc.php" class="list-group-item list-group-item-action">Mở môn học</a>
                        <div class="dropdown">
                            <a href="#" class="list-group-item list-group-item-action dropdown-toggle"
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
                    <div class="form">
                        <form method="POST">
                            <h3>Quản lí điểm</h3>
                            <?php
                        if(isset($message))
                        {
                            echo $message;
                        }
                            ?>

                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Mã môn học: </label>
                                <select name="mamonhoc" class="form-control-static" id="exampleFormControlSelect1">
                                    <?php
                                        $idgiangvien=$_SESSION['taikhoan'];
                                        $query="SELECT idmonhoc from tblmonhoc where userteacher='$idgiangvien'";
                                        $result=mysqli_query($dbc,$query) or die ("Query: $query \n <br> Mysql_error: ".musqli_error($dbc));
                                        while($records=mysqli_fetch_array($result))
                                        {
                                            ?>
                                    <option  value="<?php echo $records['idmonhoc'] ; ?>"><?php echo $records['idmonhoc'] ; ?></option>
                                    <?php
                                        }


                                    
                                    ?>
                                </select>
                            </div>



                            <button name="submit" type="submit" class="btn btn-primary">Xem danh sách</button>
                        </form>
                    </div>


                    <div class="form">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Mã môn học</th> 
                                    <th>Mã sinh viên</th>
                                    <th>Tên sinh viên</th>
                                    <th>Điểm</th>
                                    <th>Sửa/Ghi điểm</th>


                                </tr>


                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    while($info=mysqli_fetch_array($result2))
                                    {
                                        $idsinhvien=$info['userstudent'];
                                        $query3="SELECT hoten from tblinfo where user='$idsinhvien'";
                                        $result3=mysqli_query($dbc,$query3) or die ("Query: $query3 \n <br> Mysql_error: ".mysqli_error($dbc));
                                        list($hoten)=mysqli_fetch_array($result3);
                                        ?>
                                    <tr>
                                        <td><?php echo $info['idmonhoc']; ?></td>
                                        <td><?php echo $info['userstudent']; ?></td>
                                        <td><?php echo $hoten; ?></td>
                                        <td>
                                        <?php 
                                            if ($info['diem']==-1)
                                            {
                                                echo "Chưa có";
                                            }
                                            else
                                            {
                                                echo $info['diem'];
                                            }

                                        ?>



                                       </td>
                                        <td  ><a href="./teacher-xulidiem.php?idmonhoc=<?php echo $info['idmonhoc'].'&idsinhvien='.$idsinhvien.'&idgiangvien='.$idgiangvien; ?>"><img width="20px" src="../images/icon_ghidiem.png" alt=""></a></td>
                                        
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</body> <?php
    include('../include/footer.php');
?>

</html>