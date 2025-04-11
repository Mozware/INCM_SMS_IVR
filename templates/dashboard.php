<?php // Required to tell PhpRenderer this is a PHP file ?>

<div class="card shadow p-4" style="width: 100%; max-width: 400px;">
  <div class="text-center mb-4">
    <img src="/assets/img/logo.png" height="100" alt="Logo">
    <h3 class="mt-2">Login</h3>
  </div>
  <form method="POST" action="/">
    <div class="form-group mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" required />
    </div>
    <div class="form-group mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required />
    </div>
    <button type="submit" class="btn btn-primary w-100">Log In</button>
  </form>
</div>