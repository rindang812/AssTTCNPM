

<?php
    session_start();
    if (isset($_SESSION['id']))
    {
        if ($_SESSION['actor']=="admin")
        {
            header('Location: ./main_admin.php');
        }
        else if ($_SESSION['actor']=="student")
        {
            header('Location: ./main_student.php');
        }
        else{
            header('Location: ./main_teacher.php');
        }
    }
    
    include('../include/header.php');
    include('../include/mysql_connect.php');
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
        if (empty($errors))
    {
        $query="SELECT id,user,password,actor from tbluser where user='$taikhoan' and password='$matkhau'";
        $result=mysqli_query($dbc,$query) or die("Query: $query \n <br> Mysql_error: ".mysqli_error($dbc));
        if (mysqli_num_rows($result)==1)
        {
            list($id,$taikhoan,$matkhau,$actor)=mysqli_fetch_array($result);
            $_SESSION['id']=$id;
            $_SESSION['taikhoan']=$taikhoan;
            $_SESSION['actor']=$actor;
           
            if($actor=="admin")
            {
                header('Location: ./main_admin.php');
            }
            else if ($actor=="student")
            {
                header('Location: ./main_student.php');
            }
            else{
                header('Location: ./main_teacher.php');
            }
        }
        else{
            $message= "<p class='required'>Tài khoản hoặc mật khẩu không đúng</p>";
            $_POST['taikhoan']='';
            $_POST['matkhau']='';
        }
    }
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />

    <script src="../bootstrap-3.3.7-dist/js/bootstrap.js"></script>
    <script src="../jquery_321/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" href="../css/dangnhap.css">
    <style>
    .required{
        color:red;
    }
</style>
</head>

<body>
    <div class="main">


        <div class="container">
            <div class="row">

                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <form method="POST">
                        <h3>Nhập thông tin tài khoản</h3>
                        <?php 
                            if(isset($message))
                            {
                                echo $message;
                            }
                        ?>
                        <div class="form-group">
                        
                            <label for="" >Tên tài khoản </label>   
                            <input value="<?php if (isset($_POST['taikhoan']))  echo $_POST['taikhoan']; ?>" name="taikhoan" type="text" class="form-control" placeholder="Tên tài khoản">
                            <?php
                                if (isset($errors) && in_array('taikhoan',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập tài khoản</p>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="">Mật khẩu</label>
                            <input value="<?php if (isset($_POST['matkhau'])) echo $_POST['matkhau']  ?>" name="matkhau" type="password" class="form-control" placeholder="Mật khẩu">
                            <?php
                                if (isset($errors) && in_array('matkhau',$errors))
                                {
                                    echo "<p class='required'>Bạn chưa nhập mật khẩu</p>";
                                }
                            ?>
                        </div>
                        
                        <button name="submit" type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-log-in'></span>  Đăng nhập</button>
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