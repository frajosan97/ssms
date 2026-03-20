// AUTHENTICATE PAGE FORMS SUBMIT
$(".authFormSubmit").on("submit", function (event) {
  event.preventDefault();
  var alertBox = $(".alertContainer");
  var loaderBox = $(".loadContainer");
  loaderBox.removeClass("d-none");
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: currentUrl,
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (response) {
      loaderBox.addClass("d-none");
      if (response.includes("success")) {
        window.location.href = "password";
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
});

$(".authPassForm").on("submit", function (event) {
  event.preventDefault();
  var alertBox = $(".alertContainer");
  var loaderBox = $(".loadContainer");
  loaderBox.removeClass("d-none");
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: currentUrl,
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {
      loaderBox.addClass("d-none");
      if (data.includes("incorrect")) {
        alertBox.html(data);
        alertBox.removeClass("success-alert p-1");
        alertBox.addClass("error-alert p-1");
      } else {
        window.location.href = data;
      }
    },
    error: function (xhr, desc, err) {
      console.log(xhr);
    },
  });
});

$(".changePassForm").on("submit", function (event) {
  event.preventDefault();
  var alertBox = $(".alertContainer");
  var loaderBox = $(".loadContainer");
  var userType = $("#userID").val();
  loaderBox.removeClass("d-none");
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: currentUrl,
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {
      loaderBox.addClass("d-none");
      alertBox.html(data);
      if (data.includes("successfully")) {
        alertBox.addClass("success-alert p-1");
        alertBox.removeClass("error-alert p-1");
        window.setTimeout(function () {
          window.location.href = root() + "/auth/" + userType;
        }, 2000);
      } else {
        alertBox.removeClass("success-alert p-1");
        alertBox.addClass("error-alert p-1");
      }
    },
    error: function (xhr, desc, err) {
      console.log(xhr);
    },
  });
});

$(".userRegForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: currentUrl,
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".addStreamForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: currentUrl,
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".addClassForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: currentUrl,
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".loadPaymentForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/invoice/payment",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".resultsDelForm").on("submit", function (event) {
  event.preventDefault();
  if (confirm("Are you sure you want to delete the checked results records?\nOnce the records are deleted, they cannot be reverted!") == true) {
    var formData = new FormData(this);
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/result/delete",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
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
});

// FINANCE
$(".postFeesForm").on("submit", function (event) {
  event.preventDefault();
  if (confirm("Are you sure you want to POST fees for the selected students category and its consituent fields?") == true) {
    var formData = new FormData(this);
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/finance/postFees",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
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
});

$(".addVoteHeadForm").on("submit", function (event) {
  event.preventDefault();
  if (confirm("Confirm that you want to add the keyed in vote head") == true) {
    var formData = new FormData(this);
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/system/vote_head",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
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
});

$(".addVoteAmountForm").on("submit", function (event) {
  event.preventDefault();
  if (confirm("Are you sure you want to add amount for the votehead") == true) {
    var formData = new FormData(this);
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/system/manage_vote_head",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
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
});

$(".fsNotesForm").on("submit", function (event) {
  event.preventDefault();
  if (confirm("Are you sure you want to update the fees structure notes?") == true) {
    var formData = new FormData(this);
    $.ajax({
      type: "POST",
      url: root() + "/" + viewFolder + "/system/fsNotes",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
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
});

$(".regBulkStud").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/student/regBulkStud",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".addAccountForm").on("submit", function (event) {
  event.preventDefault();
  loaderBox.removeClass("d-none");
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/account/create",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".updateAccForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/account/read",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".feesPayForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/cashier/feesPayment",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (response) {
      alert(response);
      if (response.includes("successfully")) {
        window.location.href = root() + "/" + viewFolder + "/printtemp";
        window.setTimeout(function () {
          location.reload();
        }, 2000);
      }
    },
    error: function (xhr, desc, err) {
      console.log(xhr);
    },
  });
});

$(".addExpenseForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/expense/create",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".updateExpenseForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/expense/update",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".feesBalanceForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/message/sendFeeBalance",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".addDownloadForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/download/create",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".addBlogForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/blog/create",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".createTermForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/system/createTerm",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".createExamForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/system/createExam",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".staffUpdateForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/staff/update",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".createSchoolForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/school/create",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".studRegForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/student/create",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".studentSearchForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/student/search",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (response) {
      $(".searchData").html(response);
    },
    error: function (xhr, desc, err) {
      console.log(xhr);
    },
  });
});

$(".createMartksEntryForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/exam/create",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".marksEntryRequestForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/exam/entry",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (response) {
      if (response.includes("successfully")) {
        window.location.href = root() + "/" + viewFolder + "/exam/marks_entry";
      } else {
        alert(response);
      }
    },
    error: function (xhr, desc, err) {
      console.log(xhr);
    },
  });
});

$(".marksEntryForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/exam/marks_entry",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".alumniSignUpForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/alumni/register",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (response) {
      alert(response);
      if (response.includes("successfully")) {
        window.location.href = root() + "/alumni/login";
      }
    },
    error: function (xhr, desc, err) {
      console.log(xhr);
    },
  });
});

$(".alumniLoginForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/alumni/login",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (response) {
      alert(response);
      if (response.includes("successfully")) {
        window.location.href = root() + "/alumni";
      }
    },
    error: function (xhr, desc, err) {
      console.log(xhr);
    },
  });
});

$(".studentsActionForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  var actionType = $('#actionType').val();
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/student/" + actionType,
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (response) {
      if (response.includes("successfully")) {
        serverResponse('Success', response);
      } else {
        serverResponse('Error', response);
      }
    },
    error: function (xhr, desc, err) {
      console.log(xhr);
    },
  });
});

$(".addTeacherSubjectForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/classes/addSubjectTeacher",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".reportGetForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  var reportType = $("#reportType").val();
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/finance_report/" + reportType,
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (response) {
      $(".financeReportData").html(response);
    },
    error: function (xhr, desc, err) {
      console.log(xhr);
    },
  });
});

$(".addIncomeSourceForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/" + viewFolder + "/income/create",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});

$(".dynamicPageForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: root() + "/alumni/create",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
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
});