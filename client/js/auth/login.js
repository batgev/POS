const loginBtn = document.getElementById("login-btn");
const usernameEl = document.getElementById("username");
const passwordEl = document.getElementById("password");

if (!loginBtn || !usernameEl || !passwordEl) {
  alert("all fields are mandotory");
  // Prevent runtime errors if the elements don't exist on the page.
  throw new Error("Missing login form elements");
}

// Resolve controller path relative to this page (client/auth/login.php)
const controllerUrl = "/POS/server/controllers/auth/loginController.php";

loginBtn.addEventListener("click", async (e) => {
  e.preventDefault();

  const username = (usernameEl.value || "").trim();
  const password = passwordEl.value || "";

  try {
    const res = await fetch(controllerUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ username, password }),
    });

    let data;
    try {
      data = await res.json();
    } catch (_) {
      const text = await res.text().catch(() => "");
      alert(text ? `Server response: ${text}` : `Request failed (${res.status})`);
      return;
    }

    if (!res.ok) {
      alert(data && data.message ? data.message : `Request failed (${res.status})`);
      return;
    }

    if (data && data.success) {
      alert(data.message);
      window.location.href = "../dashboards/admin/index.php";
    } else {
      alert(data && data.message ? data.message : "invalid credentials");
    }
  } catch (err) {
    alert("Network/server error. Try again.");
    console.error(err);
  }
});

