{% extends "/layouts/base.php" %}

{% block title %}{{ title }}{% endblock %}

{% block content %}
<h1>{{ title }}</h1>
<p class="important">
    {{ body }}
</p>
{% endblock %}
