/* Initialize custom select elements */
let fetchedData,
    regions = {},
    districts = {},
    metricsTranslations = {
      'region_code': 'Codice ISTAT Regione',
      'intensive_care': 'Terapia Intensiva',
      'total_hospitalized': 'Totale ospedalizzati',
      'hospitalized_with_symptoms': 'Ospedalizzati con sintomi',
      'home_isolation': 'Isolamento domestico',
      'total_positives': 'Totale positivi',
      'total_variation_positives': 'Variazione totale positivi',
      'new_positives': 'Nuovi positivi',
      'released_cured': 'Dimessi guariti',
      'total_deaths': 'Morti totali',
      'total_cases': 'Casi totali',
      'swabs': 'Tamponi',
      'testes_cases': 'Casti testati'
    };

/* 
  Popolo un oggetto "regions" utile per le traduzioni. Alla fine avrò un oggetto così:
  {
    1: "Piemonte", 2: "Valle d'Aosta", 3: "Lombardia", etc etc
  }
  così se per es. vado a fare alert(regions[3]) mi stamperà nell'alert "Lombardia"
*/
document.querySelector("[name=regions]").options.forEach((o)=>{
  regions[parseInt(o.value)] = o.innerHTML
})


/* 
  Popolo un oggetto "districts" utile per le traduzioni. Alla fine avrò un oggetto così:
  {
    "CH": "Chieti", "AQ": "L'Aquila", "PE": "Pescare", etc etc
  }
  così se per es. vado a fare alert(districts["PE"]) mi stamperà nell'alert "Pescara"
*/
document.querySelector("[name=districts]").options.forEach((o)=>{
  districts[o.value] = o.innerHTML
})


/* Creo i grafici vuoti*/ 
chartsInit();

/* Startup libreria per autocomplete regioni e province */
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


/* Costruisce l'endpoint a cui fare le richieste: 
    es. '/api/regions/read.php?region_code=13&start_date=2020-02-24&end_date=2020-06-01'
*/
function buildUrl(endpoint, obj){
  let url = endpoint

  if(endpoint === 'regions'){ delete obj.district_code }
  if(endpoint === 'districts'){ delete obj.region_code }

  if(!obj.end_date){
    delete obj.end_date
  }

  return '/api/' + url + '/read.php?' + Object.keys(obj).map(key => key + '=' + obj[key]).join('&');
}

/* Event Handler alla submit del form */
const form = document.querySelector('#filters_histogram'),
      pieForm = document.querySelector('#filters_pie');
form.addEventListener('submit', function(e){
  e.preventDefault();
  let sel         = form.querySelector('select'),
      apiType     = sel.options[sel.selectedIndex].value,
      startDate   = form.querySelector('[name=start_date]').value,
      endDate     = form.querySelector('[name=end_date]').value, 
      regions     = [...form.querySelector('[name=regions]')].map(d=>parseInt(d.value)),
      districts   = [...form.querySelector('[name=districts]')].map(d=>d.value),
      metrics     = [...form.elements["metrics[]"]].filter(d=>d.checked).map(d=>d.value) ,
      url         = buildUrl(apiType, {
        region_code: regions, 
        district_code: districts, 
        start_date: startDate,
        end_date: endDate
      })
  
  console.log(url)

  /* FACCIO LA RICHIESTA ALL'URL CREATO */
  fetch(url)
  .then(function(response){
    return response.json()
  })
  .then(function(data){
    data.forEach((d)=>{
      /* Monkeypatch: converto alcuni valori in numeri, dalle API mi arrivano come stringa */
      Object.keys(d).forEach((k)=>{
        switch(k){
          case 'latitude':
          case 'longitude':
            d[k] = parseFloat(d[k])
            break;
          case 'region_code':
          case 'intensive_care':
          case 'total_hospitalized':
          case 'hospitalized_with_symptoms':
          case 'home_isolation':
          case 'total_positives':
          case 'total_variation_positives':
          case 'new_positives':
          case 'released_cured':
          case 'total_deaths':
          case 'total_cases':
          case 'swabs':
          case 'testes_cases':
            d[k] = parseInt(d[k])
            break;
        }
      })
    })

    /* inserisco nella variabile globale fetchedData i risultati della chiamata ad API */
    fetchedData = data
    
    
    /* 
      Qui chiamo la funzione globale draw() che è presente in amcharts.php
      Qui cioè vado a resettare il grafico presente e a creare le nuove series
      VAI A VEDERE LA FUNZIONE DRAW() presente in amcharts.php

     */
    draw(apiType === 'regions' ? regions : districts, metrics);
  })
  .catch(function(e){
    console.log(e)
    alert("Error during regions data fetch")
  })
  return false;
})


pieForm.addEventListener('submit', function(e){
  e.preventDefault()
  console.log('1 - PRENDO I VALORI DEI CAMPI SELEZIONATI')
  console.log('2 - COSTRUISCO L\'URL')
  console.log('3 - FACCIO LA RICHIESTA TRAMITE UNA fetch')
  console.log('4 - fetchedData = data ---> MOLTO IMPORTANTE')
  console.log('5 - chiamare drawPie()')

  
  drawPie();
  return false;
});