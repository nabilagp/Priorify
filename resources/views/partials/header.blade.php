<div class="header">
  <div class="logo-title">
    <img src="{{ asset('logo.png') }}" alt="Priorify Logo" class="logo-img" />
    <div class="title">
      <h1>Priorify</h1>
      <span>To-Do List</span>
    </div>
  </div>

  <div class="profile-container">
    <div class="profile-circle" onclick="toggleProfileMenu()">
      {{ strtoupper(substr(Auth::user()->email, 0, 1)) }}
    </div>
    <div class="profile-dropdown" id="profileDropdown">
      <div class="profile-info">
        <strong>{{ Auth::user()->name ?? 'User Name' }}</strong><br>
        <small>{{ Auth::user()->email }}</small>
      </div>
      <a href="{{ route('profile') }}">Profile</a>
      <a href="{{ route('logout') }}">Logout</a>
    </div>
  </div>
</div>
