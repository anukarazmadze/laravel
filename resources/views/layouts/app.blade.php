<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Job Listings')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light px-4 py-3">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="btn btn-outline-primary ms-2" href="{{ route('jobs.index') }}">Dashboard</a>
            <div class="collapse navbar-collapse justify-content-end pt-2" id="navbarSupportedContent">
                <div>
                    @guest
                    <a class="btn btn-outline-primary ms-2" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-outline-secondary ms-2" href="{{ route('register') }}">Sign Up</a>
                    @endguest
                    @auth
                    @if (Auth::user()->role === 'company')
                    <a class="btn btn-outline-primary ms-2" href="{{ route('company.jobs') }}">My Jobs</a>
                    <a class="btn btn-success ms-2" href="{{ route('jobs.create') }}">Create Job</a>
                    @endif
                    @if (Auth::user()->role === 'job_seeker')
                    <a class="btn btn-outline-primary ms-2" href="{{ route('user.applied_jobs') }}">My Applied Jobs</a>
                    @endif
                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger ms-2">Logout</button>
                    </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html>
