<?php
    session_start();
    error_reporting(0);
    include ('../include/mysql_connect.php');
    include('../include/header.php');
    if (!isset($_SESSION['id']))
    {
        header('Location: dangnhap.php');
    }
    
    if (isset($_POST['submit']))
    {
        $errors=array();
        if (empty($_POST['hoten']))
        {
            $errors[]='hoten';
        }
        else{
            $ten=$_POST['hoten'];
            
        }
        if(empty($errors))
        {
               
                $query2="SELECT count(user) from tblinfo where hoten like '%$ten'";
                $result2=mysqli_query($dbc,$query2) or die ("Query: $query \n <br> Mysql_error: ".mysqlli_error($dbc));
                list($count)=mysqli_fetch_array($result2);
                
                $query="SELECT user from tblinfo where hoten like '%$ten'";
                $result=mysqli_query($dbc,$query) or die ("Query: $query \n <br> Mysql_error: ".mysqlli_error($dbc));
                for ($i=0;$i<$count;$i++)   
                {
                    list($users[$i])=mysqli_fetch_array($result);
                }

                if ($count!=0)
                {
                    $check=0;
                    for ($i=0;$i<$count;$i++)
                    {
                        $query3="DELETE FROM tbluser where user='$users[$i]'";
                        $result3=mysqli_query($dbc,$query3) or die ("Query: $query \n <br> Mysql_error: ".mysqlli_error($dbc));
                        $query4="DELETE FROM tblinfo where user='$users[$i]'";
                        $result4=mysqli_query($dbc,$query4) or die ("Query: $query \n <br> Mysql_error: ".mysqlli_error($dbc));
                        $query5="DELETE FROM tblbangdiem where userstudent='$users[$i]' or userteacher='$users[$i]'";
                        $result5=mysqli_query($dbc,$query5) or die ("Query: $query \n <br> Mysql_error: ".mysqlli_error($dbc));
                        $check+=1;
                    }
                    if ($check==$count)
                    {
                        $message ="<p style='color:green'>Xóa user thành công</p>";
                        $_POST['hoten']='';
                    }
                    else
                    {
                        $message="<p class='required'>Xóa user thất bại</p>";
                    }

                    
                }
                else
                {
                    $message ="<p class='required'>Tên không tồn tại trong hệ thống. Vui lòng kiểm tra lại!!!</p>";
                }

                


        }
        
        
       

        
    }
    
    
    
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Xóa User - Theo tên</title>
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
                            <a href="#" class="list-group-item list-group-item-action  dropdown-toggle"
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
                            <a href="#" class="list-group-item list-group-item-action active dropdown-toggle"
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
                            <h3>Xóa User - Theo Tên</h3>
                            <?php
                        if(isset($message))
                        {
                            echo $message;
                        }
                            ?>
                            <div class="form-group">
                                <label for="">Nhập tên: </label>
                                <input value="<?php if(isset($_POST['hoten'])) echo $_POST['hoten'] ; ?>"
                                    name="hoten" type="text" class="form-control" placeholder="Nhập tên">
                                <?php
                                if(isset($errors) && in_array('hoten',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập tên user</p>";
                                }
                            ?>
                            </div>
                            


                            <button name="submit" type="submit" class="btn btn-primary">Xóa</button>
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