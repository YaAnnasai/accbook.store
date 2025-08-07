document.getElementById("btnLogin").addEventListener("click", function () {
  const btn = this;
  btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
  btn.disabled = true;

  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;
  const recaptcha = document.getElementById("g-recaptcha-response").value;

  fetch("https://accbook.store/ajaxs/client/login.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `username=${username}&password=${password}&recaptcha=${recaptcha}`
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        alert(data.msg);
        window.location.href = "https://accbook.store/client/home";
      } else if (data.status === "verify") {
        alert(data.msg);
        setTimeout(() => {
          window.location.href = data.url;
        }, 1000);
      } else {
        alert("Login failed: " + data.msg);
      }
      btn.innerHTML = "Log in";
      btn.disabled = false;
    })
    .catch(() => {
      alert("Request failed.");
      btn.innerHTML = "Log in";
      btn.disabled = false;
    });
});
