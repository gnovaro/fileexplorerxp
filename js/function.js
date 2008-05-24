/**
* @author Gustavo Novaro <gnovaro@gmail.com>
* @version 1.0
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
