{% extends "/layouts/base.php" %}

{% block title %}{{ title }}{% endblock %}

{% block content %}
<h1>{{ title }}</h1>

<div class="container">
{% for article in articles %}



            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="media mb-4 mt-0">
                            <div class="media-body  pr-4">
                                <h6 class="media-title">
                                    <a href="/articles/{{ article.id }}" data-abc="true">{{ article.title }}</a>
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
                                </h6>

                                <div class="mt-4">
                                {{ article.content|e }}
                                </div>

                                <div class="row mb-2 mt-4">
                                    <div class="col-8">
                                        <span class="text-muted">Author: {{ article.user.name }}</span>
                                    </div>
                                    <div class="col-4">
                                        <span class="list-inline-item">Comments: {{ article.commentsCount }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-column flex-md-row">
                                <div class="card-img-actions">
                                    <img src="{{ article.imageUrl }}" class="img-fluid img-preview rounded" alt="">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    {% endfor %}

    <nav class="mt-4">
        <ul class="pagination">
            {% if paginator.needShowPrevButton() %}
            <li class="page-item">
                <a class="page-link" href="/articles?page={{ paginator.getPrevPage() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            {% endif %}
            {% for i in paginator.startPage()..paginator.endPage() %}
            <li class="page-item{% if paginator.getCurrentPage() == i %} active{% endif %}"><a class="page-link" href="/articles?page={{ i }}">{{ i }}</a></li>
            {% endfor %}
            {% if paginator.needShowNextButton() %}
            <li class="page-item">
                <a class="page-link" href="/articles?page={{ paginator.getNextPage() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
            {% endif %}
        </ul>
    </nav>

</div>

{% endblock %}
