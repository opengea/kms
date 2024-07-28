linkElement = document.createElement("link");
linkElement.rel = "stylesheet";
linkElement.href = "/kms/mod/isp/dashboard/css/tailwind.min.css";
document.head.appendChild(linkElement);

linkElement_2 = document.createElement("link");
linkElement_2.rel = "stylesheet";
linkElement_2.href = "/kms/mod/isp/dashboard/css/dashboard.css";
document.head.appendChild(linkElement_2);

$('.serverBtn').click(function(){
   alert('click');
});