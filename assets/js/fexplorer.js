/**
 * @author Gustavo Novaro
 */
var FileExplorer {
    rename : function(name) {

    },
    goPath: function() {
        var sPath = $("txtPath").val();
    	if(!sPath)
    		alert("Por favor complete la direccion");
    	else
    		document.getElementById("frmMain").submit();
    },
    downloadFile: function(file) {
        window.location = "get_file.php?file=" + file;
    }
};
