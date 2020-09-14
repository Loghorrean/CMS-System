// creating a WYSIWYG editor
$(document).ready(function() {
    ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );
});
// select all checkboxes with one
$(document).ready(function() {
    $('#selectAllBoxes').click(function(event) {
        if (this.checked) {
            $('.checkBoxes').each(function() {
                this.checked = true;
            });
        }
        else {
            $(".checkBoxes").each(function() {
                this.checked = false;
            });
        }
    });
});
let div_box = "<div id = 'load-screen'><div id = 'loading'></div></div>";

$("body").prepend(div_box);

$('#load-screen').delay(25).fadeOut(300 , function() {
    $(this).remove();
});