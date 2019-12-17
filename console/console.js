$(function(){
	if(!$_CONSOLE){
		var $_CONSOLE = {
			_console: $('#console'),
			_close: '',
			_visible: '',
			// _width: '',
			// _count: '',
			_isAlt: false,
			_resizable: true,
			toggleConsole: function($val = 'hide'){
				$.post('/index.php', {'console-hide':$val});
				if($val == 'hide'){
					this._console.addClass('hide');
					this._visible = 'hide';
				}else{
					this._console.removeClass('hide');
					this._visible = 'show';
				}
			},
			convert_box: function(){ // pre_to_textarea
				$(document).on('click', '#console > .console > .line .title', function(){
					if($(this).siblings('textarea').length !== 0){
						$(this).after("<pre>"+$(this).siblings('textarea').text()+"</pre>");
						$(this).siblings('textarea').remove();
					}
					if($(this).siblings('pre').length !== 0){
						$(this).after("<textarea style='height:"+$(this).siblings('pre').outerHeight()+"px'>"+$(this).siblings('pre').text()+"</textarea>");
						$(this).siblings('pre').remove();
					}
				});
			},
			init: function(){
				// this._count = parseInt(this._console.attr('count'));
				// this._width = parseInt(this._console.css('width'));
				this._visible = this._console.hasClass('hide') ? 'hide' : 'show';
				this._close = this._console.children('.close');
				this._close.click(function(){
					$_CONSOLE.toggleConsole();
				});
				
				this.convert_box();
				$(document).keyup(function(e){
					if(e.which == 18) $_CONSOLE._isAlt = false;
				}).keydown(function(e){
					if(e.which == 18) $_CONSOLE._isAlt = true;
					if((e.which == 67 && $_CONSOLE._isAlt == true) || (e.which == 86 && $_CONSOLE._isAlt == true)){
						if($_CONSOLE._visible == 'hide'){
							$_CONSOLE.toggleConsole('show');
						}else{
							$_CONSOLE.toggleConsole();
						}
						return false;
					}
				});

				if(this._resizable){
					this._console.resizable({
						maxWidth: 750,
						minWidth: 300,
						grid: 50,
						// ghost: true
						stop:function(event, ui){
							$.post('/index.php', {'console-width':ui.size['width']+'px'});
						}
					});
				}
			}
		};
		$_CONSOLE.init();
	}
})