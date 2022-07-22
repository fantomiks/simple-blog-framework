{% extends "/layouts/base.php" %}

{% block title %}{{ title }}{% endblock %}

{% block content %}




<section class="mbr-section">

    <div class="container">
        <div class="media-container-row">
            <div class="title col-12 col-md-8">
                <h2 class="align-center pb-3 mbr-fonts-style display-2">
                    {{ article.title }}
                </h2>
                <div class="meta">
                    <div class="post-author">
                        By <a href="#">{{ article.user.name }}</a> /
                    </div>
                    <div class="post-date">
                        <i class="fa fa-clock-o"></i>{{ article.createdAt|date("l jS F Y")}} /
                    </div>
                    <div class="comments">
                        <i class="fa fa-solid fa-comment"></i> {{ article.commentsCount }}
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8 mt-4 mb-4 align-center">
                <img src="{{ article.imageUrl }}" class="rounded" alt="">
            </div>

            <div class="mb-4 pb-4">
                {{ article.content }}
            </div>

        </div>
    </div>
</section>

{% endblock %}
