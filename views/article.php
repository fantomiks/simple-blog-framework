{% extends "/layouts/base.php" %}

{% block title %}{{ title }}{% endblock %}

{% block content %}
<h1>{{ title }}</h1>

<div class="container">
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

</div>

{% endblock %}
