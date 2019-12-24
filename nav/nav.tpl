<link rel="stylesheet" id='navCSS' type="text/css" href="{THEME}/css/nav.css?ver={microtime}">
<script type="text/javascript" src='{THEME}/js/nav.js?ver={microtime}'></script>
<custom-menu>
	<close-menu id='close-menu'></close-menu>
	<nav>
		<span style="display:none;">Назад</span>
		{login}
		<a href="/"><i class="fad fa-grip-lines-vertical"></i> Главная</a>
		[not-admin]<a href="/portfolio/"><i class="fad fa-brackets-curly"></i> Портфолио</a>[/not-admin]
		[admin]<sub-menu>
			<a href="/portfolio/"><i class="fad fa-brackets-curly"></i> Портфолио</a>
			<div style="display:none;">
				<a href="/portfolio/">Перейти</a>
				<a href="/portfolio/add">Добавить</a>
				<a href="/portfolio/edit">Редактировать</a>
			</div>
		</sub-menu>[/admin]
		<a href="/feedback/"><i class="far fa-comment-dots"></i> Обратная связь</a>
		[admin]<sub-menu>
			<a href="#"><i class="fas fa-hammer-war"></i> Добродетель админа</a>
			<div style="display:none;">
				<a href="/mishkabar/parse/"><i class="fal fa-paw"></i> Запустить парсинг</a>
				<a href="/fontawesome/"><i class="fas fa-font"></i> FontAwesome</a>
				<a href="/l/"><i class="fal fa-link"></i> Короткие ссылки</a>
				<!-- <a href="#">Пункт под-меню 8</a> -->
			</div>
		</sub-menu>[/admin]
		<a href="/mishkabar/"><i class="fal fa-paw"></i> Мишка на десперадо</a>
		<a href="/change.log"><i class="fal fa-code"></i> Дневник разработчика</a>
	</nav>
</custom-menu>
<a id='open-menu'><i class='fal fa-bars'></i><span>Открыть&nbsp;меню</span></a>
<close-menu></close-menu>