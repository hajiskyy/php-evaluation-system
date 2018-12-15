function launch_toast(text) {
  var msg = document.getElementById("desc");
  msg.innerText = text;
  var x = document.getElementById("toast");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

// Function to format date
function formatDate(date) {
  var d = new Date(date),
      month = '' + (d.getMonth() + 1),
      day = '' + d.getDate(),
      year = d.getFullYear();

  if (month.length < 2) month = '0' + month;
  if (day.length < 2) day = '0' + day;

  return [year, month, day].join('-');
}
// select date from DOM
const dateForm = document.querySelector('#date');

// If it exist
if(dateForm){
  // declare today's date
  let today = new Date();
  // set minimum attibute to today
  dateForm.setAttribute('min', formatDate(today));
}

function onSubmit(id){
  console.log(id);
  document.querySelector("#"+id);
}