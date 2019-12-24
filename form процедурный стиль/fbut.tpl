<!-- <a href="#" fbut="_main2" fbut_t="Заголовок услуги">Открыть форму</a> -->

<fbut-form view='hide' style="display:none;">
	<link rel="stylesheet" type="text/css" href="{THEME}/fbut/fbut-form.css">
	<script type="text/javascript" src="{THEME}/fbut/jquery.mask.min.js"></script>
	<script type="text/javascript" src="{THEME}/fbut/fbut-form.js"></script>
	<fbut-close></fbut-close>
	<fbut-load><b></b><b></b><b></b><b></b></fbut-load>
	
	<fbut-wrap view="hide" id='_callback'>
		<fbut-close></fbut-close>
		<fbut-title>Оставьте заявку<br> и наш менеджер свяжется<br>с Вами в кратчайшее время</fbut-title>
		<form method="POST" action='/mail/index.php' accept-charset='UTF-8' autocomplete="off" enctype="multipart/form-data" ajax>
			<input type="hidden" name="Заголовок" value="Заголовок формы">
			<label>
				<i class="far fa-user"></i>
				<input type="text" name="Имя" placeholder="Ваше Имя" required>
			</label>
			<label>
				<i class="fa fa-mobile-alt"></i><input type="text" name="Телефон" placeholder="Ваш телефон" required>
			</label>
			<button><span><i class="fab fa-telegram-plane"></i> Отправить заявку</span></button>
			<fbut-agree>
				<label>
					<input type="checkbox" name="Персональные_данные" value="Я даю согласие на обработку персональных данных" required checked>
					<span>
						Я даю согласие на обработку моих персональных данных.
					</span>
				</label>
			</fbut-agree>
		</form>
	</fbut-wrap>

	<fbut-wrap view="hide" id='_main'>
		<fbut-close></fbut-close>
		<fbut-title>Оставьте заявку<br> и наш менеджер свяжется<br>с Вами в кратчайшее время</fbut-title>
		<form method="POST" action='/mail/index.php' accept-charset='UTF-8' autocomplete="off" enctype="multipart/form-data" ajax>
			<input type="hidden" name="Заголовок" value="Заголовок формы">
			<label>
				<i class="far fa-user"></i>
				<input type="text" name="Имя" placeholder="Ваше Имя" required>
			</label>
			<label>
				<i class="fa fa-mobile-alt"></i><input type="text" name="Телефон" placeholder="Ваш телефон" required>
			</label>
			<button><span><i class="fab fa-telegram-plane"></i> Отправить заявку</span></button>
			<fbut-agree>
				<label>
					<input type="checkbox" name="Персональные_данные" value="Я даю согласие на обработку персональных данных" required checked>
					<span>
						Я даю согласие на обработку моих персональных данных.
					</span>
				</label>
			</fbut-agree>
		</form>
	</fbut-wrap>
</fbut-form>
<fbut-info><div></div></fbut-info>