$(document).ready(function(){
    // for product images///////////////////////////////////////////////////////////////////////////////////////////////

    $(document).ajaxStart(function(){
        // Show image container
        $("#loader").show();
    });
    $(document).ajaxComplete(function(){
        // Hide image container
        $("#loader").hide();
    });

    const photoSelect = document.getElementById("uploadPhoto"),
    photoElem = document.getElementById("photoInput"),
    photoList = document.getElementById("photoValue");
    photoElem.addEventListener("change", handleFiles4, false);

    const fileSelect = document.getElementById("uploadManual"),
    fileElem = document.getElementById("manualInput"),
    fileList = document.getElementById("manualValue");
    fileElem.addEventListener("change", handleFiles, false);


    function handleFiles4() {
        console.log('here');
        if (!this.files.length) {
            photoList.innerHTML = "<p>No files selected!</p>";
        } else {
            photoList.innerHTML = "";
            const list = document.createElement("ul");
            photoList.appendChild(list);
            for (let i = 0; i < this.files.length; i++) {
                const li = document.createElement("span");
                list.appendChild(li);

                const img = document.createElement("img");
                img.src = URL.createObjectURL(this.files[i]);
                img.height = 40;
                img.width = 40
                img.onload = function() {
                    URL.revokeObjectURL(this.src);
                }
                li.appendChild(img);
                const info = document.createElement("span");
                const filesLength = this.files.length;
                const fileSize = this.files[i].size / 1024 / 1024;
                const fileInfo = this.files[i].name;
                console.log(fileInfo);
                // console.log(date);

                info.innerHTML = fileInfo  + ": " + fileSize.toFixed(2) + " MB";
                li.appendChild(info);

            }
        }
    }

    $("#photoForm").on('submit',(function(e) {
        e.preventDefault();
        const filesLength = photoElem.files.length;
        if (!filesLength) {
            photoList.innerHTML = "<p>Select the Property Photo</p>";
        } else {
            $('#photoModal').modal('hide');
            // $("#loadingModal").modal("show");
            for (let i = 0; i < filesLength; i++) {
                var file_data = $("#photoInput").prop("files")[i];
                var prod_id = $("#propId").val();
                var form_data = new FormData();
                form_data.append("file", file_data);
                form_data.append("propId", prod_id);

                console.log(prod_id);
                console.log(file_data);
                console.log(form_data);

                $.ajax({
                    url: "includes/handlers/ajax/photoHandler.php",
                    type: "POST",
                    data:  form_data,
            		dataType: 'json',
		            contentType: false,
		            cache: false,
		            processData:false,
                    success: function(response){
                        console.log(response)
                        if(response.status == 0){
                            alert(response.message);
                            errorMessage.innerHTML = response.message;
                            dangerAlertELement = document.getElementById("dangerAlert");
                            dangerAlertELement.classList.remove("hidden");
                            dangerAlertELement.classList.add("show");
                            return;
                        } else {
                            successMessage = document.getElementById("successMessage");

                            successMessage.innerHTML = "   Successfully added Photo(s)";
                            successAlertELement = document.getElementById("successAlert");
                            successAlertELement.classList.remove("hidden");
                            successAlertELement.classList.add("show");

                            const addPhoto = document.getElementById("propertyImageList");
                            const li = document.createElement("span");
                            addPhoto.appendChild(li);
                            li.classList.add("ImageListItem");
                            li.addEventListener("click", setSelectedPhoto(response.id, prod_id, this))

                            const img = document.createElement("img");
                            img.src = response.message;
                            li.appendChild(img);
                            const br = document.createElement("br");
                            addPhoto.appendChild(br);
                        }
                    },
                    error: function(e){
                        alert(response.message);
                        errorMessage.innerHTML = response.message;
                        dangerAlertELement = document.getElementById("dangerAlert");
                        dangerAlertELement.classList.remove("hidden");
                        dangerAlertELement.classList.add("show");
                    }
                });
            }
            // $("#loadingModal").modal("hide");
			$("html, body").animate({scrollTop: 0}, "slow")
        }

    }));
// //////////////////////// end of property images/////////////////////////////////////////////////////////////////////

// //////////////////////// Start property details/////////////////////////////////////////////////////////////////////

    $("#saveDrafts , #publish, #preview").on('click', function (e) {

        e.preventDefault();
        console.log('clicked');


        // location
        var city = $("#city").val();
        var street = $("#street").val();
        var neighb = $("#neighb").val();

        // pricing
        var price = $("#price").val();
        var rent_income = $("#rent_income").val();
        var oldPrice = $("#oldPrice").val();

        // descriptive features
        var rooms = $("#rooms").val();
        var area = $("#area").val();
        var floor = $("#floor").val();
        var floor_in_build = $("#floor_in_build").val();

        // amenities
        var balcony = $("#balcony").val();
        var parking = $("#parking").val();
        var elevator = $("#elevator").val();
        var storeroom = $("#storeroom").val();
        var air_condition = $("#air_condition").val();
        var security_room = $("#security_room").val();

        // extra expenses
        var lawyer = $("#lawyer").val();
        var renovation = $("#renovation").val();
        var brokerage = $("#brokerage").val();
        var tax = $("#tax").val();
        var appraiser = $("#appraiser").val();

        // other values
        var rent_status = $("input[type=checkbox][name=rent_status]:checked").val();
        var renovation_status = $("input[type=radio][name=renovation_status]:checked").val();
        var property_description = $("#property_description").val();
        var built_year = $("#built_year").val();

        // seller Details
        var firstname = $("#firstname").val();
        var lastname = $("#lastname").val();
        var agentEmail = $("#agentEmail").val();
        var agentNumber = $("#agentNumber").val();

        var proceed = 1;
        if(this.id === 'saveDrafts'){
            var status = 0,
            preview = 0;
            console.log('Saved as drafts');
        }else if (this.id === 'publish') {
            if (city == '' || street == '' || neighb == '' || price == '' || rent_income == '' || oldPrice == '' || rooms == '' || area == '' || floor == '' || floor_in_build == '' || balcony == '' || parking == '' || elevator == '' || storeroom == '' || air_condition == '' || security_room == '' || lawyer == '' || renovation == '' || brokerage == '' || tax == '' || appraiser == '' || built_year == '' || property_description == '' || renovation_status == '' || firstname == '' || lastname == '' || agentEmail == '' || agentNumber == '') {
              proceed = 0;
            } else {
                var status = 1,
                preview = 0;
                console.log('Published');
            }
        } else {
            var status = 0,
            preview = 1;
            console.log('Saved as drafts for preview');
        }

        if (rent_status == undefined) {
          rent_status = "no";
        }
        console.log(city);
        console.log(street);
        console.log(neighb);
        console.log(price);
        console.log(rent_income);
        console.log(oldPrice);
        console.log(rooms);
        console.log(area);
        console.log(floor);
        console.log(floor_in_build);
        console.log(balcony);
        console.log(parking);
        console.log(elevator);
        console.log(storeroom);
        console.log(air_condition);
        console.log(security_room);
        console.log(lawyer);
        console.log(renovation);
        console.log(brokerage);
        console.log(tax);
        console.log(appraiser);
        console.log(built_year);
        console.log(property_description);
        console.log(renovation_status);
        console.log(rent_status);
        console.log(firstname);
        console.log(lastname);
        console.log(agentEmail);
        console.log(agentNumber);

        console.log(proceed);

        if (proceed) {

            //data to be sent to server
            //Ajax post data to server
            $.post("includes/handlers/ajax/submitProducts.php", {
              propId: propId,
              city:city,
              street:street,
              neighb:neighb,
              price:price,
              rent_income:rent_income,
              oldPrice:oldPrice,
              rooms:rooms,
              area:area,
              floor:floor,
              floor_in_build:floor_in_build,
              balcony:balcony,
              parking:parking,
              elevator:elevator,
              storeroom:storeroom,
              air_condition:air_condition,
              security_room:security_room,
              lawyer:lawyer,
              renovation:renovation,
              brokerage:brokerage,
              tax:tax,
              appraiser:appraiser,
              built_year:built_year,
              property_description:property_description,
              renovation_status:renovation_status,
              rent_status:rent_status,
              firstname:firstname,
              lastname:lastname,
              agentEmail:agentEmail,
              agentNumber:agentNumber,
              status: status

            }).done(function(response){

                console.log(response);
                result = JSON.parse(response);

                if(result.status === 0){
                    output = '<div class="alert-danger" style="padding:10px; margin-bottom:25px;">' + result.message+ '</div>';
                    return;
                } else {
                    if (status == 1 && preview == 0) {
                        // location.reload(true);
                        successMessage = document.getElementById("successMessage");
                        successMessage.innerHTML = result.message+ ". Published!";
                        successAlertELement = document.getElementById("successAlert");
                        successAlertELement.classList.remove("hidden");
                        successAlertELement.classList.add("show");
                    }else if(status == 0  && preview == 0) {
                        // location.reload(true);
                        successMessage = document.getElementById("successMessage");

                        successMessage.innerHTML = "       SAVED AS DRAFTS ";
                        successAlertELement = document.getElementById("successAlert");
                        successAlertELement.classList.remove("hidden");
                        successAlertELement.classList.add("show");
                    }else if(status == 0  && preview == 1) {
                        successMessage = document.getElementById("successMessage");

                        successMessage.innerHTML = "      This has been saved to Draft. Preview in the next tab. Click publish to make the changes Permanent";
                        successAlertELement = document.getElementById("successAlert");
                        successAlertELement.classList.remove("hidden");
                        successAlertELement.classList.add("show");

                        var newUrl = '../../../../productPreview.php?id='+ prodId;
                        console.log(newUrl);
                        const tab = window.open(newUrl, '_blank');
                    } else {
                        errorMessage = document.getElementById("errorMessage");
                        errorMessage.innerHTML = "   This is an Unintended Instance. contact Webadministrators for more info";
                        dangerAlertELement = document.getElementById("dangerAlert");
                        dangerAlertELement.classList.remove("hidden");
                        dangerAlertELement.classList.add("show");
                    }
                }

            });

        } else{
            console.log("Fill all fields")
            errorMessage = document.getElementById("errorMessage");
            errorMessage.innerHTML = "Please Fill in all neccessary Fields";
            dangerAlertELement = document.getElementById("dangerAlert");
            dangerAlertELement.classList.remove("hidden");
            dangerAlertELement.classList.add("show");
        }
        $("html, body").animate({scrollTop: 0}, "slow")

    });

// //////////////////////// end of property details ///////////////////////////////////////////////////////////////////

// //////////////////////// start logo slider images///////////////////////////////////////////////////////////////////

    $("#logoForm").on('submit',(function(e) {
        e.preventDefault();
        console.log("Submitting");
        const filesLength = photoElem.files.length;
        if (!filesLength) {
            photoList.innerHTML = "<p>Select Logo</p>";
        } else {
            for (let i = 0; i < filesLength; i++) {
                var file_data = $("#photoInput").prop("files")[i];
                var form_data = new FormData();
                var check = 'sending';
                form_data.append("file", file_data);
                form_data.append("checkData", check);

                console.log(file_data);
                console.log(form_data);

                $.ajax({
                    url: "includes/handlers/ajax/logoHandler.php",
                    type: "POST",
                    data:  form_data,
            		dataType: 'json',
		            contentType: false,
		            cache: false,
                    processData:false,
                    success: function(response){
                        console.log(response);
                        console.log(response.message);
                        if(response.status == 0){
                            alert(response.message);
                            return;
                        } else {
                            var addPhoto = $("#logoHere");

                            var span =  $("<span>", {"class": "logoSpan"});
                            var img = $("<img />", {src: response.message, "class": "logoImage"});

                            img.appendTo(span);

                            console.log(span);
                            console.log(addPhoto);

                            addPhoto.html(span);

                            photoList.innerHTML = ' ';
                        }
                    },
                    error: function(e){
                        console.log(e);

                    }
                });
            }
			$("html, body").animate({scrollTop: 0}, "slow")
        }

    }));

// //////////////////////// end logo slider images////////////////////////////////////////////////////////////////////

// ////////////////////////////////////// start plann ////////////////////////////////////////////////////////////////

  function handleFiles() {
      if (!this.files.length) {
          fileList.innerHTML = "<p>No files selected!</p>";
      } else {
          fileList.innerHTML = "";
          const list = document.createElement("ul");
          fileList.appendChild(list);
          for (let i = 0; i < this.files.length; i++) {
              const li = document.createElement("span");
              list.appendChild(li);

              // const img = document.createElement("img");
              // img.src = URL.createObjectURL(this.files[i]);
              // img.height = 60;
              // img.onload = function() {
              // 	URL.revokeObjectURL(this.src);
              // }
              // li.appendChild(img);
              const info = document.createElement("span");
              filesLength = this.files.length;
              fileSize = this.files[i].size / 1024 / 1024;
              fileInfo = this.files[i].name;
              manualDirectory = "../uploads/manual/" + fileInfo;
              // console.log(manualDirectory);
              // console.log(date);
              type = "Manual";

              info.innerHTML = fileInfo  + ": " + fileSize.toFixed(2) + " MB";
              li.appendChild(info);

          }
      }
  }

  $("#manualForm").on('submit', function(e){

      console.log("manual form to be submited");

      e.preventDefault();
      filesLength = fileElem.files.length;
      if (!filesLength) {
          fileList.innerHTML = "<p>Select the Town Plan to Upload</p>";
      } else {
          $('#manualModal').modal('hide');
          // $("#loadingModal").modal("show");
          for (let i = 0; i < filesLength; i++) {
              var file_data = $("#manualInput").prop("files")[i];
              var prop_id = $("#manualprodId").val();
              var form_data = new FormData();
              form_data.append("file", file_data);
              form_data.append("propId", prop_id);
              console.log(file_data);

                $.ajax({
                  type: 'POST',
                  url: 'includes/handlers/ajax/townPlanHandler.php',
                  data: form_data,
                  dataType: 'json',
                  contentType: false,
                  cache: false,
                  processData:false,
                  beforeSend: function(){
                      $('.submitBtn').attr("disabled","disabled");
                      $('#fupForm').css("opacity",".5");
                  },
                  success: function(response){
                      console.log(response);
                      if(response.status == 0){
                          errorMessage = document.getElementById("errorMessage");
                          errorMessage.innerHTML = response.message;
                          dangerAlertELement = document.getElementById("dangerAlert");
                          dangerAlertELement.classList.remove("hidden");
                          dangerAlertELement.classList.add("show");
                      } else {
                          successMessage = document.getElementById("successMessage");
                          successMessage.innerHTML = " " + response.message + ". Refresh to View";
                          successAlertELement = document.getElementById("successAlert");
                          successAlertELement.classList.remove("hidden");
                          successAlertELement.classList.add("show");

                      }
                  }
               });
          }
          // $("#loadingModal").modal("hide");
          $("html, body").animate({scrollTop: 0}, "slow")
      }
  });

/////////////////////////////////// end of manual /////////////////////////////////////////////////////////////////////

// /////////////////////////////////////// similar purchases //////////////////////////////////////////////////////////

  $("#sim_purchase_form").on('submit',(function(e) {
    e.preventDefault();
    var propertyId = $("#sim_propertyId").val();
    var address = $("#address").val();
    var rooms = $("#sim_rooms").val();
    var price = $("#sim_price").val();
    var date_prop = $("#date_prop").val();
    var build_year = $("#sim_build_year").val();

    $.post("includes/handlers/ajax/simpurchaseHandler.php", {
      propertyId: propertyId,
      address: address,
      rooms:rooms,
      price:price,
      date_prop:date_prop,
      build_year:build_year
    }).done(function(response){
        console.log(response);
        result = JSON.parse(response);

        if(result.status === 0){
          errorMessage = document.getElementById("errorMessage");
          errorMessage.innerHTML = response.message;
          dangerAlertELement = document.getElementById("dangerAlert");
          dangerAlertELement.classList.remove("hidden");
          dangerAlertELement.classList.add("show");
        } else {
            successMessage = document.getElementById("successMessage");
            successMessage.innerHTML = " " + response.message + ". Refresh to View";
            successAlertELement = document.getElementById("successAlert");
            successAlertELement.classList.remove("hidden");
            successAlertELement.classList.add("show");

        }

    });
    $("html, body").animate({scrollTop: 0}, "slow")


}));

});
/////////////////////////// set selected photo ////////////////////////////////////////////////////////////////////////

function setSelectedPhoto(id, propId, imageElement) {
    $.post("includes/handlers/ajax/setSelectedPhoto.php", {propId: propId, photoId: id})
    .done(function(e){
        if (e == '') {
            var item = $(imageElement);
            var imageElementClass = item.attr("class");

            $("." + imageElementClass).removeClass("selected");

            item.addClass("selected");
            alert('Main property photo Selected');
            console.log('Main property photo Selected');

        } else {
            console.log(e);
        }
    });
}
