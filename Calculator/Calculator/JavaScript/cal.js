let currentResult = "";
let displayValue = "";

function updateResult() {
  document.getElementById("result").value = displayValue;
}

function appendNumber(number) {
  currentResult += number;
  displayValue = currentResult;
  updateResult();
}

function appendOperation(operation) {
  if (currentResult === "") return;
  currentResult += operation;
  displayValue = currentResult;
  updateResult();
}

function appendDecimal() {
  if (currentResult.includes(".")) return;
  currentResult += ".";
  displayValue = currentResult;
  updateResult();
}

function clearAll() {
  currentResult = "";
  displayValue = "";
  updateResult();
}

function clearEntry() {
  currentResult = currentResult.slice(0, -1);
  displayValue = currentResult;
  updateResult();
}

function calculate() {
  try {
    const result = eval(currentResult);
    currentResult = String(result);
    displayValue = currentResult;
    updateResult();
  } catch (error) {
    displayValue = "Error";
    updateResult();
  }
}

