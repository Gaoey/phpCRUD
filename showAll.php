<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>show all</title>
        <style>
         tr:nth-child(even) {
             background-color: #f2f2f2;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        table {
             border-collapse: collapse;
             width: 100%;
             text-align: center;
            }
        tr:hover {background-color: #f5f5f5;}
        th {
            height: 50px;
        }
        </style>
        <script>
            function deletePopUp(id) {
                var txt;
                if (confirm("Do you want to delete?") == true) {
                    window.open("delete.php?id="+id, "_self")
                }
            }
        </script>
    </head>
    <body>
        <?php require_once("./customerFunction.php"); ?>
        <h1>Customer</h1>
        <table>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>surname</th>
                <th>phone</th>
                <th>email</th>
                <th>timestamp</th>
                <th>edit</th>
                <th>delete</th>
            </tr>
            <?php $customerList = getAllCustomer(); ?>
            <?php for ($i=0; $i < count($customerList) ; $i++) { 
                $id = $customerList[$i]['id']; 
            ?>
            <tr>
                <td><?php echo $id ?></td>
                <td><?php echo $customerList[$i]['name']; ?></td>
                <td><?php echo $customerList[$i]['surname']; ?></td>
                <td><?php echo $customerList[$i]['phone']; ?></td>
                <td><?php echo $customerList[$i]['email']; ?></td>
                <td><?php echo $customerList[$i]['timestamp']; ?></td>
                <td><button><a href='insert.php?action=edit&id=<?php echo $id; ?>'>edit</a></button></td>
                <td><button onclick='deletePopUp(<?php echo $id; ?>)'>delete</button></td>
            </tr>
            <?php } ?>
        </table>
        <h4><a href="./index.php">BACK</a></h4>
    </body>
</html>