document.onkeydown = function(){
  if(window.event && window.event.keyCode == 123) {
    window.location="404F12.html";
    return false;
  }
  if (event.ctrlKey && window.event.keyCode==73){ 
	window.location="404ctrl+i.html";
	return false; 
    }
  if (event.ctrlKey && window.event.keyCode==85){ 
	window.location="404ctrl+u.html";
	return false; 
    }
}
