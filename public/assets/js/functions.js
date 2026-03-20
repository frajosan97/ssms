function passReqForm(type) {
  var verType = type;
  var alertBox = $(".alertContainer");
  var loaderBox = $(".loadContainer");
  loaderBox.removeClass("d-none");
  $.ajax({
    type: "POST",
    url: currentUrl,
    data: { verType: verType },
    success: function (response) {
      loaderBox.addClass("d-none");
      if (response.includes("successfully!")) {
        window.location.href = "reset_password";
      } else {
        alertBox.html(response);
        alertBox.removeClass("success-alert p-1");
        alertBox.addClass("error-alert p-1");
      }
    },
    error: function (xhr, desc, err) {
      console.log(xhr);
    },
  });
}

function vPF(action, view, print, name) {
  var btnAction = action.value;
  var viewData = document.getElementById(view);
  var printData = document.getElementById(print);
  var actionBtn = document.getElementById("actionBtn");
  var printBtn = document.getElementById("printBtn");
  if (btnAction === "show") {
    // hide main & show print format
    viewData.classList.add("d-none");
    printData.classList.remove("d-none");
    actionBtn.value = "hide";
    actionBtn.innerHTML = "<i class='fas fa-eye-slash'></i> Hide " + name;
    printBtn.classList.remove("d-none");
  } else {
    // show main & hide print format
    printData.classList.add("d-none");
    viewData.classList.remove("d-none");
    actionBtn.value = "show";
    actionBtn.innerHTML = "<i class='fas fa-eye'></i> View " + name;
    printBtn.classList.add("d-none");
  }
}

function printDiv(divToPrint) {
  var printContents = document.getElementById(divToPrint).innerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
}

function loadStudentInfo(params) {
  var studKey = params.value;
  window.location.href = root() + "/" + viewFolder + "/cashier/" + studKey;
}

function valPass(password) {
  var pw = password.value;
  var submitBtn = $(".passSubmitBtn");
  var passAlert = $(".passAlert");
  var error = false;
  var message = "";
  if (pw.length < 4) {
    message += "Password cannot be empty</br>";
    error = true;
  }
  if (pw.search(/^(?=.*[~`!@#$%^&*()--+={}\[\]|\\:;"'<>,.?/_₹]).*$/) == -1) {
    message += "Password MUST contain at least one special character.</br>";
    error = true;
  }
  if (pw.search(/[a-z]/) == -1) {
    message += "Password MUST contain at least one lower case letter.</br>";
    error = true;
  }
  if (pw.search(/[A-Z]/) == -1) {
    message += "Password MUST contain at least one upper case letter.</br>";
    error = true;
  }
  if (pw.search(/[0-9]/) == -1) {
    message += "Password MUST contain at least one numeric character.";
    error = true;
  }
  if (error) {
    submitBtn.attr("disabled", "disabled");
    submitBtn.html("Submit button disabled");
    passAlert.removeClass("d-none");
    passAlert.html(message);
  } else {
    submitBtn.removeAttr("disabled");
    submitBtn.html("Save new password");
    passAlert.addClass("d-none");
  }
  return false;
}

function checkUserName(userName) {
  var userName = userName.value;
  var alertBox = $(".alertContainer");
  var submitBtn = $(".submitBtn");
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/staff/checkUserName",
    data: {
      userName: userName,
    },
    success: function (response) {
      alertBox.html(response);
      if (response.includes("approved")) {
        submitBtn.removeAttr("disabled");
        alertBox.addClass("success-alert p-1");
        alertBox.removeClass("error-alert p-1");
      } else {
        submitBtn.attr("disabled", "disabled");
        alertBox.removeClass("success-alert p-1");
        alertBox.addClass("error-alert p-1");
      }
    },
    error: function (xhr, desc, err) {
      console.log(xhr);
    },
  });
}

function switchViewType(type) {
  var type = type.value;
  window.location.href = root() + "/" + viewFolder + "/student/" + type;
}

function showPassword(checkBox) {
  var password = document.getElementById("password");
  if (checkBox.checked) {
    password.type = "text";
  } else {
    password.type = "password";
  }
}

function exAcYear(year) {
  var year = year.value;
  window.location.href = root() + "/" + viewFolder + "/result/" + year;
}

function previewImg(input) {
  $(".img")[0].src = (window.URL ? URL : webkitURL).createObjectURL(
    input.files[0]
  );
}

function previewImg2(url) {
  $(".img").prop("src", url.value);
}

$(".file-upload").on("click", function (e) {
  e.preventDefault();
  $(".fileInput").trigger("click");
});

var inputRow = 2;
function addInputRow() {
  html = '<tr id="invoice-row' + inputRow + '">';
  html += '<td><input type="text" name="invoiceItemHead[]" placeholder="Invoice Item" class="form-control" required /></td>';
  html += '<td><input type="number" name="invoiceItemAmnt[]" placeholder="Item Amount" class="form-control" required /></td>';
  html += '<td><button type="button" onclick="$(\'#invoice-row' + inputRow + '\').remove();" class="btn btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
  html += "</tr>";
  $(".invoiceItems tbody").append(html);
  inputRow++;
}

function showCategory(group) {
  if (group === "overall") {
    var group = group;
  } else {
    var group = group.value;
  }
  var content = document.getElementById(group).innerHTML;
  $(".contentDisplay").html(content);
}

function delTeacherSub(user_key, sub_id) {
  if (confirm("Are you sure you want to remove subject for " + user_key + " ?") === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/staff/delTeacherSub",
      data: { sub_id: sub_id },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  } else {
    alert("Action Cancelled!");
  }
}

function deleteStaff(user_key) {
  if (confirm("Are you sure you want to delete the teacher with staff key: " + user_key + " from the system?\nThis will delete all data related with the staff and it cannot be recovered!") === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/staff/delete",
      data: { user_key: user_key },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  } else {
    alert("Operation Cancelled!");
  }
}

function subjectAction(actionKey, actionType) {
  var actionKey = actionKey.value;
  if (confirm("Are you sure you want to " + actionType + " " + actionKey) === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/system/subject",
      data: { actionKey: actionKey, actionType: actionType },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  } else {
    alert("Operation Cancelled!");
  }
}

function deleteGrdSys(grdKey, grdName) {
  if (confirm("Are you sure you want to delete " + grdName + " from this school account?") === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/grading/delete",
      data: { grdKey: grdKey, grdName: grdName },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  } else {
    alert("Operation Cancelled!");
  }
}

function addCTeacher(teacher, classKey) {
  var teacher = teacher.value;
  var classKey = classKey;
  if (confirm("Are you sure you want to add " + teacher + " as class teacher for " + classKey + "?") === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/classes/addClassTeacher",
      data: { teacher: teacher, classKey: classKey },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  } else {
    alert("Operation Cancelled!");
  }
}

function addSTeacher(teacher, subject, classKey) {
  var teacher = teacher.value;
  var subject = subject;
  var classKey = classKey;
  if (confirm("Are you sure you want to add " + teacher + " as subject teacher for form " + classKey + " - " + subject + "?") === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/classes/addSubjectTeacher",
      data: { teacher: teacher, subject: subject, classKey: classKey },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  } else {
    alert("Operation Cancelled!");
  }
}

function getSchoolInv(schoolKey) {
  var schoolKey = schoolKey.value;
  $.ajax({
    type: "GET",
    url: root() + "/" + viewFolder + "/invoice/getInvoices/" + schoolKey,
    data: {},
    success: function (response) {
      $(".invoiceCont").html(response);
      $(".invoiceInfo").html("");
    },
    error: function (xhr, desc, err) {
      console.log(xhr);
    },
  });
}

function getInvoiceInfo(invKey) {
  var invKey = invKey.value;
  $.ajax({
    type: "GET",
    url: root() + "/" + viewFolder + "/invoice/getInvInfo/" + invKey,
    data: {},
    success: function (response) {
      $(".invoiceInfo").html(response);
      if (!response.includes("No ivoice data related to your search!")) {
        $(".paymentMethod").removeClass("d-none");
      } else {
        $(".paymentMethod").addClass("d-none");
        $(".loadPayment").html("");
      }
    },
    error: function (xhr, desc, err) {
      console.log(xhr);
    },
  });
}

function requestLoad(method) {
  var method = method.value;
  $.ajax({
    type: "GET",
    url: root() + "/" + viewFolder + "/invoice/requestLoad/" + method,
    data: {},
    success: function (response) {
      $(".loadPayment").html(response);
    },
    error: function (xhr, desc, err) {
      console.log(xhr);
    },
  });
}

function validatePayment(payCode) {
  var payCode = payCode.value;
  $.ajax({
    url: root() + "/" + viewFolder + "/invoice/payCheck/" + payCode,
    type: "GET",
    data: {},
    success: function (response) {
      if (!(response.length == 0)) {
        $(".payButton").prop("disabled", true);
        html = response;
      } else {
        $(".payButton").prop("disabled", false);
        html = "<label for=''>Enter Amount paid</label>";
        html += "<input type='number' name='pay_amnt' placeholder='Enter Amount paid' class='form-control' required />";
      }
      $(".paymentReport").html(html);
    },
    error: function (xhr, desc, err) {
      console.log(xhr);
    },
  });
}

function loadPaymentData(payMode) {
  var dataPayMode = payMode;
  if (!(payMode == "all"))
    var dataPayMode = payMode.value;
  $.ajax({
    type: "GET",
    url: root() + "/" + viewFolder + "/invoice/fetchPayment/" + dataPayMode,
    data: {},
    success: function (response) {
      $(".paymentData").html(response);
    },
    error: function (xhr, desc, err) {
      console.log(xhr);
    },
  });
}

function studActionBtn(type, classType) {
  if (confirm("Are you sure you want to " + type + " " + classType + " students?") == true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/student/" + type,
      data: { classType: classType },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  }
}

function deleteTerm(termKey) {
  var termKey = termKey.value;
  if (confirm("Are you sure you want to delete " + termKey + " term?") == true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/system/deleteTerm/",
      data: { termKey: termKey },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  }
}

function manageSchAcc(actionType, actionKey, actionValue, actionObject, objectPhone, objectEmail) {
  if (confirm("Confirm that you want to " + actionType + " the account for " + actionObject) == true) {
    var userPassword = window.prompt("You are about to " + actionType + " the account for " + actionObject + ", to continue kindly enter your password!");
    if (userPassword.length > 0) {
      $.ajax({
        type: "POST",
        url: root() + "/" + viewFolder + "/school/" + actionType,
        data: { userPassword: userPassword, actionKey: actionKey, actionValue: actionValue, actionObject: actionObject, objectPhone: objectPhone, objectEmail: objectEmail },
        success: function (response) {
          alert(response);
          if (response.includes("successfully")) {
            window.location.reload();
          }
        },
        error: function (xhr, desc, err) {
          console.log(xhr);
        },
      });
    } else {
      alert("You MUST enter your password to continue!");
    }
  } else {
    alert("Operation cancelled!");
  }
}

function deleteExam(examKey) {
  var examKey = examKey.value;
  if (confirm("Are you sure you want to delete " + examKey + " exam?") == true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/system/deleteExam/",
      data: { examKey: examKey },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  }
}

function deleteInvalid(examKey) {
  var examKey = examKey.value;
  if (confirm("Are you sure you want to delete invalid results records for " + examKey + " exam?") == true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/result/deleteInvaid/",
      data: { examKey: examKey },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  }
}

function deleteVoteHead(deleteKey) {
  if (confirm("Are you sure you want to delete the vote head by key ID: " + deleteKey) === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/system/deleteVoteHead",
      data: { deleteKey: deleteKey },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  } else {
    alert("Operation cancelled!");
  }
}

function deleteAmnt(deleteKey) {
  if (confirm("Are you sure you want to delete the vote head amount by key ID: " + deleteKey) === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/system/deleteAmnt",
      data: { deleteKey: deleteKey },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  } else {
    alert("Operation cancelled!");
  }
}

// QUERY MANAGEMENT
function runQuery(params) {
  if (confirm("Are you sure you want to run this query of ID:" + params) === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/query/" + params,
      data: { params: params },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  } else {
    alert("Operation cancelled!");
  }
}

function syncStudents(domain) {
  if (navigator.onLine) {
    if (confirm("Are you sure you want to sync students data from the online server to this finance management system?\nThis action will log all recently added students to the system and update any recent updates!") === true) {
      if (domain.length > 0) {
        $.ajax({
          type: "POST",
          url: domain + "/api/sync",
          data: {},
          success: function (response) {
            $('#regStud').modal('show');
            $('.studentsData').html(response);
          },
          error: function (xhr, desc, err) {
            console.log(xhr);
          },
        });
      } else {
        alert("School domain link is not set, kindly go to system management -> school profile and update the school domain with the online system domain link");
      }
    } else {
      alert("Operation cancelled!");
    }
  } else {
    alert("You are currently offline hence unable to sync students informations from the online server!");
  }
}

function deleteStudent(studKey) {
  if (confirm("Are you sure you want to delete this student?\nThis will delete all students records including student results, financial records and library resources available!") === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/student/delete",
      data: { studKey: studKey },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  }
}

function deleteDown(down_key) {
  if (confirm("Are you sure you want to delete this download?\nNote, once this is donw it cannot be reverted!") === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/download/delete",
      data: { down_key: down_key },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  }
}

function deleteClass(cl_key) {
  if (confirm("Are you sure you want to delete form " + cl_key + " class?\nNote, once this is done it cannot be reverted!") === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/classes/delete",
      data: { cl_key: cl_key },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  }
}

function deleteBlog(blog_key) {
  if (confirm("Are you sure you want to delete this blog post?") === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/blog/delete",
      data: { blog_key: blog_key },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  }
}

function deleteInvoice(inv_key) {
  if (confirm("Are you sure you want to delete this invoice?") === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/invoice/delete",
      data: { inv_key: inv_key },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  }
}

function getExams(acYear) {
  var acYear = acYear.value;
  window.location.href = root() + "/" + viewFolder + "/result/" + acYear;
}

function deleteExpense(fi_key) {
  if (confirm("Are you sure you want to delete this invoice?") === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/expense/delete",
      data: { fi_key: fi_key },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  }
}

function deletePayment(fi_key) {
  if (confirm("Are you sure you want to delete this payment?") === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/cashier/delete",
      data: { fi_key: fi_key },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  }
}

function deleteAcc(id) {
  if (confirm("Are you sure you want to delete this account?") === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/account/delete",
      data: { id: id },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  }
}

function deleteSubTeacher(id) {
  if (confirm("Are you sure you want to delete the subject from the attached teacher?") === true) {
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/staff/delTeacherSubject",
      data: { id: id },
      success: function (response) {
        alert(response);
        if (response.includes("successfully")) {
          window.location.reload();
        }
      },
      error: function (xhr, desc, err) {
        console.log(xhr);
      },
    });
  }
}

function moveStudents() {
  swal.fire({
    title: 'Move students',
    text: 'Are you sure you want to move students as per selected categories?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      $(".studentsActionForm").submit();
    }
  });
}

function deleteStudents() {
  swal.fire({
    title: 'Delete students',
    text: 'Are you sure you want to delete the selected students?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      html = '<input type="hidden" id="actionType" name="actionType" value="delete">';
      $('#actionInputs').html(html);
      $(".studentsActionForm").submit();
    }
  });
}

function serverResponse(status, message) {
  swal.fire({
    title: status,
    text: message,
    type: status,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Okay',
  }).then((result) => {
    location.href = window.location;
  });
}