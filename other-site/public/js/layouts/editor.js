let linkIndex=0;
let imageIndex=0;
$(document).ready(function() {
    
    editor();
    
});

function editor(){
      $('#editControls a').click(function(e) {
        e.preventDefault();
        switch($(this).data('role')) {
            case 'h1':
            case 'h2':
            case 'h3':
            case 'h4':
            case 'h5':
            case 'h6':
            case 'p':
                document.execCommand('formatBlock', false, $(this).data('role'));
                break;
            default:
                document.execCommand($(this).data('role'), false, null);
                break;
        }
    });

    $("#editor").keyup(function() {
        var value = $(this).html();
    }).keyup();

    $("#editor").keydown(function(e) {
        if(e.keyCode === 9) { // tab was pressed
            // get caret position/selection
            var start = this.selectionStart;
                end = this.selectionEnd;

            var $this = $(this);

            // set textarea value to: text before caret + tab + text after caret
            $this.val($this.val().substring(0, start)
                        + "\t"
                        + $this.val().substring(end));

            // put caret at right position again
            document.execCommand('insertText', false /*no UI*/, '          ');
            this.selectionStart = this.selectionEnd = start + 1;
            // prevent the focus lose
            return false;
        }
    });
}

function fontEditor(type,fontName) {
    document.execCommand(type, false, fontName);
}

function setColor(color) {
    document.execCommand('styleWithCSS', false, true);
    document.execCommand('foreColor', false, color);
}

function setBackColor(color) {
    document.execCommand('styleWithCSS', false, true);
    document.execCommand('BackColor', false, color);
}

$('#link-btn').click(function() {
    $("#authoring-tool-link-modal").modal("show");
});

function appendLink(){
    linkIndex++;
    link=$('#link-url').val();
    displaytext=$('#link-display-text').val();
    $('#editor').append(`<a id="link-${linkIndex}" href="${link}" target="_blank" role="button">${displaytext}</a>`);
    $("#authoring-tool-link-modal").modal("hide");
    $('#link-url').val('');
    $('#link-display-text').val('');

}

function dismissLinkModal(){
    $("#authoring-tool-link-modal").modal("hide");
}

$('#editor_select_img').click(function() {
    imageIndex++;
    $('#editor').append(`<img src="'/assets/images/default/no_image.png'" onerror="this.src='/assets/images/default/no_image.png'" 
                        width="250px;" height="200px;" class="geo-border-primary border mt-2" id="image-${imageIndex}">`);
    $('#editor_image_select').click();
});

$('#editor_image_select').change(function() {

    if (this.files && this.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            //upload image
            showLoader('Uploading!','Please wait...');
            var file_data = $('#editor_image_select').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('imageFile', file_data);
            
            $.ajax({
                     
                        type:"post",
                        url:"/upload/image",
                        data:form_data,
                        method:'POST',
                        dataType:"json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success:function(data) {
                        console.log(data);
                        if(data == 'error'){//error
                            $(`#image-${imageIndex}`).remove();
                            showErrorAlert('Error','Please check your internet connection');

                        }else{//success
                            $(`#image-${imageIndex}`).attr('src',data);
                        }
                        Swal.close();
                         
                        },
                        error: function(error) {
                            showHttpErrorAlert(error);
                        }
            });  
        }
        // check if file is png
        ext=this.files[0].type;
        if(ext.includes("image")){
            reader.readAsDataURL(this.files[0]);
        }else{
            $(`#image-${imageIndex}`).remove();
            showWarningAlert('Warning','Please select image');
        }
    }
});

