<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistem Akademik')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        .navbar-brand {
            font-weight: bold;
        }
        footer {
            background: #343a40;
            color: #fff;
            padding: 15px 0;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Monitoring Akademik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a href="{{ route('students.index') }}" class="nav-link">Siswa</a></li>
                    <li class="nav-item"><a href="{{ route('subjects.index') }}" class="nav-link">Mapel</a></li>
                    <li class="nav-item"><a href="{{ route('classrooms.index') }}" class="nav-link">Kelas</a></li>
                    <li class="nav-item"><a href="{{ route('scores.index') }}" class="nav-link">Nilai</a></li>
                    <li class="nav-item"><a href="{{ route('attendances.index') }}" class="nav-link">Absensi</a></li>
                    <li class="nav-item"><a href="{{ route('achievements.index') }}" class="nav-link">Prestasi</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-light btn-sm">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>

    <footer class="text-center">
        <div class="container">
            <small>© {{ date('Y') }} Sistem Monitoring Akademik Siswa</small>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js" integrity="sha512-7Pi/otdlbbCR+LnW+F7PwFcSDJOuUJB3OxtEHbg4vSMvzvJjde4Po1v4BR9Gdc9aXNUNFVUY+SK51wWT8WF0Gg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @stack('scripts')
</body>
</html>
