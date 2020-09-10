// validating comments
function doCommentsValidate() {
    try {
        let cont = document.getElementById('comment_content').value;
        if (cont == null || cont == "") {
            alert("All fields must be filled out");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
}
// validating users
function doUsersValidate() {
    try {
        let user = document.getElementById('username').value;
        let fname = document.getElementById('user_firstname').value;
        let lname = document.getElementById('user_lastname').value;
        let mail = document.getElementById('user_email').value;
        if (user == null || user == "" || fname == null || fname == "null" || lname == null || lname == "" || mail == null || mail == "") {
            alert("All fields must be filled out");
            return false;
        }
        if (mail.indexOf('@') == -1) {
            alert("Wrong mail format");
            return false;
        }
        return true;
    } catch (e) {
        return false;
    }
    return false;
}