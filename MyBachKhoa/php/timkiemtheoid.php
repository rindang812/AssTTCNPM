<?php
    session_start();
    error_reporting(0);
    include ('../include/mysql_connect.php');
    include('../include/header.php');
    if (!isset($_SESSION['id']))
    {
        header('Location: dangnhap.php');
    }
    if(isset($_POST['submit']))
    {
        $errors=array();
        if(empty($_POST['taikhoan']))
        {
            $errors[]='taikhoan';
        }
        else{
            $taikhoan=$_POST['taikhoan'];
        }
        if (empty($errors))
        {
            $query="SELECT user,hoten,ngaysinh,dienthoai,diachi from tblinfo where user='$taikhoan'";
            $result=mysqli_query($dbc,$query) or die("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
            if (mysqli_num_rows($result)==1)
            {
                $_POST['taikhoan']='';

            }
            else{
                $message ="<p class='required'>ID không tồn tại. Vui lòng kiểm tra lại</p>";
            }
        }
       

    }
    
    
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tìm kiếm User - Theo ID</title>
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
                    <div class="form">
                        <form method="POST">
                            <h3>Tìm kiếm User - Theo Id</h3>
                            <?php
                        if(isset($message))
                        {
                            echo $message;
                        }
                            ?>
                            <div class="form-group">
                                <label for="">Nhập id: </label>
                                <input value="<?php if(isset($_POST['taikhoan'])) echo $_POST['taikhoan'] ; ?>"
                                    name="taikhoan" type="text" class="form-control" placeholder="Nhập id">
                                <?php
                                if(isset($errors) && in_array('taikhoan',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập ID</p>";
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
                                <th>Tên tài khoản</th>
                                <th>Họ tên</th>
                                <th>Ngày sinh</th>
                                <th>Điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>
                                    Chỉnh sửa


                                </th>

                                </tr>
                                

                            </thead>
                            <tbody>
                                <tr>
                                <?php
                                    while($users=mysqli_fetch_array($result))
                                    {
                                        ?>
                                        <td><?php echo $users['user']; ?></td>
                                        <td><?php echo $users['hoten']; ?></td>
                                        <td><?php echo $users['ngaysinh']; ?></td>
                                        <td><?php echo $users['dienthoai']; ?></td>
                                        <td><?php echo $users['diachi']; ?></td>
                                        <td style="align:center;"><a href="./chinhsuauser.php?user=<?php echo $users['user']; ?>"><img width="16px" src="../images/icon_edit.png" alt=""></a></td>
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



</body>
<?php
    include('../include/footer.php');
?>

</html>