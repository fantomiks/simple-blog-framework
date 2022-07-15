{% extends "/layouts/base.php" %}

{% block title %}{{ title }}{% endblock %}

{% block content %}
<h1>{{ title }}</h1>

<div class="container">
{% for article in articles %}
    <div class="col-md-12">
        <div class="row pt-2">
            <span class="date">{{ article.createdAt }}</span> - <span class="title">{{ article.title }}</span>
        </div>
        <div class="row p-2">
            <div class="col-md-8">{{ article.content|e }}</div>
            <div class="col-md-4">IMG</div>
        </div>
        <div class="row pb-2">
            <div class="col-md-6">{{ article.user.name }}</div>
            <div class="col-md-6">{{ article.commentsCount }}</div>
        </div>
    </div>
{% endfor %}

    <nav class="mt-4">
        <ul class="pagination">
            {% if page > 10 %}
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            {% endif %}
            {% for i in fromPage..toPage %}
            <li class="page-item{% if page == i %} active{% endif %}"><a class="page-link" href="/articles?page={{i}}">{{ i }}</a></li>
            {% endfor %}
            {% if maxPage > 10 %}
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
            {% endif %}
        </ul>
    </nav>

</div>

{% endblock %}
