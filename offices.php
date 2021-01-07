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
$sql = 'SELECT *
        FROM offices';
 

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
            <h2>Offices</h2>
            <div id="officetable">
             <table>
                     <tr>
                         <th>City</th>
                         <th>Address</th>
                         <th>Phone Number</th>
                         <th>Employees</th>
                    </tr>
           
                <?php
                    $counter=0;        
                    while ($row = $result->fetch()): 
            
                        $office=$row['officeCode'];
                        $officeid="moreinfo$counter"; ?>

                    <tr>
                        <td><?php echo htmlspecialchars($row['city']); ?></td>
                        <td><?php echo htmlspecialchars($row['addressLine1']).', '.htmlspecialchars($row['addressLine2']).', '.htmlspecialchars($row['state']).' '.htmlspecialchars($row['country']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><button onclick=myFunction('<?php echo htmlspecialchars($officeid) ?>')>More Info</button></td>
                        </tr>
                
                    <tr>         
                        <td colspan="4">
                            <table id="<?php echo htmlspecialchars($officeid) ?>" class="employeetable">
                                <tr>
                                    <th>Name</th>
                                    <th>Job Title</th>
                                    <th>Employee Number</th>
                                    <th>Email Address</th>
                                </tr>
                         
                                <?php
                                $counter++;

                                $sql1 = "SELECT *
                                        FROM offices o, employees e
                                        WHERE o.officeCode = e.officeCode
                                        AND o.officeCode = '$office' 
                                        ORDER BY e.jobTitle";

                                $result1=fetchfromdatabase($sql1);
                                while ($row1 = $result1->fetch()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row1['firstName']).' '.htmlspecialchars($row1['lastName']); ?></td>
                                    <td><?php echo htmlspecialchars($row1['jobTitle']); ?></td>
                                    <td><?php echo htmlspecialchars($row1['employeeNumber']); ?></td>
                                    <td><?php echo htmlspecialchars($row1['email']); ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </table>
                        </td>
                    </tr>
                <?php endwhile; ?>    
            </table> 
        </div>            
        </div>
     <?php include 'footer.php';?>
    </body>
    <script>
        function myFunction(officeid) {
            var classlist = document.getElementsByClassName("employeetable");
            for (var i = 0; i < classlist.length; i++) {
                classlist[i].style.display = "none";     
        }
            document.getElementById(officeid).style.display = "block";      
        }
    </script>
</html>