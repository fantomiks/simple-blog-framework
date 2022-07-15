<!doctype html>
<html lang="en" class="h-100">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>{% block title %}{% endblock %} - My Webpage</title>
</head>
<body class="d-flex flex-column h-100">

<main class="flex-shrink-0">
    <header class="container py-3 mb-4 border-bottom">
        <div class="row">
            <div class="col-md-2">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 text-white text-decoration-none">
                    <div class="p-3 bg-primary rounded float-start"> LOGO </div>
                </a>
            </div>
            <div class="col-md-8">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a href="/" class="nav-link">Welcome</a></li>
                    <li class="nav-item"><a href="/articles" class="nav-link">Articles</a></li>
                </ul>
            </div>
            <div class="col-md-2 pull-right">
                <ul class="nav">
                    <li class="nav-item"><a href="/login" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="/logout" class="nav-link">Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container mt-4">
        {% block content %}{% endblock %}
    </div>
</main>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <span class="text-muted">Place sticky footer content here.</span>
    </div>
</footer>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
