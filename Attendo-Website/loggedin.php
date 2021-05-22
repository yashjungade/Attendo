<?php 

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location: loginPage.php");
}
?>



<html>
    
    <head>
        <title>Attendo|loggedin</title>
        <link href="logo1.jpeg" rel="icon" />
    </head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <body>
        <div>
            <header style="background-color: #123255; padding: 1rem; display:flex; justify-content: space-between;">
                <div style="display:flex;">    
                    <h4 style="color:rgb(248, 205, 191); " ;>
                        <?php echo "Welcome ". $_SESSION['username']?></h4>
                    </div>
                    <a href="logout.php" style="display:flex; text-decoration: none;">
                        <h4 style=" display:inline-block; margin: 0px 1rem;
                            color: rgb(248, 205, 191);
                            background-color: #123255;
                            padding: .3rem;
                            text-align: center;
                            border: 2px solid rgb(248, 205, 191);
                            border-radius: 50px;
                            font-size: 1rem;
                            cursor: pointer;
                            outline: none;
                            width: 6.5rem;">
                            Log Out</h4>
                        </a>
                    </header>
                        <br>
                        <h3 style="margin: 1rem">You have succesfully loggedin</h3>
                        <h4 style="margin: 1rem">Check your attendance here:</h4>
                        <br>
                        <table table-dark style="margin-left: auto; 
                        margin-right: auto; width:60%; text-align: center; color:#0a1b2e; font-weight:bold; 
                        font-size:20px; border-collapse: collapse; background-color: #a7c4e4; border:2px solid #112336" border="3"
                                cellspacing="1" cellpadding="5">
                                <tr style="background-color: #112336;">
                                    <td style="color:white">
                                        <font face="Times">Name</font>
                                    </td>
                                    <td style="color:white">
                                        <font face="Times">Date</font>
                                    </td>
                                    <td style="color:white">
                                        <font face="Times">Time</font>
                                    </td>
                                </tr>
                                <?php
                                $username = 'root';
                                $password = '';
                                $database = 'login';
                                   $mysqli = new mysqli("localhost", $username, $password, $database);
                                        $x=$_SESSION['username'];
                                        $query = "SELECT * FROM attendance WHERE name='$x' ORDER BY Date DESC";
                                        if ($result = $mysqli->query($query)) {
                                                while ($row = $result->fetch_assoc()) {
                                                        $Name = $row["Name"];
                                                        $Date = $row["Date"];
                                                        $Time = $row["Time"];

                                                        echo '<tr> 
                                                                <td>'.$Name.'</td> 
                                                                <td>'.$Date.'</td> 
                                                                <td>'.$Time.'</td> 
                                                            </tr>';
                                            }
                                            $result->free();
                                        }  
                                ?>
                    <footer style="position:absolute; right: 1rem; bottom: 1rem;">
                        <img style="width: 8rem; opacity:0.6" src="logo.jpeg"><a
                        href="mainPage.html"></a></img>
                    </footer>
                </div>

</body>

</html>