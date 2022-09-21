document.getElementById('ONOFF').addEventListener('click', openCalc);

function openCalc() {
    var pantalla = document.getElementById('pantalla');
    var power = document.getElementById('ONOFF');
    var value = power.getAttribute('value');
    (value === 'OFF') ? power.setAttribute('value', 'ON') : power.setAttribute('value', 'OFF');

    if (value === 'OFF') {
        pantalla.setAttribute('value', 'Encendida');
    } else {
        pantalla.setAttribute('value', 'Apagada');
    }
}

var secondRow = document.querySelectorAll('.second-row input');
console.log(secondRow);