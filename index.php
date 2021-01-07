
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
$sql = 'SELECT  *
        FROM productlines';

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
            <h2>Product Lines</h2>
                             <?php 
                                    $counter=0;
                                    while ($row = $result->fetch()):
                                    
                                    $productline=$row['productLine'];
                                    $productlineid="moreproducts$counter";  ?>
                              
                                    <h3><a href="javascript:void(0);" onclick=myFunction('<?php echo htmlspecialchars($productlineid) ?>')><?php echo htmlspecialchars("$productline")?></a></h3>
                                    <p><?php echo htmlspecialchars($row['textDescription']); ?></p>
                                    <div id="indextable">
                                        <table id="<?php echo htmlspecialchars($productlineid) ?>" class="productstable">
                                             <thead>
                                                 <tr>
                                                    <th>Product Code</th>
                                                    <th>Product Name</th>
                                                    <th>Product Line</th>
                                                    <th>Product Scale</th>
                                                    <th>Product Vendor</th>
                                                    <th>Product Description</th>
                                                    <th>Quantity in Stock</th>
                                                    <th>Buy Price</th>
                                                    <th>MSRP</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <?php
                                                $counter++;
                                                
                                                $sql1 = "SELECT  *
                                                        FROM productlines pl, products p
                                                        WHERE pl.productLine = p.productLine
                                                        AND pl.productLine = '$productline'
                                                        ";

                                                $result1=fetchfromdatabase($sql1);
                                                while ($row1 = $result1->fetch()): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row1['productCode'])?></td>
                                                    <td><?php echo htmlspecialchars($row1['productName']); ?></td>
                                                    <td><?php echo htmlspecialchars($row1['productLine']); ?></td>
                                                    <td><?php echo htmlspecialchars($row1['productScale'])?></td>
                                                    <td><?php echo htmlspecialchars($row1['productVendor']); ?></td>
                                                    <td><?php echo htmlspecialchars($row1['productDescription']); ?></td>
                                                    <td><?php echo htmlspecialchars($row1['quantityInStock'])?></td>
                                                    <td><?php echo htmlspecialchars($row1['buyPrice']); ?></td>
                                                    <td><?php echo htmlspecialchars($row1['MSRP']); ?></td>
                                                </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>    
                             <?php endwhile; ?>
                      
             <?php include 'footer.php';?>
         </div>
    </body>
    <script>
        function myFunction(productlineid) {
            var classlist = document.getElementsByClassName("productstable");
            for (var i = 0; i < classlist.length; i++) {
                classlist[i].style.display = "none";     
        }
            document.getElementById(productlineid).style.display = "block";      
        }
    </script>
</html>
                  