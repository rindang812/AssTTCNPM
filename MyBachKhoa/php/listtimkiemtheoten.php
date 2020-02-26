<?php
    session_start();
    error_reporting(0);
    include ('../include/mysql_connect.php');
    include('../include/header.php');
    if (!isset($_SESSION['id']))
    {
        header('Location: dangnhap.php');
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tìm kiếm User - Theo tên</title>
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
                    <h3>Danh sách User</h3>
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
                                
                                <?php
                                $ten=$_GET['ten'];
                                 $limit=10;
                                 if (isset($_GET['s']) && FILTER_VAR($_GET['s'],FILTER_VALIDATE_INT))
                                 {
                                     $start=$_GET['s'];
                                 }
                                 else{
                                     $start=0;
                                 }
                                 if (isset($_GET['p']) && FILTER_VAR($_GET['p'],FILTER_VALIDATE_INT))
                                 {
                                     $per_page=$_GET['p'];
                                 }
                                 else
                                 {
                                     
                                     $query2="SELECT count(id) from tblinfo where hoten like '%$ten%'";
                                     $result2=mysqli_query($dbc,$query2) or die ("Query: $query2 \n <br> Mysql_error: ".mysqli_error($dbc));
                                     list($record)=mysqli_fetch_array($result2);
                                     
                                     if ($record>$limit)
                                     {
                                         $per_page=ceil($record/$limit);
                                     }
                                     else{
                                         $per_page=1;
                                     }
                                 }
                                
                                     
                                     $query="SELECT user,hoten,ngaysinh,dienthoai,diachi from tblinfo where hoten like '%$ten%' limit $start,$limit";
                                     $result=mysqli_query($dbc,$query) or die ("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
                                    while($users=mysqli_fetch_array($result))
                                    {
                                        ?>
                                        <tr>
                                        <td><?php echo $users['user']; ?></td>
                                        <td><?php echo $users['hoten']; ?></td>
                                        <td><?php echo $users['ngaysinh']; ?></td>
                                        <td><?php echo $users['dienthoai']; ?></td>
                                        <td><?php echo $users['diachi']; ?></td>
                                        <td style="align:center;"><a href="./chinhsuauser.php?user=<?php echo $users['user']; ?>"><img width="16px" src="../images/icon_edit.png" alt=""></a></td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                                

                                


                            </tbody>

                        </table>
                                    <ul class="pagination">
                            <?php
                                
                                    if ($per_page>1)
                                    {
                                        $current_page=($start/$limit)+1;
                                        if ($current_page!=1)
                                        {
                                            $link="./listtimkiemtheoten.php?s=".($start-$limit)."&p=$per_page&ten=".$ten ;
                                            echo "<li><a href='$link'>Back</a></li>";
                                            
                                        }
                                        for ($i=1;$i<=$per_page;$i++)
                                        {
                                            if ($current_page!=$i)
                                            {
                                                $link="./listtimkiemtheoten.php?s=".($limit*($i-1))."&p=$per_page&ten=".$ten;
                                                echo "<li><a href='$link'>$i</a></li>";
                                            }
                                            else{
                                                echo "<li class='active'><a href=''>$i</a></li>";
                                            }
                                        }
                                        if ($current_page!=$per_page)
                                        {
                                            $link="./listtimkiemtheoten.php?s=".($start+$limit)."&p=$per_page&ten=".$ten;
                                            echo "<li><a href='$link'>Next</a></li>";
                                        }
                                    }

                                

                            ?>
                            </ul>

                    </div>
                
                
                </div>


            </div>






        </div>



</body>
<?php
    include('../include/footer.php');
?>

</html>