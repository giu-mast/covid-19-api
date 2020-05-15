<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chart.js test</title>
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
        <h1>Test grafici con Chart.Js</h1>
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
        <canvas id="dynamic" class="chart">
        </canvas>
      </div>
    </div>
  </div>

  <!-- LIBS AND POLYFILL -->
  <script src="node_modules/date-input-polyfill/date-input-polyfill.dist.js"></script>
  <script src="node_modules/choices.js/public/assets/scripts/choices.min.js"></script>


  <!-- CHART LIB -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

  <!-- TEMP COMMON OPS (init widgets, load test json, etc) -->
  <script type="text/javascript" src="../js/charts_common.js"></script>

  <script type="text/javascript">
    //Chart library test with actual data

    function draw(startDate, endDate, regions, districts, metrics){


      /* regionsData is the array containing all the data */
      let = dataset = JSON.parse(JSON.stringify(regionsData)).sort(function(a, b){ return Date.parse(a.data) > Date.parse(b.data) }),
            start   = Date.parse(startDate),
            end     = Date.parse(endDate);
      
      /* Metriche uguali devono avere tipi di series uguali! */
      /* Regioni uguali devono avere colori uguali! */
      
      /* IMPORTANT!! data filtering */

      if(!!start){
        dataset = dataset.filter(function(obj){
          return Date.parse(obj.data) > start
        })
      }

      if(!!end){
        dataset = dataset.filter(function(obj){
          return Date.parse(obj.data) < end
        })
      }

      if(!!regions.length){
        dataset = dataset.filter(function(obj){
          return regions.includes(obj.codice_regione)
        })
      }

      if(!!districts.length){
        dataset = dataset.filter(function(obj){
          return districts.includes(obj.codice_regione)
        })
      }
      
      console.log("dataset length", dataset.length)
      
      /* Create new chart */

      chart = am4core.create('dynamic', am4charts.XYChart)
      chart.colors.list = [
        am4core.color("#845EC2"),
        am4core.color("#D65DB1"),
        am4core.color("#FF6F91"),
        am4core.color("#FF9671"),
        am4core.color("#FFC75F"),
        am4core.color("#F9F871")
      ];

      let timeAxis = chart.xAxes.push(new am4charts.DateAxis())
      timeAxis.title.text = "Data"
      let valueAxis = chart.yAxes.push(new am4charts.ValueAxis())
      valueAxis.title.text = "Quantità assolute";

      /* create series */
      regions.forEach(function(region){
        metrics.forEach(function(metric){
          /* Corrispondenza metrica -> series */
          switch(metric){
            case 'totale_casi':
            case 'dimessi_guariti':
            case 'tamponi':
              let columnSeries = chart.series.push( new am4charts.ColumnSeries() );  
              columnSeries.dataFields.valueY = metric
              columnSeries.dataFields.dateX = 'data'
              columnSeries.columns.template.tooltipText = `${metric} in ${region} il {dateX}: {valueY}`;
              columnSeries.data = dataset.filter(function(d){
                return d.codice_regione === region
              })
            break;
            case 'deceduti':
              console.log(`${metric} in ${region}`)
              let lineSeries = chart.series.push( new am4charts.LineSeries() );
              lineSeries.tooltipText = `${metric} in ${region} il {dateX}: {valueY}`;
              lineSeries.strokeWidth = 2
              lineSeries.dataFields.valueY = metric
              lineSeries.dataFields.dateX = 'data'
              lineSeries.dataFields.valueY = metric
              lineSeries.dataFields.dateX = 'data'
              let bullet = lineSeries.bullets.push(new am4charts.Bullet());
              let circle = bullet.createChild(am4core.Circle);
              circle.width = 8;
              circle.height = 8;
              circle.tooltipText = `${metric} in ${region}: {${metric}}`;
              lineSeries.data = dataset.filter(function(d){
                return d.codice_regione === region
              })
            break;
            default:
              console.log(`${metric} still not handled`)
            break;
          }
        })
      });

    }

    function createXYChart(){
      console.log("DATA FIELDS: ")
      console.log(Object.keys(regionsData[0]))

      var ctx = 'dynamic';

      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [...new Set(regionsData.map(item => item.denominazione_regione))],
            datasets: [{
                label: '# of Votes',
                data: [...new Set(regionsData.map(item => item.terapia_intensiva))],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    }
    
  </script>
</body>
</html>