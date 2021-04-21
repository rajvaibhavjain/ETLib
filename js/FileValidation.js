/* Image Preview */

$(document).on('change','.ETFileSize',function(){
    var FileSize = this.files[0].size / 1024 / 1024;           // in MiB
    var maxuploadsize=parseInt($(this).data('filesize'));
    if (FileSize > maxuploadsize) {
        sweetalert("Error","File size exceeds "+maxuploadsize+" MB","error","OK","")
        $(this).val("");
    } 
})

$(document).on('change','.ETFileFormate',function(){
    var fileName = this.value;
    var fileformate=$(this).data('fileformate');
    var filefomateArray = fileformate.split(",");
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if(filefomateArray.indexOf(extFile) != -1){
    }else{
        sweetalert("Error","Only "+fileformate+" files are allowed!","error","OK","")
        $(this).val("");
    }
})
