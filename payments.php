<?php

function fetchfromdatabase($query) {
    $host = 'localhost';
    $dbname = 'classicmodels';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        $result = $conn->query($query);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        return $result;

        } 
        catch (PDOException $pe) {
            die("Could not connect to the database $dbname :" . $pe->getMessage());
        }

} 
$sql = "SELECT *
        FROM payments
        ORDER BY paymentDate DESC
        LIMIT 20";
 

$result=fetchfromdatabase($sql);

?>



<!DOCTYPE html>

<html>
    <head>
        <title>Classic Models</title>
        <link rel="stylesheet" type="text/css" href="style.css">   
    </head>
    <body>
        <div id='container'>
            <?php include 'navigation.php';?>
            <p><img src="pngwing.com.png" alt="Vintage Car"></p>
            <h2>Payments</h2>
            <div id="paymentstable">
             <table>
                     <tr>
                         <th>Check Number</th>
                         <th>Payment Date</th>
                         <th>Amount</th>
                         <th>Customer Number</th>
                    </tr>
           
                <?php
                    $counter=0;        
                    while ($row = $result->fetch()): 
                        $customer=$row['customerNumber'];
                        $customerid="moreinfo$counter"; ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['checkNumber']); ?></td>
                        <td><?php echo htmlspecialchars($row['paymentDate']); ?></td>
                        <td><?php echo htmlspecialchars($row['amount']); ?></td>
                        <td><a href="javascript:void(0);" onclick=myFunction('<?php echo htmlspecialchars($customerid) ?>')><?php echo htmlspecialchars("$customer") ?></a></td>
                </tr>   
                <tr>
                    <td colspan="4">
                        <table id="<?php echo htmlspecialchars($customerid) ?>" class="customertable">
                                <tr>
                                    <th>Phone Number</th>
                                    <th>Sales Rep</th>
                                    <th>Credit Limit</th>
                                    <th>All Payments</th>
                                    <th>Total Paid</th>
                                </tr>
              
                                <?php
                                $counter++;
                                
                                $sql1 = "SELECT c.phone, c.salesRepEmployeeNumber, c.creditLimit, GROUP_CONCAT(DISTINCT p.amount SEPARATOR ', ') AS amount, SUM(p.amount) AS total
                                        FROM payments p, customers c
                                        WHERE p.customerNumber = c.customerNumber
                                        AND p.customerNumber = '$customer' ";
        
                                       

                                $result1=fetchfromdatabase($sql1);
                                while ($row1 = $result1->fetch()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row1['phone']); ?></td>
                                    <td><?php echo htmlspecialchars($row1['salesRepEmployeeNumber']); ?></td>
                                    <td><?php echo htmlspecialchars($row1['creditLimit']); ?></td>
                                    <td><?php echo htmlspecialchars($row1['amount']); ?></td>
                                    <td><?php echo htmlspecialchars($row1['total']); ?></td>
                                </tr>
                    <?php endwhile; ?>
                        </table>
                    </td>
                 </tr>
                <?php endwhile; ?> 
            </table>
            </div>        
         <?php include 'footer.php';?>
        </div>
    </body>
    <script>
        function myFunction(customerid) {
            var classlist = document.getElementsByClassName("customertable");
            for (var i = 0; i < classlist.length; i++) {
                classlist[i].style.display = "none";    
        }
      
            document.getElementById(customerid).style.display = "block";      
        }
    </script>
</html> 