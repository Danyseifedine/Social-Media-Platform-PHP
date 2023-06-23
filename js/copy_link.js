function copyToClipboard(event, button) {
    event.preventDefault(); // Prevent form submission behavior
  
    var url = window.location.href;
    var tempInput = document.createElement("input");
    tempInput.value = url;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);
    button.innerHTML = "Copied!";
  
    setTimeout(() => {
        button.innerHTML = "Copy link";
    }, 5000);    
  }
  