<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once("layouts/header.php") ?>
</head>
<style>
  fieldset{border: 1px solid #eee; padding:5px;}
</style>
<body class="login-page" style="height:auto">
          <div class="row" style="margin-top:50px">
              <div class="col-md-4">
              </div>


              <div class="col-md-6">
                  <div class="card fat" id="register_form" style="margin-top:0px; border: 1px solid #cecbcb">
                      <div class="card-body">
                        <h4 class="card-title" style="text-align:center;">
                          <a href="index.php" style="text-decoration:  none;">
                            <img src="assets/images/logoteam-alpha.png" style="width: 75px;">
                          </a>
                          Driver Registration</h4>
                        <div class="row">
                          <div class="col-md-12">
                              <span id="result" style="font-size: 11px"></span>
                           </div>
                        </div>
                        <br>
                        <input type="hidden" id="current" value="1">
                        <fieldset id="fieldset1">
                            <h6> Driver's Information</h6>
                            <div class="row">
                              <div class="col-md-6">
                                  <label class="form-control-label">First Name <span class="text-danger">*</span></label>
                                  <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Juan" maxlength="25">
                               </div>
                             <div class="col-md-6">
                                  <label class="form-control-label">Last Name <span class="text-danger">*</span></label>
                                  <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Cruz" maxlength="20">
                              </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                  <label class="form-control-label">Email Address<span class="text-danger">*</span></label>
                                  <input type="email" class="form-control" id="email" placeholder="juancruz@gmail.com">
                                </div>

                                <div class="col-md-6">
                                  <label class="6-control-label">Password <span class="text-danger">*</span></label>
                                  <input type="password" class="form-control" name="password" id="password" placeholder="@juander12">
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                  <label class="form-control-label">Address</label>
                                  <input type="text" class="form-control" name="address" id="address" placeholder="Quezon City">
                                </div>
                                 <div class="col-md-6">
                                  <label class="form-control-label">Mobile No. (including country code) <span class="text-danger">*</span></label>
                                  <div style="display: flex">
                                  <span style="padding: 9px;">+ </span>
                                  <input type="text" class="form-control" name="mobile" id="mobile" placeholder="639876543210" maxlength="19">
                                  </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                              <div class="col-md-12">
                                <label>Driver's Photo <span class="text-danger">*</span></label><br>
                                 <img src="#" id="driver_img" alt="" style="width: 200px; height: 200px; border:1px solid;"><br>
                                <input type="file" id="photo">
                              </div>
                            </div>
                        </fieldset>

                        <fieldset id="fieldset2" style="display: none;">
                            <h6> Vehicle Information</h6>
                            <div class="row">
                              <div class="col-md-6">
                                  <label class="form-control-label">Plate No. <span class="text-danger">*</span></label>
                                  <input type="text" class="form-control" id="plateno" placeholder="ABC123" maxlength="6">
                               </div>
                             <div class="col-md-6">
                                 <label class="form-control-label">Type <span class="text-danger">*</span></label>
                                  <select class="form-control" id="vtype">
                                      <option value="Compact">Compact</option>
                                      <option value="Limousine">Limousine</option>
                                       <option value="Sedan">Sedan</option>
                                      <option value="SUV">SUV</option>
                                      <option value="Van">Van</option>
                                  </select>
                              </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                  <label class="form-control-label">Manufacturer <span class="text-danger">*</span></label>
                                  <input  type="text" class="form-control" list="scars"  id="make"/>
                                    <datalist id="scars">
                                    <option>Chevrolet</option>
                                    <option>Ford</option>
                                    <option>Honda</option>
                                    <option>Hyundai</option>
                                    <option>Isuzu</option>
                                    <option>Mazda</option>
                                    <option>Mitsubishi</option>
                                    <option>Nissan</option>
                                    <option>Suzuki</option>
                                    <option>Toyota</option>
                                     </datalist>
                               </div>
                           
                                <div class="col-md-4">
                                  <label class="form-control-label">Model <span class="text-danger">*</span></label>
                                  <input  type="text" class="form-control" list="mcars"  id="model"/>
                                    <datalist id="mcars">
                                    <option>Accent</option>
                                    <option>Adventure</option>
                                    <option>Almera</option>
                                    <option>Avanza</option>
                                    <option>Ciaz</option>
                                    <option>Civic</option>
                                    <option>City</option>
                                    <option>Corolla Altis</option>
                                    <option>Crosswind</option>
                                    <option>EcoSport</option>
                                    <option>Ertiga</option>
                                    <option>Escape</option>
                                    <option>Innova</option>
                                    <option>Mazda 2</option>
                                    <option>Mazda 3</option>
                                    <option>Mirage G4</option>
                                    <option>Mobilio</option>
                                    <option>Sail</option>
                                    <option>Vios</option>
                                    <option>Yaris</option>
                                    </datalist>
                                </div>

                                <div class="col-md-4">
                                  <label class="form-control-label">Color <span class="text-danger">*</span></label>
                                  <input type="text" class="form-control" id="color" placeholder="Black">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                              <div class="col-md-12">
                                <label>Vehicle Photo</label><br>
                                 <img src="#" id="vehicle_img" alt="" style="width: 200px; height: 200px; border:1px solid;"><br>
                                <input type="file" id="vphoto">
                              </div>
                            </div>
                          </fieldset>

                          <fieldset id="fieldset3" style="display: none;">
                          <h6>Driver's Documents</h6>
                            <div class="row">
                                <div class="col-md-6">
                                  <label>Document Description</label><br>
                                  <input type="text" class="form-control" id="description" placeholder="description">
                                </div>
                                <div class="col-md-6">
                                  <label>Type of Document</label><br>
                                  <select class="form-control" id="type">
                                      <option value="License">License</option>
                                      <option value="OR/CR">OR/CR</option>
                                      <option value="Police Clearance">Police Clearance</option>
                                      <option value="Others">Others</option>
                                  </select>
                                </div>
                                <div class="col-md-12">
                                    <label>File</label><br>
                                    <input type="hidden" id="doc_holder">
                                    <input type="file" id="doc">
                                </div>
                            </div>
                            <br>
                          </fieldset>
                    </div>
                    <br>
                    <div class="text-danger text-center" id="rwarning"></div>
                    <div class="form-group no-margin" style="margin-left:auto">
                      <button class="btn btn-default" onclick="prev()">
                        Previous
                      </button>
                      <button type="submit" name="submit" class="btn btn-success" onclick="next()" id="sbtn">
                        Next
                      </button>
                    </div>
                  </div>
              </div>
          </div>


<script>
    document.getElementById("photo").onchange = function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("driver_img").src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    };
    document.getElementById("doc").onchange = function () {
          var reader = new FileReader();
          reader.onload = function (e) {
              document.getElementById("doc_holder").value = e.target.result;
          };
          reader.readAsDataURL(this.files[0]);
      };
      document.getElementById("vphoto").onchange = function () {
          var reader = new FileReader();
          reader.onload = function (e) {
              document.getElementById("vehicle_img").src = e.target.result;
          };
          reader.readAsDataURL(this.files[0]);
      };
    function prev(){
      current = $('#current').val();
      switch(current){
        case '2':
           $('#current').val(1);
            wizard(1);
            $('#sbtn').text('Next');
           break;
        case '3':
           $('#current').val(2);
           wizard(2);
           $('#sbtn').text('Next');
           break;
      }
    }
    function next(){
      current = $('#current').val();
      err =0;
      switch(current){
        case '1':
          firstname = $('#firstname').val();
          lastname = $('#lastname').val();
          email = $('#email').val();
          password = $('#password').val();
          mobile = $('#mobile').val();
          photo = $('#photo').val();
          
          if(firstname == '' || lastname == '' || email == '' || password == '' || mobile == '' || photo == '') {
            err = 1;
          }
          else {
              if(!(mailvalidate(email))) {
                err = 2;
              }
              else
                err = 0;
          }
          
          switch(err){
              case 0:
                   $('#current').val(2);
                    wizard(2);
                    $('#sbtn').text('Next');
                  break;
              case 1:
                  $('#rwarning').text('Please fill out all required fields and check if the data you provided are correct.');
                  break;
              case 2:
                  $('#rwarning').text('Invalid Email Address.');
                  break;
              case 3:
                  $('#rwarning').text('Invalid Contact Number.');
                  break;
          }
          break;
        case '2':
            plateno = $('#plateno').val();
            type = $('#vtype').val();
            make = $('#make').val();
            model = $('#model').val();
            color = $('#color').val();
            vehicle_img = $('#vphoto').val();
            if(plateno =='' || type == '' ||  make == '' || model == '' || color == '' || vehicle_img == ''){
               err = 1;
              }
            else err =0;
            if(err == 0){
               $('#current').val(3);
               wizard(3);
             }
            else 
            $('#rwarning').text('Please fill out all required fields and check if the data you provided are correct.');
          
           $('#sbtn').text('Submit');
           break;
        case '3':
            alert('Do you want to submit the form?');
            description = $('#description').val();
            type = $('#type').val();
            docs = $('#doc').val();
            if(description == '' || type == '' || docs == '')
               err = 1;
            else err =0;
            if(err == 0)
              registerdriver();
            else $('#rwarning').text('Please fill out all required fields and check if the data you provided are correct.');
           break;
      }
    }
    function wizard(val){
      $('#rwarning').text('');
      $('fieldset').hide();
      $('#fieldset' + val).show();
    }
    function registerdriver() {
       firstname = $('#firstname').val();
       lastname = $('#lastname').val();
       email = $('#email').val();
       password = $('#password').val();
       address = $('#address').val();
       mobile = '+' + $('#mobile').val();
       photo = document.getElementById("driver_img").src;
        $.ajax({
          type: "POST",
          url: "/api/driver/register.php",
          async:false,
          data: JSON.stringify({
          firstname: firstname,
          lastname: lastname,
          email: email,
          password: password,
          address: address,
          mobile : mobile,
          photo: photo
          }),
          success: function (response) {
            add_vehicle(response["id"]);
          },
          error: function (response) {
            $("#result").removeClass();
            $('#result').addClass('alert alert-danger');
            $('#result').html("Error Message: " + response.responseJSON["message"]);
          },
          contentType: "application/json; charset=UTF-8",
          dataType: "json"
        });
    };
    function add_vehicle(id){
      plateno = $('#plateno').val();
      type = $('#vtype').val();
      make = $('#make').val();
      model = $('#model').val();
      color = $('#color').val();
      vphoto = document.getElementById("vehicle_img").src;
      $.ajax({
       type: "POST",
       url: "/api/vehicle/add.php",
       async:false,
       data:JSON.stringify({
          driverid: id,
          plateno: plateno,
          type: type,
          make: make,
          model: model,
          color: color,
          vphoto: vphoto
      }),
       success: function (response) {
            go_upload(id);
          },
        error: function (response) {
          $('#result').html("Error Message: " + response.responseJSON["message"]);
        },
      contentType: "application/json; charset=UTF-8",
      dataType: "json"
    });
    }
    function mailvalidate(email) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(email)) {
            return true;
        }
        else {
            return false;
        }
      }
 
  function go_upload(id){
    description = $('#description').val();
    type = $('#type').val();
    docs = $('#doc_holder').val();
    $.ajax({
       type: "POST",
       url: "/api/driver/adddocument.php",
       async:false,
       data:JSON.stringify({
          driverid: id,
          document: docs,
          description: description,
          type: type
      }),
      success: function (response) {
          $("#result").removeClass();
          $('#result').addClass('alert alert-success');
          $('#result').html("Successful Message: Driver addded. ID: " + id);
          $('#register_form input').val('');
      },
      error: function (response) {
        $('#result').html("Error Message: " + response.responseJSON["message"]);
      },
      contentType: "application/json; charset=UTF-8",
      dataType: "json"
    });
  }
   $("#mobile").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl/cmd+A
            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+C
            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+X
            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
  </script>
</body>
</html>
