{% extends 'layout.php' %}

{% block title %}Информация о законе{% endblock %}

{% block body %}
<div class="wrapper">
    <h3>Закон "{{ law.title_law }}"</h3>
    <p>Источник: <a>{{ law.scr_law }}</a></p>
    <p>Описание: </p>
    <p>{{ law.description_law }}</p>
</div>
{% endblock %}
