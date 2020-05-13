{% extends 'layout.php' %}

{% block body %}
<div class="wrapper">
    <h3>Поиск законопроекта:</h3>
    <form action="search_laws.php" method="post" class="wrapper-search">
        <div class="wrapper-input">
            <p>Номер законопроекта</p>
            <input type="text" name="number_laws" placeholder="Введите номер законопроекта...">
        </div>
        <div class="wrapper-input">
            <p>Название законопроекта</p>
            <input type="text" name="name_laws" placeholder="Введите название законопроекта...">
        </div>
        <input type="submit" class="btn" value="Найти">
    </form>
</div>
{% endblock %}