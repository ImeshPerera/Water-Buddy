function AlertDanger(msg) {
    if (msg == null) {
        msg = "Something Went Wrong. Report To Admin";
    }
    document.getElementById("alertnobtn").classList.add("d-none");
    document.getElementById("alertnobox").classList.remove("d-none");
    document.getElementById("alertnoline").innerText = msg;
}

function AlertSuccess(msg) {
    if (msg == null) {
        msg = "Something Happend. Report To Admin";
    }
    document.getElementById("alertokbtn").classList.add("d-none");
    document.getElementById("alertokbox").classList.remove("d-none");
    document.getElementById("alertokline").innerText = msg;
}

function alertDangerclose() {
    var alertnobox = document.getElementById("alertnobox");
    alertnobox.classList.add("d-none");
}

function alertSuccessclose() {
    var alertokbox = document.getElementById("alertokbox");
    alertokbox.classList.add("d-none");
}

function ApplyAlertBtn(btnid, where, line, color) {
    var alertbtn = document.getElementById(btnid);
    alertbtn.classList.remove("d-none");
    alertbtn.classList.add(color);
    alertbtn.setAttribute('href', where);
    alertbtn.innerHTML = line;
}

function changeView() {
    var signInBox = document.getElementById("signInBox");
    var signUpBox = document.getElementById("signUpBox");

    signInBox.classList.toggle("d-none");
    signUpBox.classList.toggle("d-none");
}

function SignUp() {
    var fullname = document.getElementById("fullname");
    var accountno = document.getElementById("accountno");
    var address = document.getElementById("address");
    var email = document.getElementById("email");
    var username = document.getElementById("username");
    var password = document.getElementById("password"); 

    var SignUpForm = new FormData();
    SignUpForm.append("fullname", fullname.value);
    SignUpForm.append("accountno", accountno.value);
    SignUpForm.append("address", address.value);
    SignUpForm.append("email", email.value);
    SignUpForm.append("username", username.value);
    SignUpForm.append("password", password.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text1 = r.responseText;
            if (text1 == "Success") {
                fullname.value = "";
                accountno.value = "";
                address.value = "";
                email.value = "";
                username.value = "";
                password.value = "";
                AlertSuccess('Sign Up Process is Success');
                alertDangerclose();
                changeView();
            } else {
                AlertDanger(text1);
            }
        }
    };

    r.open("POST", "process/process1.php", true);
    r.send(SignUpForm);
}

function SignIn() {
    var logusername = document.getElementById("logusername");
    var logpassword = document.getElementById("logpassword");
    var remember = document.getElementById("remember");

    var form = new FormData();
    form.append("username", logusername.value);
    form.append("password", logpassword.value);
    form.append("remember", remember.checked);

    var s = new XMLHttpRequest();

    s.onreadystatechange = function() {
        if (s.readyState == 4) {
            var text2 = s.responseText;
            if (text2 == "Success") {
                alertDangerclose();
                window.location = "home.php";
            } else {
                AlertDanger(text2);
            }
        }
    };

    s.open("POST", "process/process2.php", true);
    s.send(form);
}

function showPass1() {
    var password1 = document.getElementById("password");
    var password1b = document.getElementById("password1b");
    password1b.classList.toggle("bi-eye");
    password1b.classList.toggle("bi-eye-slash");
    if (password1.type == "password") {
        password1.type = "text";
    } else {
        password1.type = "password";
    }
}

function showPass2() {
    var password2 = document.getElementById("logpassword");
    var password2b = document.getElementById("password2b");
    password2b.classList.toggle("bi-eye");
    password2b.classList.toggle("bi-eye-slash");
    if (password2.type == "password") {
        password2.type = "text";
    } else {
        password2.type = "password";
    }
}

function BillCalculate() {
    var usage = document.getElementById("usage");
    var bill_preview = document.getElementById("bill_preview");
    var bill_box = document.getElementById("bill_box");

    var form = new FormData();
    form.append("usage", usage.value);

    var s = new XMLHttpRequest();

    s.onreadystatechange = function() {
        if (s.readyState == 4) {
            var text2 = s.responseText;
            if (text2 == "Success") {
                AlertDanger(text2);
            } else {
                bill_box.classList.remove('d-none');
                bill_preview.innerHTML = text2;                
            }
        }
    };

    s.open("POST", "process/process3.php", true);
    s.send(form);
}

function submitbill(){
    var billuse = document.getElementById("billuse");
    var billfinalvalue = document.getElementById("billfinalvalue");
    var year = document.getElementById("year");
    var month = document.getElementById("month");
    alert('Hi');
    if(billuse > '0'){
        var form = new FormData();
        form.append("billuse", billuse.textContent);
        form.append("billfinalvalue", billfinalvalue.textContent);
        form.append("year", year.value);
        form.append("month", month.value);

        var s = new XMLHttpRequest();

        s.onreadystatechange = function() {
            if (s.readyState == 4) {
                var text2 = s.responseText;
                if (text2 == "Success") {
                    AlertSuccess('Saving Process is Success !');
                    alertDangerclose();
                } else {
                    AlertDanger(text2);        
                }
            }
        };

        s.open("POST", "process/process4.php", true);
        s.send(form);
    }else{

    }
}