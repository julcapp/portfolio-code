$(function(){
	if(!$_logotypeColorSubmol){
		var $_logotypeColorSubmol = {
			_start: false,
			_logotype: '',
			_logotype_clone: '',
			_logotype_sumbol: '',
			rand: function(min, max){
				return Math.floor(Math.random() * (max - min + 1)) + min;
			},
			randColor: function($rgba = 0){
				return ($rgba) ? 'rgb('+this.rand(0,255)+','+this.rand(0,255)+','+this.rand(0,255)+','+(this.rand(0,100) / 100)+')' : 'rgb('+this.rand(0,255)+','+this.rand(0,255)+','+this.rand(0,255)+')';
			},
			genSumbol: function(){
				if(this._logotype.find('sumbol').length == 0){
					this._logotype.find('i, div').each(function(){
						$text = $(this).text().split('');
						$new_text = '';
						$text.forEach(function(item, i, arr){
							$new_text += '<sumbol>'+item+'</sumbol>';
						});
						$(this).html($new_text)
					});
					this._logotype_sumbol = this._logotype.clone();
				}
			},
			defaultLogo: function(){
				this._logotype.html(this._logotype_clone.html());
			},
			setColor: function($sumnol){
				$sumnol.css({'color':this.randColor()});
			},
			animate: function($this = this){
				if(this._start){
				this._logotype.find('sumbol').each(function(){
					$this.setColor($(this));
				});
				}
			},
			init: function($delay = 100, $logotype = 'header > .wrap > .logotype', $this = this){
				this._logotype = $($logotype);
				this.genSumbol();
				this._logotype_clone = $($logotype).clone();

				setInterval(function(){
					$this.animate();
				}, $delay);

				this._logotype.mouseenter(function(){
					$this.genSumbol();
					$this._start = true;
				}).mouseleave(function(){
					$this._start = false;
					$this.defaultLogo();
				});
			}
		};

		$_logotypeColorSubmol.init(110);
	}
});