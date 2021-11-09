var nameEvent = document.getElementById("inputName");
var emailEvent = document.getElementById("inputEmail");
var dateEvent = document.getElementById("inputDate");
var numEvent = document.getElementById("inputNum");
var cvcEvent = document.getElementById("inputCvc");

nameEvent.addEventListener("change",checkName,false);
emailEvent.addEventListener("change",checkEmail,false);
dateEvent.addEventListener("change",checkDate,false);
numEvent.addEventListener("change", checkNum,false);
cvcEvent.addEventListener("change",checkCvc,false);


function checkName(event)
{
  var name = event.currentTarget;
  var pos = name.value.search(/^[a-zA-Z\s]+$/);
  if (pos != 0)
  {
    alert("The name you have entered '" + name.value + "' is invalid.\n Enter:  'FirstName  LastName'\n");
    name.focus();
    name.select();
    return false;
  }
}

function checkEmail(event)
{
  var email = event.currentTarget;
  var pos = email.value.search(/^[\w-\.]+@[\w+\.]+\.(\w+\.){0,2}\w{2,3}$/);
  if (pos != 0)
  {
    alert("The name you have entered '" + email.value + "' is invalid.\n Enter:username@domain.com\n");
    email.focus();
    email.select();
    return false;
  }
}

function checkDate(event)
{
  var date = event.currentTarget;
  var stringDate = date.value;
  var stringYr = parseInt(stringDate.substring(0,4));
  var stringMth = parseInt(stringDate.substring(5,7));

  var today = new Date();

  if (stringYr < today.getFullYear())
  {
    alert("Invalid date choosen, choose again\n");
    date.focus();
    date.select();
    return false;
  }

  if (stringYr == today.getFullYear() && stringMth < today.getMonth()+1 )
  {
    alert("Invalid date choosen, choose again\n");
    date.focus();
    date.select();
    return false;
  }
}

function checkCvc(event)
{
  var cvc = event.currentTarget;
  var pos = cvc.value.search(/^\d{3}$/);
  if(pos!=0)
  {
    alert("Invalid cvc number, enter again\n");
    cvc.focus();
    cvc.select();
    return false;
  }

}

function checkNum(event)
{
  var cardNum = event.currentTarget;
  var pos= cardNum.value.search(/^\d{4}-\d{4}-\d{4}-\d{4}$/);
  if(!cardNum.value.match(pattern))
  {
    alert("Invalid card number, please enter in this format 1233-1233-1233-1233")
    cardNum.focus();
    cardNum.select();
    return false;
  }
}