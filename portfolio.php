<!--STOCKFOLI PORTFOLIO HTML-->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>StockFoli | Dashboard</title>
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/responsive.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="main.css"/> 
        <link href='https://fonts.googleapis.com/css?family=Archivo+Black' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,700,300,100' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div class="portfolio-wrapper">

            <div id="header">
                <div id="portfolio-logo"> 
                    <!--<h1>StockFoli</h1>-->
                    <img src="img/StockFoliLogo.png">
                </div>
                <div id="account-wrapper">
                    <!-- Include account balance information, and portfolio worth information-->
                    <h1>Account wrapper</h1>
                    <ul>
                        <li><h4>Account Balance</h4></li>
                        <li><h4>Net Portfolio Value</h4></li>
                    </ul>

                </div>

                <div id="upload-search-logout-wrapper">
                    <!-- Include buttons and input search fields and logout and displayed digital time-->
                    <h1>Upload / Search / Logout Wrapper</h1>
                    <ul>
                        <li><a href="www.facebook.com">Upload CSV</a></li>

                        <!-- Search Bar Functionality 
                        Adapted from: http://stackoverflow.com/questions/16403221/creating-a-php-search-bar
                        -->
                        <li><form action="portfolio.php" method="POST">
                        <li><input id="search" name="search" type="text" placeholder="Type here" maxLength="5"></li>
                        <li><input id="submit" type="submit" name="searchSubmit" value="Search"></li>
                        </form></li>

                        <li><a href="index.php">Logout</a></li> 
                    </ul>
                </div>
            </div>
            
            <div id="columns-wrapper">

                <!--LEFT-->
                <div id="left-wrapper">
                    <div id="portfolio-widget">
                        <!--Include portfolio widget information-->
                        <h1>Portfolio Widget</h1>


                        <!-- This is a really temporary HTML table, but I think we need
                        to figure out how to populate a table with PHP, and this might not 
                        be the solution-->


                        <!-- Code to get data from Quandl API -->
                        
                        <!--
                        <table style="width:100%">
                            <tr>
                                <th>Ticker Name</th>
                                <th>Company Name</th>
                                <th>Stock Quantity</th>
                                <th>Current Price</th>
                            </tr>
                            <tr>
                                <td id="TN1">TN1</td>
                                <td>CN1</td>
                                <td>SQ1</td>
                                <td>CP1</td>
                            </tr>
                            <tr>
                                <td>TN2</td>
                                <td>CN2</td>
                                <td>SQ2</td>
                                <td>CP2</td>
                            </tr>
                            <tr>
                                <td>TN3</td>
                                <td>CN3</td>
                                <td>SQ3</td>
                                <td>CP3</td>
                            </tr>
                            <tr>
                                <td>TN4</td>
                                <td>CN4</td>
                                <td>SQ4</td>
                                <td>CP4</td>
                            </tr>
                            <tr>
                                <td>TN5</td>
                                <td>CN5</td>
                                <td>SQ5</td>
                                <td>CP5</td>
                            </tr>
                            <tr>
                                <td>TN6</td>
                                <td>CN6</td>
                                <td>SQ6</td>
                                <td>CP6</td>
                            </tr>
                            <tr>
                                <td>TN7</td>
                                <td>CN7</td>
                                <td>SQ7</td>
                                <td>CP7</td>
                            </tr>
                        </table>-->

                    </div>

                    <div id="buy-sell-widget">
                        <!-- Include buying and selling functionality. Do they choose stock to buy/sell before clicking those buttons, or after?-->
                        <h1>Buy / Sell Widget</h1>


                        <!-- How do we make buttons and whatnot????? -->
                        <ul>
                            <form action="users.php" method="GET">
                            <li><input style="width: 80px; float:center" id="submit" type="submit" value="Buy"></li>
                            </form>

                            <form action="users.php" method="GET">
                            <li><input style="width: 80px; float:center" id="submit" type="submit" value="Sell"></li>
                            </form>
                        </ul>

                    </div>
                </div>

                <!--CENTER-->
                <div id="center-wrapper">
                    <div id="tabs">
                        <p>We need two tabs here to switch between graph widget and ???</p>
                    </div>
                    <div id="graph-widget">
                        <!-- Include the two tabs (graph and watch list?) as well as those displays-->
                        <h1>Graph Widget</h1>
                        <img src="http://media.ycharts.com/charts/99c59a48940d02ffc75954117a986932.png" style="width: 95%">
                        <p>We also need buttons to change the time line stuff</p>
                    </div>

                    <div id="stock-information-widget">
                        <!-- Include the information about a certain stock. But how does this work if multiple stocks are shown? Dropdown list to choose which to display info for?-->
                        <h1>Stock Information Widget</h1>
                        <h3 style="text-align:left; padding-left: 40px">FCA</h3>
                        <p>Lots of more information about the selected stock</p>
                    </div>
                </div>

                <!--RIGHT-->
                <div id="right-wrapper">
                    <div id="digital-time">
                        <h1>12:34 PM EST</h1>
                    </div>
                    <div id="user-manual-widget">
                        <!-- Include the user manual information. Is this supposed to be FAQ displayed, or rather a popup window with more information?-->
                        <h1>User Manual Widget</h1>
                        <p>So you don't know how to use this website? StockFoli is so straight forward, I just don't understand
                            what you are having trouble with...Such high-tech</p>
                    </div>

                    <div id="watch-list-widget">
                        <!-- Include the watch list information (but wasn't that a tab?...)-->
                        <h1>Watch List Widget</h1>
                        <p>Is this supposed to be here or is it supposed to be a tab with the graph widget??</p>
                    </div>

                    <div id="recommended-action-widget">
                        <!-- Include recommended stock widget-->
                        <h1>Recommended Action Widget</h1>
                        <p>I don't think that this widget should go here since the watch-list will be long...the 
                            Group 11 SRS is confusing and this is not pretty so stay tuned for changes</p>
                    </div>

                    <div id="legend-widget">
                        <!-- Include a legend describing the functionality and colors?-->
                        <h1>Legend Widget</h1>
                        <p>Here's a description of what everything means in this webpage (I think). More to come</p>
                    </div>
                </div> 
            </div>


            <div id="test-wrapper">
                <h1>test wrapper</h1>
                <?php 
                        require_once "Quandl.php";
                        $api_key = "FEnyznn3PiGxaFbs-Yuz";
                        $symbol = "WIKI/FB";

                        $quandl = new Quandl($api_key, "json");
                        $data = $quandl->getResult($symbol);
                        //echo "facebook name";
                        //echo $data['code']; // STOCK SYMBOL (ex. AAPL)
                        //echo $data['name']; // STOCK NAME (ex. Facebook Inc. (FB) Prices, Dividends, Splits and Trading Volume)
                        //echo $data['data'][0][4]; // CLOSING DAY PRICE TODAY
                        //echo $data['data'][1][4]; // CLOSING DAY PRICE YESTERDAY
                        //echo "facebook name ", $data['code']; 

                       //For generating the table from different values


                        $colnames = ["CODE", "COMPANY", "STOCK QUANTITY", "CURRENT PRICE"];
                        $stocknames = ['WIKI/AAPL', 'WIKI/FB', 'WIKI/BMRN', 'WIKI/RARE']; 

                        echo "<table id='table1'>\n";
                        /*
                        for ($headerCount = 0; $headerCount < count($colnames); $headerCount++) {
                            echo <
                        }*/

                        /* http://stackoverflow.com/questions/22346707/dynamically-generate-table-using-php */

                        for ($i = 0; $i < count($stocknames); $i++) {
                            if ($i == 0) {
                                echo "<tr>";
                                for ($j = 0; $j < count($colnames); $j++) {
                                    $colname = $colnames[$j];
                                    echo "<th>$colname</th>";
                                }
                                echo"</tr>";
                            }
                            echo "<tr>";
                            $data = $quandl->getResult($stocknames[$i]);
                            $stockcode = $data['code'];
                            $stockname = explode('(', $data['name'])[0];
                            $stockquantity = '###';
                            $stockprice = $data['data'][0][4];

                            echo "<td>$stockcode</td>";
                            echo "<td>$stockname</td>";
                            echo "<td>$stockquantity</td>";
                            echo "<td>$stockprice</td>";   
                            echo "</tr>";
                        }

                        echo "</table>\n";
                        ?>
            </div>
        </div>
    </body>
</html>