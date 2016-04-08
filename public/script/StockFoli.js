/**
 * Created by benjaminschoen on 19/03/16.
 */

var fillColors = ["rgba(51,0,204,0.3)","rgba(153,0,102,0.3)","rgba(0,153,51,0.3)"];
var pointColors = ["rgba(51,0,204,1)","rgba(153,0,102,1)","rgba(0,153,51,1)"];
var selectedStocks = [];

function graphSelectedStock(symbolString, interval) {
     interval = interval || $("#selectedTimeRange li.active").text();

    $.ajax("/stockData", {
        method: "POST",
        data: {ticker: symbolString, interval: interval},
        dataType: "json",
        success: function (data) {
            var lineChartData = {
                labels: data[0].labels,

                //chartJS demands you have a key called labels and a value called datasets
                datasets: data.map(function (dataset, i) {
                    return {
                        label: dataset.symbol,
                        data: dataset.values,
                        fillColor: fillColors[i % 3],
                        strokeColor: "#999",
                        pointColor: pointColors[i % 3],
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#000",
                        pointHighlightStroke: pointColors[i % 3]
                    };
                })
            };
            window.myLine.destroy();
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myLine = new Chart(ctx).Line(lineChartData, {responsive: true,
                legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].pointColor%>;width:1em;height:1em\">&nbsp;&nbsp;&nbsp;</span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"


            });
            document.getElementById("legend").innerHTML = window.myLine.generateLegend();

        }


    });
}

function fillDetailedInformation(singleStockSelected){
    $.ajax("/detailedInformation",{
        method: "POST",
        data: {ticker: singleStockSelected},
        dataType: "json",
        success: function (data){

            data = data.stocks;

            var percent_change = ((data[0].current_price - data[0].previous_price)/data[0].current_price)*100;
            var rounded_percent_change = percent_change.toFixed(2);

            $("#detailedInformationTable tbody tr:nth-child(2) td:nth-child(1)").html(data[0].company_name);
            $("#detailedInformationTable tbody tr:nth-child(2) td:nth-child(2)").html(data[0].ticker);
            $("#detailedInformationTable tbody tr:nth-child(2) td:nth-child(3)").html(data[0].quantity);
            $("#detailedInformationTable tbody tr:nth-child(4) td:nth-child(1)").html(data[0].current_price);




            $("#detailedInformationTable tbody tr:nth-child(4) td:nth-child(3)").html((rounded_percent_change));
           if(rounded_percent_change > 0)
           {
               $("#detailedInformationTable tbody tr:nth-child(4) td:nth-child(3)").css("color", "#0c0");
           }
            else if(rounded_percent_change < 0){
               $("#detailedInformationTable tbody tr:nth-child(4) td:nth-child(3)").css("color", "#c00");
           }
            else
           {
               $("#detailedInformationTable tbody tr:nth-child(4) td:nth-child(3)").css("color", null) ;
           }




            $("#detailedInformationTable tbody tr:nth-child(4) td:nth-child(2)").html((data[0].previous_price));
            // $("#detailedInformationTable").find(".quantity").html(data[count].quantity);
            $("#detailedInformationTable").css({display: "block"});
        }

    });
}
//document.ready is a jquery function
//it is automatically called when the page is ready (all assets - css, html, javascript - are loaded - not pending) - it's a general jquery function
//For us, the lambda function inside of document.ready handles formatting the watchlist and portfolio tables and setting up the check boxes and associated event handlers that are used to display graph and detailed information
//it also handles clicks on the different interval buttons

//.ready sets up the web page to respond to 2 different events that lead to graphing stock data
//1st - if a stock in the watch or portfolio list is selected or deselected (the checkbox)
//2nd - if a different time interval is selected
$(document).ready(function(){
    //this makes are table look good with bootgrid and makes the rows selectable with check boxes
    $("#watchlistTable, #portfolioTable").bootgrid({selection:true, multiSelect: true, navigation: 2});

    //this is the function that is called when a row in the tables is selected
    $("#watchlistTable, #portfolioTable").each(function(){

        //$(this) equals the higher level html element currently being selected (either watchlist or portfolio)
        //css selector syntax requires a # so we did string math to form the correct selector.
        var id = "#" + $(this).prop('id');
        $(this).bootgrid().on("selected.rs.jquery.bootgrid deselected.rs.jquery.bootgrid", function (e)
        {
            /* bootgrid(getSelectedRows) is a jquery function written for us that returns the selected rows in id form (the ticker symbol) */
            var symbols = $(id).bootgrid("getSelectedRows");

            //we needed a global variable to know which stocks were selected for interval changing so we made selectedStocks
            selectedStocks = symbols;
            var symbolString = symbols.join(",");

            //we pass every selected stocks ticker symbol to graphSelectedStock as one string. this function sends that string to the server who then explodes that string
            //honestly, there might be an easier way to do it
            if(symbols.length > 0)
            {
                graphSelectedStock(symbolString);
            }

            //if only one row is selected then all buttons in the high level table are enabled
            if(symbols.length==1)
            {
                $("button", $(this).parent()).prop("disabled", false);
                //fills the hidden field of the transaction form so the server knows what stock you are buying or selling
                $("input[name='ticker']",$(this).parent()).val(symbols[0]);

                //Populate Detailed Information Div
                var singleStockSelected = symbols[0];
                fillDetailedInformation(singleStockSelected);

            }
            else {
                $("button", $(this).parent()).prop("disabled", true);
            }



        });

        });

    //Changing intervals
    $("#selectedTimeRange li").on("click", function(e){
       graphSelectedStock(selectedStocks.join(","), $(e.target).text());
    });

});


