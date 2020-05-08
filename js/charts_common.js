/* Initialize custom select elements */
let regionsData;

fetch('../regions.json')
.then(function(response){
  return response.json()
})
.then(function(data){
  regionsData = data
  onCSVLoad()
})
.catch(function(e){
  console.log(e)
  alert("Error during regions data fetch")
})


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
