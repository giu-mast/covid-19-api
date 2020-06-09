<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../img/icona.ico" />
  <title>API COVID-19</title>
  <link rel="stylesheet" href="/charts/node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/charts/node_modules/choices.js/public/assets/styles/choices.min.css" />

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
      <div class="col-md-8 offset-md-2">
        <h1>Grafici interattivi</h1>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8 offset-md-2 my-5">
        <h2>Istogramma</h2>
        <?php require('filters.php'); ?>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div id="dynamic" class="chart">
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col-md-8 offset-md-2 my-5">
        <h2>Grafico a torta</h2>
        <?php require('filters_pie.php'); ?>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div id="piechart" class="chart">
        </div>
      </div>
    </div>

  </div>

  <!-- LIBS AND POLYFILL -->
  <script src="/charts/node_modules/date-input-polyfill/date-input-polyfill.dist.js"></script>
  <script src="/charts/node_modules/choices.js/public/assets/scripts/choices.min.js"></script>


  <!-- CHART LIB -->
  <script src="//www.amcharts.com/lib/4/core.js"></script>
  <script src="//www.amcharts.com/lib/4/charts.js"></script>
  <script src="//www.amcharts.com/lib/4/themes/animated.js"></script>
  <script src="//www.amcharts.com/lib/4/lang/it_IT.js"></script>

  <!-- TEMP COMMON OPS (init widgets, load test json, etc) -->
  
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script type="text/javascript">
    $(function() {
        $('.js-api').each(function(i,v){
          let $form = $(v).closest('form');
          $(v).change(function(){
            $form.find('.divs').hide();
            $form.find('.' + $(this).val()).fadeIn(500);
          });
        })
    });

    /* 1. VAI A VEDERE IN charts_common COSA SUCCEDE DURANTE L'INIZIALIZZAZIONE */

    function draw(data, metrics){

      /* 
        in data se ho selezionato le regioni:
          - ho l'elenco degli id delle regioni (1, 3, 4, etc)
        se ho selezionato le province:
          - ho l'elenco delle sigle delle province (BA, FG, RM, etc)
        
        in metrics ho un array delle metriche selezionate :
          ['total_deaths', 'swabs', etc etc]

      */

      /* Reset charts */
      xyChart.dispose()

      /* in fetchedData ho tutti i dati prelevati dalle API */
      
      let dataset = fetchedData;
      console.log(fetchedData)
      
      /* Ricreo il grafico */

      xyChart = am4core.create('dynamic', am4charts.XYChart);


      /*  
          Asse X -> Date
          Asse Y -> numeri 
      */
      var timeAxis = xyChart.xAxes.push(new am4charts.DateAxis())
      timeAxis.title.text = "Data"
      var valueAxis = xyChart.yAxes.push(new am4charts.ValueAxis())
      valueAxis.title.text = "Quantità assolute";

      /*
        Ecco la parte più complicata:
        PER OGNI REGIONE che ho selezionato nella select e PER OGNI METRICA (deceduti, totale casi, etc)
        vado a creare una series di amcharts e la vado ad aggiungere al grafico

        Uso uno switch per capire a seconda della metrica di turno quale tipo di series utilizzare (ColumnSeries o LineSeries epr il momento)

        per le metriche released_cured, swabs, region_code, intensive_care, total_hospitalized, etc uso una ColumnSeries
        per le metriche total_deaths, total_cases utilizzo una LineSeries

      */

      data.forEach(function(region){
        metrics.forEach(function(metric){
          console.log(`metric ---> ${metric}`)
          switch(metric){
              case 'released_cured':
              case 'swabs':
              case 'region_code':
              case 'district_name':
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

                /* Qui setto quale metrica (es. "released_cured", "swabs") deve vedere la series per l'asse Y*/
                columnSeries.dataFields.valueY = metric
                /* Qui setto quale metrica (il campo "date") deve vedere la series per l'asse X */
                columnSeries.dataFields.dateX = 'date'
                columnSeries.columns.template.tooltipText = `${metricsTranslations[metric]} in ${regions[region]} il {dateX}: {valueY}`;

                /* Assegno i dati filtrati per regione alla series */
                var d = dataset.filter(function(o){
                  return parseInt(o.region_code) === region
                });
                columnSeries.data = d
              break;
            break;
            case 'total_deaths':
            case 'total_cases':
              console.log(`LineSeries in ${regions[region]} for metric -> ${metric}`)
              var lineSeries = xyChart.series.push( new am4charts.LineSeries() );
              lineSeries.tooltipText = `${metricsTranslations[metric]} in ${regions[region]} il {dateX}: {valueY}`;
              lineSeries.strokeWidth = 2
              /* Qui setto quale metrica (es. "released_cured", "swabs") deve vedere la series per l'asse Y*/
              lineSeries.dataFields.valueY = metric
              /* Qui setto quale metrica (il campo "date") deve vedere la series per l'asse X */
              lineSeries.dataFields.dateX = 'date'

              /* creo il cerchietto interattivo per vedere informazioni quando passo col mouse */

              var bullet = lineSeries.bullets.push(new am4charts.Bullet());
              var circle = bullet.createChild(am4core.Circle);
              circle.width = 8;
              circle.height = 8;
              circle.tooltipText = `${metricsTranslations[metric]} in ${regions[region]} il {dateX}: {valueY}`;
              
              /* Assegno i dati filtrati per regione alla series */
              var d = dataset.filter(function(o){
                return parseInt(o.region_code) === region
              })
              lineSeries.data = d;
            break;
          }
        })
      });
        
      xyChart.exporting.menu = new am4core.ExportMenu();
    }


    function drawPie(data, metrics){
        
      //debugger
      
      pieChart.dispose();
        
      pieChart = am4core.create('piechart', am4charts.PieChart);
        
      let dataset = fetchedData;
      console.log(fetchedData)
        
      pieChart.data = dataset;
        
      pieChart.innerRadius = am4core.percent(50);
        
      let pieSeries = pieChart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = metrics;
        pieSeries.dataFields.category = "region_name";
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeWidth = 2;
        pieSeries.slices.template.strokeOpacity = 1;
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;
        pieChart.legend = new am4charts.Legend();
        
        pieChart.exporting.menu = new am4core.ExportMenu();
    }

    function chartsInit(){
      am4core.useTheme(am4themes_animated);
      window.xyChart = am4core.create('dynamic', am4charts.XYChart)
      window.pieChart = am4core.create('piechart', am4charts.PieChart)
    }
    
  </script>
  <script type="text/javascript" src="../js/charts_common.js"></script>
</body>
</html>