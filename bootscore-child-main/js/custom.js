jQuery(function ($) {

    // Do stuff here

}); // jQuery End


var img = document.querySelector('img');
img.addEventListener('click', verifyCLick);

function verifyCLick(event){
let pos = {x: event.layerX, y: event.layerY};
let point = [(pos.x/(event.target.naturalWidth/100)).toFixed(2), (pos.y/(event.target.naturalHeight/100)).toFixed(2)];
console.log(pos, point);
}
