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
        <div class="chart">
          
        </div>
      </div>
    </div>
  </div>

  <!-- LIBS AND POLYFILL -->
  <script src="node_modules/date-input-polyfill/date-input-polyfill.dist.js"></script>
  <script src="node_modules/choices.js/public/assets/scripts/choices.min.js"></script>


  <!-- CHART LIB -->
  <script src="https://www.amcharts.com/lib/4/core.js"></script>
  <script src="https://www.amcharts.com/lib/4/charts.js"></script>
  <script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
  <script type="text/javascript">
      /* Initialize custom select elements */
      let choices = document.querySelectorAll('.js-choices'),
          instances = [];

      choices.forEach(function(el){
        let instance = new Choices(el, {
          removeItemButton: true
        })
        instances.push(instance);
        
        instances[instances.length - 1].passedElement.element.addEventListener('change', function(event) {
            console.log(event.detail.value);
          },
          false
        );
      })

      /* Form Event Handlers */
      const form = document.querySelector('form');
      form.addEventListener('submit', function(e){
        e.preventDefault();
        console.log('Ajax Call...')        
        return false;
      })
  </script>
</body>
</html>