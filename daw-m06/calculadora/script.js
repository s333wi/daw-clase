document.getElementById('ONOFF').addEventListener('click', openCalc);
let btnValue = '';
let operation = [];
let open = false;
let pantalla = document.getElementById('pantalla');
let screenText = pantalla.value;
let firstOp = true;

function openCalc() {
    var power = document.getElementById('ONOFF');
    var powerValue = power.getAttribute('value');
    open = (powerValue === 'OFF') ? false : true;

    if (open) {
        power.setAttribute('value', 'OFF');
        pantalla.setAttribute('value', '0');
    } else {
        power.setAttribute('value', 'ON')
        pantalla.setAttribute('value', 'Apagada');
    }

}

function getButton() {
    let btnClass = window.event.target.className;
    console.log(btnClass);
    if (open && btnClass.includes('num')) {
        console.log('es num');
        btnValue += window.event.target.value;
        pantalla.setAttribute('value', btnValue);
        console.log(btnValue);

    } else if (open && btnClass.includes('operator')) {
        console.log('es operador');
        let operator = window.event.target.value;
        console.log(operator);
        console.log({ operation });
        console.log({ operator });
        switch (operator) {
            case 'C':
                operation = [];
                btnValue = 0;
                pantalla.setAttribute('value', btnValue);
                break;
            case 'CE':
                btnValue = btnValue.slice(0, -1);
                pantalla.setAttribute('value', btnValue)
                break;
            case '=':
                operation.push(btnValue);
                let finalResult = operation.toString();
                console.log( finalResult );
                let finalEnter = parseInt(finalResult);
                console.log(finalEnter);
                //btnValue = parseInt(toString(operation));
                break;
            case '+/-':
                btnValue = parseInt(btnValue) * (-1);
                pantalla.setAttribute('value', btnValue);
                break;
            case '+':
            case 'x':
            case '/':
            case '-':
                if (firstOp) {
                    operation.push(btnValue);
                    operation.push(operator);
                    btnValue = '';
                    pantalla.setAttribute('value', btnValue);
                    firstOp = false;
                } else {
                    operation.push(btnValue);
                    firstOp = true;
                }
                break;
            default:
                break;
        }
    }
    screenText = pantalla.value;
}

