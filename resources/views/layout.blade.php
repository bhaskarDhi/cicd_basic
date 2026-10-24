<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Task App')</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; background: #f3f5f8; color: #1f2933; }
        header { background: #232f3e; color: #fff; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; }
        header b { color: #ff9900; }
        main { max-width: 680px; margin: 32px auto; padding: 0 16px; }
        .card { background: #fff; border-radius: 10px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        h1 { margin: 0 0 16px; font-size: 22px; }
        input[type=text], input[type=email], input[type=password] { width: 100%; padding: 10px 12px; border: 1px solid #cbd2d9; border-radius: 6px; font-size: 15px; }
        label { display: block; margin: 12px 0 6px; font-weight: 600; font-size: 14px; }
        button { background: #ff9900; color: #fff; border: 0; padding: 10px 16px; border-radius: 6px; font-weight: 600; cursor: pointer; }
        button.link { background: none; color: #fff; padding: 0; font-weight: 400; text-decoration: underline; }
        button.small { padding: 4px 10px; font-size: 13px; background: #e4e7eb; color: #1f2933; }
        button.danger { background: #fde8e8; color: #b42318; }
        .row { display: flex; gap: 8px; }
        .row input { flex: 1; }
        ul { list-style: none; padding: 0; margin: 20px 0 0; }
        li { display: flex; align-items: center; gap: 8px; padding: 10px 0; border-bottom: 1px solid #edf0f3; }
        li span { flex: 1; }
        li.done span { text-decoration: line-through; color: #9aa5b1; }
        .error { color: #b42318; font-size: 14px; margin-top: 6px; }
        .status { background: #e3f6ec; color: #1f8a5b; padding: 8px 12px; border-radius: 6px; margin-bottom: 12px; }
        .muted { color: #7b8794; font-size: 13px; }
        form.inline { display: inline; margin: 0; }
    </style>
</head>
<body>
<header>
    <div><b>Task</b> App</div>
    @auth
        <form class="inline" method="POST" action="{{ route('logout') }}">
            @csrf
            {{ auth()->user()->name }} &middot; <button class="link" type="submit">Log out</button>
        </form>
    @endauth
</header>
<main>
    @yield('content')
</main>
</body>
</html>
