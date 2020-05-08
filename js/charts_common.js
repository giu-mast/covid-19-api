/* Initialize custom select elements */
let regionsData;

/* TEMP: open json file to get test data */

fetch('../regions.json')
.then(function(response){
  return response.json()
})
.then(function(data){
  regionsData = data
  /* Here i call global function onCSVLoad */
  createXYChart()
})
.catch(function(e){
  console.log(e)
  alert("Error during regions data fetch")
})


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

/* Form Event Handlers */
const form = document.querySelector('form');
form.addEventListener('submit', function(e){
  e.preventDefault();
  let startDate   = document.querySelector('[name=start_date]').value,
      endDate     = document.querySelector('[name=end_date]').value, 
      regions     = [...document.querySelector('[name=regions]')].map(d=>parseInt(d.value)),
      districts   = [...document.querySelector('[name=districts]')].map(d=>d.value),
      metrics     = [...document.querySelector('form').elements["metrics[]"]].filter(d=>d.checked).map(d=>d.value) 
  
  console.log(regions, districts, metrics, startDate, endDate)
  console.log("HERE I SHOULD CALL AJAX API")
  /* Here i call draw() global function to make the actual chart drawing */
  draw(startDate, endDate, regions, districts, metrics);
  return false;
})
