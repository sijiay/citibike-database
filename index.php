<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Info 340 Final</title>

    <!-- Bootstrap Core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>
    <style type="text/css">
     html, body, #map-canvas {height: 100%; margin: 0; padding: 0; }
     li{text-align: left; list-style-type: none;} 
     body > .container {padding-bottom: 60px;}
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp" type="text/javascript"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
   

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Citi Bike Data</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#about">About</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div id="map-canvas" style="width: 100%; height: 65%"></div>

    <!-- Page Content -->   
    <div class="container">
         <?php include 'db.php'; ?>
         <?php include 'graphs.php'; ?>
    
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>Find a CitiBike station in Manhattan</h1>
                <p class="lead">Choose stations by neighborhood.</p>
                
                <div class="btn-group">
                  <button class="btn  btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                    <span class="caret"></span> select one
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" class"text-center">
                      <li role="presentation" class="dropdown-header">Manhattan</li>
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Upper East Side</a></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Upper West Side</a></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Lower Manhattan</a></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Midtown</a></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Central Park</a></li>
                      
                  </ul>
                </div>

            </div>
        </div>
        <div class ="row">
        
        <div class="col-md-4">
  <h2>Visual of Ratio of Trips Taken By Girls vs Boys</h2>
  <p>It is important to note that the data used for the visual is the number of male/female subscribers(annual members). Citi Bike does not record the gender of regular Customers(24-hour or 7-day passes).</p></div>
  <div class="col-md-8"><div class="pull-left" id="donut_single" style="width: 500px; height: 500px;"></div></div>
</div>
  <div class="row" class="col-md-6">
    <h2>Top 20 Used Stations </h2>
    <div class="well">
      <h3>Start Stations</h3>
      <ul class="list-group">
        <?php for($i = 0; $i < count($top_start_stations); $i++):?>
        <li class="list-group-item">
          <span class="badge"><?php echo $top_start_stations[$i]['count'] ?></span>
          <?php echo 'Station ' . $top_start_stations[$i]['id'] ?>
        </li> <?php endfor; ?>
      </ul>
      <h3>End Stations </h3>
      <ul class="list-group">
        <?php for($i = 0; $i < count($top_end_stations); $i++):?>
        <li class="list-group-item">
          <span class="badge"><?php echo $top_end_stations[$i]['count'] ?></span>
          <?php echo 'Station ' . $top_end_stations[$i]['id'] ?>
        </li> <?php endfor; ?>
      </ul>
        
    </div>
</div>
<div class="row" class="col-md-6">
    <h2>Top Birthyears of Customers and Subscribers </h2>
    <div class="well">
      <h3>Start Stations</h3>
      <ul class="list-group">
        <?php for($i = 0; $i < count($by_counts); $i++):?>
        <li class="list-group-item">
          <span class="badge"><?php echo $by_counts[$i]['count'] ?></span>
          <?php echo 'Birthyear ' . $by_counts[$i]['by'] ?>
        </li> <?php endfor; ?>
      </ul>       
    </div>
</div>
<div class="col-md-8" id="about">
  <h2>Project Summary </h2>
          <p>For this project, I have used public data from the CitiBike bike share program in New York.; I became interested in this data when I was visiting New York City in October. The dataset that I chose contains all trips from the month of August. I have a relational database on the server with the tables: trip, stations, gender, user_type, and street. At first I wanted to make a customer entity, but I realized since this data was public, the only customer data was their gender, birthyear, and subscription type. I knew that this data alone would not be sufficient enough to make a customer data. </p>
          <p>Since my relational database, I tried to push myself to do a little more than what was required from the project. The first thing I did was create a street table, which has ids for every street that has a station. Also, I used what we learned towards the end of the quarter, functions, in my own python code. My project had similar concepts to the labs that we did for class. I also had functions that would check if a value was present and insert it if it wasn’t( much like the insertHT function). I also created a json file for the neighborhoods of Manhattan, that include coordinates and general bounding coordinates for the neighborhood. The most difficult part of this project was server-side/client-side communication while I was trying to implement google maps. As you see from the website, I have implemented a dropdown menu that allows the user to choose a neighborhood in Manhattan. The map will then display the neighborhood and all stations in that neighborhood. It seems relatively simple, but I had a lot of trouble getting the selected dropdown menu item from javascript to php and then back. As a future project, I definitely want to learn how to use Node.js, so I never have to use javascript and php together again. Aside from the neighborhood selection, I have some data displayed including a graph. The graph shows the number female, male and unknown for all trips made by subscribers. Although it seems like it is just a ration of male to female, there in fact (249) trips that don’t have any gender defined. This number is much smaller compared to the number of trips by females/males to even show up on the graph. </p>
          <p>Overall, I really enjoyed the amount of freedom that I had to do this project. All of the features that I implemented are using data taken from queries from the database(thats why the page loads so slowly.) I found a dataset that I am interested and want to work with after this class. I would appreciate any feedback or ideas about other features I can add to my interface or other queries I can try out. </p>
        </div>
        </div>
        </div>

        <!-- /.row -->

    </div>
    <!-- /.container -->
    <footer class="footer">
      <div class="container">
        <p class="text-muted">Info 340 Fall 2014, Alice Yan</p>
      </div>
    </footer>
    <!-- jQuery Version 1.11.1 -->
     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="./js/bootstrap.min.js"></script>
    <script type="text/javascript" >
     var map;
     var geocoder;
     var bounds = new google.maps.LatLngBounds();
     var markersArray = [];
     var travelMode;
     var myArray;
     var nbSelection;
     var markers =[];
    //var origin;
    //var destination = new google.maps.LatLng(47.658335, -122.302662);
    var infoWindow = new google.maps.InfoWindow();

    var nbArray = <?php echo file_get_contents("neighborhoods.json");?>;
    google.maps.event.addDomListener(window, 'load', initialize);
    function initialize() {
      var opts = {
        center: { lat : 40.790278,
               lng : -73.959722},
          zoom: 13
        };
        map = new google.maps.Map(document.getElementById('map-canvas'), opts);
        geocoder = new google.maps.Geocoder();
      }
      
      
      function doit(neighborhood){ 
        var location = new google.maps.LatLng(neighborhood.geometry.location.lat,neighborhood.geometry.location.lng);
        map.setCenter(location);
        map.setZoom(14);
      }
      function drawMarker(stations_list) {
          for (i = 0; i< stations_list.length; i++){
              var temp = stations_list[i];
              createMarker(temp.lat, temp.long, temp.name, temp.id);
          } 
      }

      function createMarker(lat,lng, name, id) {
          var html = "<b> Station " + id + "</b> <br/>" + name;
          var latlng = new google.maps.LatLng(lat,lng);
          //alert(latlng);
          var marker = new google.maps.Marker({
            position: latlng,
            map: map
          });    
          google.maps.event.addListener(marker, 'click', function() {
             infoWindow.setContent(html);
             infoWindow.open(map, marker);
          });
          marker.setMap(map);
          markers.push(marker);
          //markers.push(marker);
     } 
     function removeMarkers(){
        for(var i=0; i<markers.length; i++){
            markers[i].setMap(null);
       }
       markers.length = 0;
    }
     $(document).ready(function(){

      $(".dropdown-menu").on('click', 'li a', function(){
        $(".btn:first-child").text($(this).text());
        $(".btn:first-child").val($(this).text());
        nbSelection = $(this).text();
        var nbJSON = '{ neighborhood: ' + nbSelection + '}';
        var temp;
        for (i = 0; i <nbArray.neighborhoods.length; i++){
          if (nbArray.neighborhoods[i].nickname == nbSelection){
            temp = nbArray.neighborhoods[i];
          }
        }
        $.post("searchStations.php", temp.geometry, function( data ) {
            //alert(data);
            myArray = JSON.parse(data);
            removeMarkers();
            drawMarker(myArray);

        }).fail(function() {
         
            // just in case posting your form failed
            alert( "Posting failed." );
             
        });

        doit(temp);
     });
});

      google.setOnLoadCallback(drawChart);
      function drawChart() {
        
        var data = google.visualization.arrayToDataTable([
          ['Effort', 'Amount given'],
          ['Male',  <?php echo $ms_count; ?>],
          ['Female',<?php echo $fs_count; ?>],
          ['Unknown',<?php echo $us_count; ?>]
        ]);

        var options = {
          pieHole: 0.25,
          pieSliceTextStyle: {
            color: 'white',
          },
          slices: {
            0: { color: '#81CFE0' },
            1: { color: '#336E7B' },
            2: { color: '#2C3E50'}
          },
          legend: 'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('donut_single'));
        chart.draw(data, options);
      }
</script>


</body>
<?php pg_close($db); ?>
</html>
