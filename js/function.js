/**
* @author Gustavo Novaro
* @version 1.1
*/
function redirect(sUrl){
	window.location = sUrl;
}//redirect

function edit(sFile){
	window.location = "edit.php?file=" + sFile;
}//edit

function go_path(){
	sPath = document.getElementById("txtPath").value;
	if(sPath == "")
		alert("Por favor complete la direccion");
	else
		document.getElementById("frmMain").submit();
}//go_path

function download_file(sFile){
	window.location = "get_file.php?file=" + sFile;
}//download_file

function add_file(){
/**
* Add a input file dinamic
* @version 1.3
*/
	var newFile = document.createElement('input');
	newFile.setAttribute('type','file');
	newFile.setAttribute('name','file[]');		
	document.getElementById('div_upload_photos').appendChild(newFile);
	var newBr = document.createElement('br');
	document.getElementById('div_upload_photos').appendChild(newBr);				
}

function showhide(targetDiv){
	var oVDiv = document.getElementById(targetDiv);
	prop = oVDiv.style.display;
	if(prop == "none"){
		oVDiv.style.display = "block";
	}
	else{
		oVDiv.style.display = "none";
	}
}//showhide_with_image
