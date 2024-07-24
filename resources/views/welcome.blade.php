<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light px-4 py-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Jobs</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                <div class="d-flex">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
                <div>
                    @if (Auth::check())
                        <a class="btn btn-outline-primary ms-2" href="{{ route('logout') }}">Logout</a>
                    @else
                        <a class="btn btn-outline-primary ms-2" href="{{ route('login') }}">Login</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col d-flex justify-content-between">
                <div>
                    <select class="form-select me-2" aria-label="Sort by">
                        <option selected>Sort by</option>
                        <option value="1">Date</option>
                        <option value="2">Salary</option>
                    </select>
                    <select class="form-select" aria-label="Filter by">
                        <option selected>Filter by</option>
                        <option value="1">Location</option>
                        <option value="2">Type</option>
                    </select>
                </div>
                <a class="btn btn-primary" href="{{ route('jobs.create') }}">Post a Job</a>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Job Title</th>
                    <th scope="col">Provided By</th>
                    <th scope="col">Published</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jobs as $job)
                    <tr>
                        <td>{{ $job->title }}</td>
                        <td>{{ $job->user->name }}</td>
                        <td>{{ $job->created_at->format('d-m-Y') }}</td>
                        <td>{{ $job->expires_at->format('d-m-Y') }}</td>
                        <td>
                            <a class="btn btn-info btn-sm" href="{{ route('jobs.show', $job) }}">View</a>
                            @auth
                                @if (Auth::user()->role === 'company' && Auth::user()->id === $job->user_id)
                                    <a class="btn btn-warning btn-sm" href="{{ route('jobs.edit', $job) }}">Edit</a>
                                    <form action="{{ route('jobs.destroy', $job) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                    </form>
                                @endif
                            @endauth
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
