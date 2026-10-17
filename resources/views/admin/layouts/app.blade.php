<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Dashboard Admin') &middot; OneMovies</title>
  <link rel="stylesheet" href="{{ asset('template/css/font-awesome.min.css') }}">
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      background: #f4f6fb;
      color: #2f3b52;
      font-size: 14px;
    }
    a { text-decoration: none; color: inherit; }

    .admin-shell { display: flex; min-height: 100vh; }

    /* Sidebar */
    .admin-sidebar {
      width: 250px;
      background: #1e2a3a;
      color: #c7d1e0;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      position: sticky;
      top: 0;
      height: 100vh;
    }
    .admin-brand {
      padding: 22px 24px;
      font-size: 20px;
      font-weight: 700;
      color: #ffffff;
      letter-spacing: .5px;
      border-bottom: 1px solid rgba(255,255,255,.08);
    }
    .admin-brand i { color: #4fc3f7; margin-right: 8px; }
    .admin-brand span span { color: #4fc3f7; }
    .admin-nav { padding: 14px 0; overflow-y: auto; }
    .admin-nav a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 24px;
      color: #c7d1e0;
      font-weight: 500;
      border-left: 3px solid transparent;
      transition: background .15s, color .15s;
    }
    .admin-nav a i { width: 18px; text-align: center; font-size: 15px; }
    .admin-nav a:hover { background: rgba(255,255,255,.06); color: #ffffff; }
    .admin-nav a.active {
      background: rgba(79,195,247,.15);
      color: #ffffff;
      border-left-color: #4fc3f7;
    }

    /* Main */
    .admin-main { flex: 1; min-width: 0; display: flex; flex-direction: column; }
    .admin-topbar {
      background: #ffffff;
      padding: 16px 28px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      box-shadow: 0 1px 4px rgba(31,45,61,.08);
      position: sticky;
      top: 0;
      z-index: 5;
    }
    .admin-topbar h1 { font-size: 20px; margin: 0; color: #1e2a3a; }
    .admin-user { display: flex; align-items: center; gap: 16px; font-size: 13px; }
    .admin-user span { color: #5a6b85; }
    .admin-user span i { color: #4fc3f7; margin-right: 5px; }
    .admin-user a.link { color: #1976d2; }
    .admin-user button {
      background: #ff5b5b;
      color: #fff;
      border: 0;
      padding: 7px 14px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 13px;
    }
    .admin-user button:hover { background: #e14b4b; }

    .admin-content { padding: 26px 28px 40px; }

    /* Alerts */
    .alert {
      padding: 12px 16px;
      border-radius: 6px;
      margin-bottom: 18px;
      font-size: 13px;
      border: 1px solid transparent;
    }
    .alert-success { background: #e7f6ec; color: #1b7d3f; border-color: #bfe6cb; }
    .alert-error { background: #fdecea; color: #b3261e; border-color: #f7c5c0; }

    /* Stat cards */
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 18px;
      margin-bottom: 26px;
    }
    .stat-card {
      background: #ffffff;
      border-radius: 10px;
      padding: 20px;
      display: flex;
      align-items: center;
      gap: 16px;
      box-shadow: 0 2px 8px rgba(31,45,61,.06);
    }
    .stat-card .icon {
      width: 48px; height: 48px;
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 20px; color: #fff;
      flex-shrink: 0;
    }
    .stat-card .value { font-size: 24px; font-weight: 700; color: #1e2a3a; line-height: 1.1; }
    .stat-card .label { font-size: 12px; color: #748199; text-transform: uppercase; letter-spacing: .4px; margin-top: 3px; }
    .bg-blue { background: #2196f3; }
    .bg-green { background: #2ecc71; }
    .bg-orange { background: #ff9800; }
    .bg-purple { background: #9b59b6; }
    .bg-pink { background: #e91e63; }
    .bg-teal { background: #009688; }

    /* Panels */
    .panels { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .panel {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(31,45,61,.06);
      overflow: hidden;
    }
    .panel-head {
      padding: 16px 20px;
      border-bottom: 1px solid #eef1f6;
      font-weight: 600;
      color: #1e2a3a;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .panel-body { padding: 6px 0; }

    /* Tables */
    .table-wrap { background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(31,45,61,.06); overflow-x: auto; }
    table.table { width: 100%; border-collapse: collapse; }
    table.table th, table.table td { padding: 12px 16px; text-align: left; border-bottom: 1px solid #eef1f6; vertical-align: middle; }
    table.table th { background: #fafbfd; font-size: 12px; text-transform: uppercase; letter-spacing: .4px; color: #748199; }
    table.table tbody tr:hover { background: #f8faff; }
    table.table td.actions { white-space: nowrap; }
    .poster-thumb { width: 42px; height: 58px; object-fit: cover; border-radius: 4px; background: #e9edf3; }
    .muted { color: #8a97ad; }
    .comment-cell { max-width: 380px; }

    /* Buttons */
    .btn {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 8px 14px; border-radius: 6px; border: 0;
      font-size: 13px; cursor: pointer; font-weight: 500;
      background: #eef1f6; color: #3a4a63;
    }
    .btn:hover { filter: brightness(.96); }
    .btn-primary { background: #2196f3; color: #fff; }
    .btn-success { background: #2ecc71; color: #fff; }
    .btn-danger { background: #ff5b5b; color: #fff; }
    .btn-secondary { background: #eef1f6; color: #3a4a63; }
    .btn-sm { padding: 5px 10px; font-size: 12px; }
    .btn-inline { display: inline; }
    .page-head { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 18px; }
    .page-head p { margin: 4px 0 0; color: #748199; font-size: 13px; }

    /* Badges & stars */
    .badge { display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
    .badge-admin { background: #e3f2fd; color: #1565c0; }
    .badge-user { background: #eef1f6; color: #5a6b85; }
    .stars i { color: #ffc107; }
    .stars i.off { color: #d6dce6; }

    /* Forms */
    .form-card { background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(31,45,61,.06); padding: 24px; max-width: 720px; }
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; margin-bottom: 6px; font-weight: 600; color: #3a4a63; font-size: 13px; }
    .form-group input[type=text], .form-group input[type=number], .form-group select, .form-group textarea {
      width: 100%; padding: 10px 12px; border: 1px solid #d7dee8; border-radius: 6px; font-size: 14px; font-family: inherit; color: #2f3b52; background: #fff;
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #2196f3; box-shadow: 0 0 0 3px rgba(33,150,243,.12); }
    .form-group textarea { min-height: 120px; resize: vertical; }
    .error-text { color: #b3261e; font-size: 12px; margin-top: 5px; }
    .form-actions { display: flex; gap: 10px; margin-top: 22px; }
    .hint { color: #8a97ad; font-size: 12px; margin-top: 5px; }

    /* Pagination */
    .pager { display: flex; justify-content: flex-end; margin-top: 18px; }
    .pager ul { display: flex; list-style: none; margin: 0; padding: 0; gap: 4px; }
    .pager li a, .pager li span {
      display: inline-block; min-width: 34px; text-align: center;
      padding: 7px 10px; border-radius: 6px; background: #fff; border: 1px solid #e2e8f0; color: #3a4a63; font-size: 13px;
    }
    .pager li a:hover { border-color: #2196f3; color: #2196f3; }
    .pager li.active span { background: #2196f3; border-color: #2196f3; color: #fff; }
    .pager li.disabled span { opacity: .5; }

    .empty { padding: 30px; text-align: center; color: #8a97ad; }

    @media (max-width: 900px) {
      .panels { grid-template-columns: 1fr; }
      .admin-sidebar { width: 66px; }
      .admin-brand span, .admin-nav a span { display: none; }
      .admin-nav a { justify-content: center; padding: 14px 0; }
    }
  </style>
  @stack('style')
</head>
<body>
  <div class="admin-shell">
    <aside class="admin-sidebar">
      <div class="admin-brand"><i class="fa fa-film"></i> <span>One<span>Movies</span></span></div>
      <nav class="admin-nav">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.films.index') }}" class="{{ request()->routeIs('admin.films.*') ? 'active' : '' }}">
          <i class="fa fa-video-camera"></i> <span>Films</span>
        </a>
        <a href="{{ route('admin.genres.index') }}" class="{{ request()->routeIs('admin.genres.*') ? 'active' : '' }}">
          <i class="fa fa-tags"></i> <span>Genres</span>
        </a>
        <a href="{{ route('admin.casts.index') }}" class="{{ request()->routeIs('admin.casts.*') ? 'active' : '' }}">
          <i class="fa fa-users"></i> <span>Casts</span>
        </a>
        <a href="{{ route('admin.kritiks.index') }}" class="{{ request()->routeIs('admin.kritiks.*') ? 'active' : '' }}">
          <i class="fa fa-comments"></i> <span>Reviews</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
          <i class="fa fa-user"></i> <span>Users</span>
        </a>
        <a href="{{ route('admin.subscribers.index') }}" class="{{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}">
          <i class="fa fa-envelope"></i> <span>Subscribers</span>
        </a>
      </nav>
    </aside>

    <div class="admin-main">
      <header class="admin-topbar">
        <h1>@yield('heading', 'Dashboard')</h1>
        <div class="admin-user">
          <span><i class="fa fa-user-circle"></i> {{ auth()->user()->name ?? 'Admin' }}</span>
          <a class="link" href="{{ route('home') }}" target="_blank"><i class="fa fa-external-link"></i> Lihat Situs</a>
          <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit"><i class="fa fa-sign-out"></i> Logout</button>
          </form>
        </div>
      </header>

      <main class="admin-content">
        @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
          <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
      </main>
    </div>
  </div>
  @stack('script')
</body>
</html>
