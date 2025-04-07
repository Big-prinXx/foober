function enableEditing() {
    document.getElementById("fname").disabled = false;
    document.getElementById("lname").disabled = false;
    document.getElementById("email").disabled = false;
    document.getElementById("mobile").disabled = false;
    document.getElementById("address").disabled = false;
    document.getElementById("saveBtn").disabled = false;
}

function saveDetails() {
    let fname = document.getElementById("fname").value;
    let lname = document.getElementById("lname").value;
    let email = document.getElementById("email").value;
    let mobile = document.getElementById("mobile").value;
    let address = document.getElementById("address").value;

    localStorage.setItem("fname", fname);
    localStorage.setItem("lname", lname);
    localStorage.setItem("email", email);
    localStorage.setItem("mobile", mobile);
    localStorage.setItem("address", address);

    window.location.href = "details.html"; 
}