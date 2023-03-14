let inpTextArea = document.getElementById('inpTextArea');
let inpCharLimit = document.getElementById('inpCharCounter');
let inpNumLimit = document.getElementById('inpNumCounter');
let charCount = document.getElementById('charCount');
let numCount = document.getElementById('numCount');
let charCounter = document.getElementById('charCounter');
let numCounter = document.getElementById('numCounter');

let charLimit = inpCharLimit.value;
let numLimit = inpNumLimit.value;

inpCharLimit.addEventListener('change', function () {
    charLimit = this.value;
    console.log(charLimit);
});

inpNumLimit.addEventListener('change', function () {
    numLimit = this.value;
    console.log(numLimit);
});


inpTextArea.addEventListener('keydown', function (e) {
    let charCode = e.key;
    console.log(charCode);
    //check if charCode is a number or a character
    if (charCode != 'Backspace' && charCode != 'Shift' && charCode != 'CapsLock') {
        if (charCode >= '0' && charCode <= '9') {
            if (numLimit == parseInt(numCount.innerHTML)) {
                numCounter.style.color = 'red';
                e.preventDefault();
            } else {
                numCounter.style.color = 'black';
                numCount.innerHTML = parseInt(numCount.innerHTML) + 1;
            }
        }

        if ((charCode >= 'a' && charCode <= 'z') || (charCode >= 'A' && charCode <= 'Z')) {
            if (charLimit == parseInt(charCount.innerHTML)) {
                charCounter.style.color = 'red';
                e.preventDefault();
            } else {
                charCounter.style.color = 'black';
                charCount.innerHTML = parseInt(charCount.innerHTML) + 1;
            }
        }
    }
});
