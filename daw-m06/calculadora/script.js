document.getElementById('ONOFF').addEventListener('click', openCalc);
let btnCalcValue = '';
let calcOperation = []; //En les posicions 0 i 2 del array sempre hi haura nums i en la 1 el operador
let isCalcOpen = false;
let calcScreen = document.getElementById('pantalla');
let screenText = calcScreen.value;


function operate(op1, op2, operator) {
    if (Number.isNaN(op2)) return op1;
    switch (operator) {
        case '+':
            return op1 + op2;
            break;
        case '-':
            return op1 - op2;
            break;
        case '/':
            if (op2 === 0) return 'Infinit';
            return op1 / op2;
            break;
        case 'x':
            return op1 * op2;
            break;
        default:
            break;
    }
}

function openCalc() {
    var calcPower = document.getElementById('ONOFF');
    var calcPowerValue = calcPower.getAttribute('value');
    isCalcOpen = (calcPowerValue === 'OFF') ? false : true;

    if (isCalcOpen) {
        calcPower.setAttribute('value', 'OFF');
        calcScreen.setAttribute('value', '0');
    } else {
        calcPower.setAttribute('value', 'ON')
        calcScreen.setAttribute('value', 'Apagada');
        btnCalcValue = '';
        calcOperation.length = 0;
    }

}

function getButton() {
    let btnClass = window.event.target.className;

    if (isCalcOpen && btnClass.includes('num')) {
        btnCalcValue += window.event.target.value;
        calcScreen.setAttribute('value', btnCalcValue);

    } else if (isCalcOpen && btnClass.includes('operator')) {
        let calcOperator = window.event.target.value;
        switch (calcOperator) {
            case 'C':
                calcOperation.length = 0;
                btnCalcValue = 0;
                calcScreen.setAttribute('value', btnCalcValue);
                break;
            case 'CE':
                if (calcScreen.value !== '0') {
                    btnCalcValue = btnCalcValue.toString().slice(0, -1);
                    calcScreen.setAttribute('value', btnCalcValue)
                }
                break;
            case '=':
                calcOperation.push(btnCalcValue);
                let firstOp = +calcOperation[0];
                let secondOp = +calcOperation[2];
                calcOperator = calcOperation[1];
                let result = operate(firstOp, secondOp, calcOperator);
                calcOperation.length = 0;
                btnCalcValue = result;
                calcScreen.setAttribute('value', btnCalcValue);
                firstOperationDone = true;
                break;
            case '+/-':
                btnCalcValue = parseInt(btnCalcValue) * (-1);
                calcScreen.setAttribute('value', btnCalcValue);
                break;
            case '+':
            case 'x':
            case '/':
            case '-':
                calcOperation.push(btnCalcValue);
                calcOperation[1] = calcOperator;
                btnCalcValue = '';
                calcScreen.setAttribute('value', btnCalcValue);
                break;
            default:
                break;
        }
    }
    screenText = calcScreen.value;
}

