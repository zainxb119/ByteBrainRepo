

var previousID = 1;
var NoQ = document.getElementById('NOQUESTIONS').value;
const questionContainers = document.getElementsByClassName('texts');
console.log(NoQ);

function IsChecked() {
    document.getElementById('errorLog').innerHTML = "";
    var checkedQuestions=0;
    console.log(checkedQuestions);
    for (let i=1;i<=NoQ; i++) {
        var optionsContainers = document.getElementById(i + 'opNo').value;
        for (let y = 1; y <= optionsContainers; y++) {
            if(document.getElementById(i + "option" + y).checked ) {
                checkedQuestions++;
            }
        }
    }
    if (checkedQuestions == NoQ) {
        document.getElementById('submitQuiz').disabled = false;
        document.getElementById('log').style.display = "none";
        document.getElementById('errorLog').style.display = "none";

    }
    else {
        document.getElementById('log').style.display = "inline-block";
        document.getElementById('submitQuiz').disabled = true;
        document.getElementById('errorLog').style.display = "inline-block";
        document.getElementById('errorLog').innerHTML += "ensure all questions are checked";
    }
}

function update(id) {
    previosID = id;
    console.log(previosID);
}

function numberValue(clicked_value) {
    let value_ID = clicked_value;
    console.log(value_ID);
    displayQuestion(value_ID);
}

function correctAns(thisID) {
    var ind = thisID.slice(0,1);
    console.log(ind);
    var optionsContainers = document.getElementById(ind + 'opNo').value;
    for (x = 1; x <= optionsContainers ; x++) {
            document.getElementById(ind+"option"+x).value = ""; 
    }
    document.getElementById(ind + "option" + thisID.slice(-1)).value = document.getElementById(ind + "ans" + thisID.slice(-1)).value;
}

function displayQuestion(ID) {
    if (ID.slice(-1)==previousID)
    return;
    else {
    for (let x = 1; x <= questionContainers.length; x++) {
        document.getElementById(x).style.display = "none";
        var optionsContainers = document.getElementById(x + 'opNo').value;
        for (let y = 1; y <= optionsContainers; y++) {
            document.getElementById(x + "op" + y).style.display = "none";
        }
    }
    document.getElementById(ID.slice(-1)).style.display = "inline";
        var optionsContainers = document.getElementById(ID.slice(-1) + 'opNo').value;
    for (let y = 1; y <= optionsContainers; y++) {
        document.getElementById(ID.slice(-1)+ "op" + y).style.display = "inline";
    }
    console.log(document.getElementById(ID.slice(-1)).id);
    previousID = parseInt(ID.slice(-1));
    document.getElementById("Qnumber").innerHTML = "Question "+previousID;
}
}


function NextQuestion(currentIndex) {
    if (currentIndex == questionContainers.length) {
        console.log(previousID);
        return;
    }
    else {
        for (let x = 1; x <= questionContainers.length; x++) {
            document.getElementById(x).style.display = "none";
            var optionsContainers = document.getElementById(x + 'opNo').value;
            for (let y = 1; y <= optionsContainers; y++) {
                document.getElementById(x + "op" + y).style.display = "none";
            }
        }
        document.getElementById(currentIndex + 1).style.display = "inline";
        var optionsContainers = document.getElementById((currentIndex + 1) + 'opNo').value;
        for (let y = 1; y <= optionsContainers; y++) {
            document.getElementById((currentIndex+1) + "op" + y).style.display = "inline";
        }
        previousID++;
        update(previousID);
        document.getElementById("Qnumber").innerHTML = "Question " + previousID;

    }
}

function PrevQuestion(currentIndex) {
    if (currentIndex == 1) {
        console.log(previousID);
        return;
    }
    else {
        for (let x = 1; x <= questionContainers.length; x++) {
            document.getElementById(x).style.display = "none";
            var optionsContainers = document.getElementById(x + 'opNo').value;
            for (let y = 1; y <= optionsContainers; y++) {
                document.getElementById(x + "op" + y).style.display = "none";
            }
        }
        document.getElementById(currentIndex - 1).style.display = "inline";
        var optionsContainers = document.getElementById((currentIndex - 1) + 'opNo').value;
        for (let y = 1; y <= optionsContainers; y++) {
            document.getElementById((currentIndex - 1) + "op" + y).style.display = "inline";
        }
        previousID--;
        update(previousID);
        document.getElementById("Qnumber").innerHTML = "Question " + previousID;

    }

}

var timer;
var input = document.getElementById("time").value;
var min = parseInt(input) -1;
var sec = 60;


(function StartTimer() {
var elem = document.getElementById('timer');
    timer = setInterval(() => {
        if (min == 0 && sec == 1) {
            elem.innerHTML = "00:00";
            clearInterval(timer);
            document.getElementById('submitQuiz').disabled = false;
            document.getElementById('submitQuiz').click();
            //window.location.href="submitpage.php?qid="+document.getElementById("quizID").value;
        } else {
            sec--;
            if (sec == 0) {
                min--;
                sec = 60;
                if (min == 0) {
                    min = min;
                }
            }
            if (min.toString().length == 1) {
                min = "0" + min;
            }
            if (sec.toString().length == 1) {
                sec = "0" + sec;
            }
            elem.innerHTML = min + ':' + sec;
        }
    }, 1000)
})();
