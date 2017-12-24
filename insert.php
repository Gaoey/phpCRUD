<?php 
        require_once("customerFunction.php");
        session_start();
        if (isset($_GET['action']) && $_GET['action'] == "edit") {
            // edit case
            $id = $_GET['id'];
            $customer = getCustomerById($id);
            if (count($customer)) {
                $name = $customer['name'];
                $surname = $customer['surname'];
                $phone = $customer['phone'];
                $email = $customer['email'];

                // setcookie("name", $name, time()+(60*5), "/");
                // setcookie("surname", $surname, time()+(60*5), "/");
                // setcookie("phone", $phone, time()+(60*5), "/");
                // setcookie("email", $email, time()+(60*5), "/");
                
                $_SESSION["name"] = $name;
                $_SESSION["surname"] = $surname;
                $_SESSION["phone"] = $phone;
                $_SESSION["email"] = $email;

                // tips::
                // COOkie:
                /*
                    client --- request-----> SERVER (create cookie)
                    client(keep data) <--- data ------ server
                */
                // - server สร้าง cookie ส่งไปให้ client -> client เก็บไว้ และสามารถส่งให้ server ได้
                // ทำให้ช้า(เพราะข้อมูลเยอะ) แต่ client ใช้ข้อมูลได้
                // อยู๋ที่ฝั่ง client

                // session:
                /*
                    client --- request-----> SERVER (create session)
                    client(keep sid) <--- session id ------ server (keep data)
                */
                // session เก็บแยกตามตัวแปล user 10 คน 10 session
                // server ส่ง session id(sid) ส่งไปให้ client
                // client เก็บ sid แล้วส่ง sid ไปให้ server 
                // อยู๋ที่ฝั่ง server, client ไม่ได้ข้อมูลไปใช้-
            }
            $action = 'editAction.php';
        }else{
            // insert case
            $action = 'insertAction.php';
        }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>insert</title>
    </head>
    <body>

    <?php 
            $validate = "";
            if (isset($_GET['return']) && $_GET['return']==1) {
                $validate =  "<p style='color: red;'>กรุณากรอกชื่อข้อมูล</p><";
            }
           
            if (isset($_GET['return']) && $_GET['return']==2) {
                $validate = "<p style='color: red;'>กรุณากรอกนามสกุลข้อมูล</p>";
            }
            
            if (isset($_GET['return']) && $_GET['return']==3) {
                $validate =  "<p style='color: red;'>กรุณากรอกโทรศัพท์ข้อมูล</p>";
            }
           
            if (isset($_GET['return']) && $_GET['return']==4) {
                $validate =  "<p style='color: red;'>กรุณากรอกอีเมวข้อมูล</p>";
            }

            if (isset($_GET['return']) && $_GET['return']==5) {
                $validate =  "<p style='color: red;'>email doesn't correct format</p>";
            }

            function checkCookie($string)
            {
                if (isset($_COOKIE[$string])) {
                    echo $_COOKIE[$string];
                }
            }

            function checkSession($string)
            {
                if (isset($_SESSION[$string])) {
                    echo $_SESSION[$string];
                }
            }
    ?>
        <form action="<?php echo $action; ?>" method="POST">
            <div><h1>form insert</h1></div>
            <div>
            <input type="hidden" name="id" value="<?php if(!empty($id)){ echo $id;} ;?>">
            <label>name: </label>
            <input type="text" name="name" value="<?php checkSession("name");?>" /> 
            </div>

            <div>
            <label>surname: </label>
            <input type="text" name="surname"  value="<?php checkSession("surname");?>" />
            </div>

            <div>
            <label>phone: </label>
            <input type="text" name="phone"  value="<?php checkSession("phone");?>" />
            </div>

            <div>
            <label>email: </label>
            <input type="text" name="email"  value="<?php checkSession("email");?>" />
            </div>

            <input type="submit" name="submit" value="submit"/></br>
        </forms></br>
        <?php echo $validate;?>
        <!-- // validation -->
        <ul>
        </ul>
        <h4><a href="./index.php">BACK</a></h4>
    </body>
</html>