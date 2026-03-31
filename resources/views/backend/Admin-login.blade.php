<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin-Login</title>
</head>
<style>
    body {
  font-family: "arial";
  margin: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  background: #fafafa;
  color: #333;
}

.logo {
  margin-left: 70px;
  margin-top: -40px;
  margin-bottom: 50px;
}

.container {
  width: 100%;
  max-width: 400px;
}

.card {
  width: 100%;
  background-color: #d4e7ef;
  padding: 40px;
  border-radius: 12px;
  border: 1px solid #a7ddf5;
}
.card .cartoon {
  margin-bottom: 35px;
  margin-left: auto;
  margin-right: auto;
  width: 200px;
  height: 200px;
}
.card .cartoon img {
  width: 100%;
  height: 100%;
}
.card form {
  display: flex;
  flex-direction: column;
}
.card form .input-group {
  width: 100%;
  margin-bottom: 14px;
}
.card form .input-group input {
  padding: 16px;
  border: none;
  border-radius: 5px;
  transition: border-color 0.3s ease-in-out;
  outline: none;
  color: #333;
  background-color: #f4f4f4;
  width: calc(100% - 30px);
}
.card form .input-group input::placeholder {
  color: #959595;
}
.card form .input-group input:focus {
  border-color: #39778c;
}
.card form button {
  background-color: #2d6476;
  color: #fff;
  padding: 16px 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease-in-out;
  font-size: 16px;
  text-transform: uppercase;
  font-weight: 600;
  letter-spacing: 1px;
  margin-top: 10px;
}
.card form button:hover {
  background-color: #39778c;
}

</style>
<body>
    <div class="container">
  <div class="card">
    <div class="cartoon">
      <img src="https://i.ibb.co.com/98gpLCQ/l1.png" alt="" id="animation1">
      <img src="https://i.ibb.co.com/Vq5j4Vg/l2.png" alt="" id="animation2" style="display: none;">
      <img src="https://i.ibb.co.com/Y0jsj90/l3.png" alt="" id="animation3" style="display: none;">
    </div>
    <form action="{{ route('login') }}" method="POST">
        @csrf
      <div class="input-group">
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
      </div>
      <div class="input-group">
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
</div>
</body>
<script>
    const emailInput = document.getElementById("email");
const passwordInput = document.getElementById("password");
const animation1 = document.getElementById("animation1");
const animation2 = document.getElementById("animation2");
const animation3 = document.getElementById("animation3");

emailInput.addEventListener("focus", () => {
  animation1.style.display = "none";
  animation3.style.display = "block";
  animation2.style.display = "none";
});

passwordInput.addEventListener("focus", () => {
  animation1.style.display = "none";
  animation2.style.display = "block";
  animation3.style.display = "none";
});

const showAnimation1 = () => {
  animation1.style.display = "block";
  animation2.style.display = "none";
  animation3.style.display = "none";
};

emailInput.addEventListener("blur", showAnimation1);
passwordInput.addEventListener("blur", showAnimation1);

</script>
</html>