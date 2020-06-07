/* Initialize custom select elements */
let regionsData;

chartsInit();

/* Autocomplete Startup */
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

function buildUrl(endpoint, obj){
  let url = endpoint

  if(endpoint === 'regions'){ delete obj.district_code }
  if(endpoint === 'districts'){ delete obj.region_code }

  if(!obj.end_date){
    delete obj.end_date
  }

  return '/api/' + url + '/read.php?' + Object.keys(obj).map(key => key + '=' + obj[key]).join('&');
}

/* Form Event Handlers */
const form = document.querySelector('form');
form.addEventListener('submit', function(e){
  e.preventDefault();
  let sel         = document.querySelector('#api'),
      apiType     = sel.options[sel.selectedIndex].value,
      startDate   = document.querySelector('[name=start_date]').value,
      endDate     = document.querySelector('[name=end_date]').value, 
      regions     = [...document.querySelector('[name=regions]')].map(d=>parseInt(d.value)),
      districts   = [...document.querySelector('[name=districts]')].map(d=>d.value),
      metrics     = [...document.querySelector('form').elements["metrics[]"]].filter(d=>d.checked).map(d=>d.value) ,
      url         = buildUrl(apiType, {
        region_code: regions, 
        district_code: districts, 
        start_date: startDate,
        end_date: endDate
      })
  
  console.log(url)


  fetch(url)
  .then(function(response){
    return response.json()
  })
  .then(function(data){
    data.forEach((d)=>{
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
    regionsData = data
    /* Here i call global function onCSVLoad */
    chartsInit()
    /* Here i call draw() global function to make the actual chart drawing */
    draw(apiType === 'regions' ? regions : districts, metrics);
  })
  .catch(function(e){
    console.log(e)
    alert("Error during regions data fetch")
  })
  return false;
})
