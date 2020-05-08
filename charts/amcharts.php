<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AMCharts test</title>
  <!-- bootstrap CDN -->
  
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="node_modules/choices.js/public/assets/styles/choices.min.css" />


  <!-- custom style -->
  <style type="text/css">
    .chart{
      background: #eee;
      min-height: 400px; 
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h1>Test grafici con AMCharts</h1>
        <?php require('filters.php'); ?>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div id="chartdiv">
          
        </div>
      </div>
    </div>
  </div>

  <!-- LIBS AND POLYFILL -->
  <script src="node_modules/date-input-polyfill/date-input-polyfill.dist.js"></script>
  <script src="node_modules/choices.js/public/assets/scripts/choices.min.js"></script>


  <!-- CHART LIB -->
  <script src="//www.amcharts.com/lib/4/core.js"></script>
  <script src="//www.amcharts.com/lib/4/charts.js"></script>
  <script src="//www.amcharts.com/lib/4/themes/material.js"></script>
  <script src="//www.amcharts.com/lib/4/lang/it_IT.js"></script>

  <!-- TEMP COMMON OPS (init widgets, load test json, etc) -->
  <script type="text/javascript" src="../js/charts_common.js"></script>

  <script type="text/javascript">
    //Chart library test with actual data
    /* regionsData is the array containing all the data */

    function onCSVLoad(){
      console.log("DATA FIELDS: ")
      console.log(Object.keys(regionsData[0]))
    }
    
  </script>
</body>
</html>