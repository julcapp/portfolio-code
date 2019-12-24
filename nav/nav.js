$.fn.toggleAttr = function(attr, value1 = false, value2 = false){
	return this.each(function(){
		var self = $(this);
		if(value1 == false && value2 == false){
			if(self.hasAttr(attr))
				self.removeAttr(attr);
			else
				self.attr(attr, null);
		}else{
			if (self.attr(attr) == value1)
				self.attr(attr, value2);
			else
				self.attr(attr, value1);
		}
	});
};

$(function(){

	var $_nav = {
		_menu: '',
		_window: '',
		_html: '',
		_css: '',
		_css_link: '',
		_mobile_css: '',
		_reload_css: false,
		_animate: 300,
		init: function(){
			this._window = $(window);
			this._html = $('html');
			this._menu = $('custom-menu');
			this._menu = $('custom-menu');

			this.load_css();
			if(this._reload_css) 
				setInterval(this.reload_css, 1000);

			// this.resize_window();
			this.toggleMenu();
			this.subMenu();
		},
		load_css: function(){
			this._css = this._html.find('#navCSS').remove();
			this._css_link = this._css.attr('href');
			this._html.find('head').append(this._css);
		},
		reload_css: function(){
			$_nav._css.attr({'href':$_nav._css_link+'?version='+new Date().getTime()});
		},
		check_mobile_css: function(){
			if(this._html.find('#navCSS_M') !== undefined) this._html.find('head').append('<style id="navCSS_M"></style>');
			this._mobile_css = $('#navCSS_M');
		},
		mobile_css: function(){
			$width = this._menu.width();
			this._mobile_css.text('[open-nav] > body{transform:translateX('+$width+'px);}custom-menu{transform:translateX(-'+$width+'px);}');
		},
		resize_window: function(){
			if(this._window.width() <= 400){
				this.check_mobile_css();
				this.mobile_css();
				this._window.resize(function(){
					$_nav.mobile_css();
				});
			}
		},
		toggleMenu: function(){
			this._html.find('#open-menu, #close-menu').click(function(){
				if($_nav._html.attr('open-nav') == undefined){
					$_nav._html.attr({'open-nav':1});
					if($(window).width() > 500)
						$_nav._menu.css({'top':$_nav._window.scrollTop()});
					return false;
				}else{
					$_nav._html.removeAttr('open-nav');
					$_nav._menu.find('sub-menu[open] > div').hide($_nav._animate).parent().removeAttr('open');
				}
				return false;
			});
		},
		subMenu: function(){
			this._menu.find('sub-menu > a').click(function(){
				if($(this).parent().attr('open') !== undefined){
					$_nav._menu.find('sub-menu[open]').children('div').hide($_nav._animate).parent().removeAttr('open');
				}else{
					if($_nav._menu.find('sub-menu[open]').length != 0){
						$_nav._menu.find('sub-menu[open]').children('div').hide($_nav._animate).parent().removeAttr('open');
						$_This = $(this);
						setTimeout(function(){
							$_This.parent().attr({'open':''}).children('div').show($_nav._animate);
						}, $_nav._animate - 100);
					}else
						$(this).parent().attr({'open':''}).children('div').show($_nav._animate);
				}

				return false;
			});
		}
	};

	$_nav.init();

	$('html > body > close-menu').click(function(){
		$('html').toggleAttr('open-nav');
	});
});