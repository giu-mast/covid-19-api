<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../img/icona.ico" />
  <title>API COVID-19</title>
  <link href="/css/style.css" rel="stylesheet" type="text/css" media="all" />
  <link rel="stylesheet" href="/charts/node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/charts/node_modules/choices.js/public/assets/styles/choices.min.css" />

  <!-- custom style -->
  <style type="text/css">
    .chart{
      background: #eee;
      min-height: 500px; 
    }
    .form-row.my-2.divs.regions{
      display:block;   
    }
    .form-row.my-2.divs.districts{
      display:block;  
    }
  </style>
</head>
<body>
  <?php require($_SERVER["DOCUMENT_ROOT"].'/header.php'); ?>
  
  <div class="container-fluid" id="ContainerTitle">
    <div class="container-fluid" id="ContainerTitle_Center">
      <div class="row-1">
          <div class="col-sm-7" id="ContainerTitle_Titolo">
            <h1>Grafici Interattivi</h1>
          </div>
          <div class="col-sm-9" id="ContainerTitle_Sottotitolo">In questa pagina sarà possibile visualizzare dei grafici interattivi realizzati con le API fornite. Questo &egrave; solo un esempio dei grafici che è possibile visualizzare utilizzando i dati forniti.</div>
        </div>
      </div>
  </div>

  <div class="container pt-5">
    <div class="row">
      <div class="col-md-8 my-5">
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
      <div class="col-md-8 my-5">
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
    
    <div class="row">
      <div class="col-12">
        <div id="radarchart" class="chart">
        </div>
      </div>
    </div>
  </div>
  <?php require($_SERVER["DOCUMENT_ROOT"].'/footer.php'); ?>
  <!-- LIBS AND POLYFILL -->
  <script src="/charts/node_modules/date-input-polyfill/date-input-polyfill.dist.js"></script>
  <script src="/charts/node_modules/choices.js/public/assets/scripts/choices.min.js"></script>


  <!-- CHART LIB -->
  <script src="//www.amcharts.com/lib/4/core.js"></script>
  <script src="//www.amcharts.com/lib/4/charts.js"></script>
  <script src="//www.amcharts.com/lib/4/themes/animated.js"></script>
  <script src="//www.amcharts.com/lib/4/lang/it_IT.js"></script>

  <!-- TEMP COMMON OPS (init widgets, load test json, etc) -->

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
      
    function get_R_D(data){
        
    }

    /* 1. VAI A VEDERE IN charts_common COSA SUCCEDE DURANTE L'INIZIALIZZAZIONE */

    function draw(data, metrics, translations, api){

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
                console.log(`ColumnSeries in ${translations[region]} for metric -> ${metric}`)
                var columnSeries = xyChart.series.push( new am4charts.ColumnSeries() );  

                /* Qui setto quale metrica (es. "released_cured", "swabs") deve vedere la series per l'asse Y*/
                columnSeries.dataFields.valueY = metric
                /* Qui setto quale metrica (il campo "date") deve vedere la series per l'asse X */
                columnSeries.dataFields.dateX = 'date'
                columnSeries.columns.template.tooltipText = `${metricsTranslations[metric]} in ${translations[region]} il {dateX}: {valueY}`;

                columnSeries.legendSettings.labelText = `${metricsTranslations[metric]} in ${translations[region]}`;

                /* Assegno i dati filtrati per regione alla series */
                var d = dataset.filter(function(o){
                  let v = api === 'regions' ? parseInt(o.region_code) : o.province_abbreviation
                  return v === region
                });
                columnSeries.data = d
              break;
            break;
            case 'total_deaths':
            case 'total_cases':
              console.log(`LineSeries in ${translations[region]} for metric -> ${metric}`)
              var lineSeries = xyChart.series.push( new am4charts.LineSeries() );
              lineSeries.tooltipText = `${metricsTranslations[metric]} in ${translations[region]} il {dateX}: {valueY}`;
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
              circle.tooltipText = `${metricsTranslations[metric]} in ${translations[region]} il {dateX}: {valueY}`;
              
              lineSeries.legendSettings.labelText = `${metricsTranslations[metric]} in ${translations[region]}`;

              /* Assegno i dati filtrati per regione alla series */
              var d = dataset.filter(function(o){
                let v = api === 'regions' ? parseInt(o.region_code) : o.province_abbreviation
                return v === region
              })
              lineSeries.data = d;
            break;
          }
        })
      });

      xyChart.legend = new am4charts.Legend();
      xyChart.exporting.menu = new am4core.ExportMenu();
        
      xyChart.cursor = new am4charts.XYCursor();
        
      xyChart.zoomOutButton.align = "left";
      xyChart.zoomOutButton.valign = "bottom";
      xyChart.zoomOutButton.marginLeft = 10;
      xyChart.zoomOutButton.marginBottom = 10;
    }


    function drawPie(data, metrics, translations, api){
        
      //debugger
      
      pieChart.dispose();
        
      pieChart = am4core.create('piechart', am4charts.PieChart);
        
      let dataset = fetchedData;
      console.log(fetchedData)
        
      pieChart.data = dataset;
        
      pieChart.innerRadius = am4core.percent(50);
        
      let pieSeries = pieChart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = metrics;
        pieSeries.dataFields.category = api === "regions" ? "region_name" : "province_denomination";
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeWidth = 2;
        pieSeries.slices.template.strokeOpacity = 1;
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;

        pieChart.legend = new am4charts.Legend();
        
        pieChart.exporting.menu = new am4core.ExportMenu();
        console.log(data)
    }
    
    function drawRadar(data, metrics, translations, api){
              
      Radar_Chart.dispose();
    
      Radar_Chart = am4core.create("radarchart", am4charts.RadarChart);
        
      let dataset = fetchedData;
      console.log(fetchedData)
        
      Radar_Chart.data = dataset;
        
      let categoryAxis = Radar_Chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = api === "regions" ? "region_name" : "province_denomination";;

      let valueAxis = Radar_Chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.renderer.axisFills.template.fill = Radar_Chart.colors.getIndex(2);
      valueAxis.renderer.axisFills.template.fillOpacity = 0.05;

      let series = Radar_Chart.series.push(new am4charts.RadarSeries());
      series.dataFields.valueY = metrics;
      series.dataFields.categoryX = api === "regions" ? "region_name" : "province_denomination";;;
      series.name = metricsTranslations[metrics];
      series.strokeWidth = 3;
        
      Radar_Chart.legend = new am4charts.Legend();
        
      Radar_Chart.exporting.menu = new am4core.ExportMenu();
    }

    function chartsInit(){
      am4core.useTheme(am4themes_animated);
      window.xyChart = am4core.create('dynamic', am4charts.XYChart)
      window.pieChart = am4core.create('piechart', am4charts.PieChart)
      window.Radar_Chart = am4core.create("radarchart", am4charts.RadarChart);
    }
      
  </script>
  <script type="text/javascript" src="../js/charts_common.js"></script>

  
</body>
</html>