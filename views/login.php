{% extends "/layouts/base.php" %}

{% block title %}{{ title }}{% endblock %}

{% block content %}
<h1>{{ title }}</h1>

<div class="container">

    {% if error %}

    <div class="container">
        <div class="alert alert-danger" role="alert" data-mdb-color="danger">
            {{ error }}
        </div>
    </div>

    {% endif %}

    <section class="w-100 p-2 d-flex justify-content-center pb-2">

        <form action="/login" method="post">
            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="email">Email address</label>
                <input type="email" id="email" name="email" class="form-control" />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" />
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

        </form>
    </section>

</div>

{% endblock %}
