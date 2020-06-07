<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../img/icona.ico" />
  <title>API COVID-19</title>
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
        <p>
          Da leggere assolutamente:
          <a href="https://www.amcharts.com/docs/v4/concepts/data/" target="_blank">
            AMCharts v.4 - Data
          </a>
        </p>
        <?php require('filters.php'); ?>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <h2>Grafico dinamico</h2>
        <div id="dynamic" class="chart">
          
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
  <script src="//www.amcharts.com/lib/4/themes/animated.js"></script>
  <script src="//www.amcharts.com/lib/4/lang/it_IT.js"></script>

  <!-- TEMP COMMON OPS (init widgets, load test json, etc) -->
  
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script type="text/javascript">
    $(function() {
        $('#api').change(function(){
            $('.divs').hide();
            $('#' + $(this).val()).fadeIn(500);
        });
    });

    function createSeries(chart, metric,) {
      var series = chart.series.push(new am4charts.LineSeries());
      series.dataFields.valueY = metric;
      series.dataFields.dateX = "date";
      series.name = metricsTranslations[metric];
      series.tooltipText = "{dateX}: [b]{valueY}[/]";
      series.strokeWidth = 2;
      
      var bullet = series.bullets.push(new am4charts.CircleBullet());
      bullet.circle.stroke = am4core.color("#fff");
      bullet.circle.strokeWidth = 2;
      series.data = dataset.filter(function(d){
        return d.codice_regione === region
      })
      return series;
    }
    

    function draw(data, metrics){
      /* Reset chart */
      xyChart.dispose()

      /* regionsData is the array containing all the fetched data */
      
      let dataset = regionsData;
      console.log(regionsData)
      
      console.log("dataset length", dataset.length)
      
      /* Create new chart */

      xyChart = am4core.create('dynamic', am4charts.XYChart);

      var timeAxis = xyChart.xAxes.push(new am4charts.DateAxis())
      timeAxis.title.text = "Data"
      var valueAxis = xyChart.yAxes.push(new am4charts.ValueAxis())
      valueAxis.title.text = "Quantità assolute";

      data.forEach(function(region){
        metrics.forEach(function(metric){
          console.log(`metric ---> ${metric}`)
          switch(metric){
              case 'released_cured':
              case 'swabs':
              case 'region_code':
              case 'intensive_care':
              case 'total_hospitalized':
              case 'hospitalized_with_symptoms':
              case 'home_isolation':
              case 'total_positives':
              case 'total_variation_positives':
              case 'new_positives':
              case 'released_cured':
              case 'swabs':
              case 'testes_cases':
                console.log(`ColumnSeries in ${regions[region]} for metric -> ${metric}`)
                var columnSeries = xyChart.series.push( new am4charts.ColumnSeries() );  
                columnSeries.dataFields.valueY = metric
                columnSeries.dataFields.dateX = 'date'
                columnSeries.columns.template.tooltipText = `${metricsTranslations[metric]} in ${regions[region]} il {dateX}: {valueY}`;
                var d = dataset.filter(function(o){
                  return parseInt(o.region_code) === region
                });
                console.log(d.length, d)
                columnSeries.data = d
              break;
            break;
            case 'total_deaths':
            case 'total_cases':
              console.log(`LineSeries in ${regions[region]} for metric -> ${metric}`)
              var lineSeries = xyChart.series.push( new am4charts.LineSeries() );
              lineSeries.tooltipText = `${metricsTranslations[metric]} in ${regions[region]} il {dateX}: {valueY}`;
              lineSeries.strokeWidth = 2
              lineSeries.dataFields.valueY = metric
              lineSeries.dataFields.dateX = 'date'
              var bullet = lineSeries.bullets.push(new am4charts.Bullet());
              var circle = bullet.createChild(am4core.Circle);
              circle.width = 8;
              circle.height = 8;
              circle.tooltipText = `${metricsTranslations[metric]} in ${regions[region]} il {dateX}: {valueY}`;
              var d = dataset.filter(function(o){
                return parseInt(o.region_code) === region
              })
              console.log(d);
              lineSeries.data = d;
            break;
          }
        })
      });

      //data.forEach(function(region){
      //  metrics.forEach(function(metric){
      //    /* Corrispondenza metrica -> series */
      //    switch(metric){
      //      case 'total_cases':
      //      case 'released_cured':
      //      case 'swabs':
      //        let columnSeries = xyChart.series.push( new am4charts.ColumnSeries() );  
      //        columnSeries.dataFields.valueY = metric
      //        columnSeries.dataFields.dateX = 'data'
      //        columnSeries.columns.template.tooltipText = `${metric} in ${region} il {dateX}: {valueY}`;
      //        columnSeries.data = dataset
      //      break;
      //      case 'total_deaths':
      //        let lineSeries = xyChart.series.push( new am4charts.LineSeries() );
      //        lineSeries.tooltipText = `${metricsTranslations[metric]} in ${regions[region]} il {dateX}: //{valueY}`;
      //        lineSeries.strokeWidth = 2
      //        lineSeries.dataFields.valueY = metric
      //        lineSeries.dataFields.dateX = 'date'
      //        let bullet = lineSeries.bullets.push(new am4charts.Bullet());
      //        let circle = bullet.createChild(am4core.Circle);
      //        circle.width = 8;
      //        circle.height = 8;
      //        circle.tooltipText = `${metricsTranslations[metric]} in ${regions[region]} il {dateX}: {${metric}//}`;
      //        lineSeries.data = dataset
      //      break;
      //      default:
      //        console.log(`${metric} still not handled`)
      //      break;
      //    }
      //  })
      //});

    }

    function chartsInit(){
      am4core.useTheme(am4themes_animated);
      window.xyChart = am4core.create('dynamic', am4charts.XYChart)

    }
    
  </script>
  <script type="text/javascript" src="../js/charts_common.js"></script>
</body>
</html>