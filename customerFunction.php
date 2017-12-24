<?php
    function createMySqlConnection()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "crud1";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        return $conn;
    }

    /*
    * using prepared statement : prevent sql injection
    *
    */

    function insertNewCustomer($name, $surname, $phone, $email)
    {
        // insert to database
        // 1. create connection
        // 2. สร้างคำสั่ง SQL
        // 3. execute คำสั่ง
        // ถ้ามีผลลัพธ์ เก็บผลลัพธ์
        // ปิด connection
        
        // Check connection
        $conn = createMySqlConnection();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
 
        $sql = "INSERT INTO customer (id, name, surname, phone, email) 
        VALUES  ( 0, ?, ?, ?, ?)";
        $statement  = $conn->prepare($sql);
        $statement->bind_param("ssss", $name, $surname, $phone, $email);
        if ( $statement->execute() === true) {
            echo "New record created successfully";
            echo "<h4><a href='./index.php'>BACK</a></h4>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $statement->close();
        $conn->close();
    }
 
    function getAllCustomer()
    {
        $conn = createMySqlConnection();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
 
        $sql = "SELECT * FROM customer";
        $result = $conn->query($sql);
        $customer = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $customerDataRow = array(
                 "id"=>$row["id"],
                 "name"=>$row["name"],
                 "surname"=>$row["surname"],
                 "phone"=>$row["phone"],
                 "email"=>$row["email"],
                 "timestamp"=>$row["timestamp"],
             );
                array_push($customer, $customerDataRow);
            }
        }
 
        $conn->close();
 
        return $customer;
    }
 
    function deleteCustomer($id)
    {
        $conn = createMySqlConnection();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
 
        $sql = "DELETE FROM customer WHERE id = ? ";
        $statement  = $conn->prepare($sql);
        $statement->bind_param("i", $id);
        if ($statement->execute() === true) {
            echo "Delete Success!!";
            echo "<h4><a href='./showAll.php'>BACK</a></h4>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $statement->close();
        $conn->close();
    }
 
    function getCustomerById($id)
    {
        $conn = createMySqlConnection();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
 
        $sql = "SELECT * FROM customer WHERE id =?"; ////// sql injection
        $stmp = $conn->prepare($sql);
        $stmp->bind_param("i", $id);
        $stmp->execute();
        $result= $stmp->get_result();

        $thisCustomer = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $thisCustomer = array(
                 "id"=>$row["id"],
                 "name"=>$row["name"],
                 "surname"=>$row["surname"],
                 "phone"=>$row["phone"],
                 "email"=>$row["email"],
                 "timestamp"=>$row["timestamp"],
             );
            }
        }
        
        $stmp->close();
        $conn->close();
 
        return $thisCustomer;
    }
 
    function updateCustomer($id, $name, $surname, $phone, $email){
     $date = date('Y-m-d H:i:s');
     $conn = createMySqlConnection();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
 
        $sql = "UPDATE `customer` SET `name` = ?, `surname` = ?, `phone` = ?, `email` =  ? WHERE `customer`.`id` =?";
        $stmp = $conn->prepare($sql);
        $stmp->bind_param("ssssi", $name, $surname, $phone, $email, $id);
        if ($stmp->execute() === true) {
            echo "Update Data success";
            echo "<h4><a href='./showAll.php'>BACK</a></h4>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $stmp->close();
        $conn->close();
    }
 
 
    function searchCustomerByName($name)
    {
        $conn = createMySqlConnection();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
 
        $sql = "SELECT * FROM customer WHERE `name` LIKE ? ";

        $stmp = $conn->prepare($sql);
        $stmp->bind_param("s", $name);
        $stmp->execute();
        $result= $stmp->get_result();

        echo $sql;
        $customer = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $customerDataRow = array(
                 "id"=>$row["id"],
                 "name"=>$row["name"],
                 "surname"=>$row["surname"],
                 "phone"=>$row["phone"],
                 "email"=>$row["email"],
                 "timestamp"=>$row["timestamp"],
             );
                array_push($customer, $customerDataRow);
            }
        }
        
        $stmp->close();
        $conn->close();
 
        return $customer;
    }

    /*
    * normal case using MySQLi => sql injection 
    *
    */
/*
   function insertNewCustomer($name, $surname, $phone, $email)
   {
       // insert to database
       // 1. create connection
       // 2. สร้างคำสั่ง SQL
       // 3. execute คำสั่ง
       // ถ้ามีผลลัพธ์ เก็บผลลัพธ์
       // ปิด connection
       
       // Check connection
       $conn = createMySqlConnection();
       if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
       }

       $sql = "INSERT INTO customer (id, name, surname, phone, email) 
       VALUES  ( 0, '$name', '$surname', '$phone', '$email')";

       if ($conn->query($sql) === true) {
           echo "New record created successfully";
           echo "<h4><a href='./index.php'>BACK</a></h4>";
       } else {
           echo "Error: " . $sql . "<br>" . $conn->error;
       }

       $conn->close();
   }

   function getAllCustomer()
   {
       $conn = createMySqlConnection();
       if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
       }

       $sql = "SELECT * FROM customer";
       $result = $conn->query($sql);
       $customer = [];
       if ($result->num_rows > 0) {
           // output data of each row
           while ($row = $result->fetch_assoc()) {
               $customerDataRow = array(
                "id"=>$row["id"],
                "name"=>$row["name"],
                "surname"=>$row["surname"],
                "phone"=>$row["phone"],
                "email"=>$row["email"],
                "timestamp"=>$row["timestamp"],
            );
               array_push($customer, $customerDataRow);
           }
       }

       $conn->close();

       return $customer;
   }

   function deleteCustomer($id)
   {
       $conn = createMySqlConnection();
       if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
       }

       $sql = "DELETE FROM customer WHERE id =$id";
       if ($conn->query($sql) === true) {
           echo "Delete Success!!";
           echo "<h4><a href='./showAll.php'>BACK</a></h4>";
       } else {
           echo "Error: " . $sql . "<br>" . $conn->error;
       }

       $conn->close();
   }

   function getCustomerById($id)
   {
       $conn = createMySqlConnection();
       if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
       }

       $sql = "SELECT * FROM customer WHERE id =$id"; ////// sql injection
       $result = $conn->query($sql);
       $thisCustomer = [];
       if ($result->num_rows > 0) {
           // output data of each row
           while ($row = $result->fetch_assoc()) {
               $thisCustomer = array(
                "id"=>$row["id"],
                "name"=>$row["name"],
                "surname"=>$row["surname"],
                "phone"=>$row["phone"],
                "email"=>$row["email"],
                "timestamp"=>$row["timestamp"],
            );
           }
       }

       $conn->close();

       return $thisCustomer;
   }

   function updateCustomer($id, $name, $surname, $phone, $email){
    $date = date('Y-m-d H:i:s');
    $conn = createMySqlConnection();
       if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
       }

       $sql = "UPDATE `customer` SET `name` = '$name', `surname` = '$surname', `phone` = '$phone', `email` = '$email' WHERE `customer`.`id` = $id;";

       if ($conn->query($sql) === true) {
           echo "Update Data success";
           echo "<h4><a href='./showAll.php'>BACK</a></h4>";
       } else {
           echo "Error: " . $sql . "<br>" . $conn->error;
       }

       $conn->close();
   }


   function searchCustomerByName($name)
   {
       $conn = createMySqlConnection();
       if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
       }

       $sql = "SELECT * FROM customer WHERE `name` LIKE '%$name%' ";

        // sql inject: $sql = "SELECT * FROM customer WHERE `name` LIKE '%$name%' ";
        // SELECT * FROM customer WHERE `name` LIKE '%%' AND '1' = '1' UNION SELECT *, 1,1,1 FROM `users` WHERE '1%' = '1%'
        // *select 1,1,1 ให้ตารางมันเท่ากัน
        // ใช้ prepared statement ป้องกัน

        // prepared statement
        // normal case: 
        // php >>> connection >>> server
        // php >>> sql command with data >>> server // may be sql inject!!
        // php << receive data <<< server
        // php --X close connection X-- server

        // prepared statement case
        // php >>> connection >>> server
        // php >>> sql command (no-data) >>> server
        // php >>> send data >>> server
        // php >>> send data >>> server
        // php >>> send data >>> server
        // ...
        // php << receive data <<< server
        // php --X close connection X-- server


        // ป้องกันได้เพราะ ps แบ่ง command กับ data ออกจากกัน ถ้ามีการโจมตีจะมาพร้อมกัยดาต้า
       echo $sql;
       $result = $conn->query($sql);
       $customer = [];
       if ($result->num_rows > 0) {
           // output data of each row
           while ($row = $result->fetch_assoc()) {
               $customerDataRow = array(
                "id"=>$row["id"],
                "name"=>$row["name"],
                "surname"=>$row["surname"],
                "phone"=>$row["phone"],
                "email"=>$row["email"],
                "timestamp"=>$row["timestamp"],
            );
               array_push($customer, $customerDataRow);
           }
       }

       $conn->close();

       return $customer;
   }
   */