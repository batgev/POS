const loginBtn = document.getElementById("login-btn");
const usernameEl = document.getElementById("username");
const passwordEl = document.getElementById("password");






loginBtn.addEventListener("click", async () => {

  if ( !usernameEl.value || !passwordEl.value) {
    return alert("all fields are mandotory");
    
  }


  const username = (usernameEl.value || "").trim();
  const password = passwordEl.value || "";

  try {
    const res = await fetch('/POS/server/controllers/auth/registerController.php', {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ username, password }),
    });

    const data = await res.json();

    if (!res.success) {
      const msg =  data.message || `Request failed (${res.status})`;
      alert(msg);
      return;
    }

    if (data.success) {
      alert(data.message || "registered successfully");
      window.location.href = "/POS/client/auth/login.php";
    }
  } catch (err) {
    alert("network/server error. Try again.");
    console.error(err);
  }
});

