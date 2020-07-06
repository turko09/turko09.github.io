var register = {
  register: function () {
    var lname = document.getElementById("lname");
    var fname = document.getElementById("fname");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var address = document.getElementById("email");
    var mobile = document.getElementById("mobile");
    var emobile = document.getElementById("emobile");

    $.ajax({
      type: "POST",
      url: config.apiUrl + "passenger/register.php",
      data: JSON.stringify({
        firstname: fname.value,
        lastname: lname.value,
        email: email.value,
        password: password.value,
        address: "Sample Address",
        mobile: mobile.value,
        panicmobile: emobile.value,
      }),
      success: function (result) {
        ons.notification.alert({
          message: 'Registration successful! You will be redirected to login page.',
          callback: function (answer) {
            window.location.href = "login.html";
          }
        });
      },
      error: function (error) {
        var nameregex = /[\d\W]/;
        var emailregex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (fname.value == "" || fname.value.length < 2 || nameregex.test(fname.value) == true) {
          $(fname).focus();
          if (fname.value == "") {
            $(fname).attr("placeholder", "Please input first name.").placeholder();
          }
          if (fname.value.length < 2) {
            $(fnerror).text("First name should not have less than 2 characters.");
            $(fnerror).show();
          }
          if (nameregex.test(fname.value) == true) {
            var nameregex1 = /\d/;
            var nameregex2 = /\W/;
            if (nameregex1.test(fname.value) == true) {
              $(fnerror).text("Name must not contain numbers.");
              $(fnerror).show();
            }
            if (nameregex2.test(fname.value) == true) {
              $(fnerror).text("Name must not contain special characters.");
              $(fnerror).show();
            }
          }
        }
        else if (lname.value == "" || lname.value.length < 2 || nameregex.test(lname.value) == true) {
          $(fnerror).hide();
          $(lname).focus();
          if (lname.value == "") {
            $(lname).attr("placeholder", "Please input last name.").placeholder();
          }
          if (lname.value.length < 2) {
            $(lnerror).text("Last name should not have less than 2 characters.");
            $(lnerror).show();
          }
          if (nameregex.test(lname.value) == true) {
            var nameregex1 = /\d/;
            var nameregex2 = /\W/;
            if (nameregex1.test(lname.value) == true) {
              $(lnerror).text("Name must not contain numbers.");
              $(lnerror).show();
            }
            if (nameregex2.test(lname.value) == true) {
              $(lnerror).text("Name must not contain special characters.");
              $(lnerror).show();
            }
          }
        }
        else if (email.value == "" || emailregex.test(email.value) == false) {
          $(lnerror).hide();
          $(email).focus();
          if (email.value == "") {
            $(email).attr("placeholder", "Please provide email address.").placeholder();
          }
          if (emailregex.test(email.value) == false) {
            $(emailerror).text("Please provide a valid email address.");
            $(emailerror).show();
          }
        }
        else if (password.value == "" || password.value.length < 4) {
          $(emailerror).hide();
          $(password).focus();
          if (password.value == "") {
            $(password).attr("placeholder", "Please input desired password.").placeholder();
          }
          if (password.value.length < 4) {
            $(pwerror).text("Password should not be less than 4 characters.");
            $(pwerror).show();
          }
        }
        else if (cpassword.value == "" || cpassword.value != password.value) {
          $(pwerror).hide();
          $(cpassword).focus();
          if (cpassword.value == "") {
            $(cpassword).attr("placeholder", "Please confirm password.").placeholder();
          }
          if (cpassword.value != password.value) {
            $(cpwerror).text("Passwords do not match.");
            $(cpwerror).show();
          }
        }
        else if (mobile.value == "" || mobile.value.length < 11) {
          $(cpwerror).hide();
          $(mobile).focus();
          if (mobile.value == "") {
            $(mobile).attr("placeholder", "Please input mobile number.").placeholder();
          }
          if (mobile.value.length < 11) {
            $(merror).text("Mobile number should not have less than 11 characters.");
            $(merror).show();
          }
        }
        else if (emobile.value == "" || emobile.value.length < 11 || emobile.value == mobile.value) {
          $(merror).hide();
          $(emobile).focus();
          if (emobile.value == "") {
            $(emobile).attr("placeholder", "Please input emergency mobile number.").placeholder();
          }
          if (emobile.value.length < 11) {
            $(emerror).text("Emergency contact number should not have less than 11 characters.");
            $(emerror).show();
          }
          if (emobile.value == mobile.value) {
            $(emerror).text("Emergency contact number should not be same with mobile number.");
            $(emerror).show();
          }
        }
        else {
          ons.notification.alert("Registration failed!");
          console.log(error.responseText);
        }
      },
      contentType: "application/json; charset=utf-8",
      dataType: "json"
    });
  }
};