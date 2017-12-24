<?php 
    require_once("./customerFunction.php");
    $customerList = getAllCustomer();
    // print_r($customerList);
    echo "
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
    ";
    for ($i=0; $i < count($customerList) ; $i++) { 
        $id = $customerList[$i]['id']; 
        printf("<tr><td>%d</td>", $id);
        printf("<td>%s</td>", $customerList[$i]['name']);
        printf("<td>%s</td>", $customerList[$i]['surname']);
        printf("<td>%s</td>", $customerList[$i]['phone']);
        printf("<td>%s</td>", $customerList[$i]['email']);
        printf("<td>%s</td>", $customerList[$i]['timestamp']);
        printf("<td><button><a href='insert.php?action=edit&id=%d'>edit</a></button></td>", $id);
        printf("<td><button onclick='deletePopUp(%d)'>delete</button></td>", $id);
        echo "</tr>";
    }
    
    echo "</table>";
    echo "<h4><a href='./index.php'>BACK</a></h4>";
?>