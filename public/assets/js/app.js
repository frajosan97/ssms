const host = window.location.host;
const pathname = window.location.pathname;
const currentUrl = window.location.href;
const viewFolder = $("meta[name='viewFolder']").attr("content");
const alertBox = $(".alertBox");
const alertTable = $(".alertTable");
const alertIcon = $(".alertIcon");
const alertMessage = $(".alertMessage");
const loaderBox = $(".loadContainer");

function root() {
  var scripts = document.getElementsByTagName("script"),
    script = scripts[scripts.length - 1],
    path = script.getAttribute("src").split("/"),
    pathname = location.pathname.split("/"),
    notSame = false,
    same = 0;

  for (var i in path) {
    if (!notSame) {
      if (path[i] == pathname[i]) {
        same++;
      } else {
        notSame = true;
      }
    }
  }

  return location.origin + pathname.slice(0, same).join("/");
}

$(document).ready(function () {
  for (let index = 1; index <= 5; index++) {
    $('#dataTable' + index).DataTable({
      language: {
        'paginate': {
          'previous': '<span class="fa fa-chevron-left"></span>',
          'next': '<span class="fa fa-chevron-right"></span>'
        },
        "lengthMenu": 'Display <select class="form-control input-sm"><option value="10">10</option><option value="20">20</option><option value="30">30</option><option value="40">40</option><option value="50">50</option><option value="-1">All</option><option value="10">10</option></select> results'
      }
    });
  }
  $('.selectpicker').select2();
});

// MOBILE NAV BAR
function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}
