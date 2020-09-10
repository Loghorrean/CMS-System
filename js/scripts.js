// validating comments
function doCommentsValidate() {
    try {
        let auth = document.getElementById('comment_author').value;
        let mail = document.getElementById('comment_email').value;
        let cont = document.getElementById('comment_content').value;
        if (auth == null || auth == "" || mail == null || mail == "" || cont == null || cont == "") {
            alert("All fields must be filled out");
            return false;
        }
        if (mail.indexOf('@') == -1) {
            alert("Wrong mail format");
            return false
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
}