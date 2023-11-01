var previousID = 1;
const questionContainers = document.getElementsByClassName('texts');
function update(id) {
    previousID = id;
    console.log(previousID);
}
function questionType(ID) {
    console.log(ID.charAt(0));
    if (document.getElementById(ID).checked) {
        document.getElementById(ID.charAt(0) + 'checkmcq').style.display = "block";
        document.getElementById(ID.charAt(0) + 'checktf').style.display = "none";
        document.getElementsByClassName(ID.charAt(0) + 'mcq')[0].disabled = false;
        document.getElementsByClassName(ID.charAt(0) + 'mcq')[1].disabled = false;
        document.getElementsByClassName(ID.charAt(0) + 'mcq')[2].disabled = false;
        document.getElementsByClassName(ID.charAt(0) + 'mcq')[3].disabled = false;
        document.getElementsByClassName(ID.charAt(0) + 'tf')[0].disabled = true;
        document.getElementsByClassName(ID.charAt(0) + 'tf')[1].disabled = true;
        document.getElementById(ID).checked = true;
        document.getElementById(ID).value = "mcq";
        console.log("mcq");
        mcQuestion(ID.charAt(0));
    }
    else {
        document.getElementById(ID.charAt(0) + 'checktf').style.display = "block";
        document.getElementById(ID.charAt(0) + 'checkmcq').style.display = "none";
        document.getElementsByClassName(ID.charAt(0) + 'mcq')[0].disabled = true;
        document.getElementsByClassName(ID.charAt(0) + 'mcq')[1].disabled = true;
        document.getElementsByClassName(ID.charAt(0) + 'mcq')[2].disabled = true;
        document.getElementsByClassName(ID.charAt(0) + 'mcq')[3].disabled = true;
        document.getElementsByClassName(ID.charAt(0) + 'tf')[0].disabled = false;
        document.getElementsByClassName(ID.charAt(0) + 'tf')[1].disabled = false;
        document.getElementById(ID).checked = false;
        document.getElementById(ID).value = "tf";
        console.log("t/f");
        TFQuestion(ID.charAt(0));
    }
}

var NoQ = document.getElementById('questionnumber').value;



function clearOthers(thisID) {
    var op = thisID.slice(-1);
    for (let z = 1; z <= 4; z++) {
        if ((previousID + "c" + z) != thisID) {
            document.getElementById(previousID + "c" + z).checked = false;
            document.getElementById(previousID + "c" + z).value = "incorrect";
            document.getElementById(previousID + 'tr').value = "incorrect";
            document.getElementById(previousID + 'fl').value = "incorrect";
        }
        else if ((previousID + 'tr') == thisID) {
            document.getElementById(previousID + 'fl').checked = false;
            document.getElementById(previousID + 'fl').value = "incorrect";
        }
        else {
            document.getElementById(previousID + 'tr').checked = false;
            document.getElementById(previousID + 'fl').checked = false;
            document.getElementById(previousID + 'tr').value = "incorrect";
            document.getElementById(previousID + 'fl').value = "incorrect";
        }
    }
    if (thisID.charAt(1) == 'c')
        document.getElementById(thisID).value = previousID + "op" + op;
    else if (thisID.charAt(1) == 't')
        document.getElementById(thisID).value = previousID + "t";
    else if (thisID.charAt(1) == 'f')
        document.getElementById(thisID).value = previousID + "f";
}

function mcQuestion(ID) {
    for (let z = 1; z <= 4; z++) {
        document.getElementById(ID + "op" + z).style.display = "block";
    }
    document.getElementById(ID + 'true').style.display = "none";
    document.getElementById(ID + 'false').style.display = "none";

}
function TFQuestion(ID) {
    for (let z = 1; z <= 4; z++) {
        document.getElementById(ID + "op" + z).style.display = "none";
    }
    document.getElementById(ID + 'true').style.display = "inline";
    document.getElementById(ID + 'false').style.display = "inline";
}

function numberValue(clicked_value) {
    let value_ID = clicked_value.slice(-1);
    console.log(value_ID);
    displayQuestion(value_ID);
}

function displayQuestion(ID) {
    const questionContainers = document.getElementsByClassName('texts');
    if (ID == previousID) {
        console.log(previousID);
        return;
    }
    else {
            document.getElementById(ID+ 'true').style.display  = "none";
            document.getElementById(ID + 'false').style.display = "none";
        for (let x = 1; x <= questionContainers.length; x++) {
            document.getElementById(x).style.display = "none";
            document.getElementById(x + "checkDiv").style.display = "none";
            document.getElementById(x + "check").style.display = "none";
            document.getElementById(x + "check2").style.display = "none";
            document.getElementById(x + "check3").style.display = "none";
            document.getElementById(x + "checktf").style.display = "none";
            document.getElementById(x + 'checkmcq').style.display = "none";
            document.getElementById(x + 'true').style.display = "none";
            document.getElementById(x + 'false').style.display = "none";
            for (let z = 1; z <= 4; z++) {
                document.getElementById(x+"op"+z).style.display = "none";
            }
        }
        questionType(ID + "check");
        document.getElementById(ID).style.display = "block";
        document.getElementById(ID + "checkDiv").style.display = "inline-block";
        document.getElementById(ID + "check").style.display = "block";
        document.getElementById(ID + "check2").style.display = "block";
        document.getElementById(ID + "check3").style.display = "block";
        document.getElementById('Qnumber').innerHTML = "Question " + ID;
        console.log(document.getElementById(ID).id);
        previousID = parseInt(ID);
    }
}


function NextQuestion(currentIndex) {
    const questionContainers = document.getElementsByClassName('texts');
    if (currentIndex == questionContainers.length) {
        console.log(previousID);
        return;
    }
    else {
        document.getElementById(currentIndex + 'true').style.display = "none";
        document.getElementById(currentIndex + 'false').style.display = "none";
        for (let x = 1; x <= questionContainers.length; x++) {
            document.getElementById(x).style.display = "none";
            document.getElementById(x + "checkDiv").style.display = "none";
            document.getElementById(x + "check").style.display = "none";
            document.getElementById(x + "check2").style.display = "none";
            document.getElementById(x + "check3").style.display = "none";
            document.getElementById(x + "checktf").style.display = "none";
            document.getElementById(x + 'checkmcq').style.display = "none";
            for (let y = 1; y <= 4; y++) {
                document.getElementById(x + "op" + y).style.display = "none";
            }
        }
        questionType((currentIndex+1) + "check");
        document.getElementById(currentIndex + 1).style.display = "block";
        document.getElementById((currentIndex + 1) + "checkDiv").style.display = "inline-block";
        document.getElementById((currentIndex + 1) + "check").style.display = "block";
        document.getElementById((currentIndex + 1) + "check2").style.display = "block";
        document.getElementById((currentIndex + 1) + "check3").style.display = "block";
        document.getElementById('Qnumber').innerHTML = "Question " + (currentIndex + 1);
        
        previousID++;
        update(previousID);
        
    }
}

function PrevQuestion(currentIndex) {
    var answer = currentIndex + "op";
    console.log(answer);
    const questionContainers = document.getElementsByClassName('texts');
    if (currentIndex == 1) {
        console.log(previousID);
        return;
    }
    else {
        document.getElementById(currentIndex + 'true').style.display = "none";
        document.getElementById(currentIndex + 'false').style.display = "none";
        for (let x = 1; x <= questionContainers.length; x++) {
            document.getElementById(x).style.display = "none";
            document.getElementById(x + "checkDiv").style.display = "none";
            document.getElementById(x + "check").style.display = "none";
            document.getElementById(x + "check2").style.display = "none";
            document.getElementById(x + "check3").style.display = "none";
            document.getElementById(x + 'checktf').style.display = "none";
            document.getElementById(x + 'checkmcq').style.display = "none";
            for (let y = 1; y <= 4; y++) {
                document.getElementById(x+"op"+y).style.display = "none";
            }
        }
        questionType((currentIndex - 1) + "check");
        var ind = currentIndex - 1;
        answer = ind.toString() + "op";
        document.getElementById(currentIndex - 1).style.display = "block";
        document.getElementById((currentIndex - 1) + "checkDiv").style.display = "inline-block";
        document.getElementById((currentIndex - 1) + "check").style.display = "block";
        document.getElementById((currentIndex - 1) + "check2").style.display = "block";
        document.getElementById((currentIndex - 1) + "check3").style.display = "block";
        document.getElementById('Qnumber').innerHTML = "Question " + (currentIndex - 1);
        previousID--;
        update(previousID);

    }
}
var empty = [];
var emptyoptions = 0;
document.getElementById('createQuiz').addEventListener("mouseover",ValidateAll,true)
function ValidateAll() {
    empty = [];
    for (let x = 1; x <= questionContainers.length; x++) {
        if (document.getElementById("te" + x).value.trim() == '' && document.getElementById("te" + x).value.length < 5) {
            empty.push("Question " + x + " is not Filled Or too short ()"); }
            if (document.getElementById(x+"check").value == "mcq") {
            var optionsContainers = document.getElementsByClassName('textareas' + x );
            for (let y = 0; y < optionsContainers.length; y++) {
                if (optionsContainers[y].value.trim() == '' && optionsContainers[y].value.length < 2) {
                    emptyoptions++; }
            }
            if (emptyoptions == 3 || emptyoptions ==4) 
                empty.push("2 options at Question "+x+" are not filled or too short");
            emptyoptions=0;
        }
    }
    if (empty.length == 0) {
        document.getElementById('createQuiz').disabled = false;
        document.getElementById('log').style.display = "none";
    }
    else {
        var errorMessages="";
        for (let y = 0; y<empty.length; y++) {
            errorMessages+=empty[y]+"\n";
        }
        document.getElementById('log').style.display = "inline-block";
        document.getElementById('errorLog').innerHTML = errorMessages;
        document.getElementById('createQuiz').disabled = true;
    }
    console.log(errorMessages);
    
}

function IsChecked() {
    var checkedQuestions = 0;
    console.log(checkedQuestions);
    for (let i = 1; i <= NoQ; i++) {
        var optionsContainers = document.getElementsByClassName(i + 'mcq');
        for (let y = 1; y <= optionsContainers.length; y++) {
            if (document.getElementById(i + "c" + y).checked) {
                checkedQuestions++;
            }
        }
        if (document.getElementById(i + "tr").checked) {
            checkedQuestions++;
        }
        else if (document.getElementById(i + "fl").checked) {
            checkedQuestions++;
        }
        console.log("checked questions : " + checkedQuestions);
    }
    if (checkedQuestions == NoQ) {
        document.getElementById('createQuiz').disabled = false;
    }
    else {
        document.getElementById('createQuiz').disabled = true;
        document.getElementById('errorLog').innerHTML += "ensure all questions are checked";

    }
}


