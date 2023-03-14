import {wordList} from "./diccionari";
function _(element) {
    return document.querySelector(element);
}
function init(gamediv) {
    window.pos = 0;
   drawKeyBoard(gamediv);
}
function drawKeyBoard(gamediv) {
    var keyboard = document.createElement('div');
    keyboard.id = 'keyboard';

    addKeys(['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p'], keyboard);
    addKeys(['a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'ç'], keyboard);
    addKeys(['Enter', 'z', 'x', 'c', 'v', 'b', 'n', 'm', 'del'], keyboard);

    var game = _('#'+gamediv);
    game.appendChild(keyboard);

    document.body.addEventListener('keyup', function (ev) {
        console.log(ev.key + " : " + ev.code);
        letterClick(ev.key);
    });
}
function letterClick(letter) {

    if (letter == 'Enter'){
        console.log('Enter key');
        console.log('Entered ' + window.pos + ' letters');
        window.pos=0;
    }
    else if (letter == 'Backspace' || letter == 'del'){
        window.pos=window.pos>0?window.pos-1:0;
        console.log('Back key');
    }
    else {
        var key = _('[data-key=' + letter + ']');

        if (key != null) {
            window.pos=window.pos+1;

            if (letter == 'd') {
                key.setAttribute('data-state', 'correct');
            }
            else if (letter=='a'){
                key.setAttribute('data-state', 'present');
            }
            else {
                key.setAttribute('data-state', 'absent');
            }
        }
    }
}

function addKeys(letters, kbobj) {
    var keyrow = document.createElement('div');
    keyrow.classList.add('keyrow');

    for (let i = 0; i < letters.length; i++) {

        var btn = document.createElement('button');
        btn.textContent = letters[i];
        btn.setAttribute('data-key', letters[i]);

        btn.addEventListener('click', function (ev) {
            var key = ev.target;
            letterClick(key.getAttribute('data-key'));
        });
        keyrow.append(btn);
    }
    kbobj.append(keyrow);
}


function initGame(gameDiv){

}