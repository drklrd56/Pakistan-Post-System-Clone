
<!doctype HTML>
<html>
    <head>
        <title>Pakistan Post</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="Handlers/style.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php"><img src="logo.jpg" height=100 alt=""></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="Track.php">Track Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Customer.php">Customer Record</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Funds.php">FundsHistory</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            DataBase Control
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="Handlers/Create.php">CreateSQLSchema</a>
                        <a class="dropdown-item" href="Handlers/Delete.php">DeleteSQLSchema</a>
                        <a class="dropdown-item" href="Handlers/Insert.php">InsertRecords</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="Form_Container">
	        <h5 style="text-align:center; margin-bottom: 20px;">Track Your Order</h5>
            <form action="Handlers/TrackHandler.php" method="POST">
                <div class="form-group">
                    <div><label class="labl" >TrackingID</label></div>
                    <textarea class="form-control" name="trackingID" id="" cols="30" rows="5" required></textarea>
                </div>
                <button style="margin-left: 10%" type="submit" class="btn btn-default" name="TrackID">Track</button>
            </form>
            <button type="submit" name="Search"  class="btn btn-default">
            <a href="FindTracking.php" target="_Blank" style="color:white;"> Forgot TrackingID</a></button>

        </div>
    </body>
</html>