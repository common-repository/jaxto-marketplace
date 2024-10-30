           
	jQuery(document).ready(function($){
		
		$('#android_color_save').click(function(){
                 
			var colortopheader         = $('#colortopheader').val();
			var colorheader            = $('#colorheader').val();
			var app_button_color       = $('#app_button_color').val();
			var ios_btn_normal         = $('#ios_btn_normal').val();
			var app_font_color         = $('#app_font_color').val();
			var app_button_text_color  = $('#app_button_text_color').val();

			var selected_button_color  = $('#selected_button_color').val();
			var selected_button_text_color  = $('#selected_button_text_color').val();

			var colors_json            = new Object();
			$('#android_overlay').show();

			colors_json.color_theme_statusbar = String(colortopheader);
			colors_json.color_theme  = String(colorheader);
			colors_json.normal_button_color = String(app_button_color);

			colors_json.normal_button_text_color = String(app_button_text_color)  ;
			colors_json.color_pager_title_strip = String("#ffffff") ;
			colors_json.color_header_text = String(colorheader) ;
			colors_json.selected_button_color =  String(selected_button_color);
			colors_json.selected_button_text_color =  String(selected_button_text_color);
			colors_json.desable_button_color =  String("#D3D3D3");
			colors_json.color_actionbar_text= String(app_font_color);
			colors_json.color_theme_dark=String(colorheader);

			$.ajax({
				data:{"action": "android_app_color_update","colors_json":colors_json},
				method: "POST",
				url: "/app/app-settings-action",
			}).done(function(response){
			$('#android_overlay').hide();
				var respo_obj = $.parseJSON(response);
				if(respo_obj.result == "success"){
				$('#android_save_feedback').html('Settings saved successfully!');
				$('#android_save_feedback').fadeIn();
				setTimeout(function(){
				$('#android_save_feedback').fadeOut();
				}, 5000);
				}else{
				alert('Error occured in saving the settings! Please re-try. If error persist please contact support team.');
				}

			});
         
         
		});
      
		function set_color(id_source, id_target, id_frame){
         
			$('#'+id_source).minicolors({
				control: $(this).attr('data-control') || 'brightness',
				defaultValue: $(this).attr('data-defaultValue') || '',
				format: $(this).attr('data-format') || 'hex',
				keywords: $(this).attr('data-keywords') || '',
				inline: $(this).attr('data-inline') === 'true',
				letterCase: $(this).attr('data-letterCase') || 'lowercase',
				opacity: $(this).attr('data-opacity'),
				position: $(this).attr('data-position') || 'bottom left',
				swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
				change: function(hex, opacity) {
					var log;
					try {
						log = hex ? hex : 'transparent';
						if( opacity ) log += ', ' + opacity;
						console.log(log);
						
						if(id_source=='selected_button_text_color')
							$('#myframe #mybutton').hover(function(){ $(this).find('b').css('color',hex); }, function(){ $(this).find('b').css('color',$('#app_button_text_color').val()); });
						else
							$('#'+id_frame+' #'+id_target).css('color',hex);
					} 
					catch(e) {}
				},
				theme: 'default'
			});
		}
		function set_bg_color(id_source, id_target, id_frame){

			$('#'+id_source).minicolors({
				control: $(this).attr('data-control') || 'brightness',
				defaultValue: $(this).attr('data-defaultValue') || '',
				format: $(this).attr('data-format') || 'hex',
				keywords: $(this).attr('data-keywords') || '',
				inline: $(this).attr('data-inline') === 'true',
				letterCase: $(this).attr('data-letterCase') || 'lowercase',
				opacity: $(this).attr('data-opacity'),
				position: $(this).attr('data-position') || 'bottom left',
				swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
				change: function(hex, opacity) {
					var log;
					try {
						log = hex ? hex : 'transparent';
						if( opacity ) log += ', ' + opacity;
						console.log(log);

						if(id_source == "selected_button_color")
							$('#myframe #mybutton').hover(function(){ $(this).css('background',hex);$(this).css('border-color',$('#app_button_color').val());  }, function(){ $(this).css('background',$('#app_button_color').val()); });
						else
							$('#'+id_frame+' #'+id_target).css('background',hex);
					} 
					catch(e) {}
				},
				theme: 'default'
			});
		}
		
		set_color('app_font_color','app_font_color','myframe');
		set_color('app_button_text_color','buytext','myframe');
		set_color('selected_button_text_color','buytext','myframe');
		set_bg_color('app_button_color','mybutton','myframe');
		set_bg_color('colortopheader','colortopheader','myframe');
		set_bg_color('colorheader','colorheader','myframe');
		set_bg_color('selected_button_color','mybutton','myframe');
		      
		setTimeout(function(){
		
			$('#myframe #colortopheader').css('background',$('#colortopheader').val());
			$('#myframe #app_font_color').css('color',$('#app_font_color').val());
			$('#myframe #colorheader').css('background',$('#colorheader').val());
			$('#myframe #headertext').css('color',$('#headertext').val());
			$('#myframe #mybutton').css('background',$('#app_button_color').val());
			$('#myframe #buytext').css('color',$('#app_button_text_color').val());
			
			// document.getElementById('myframe').contentWindow.document.getElementById('app_font_color').style.color = $('#app_font_color').val();
			// document.getElementById('myframe').contentWindow.document.getElementById('colortopheader').style.backgroundColor = $('#colortopheader').val();;
			// document.getElementById('myframe').contentWindow.document.getElementById('colorheader').style.backgroundColor = $('#colorheader').val();;
			//document.getElementById('myframe').contentWindow.document.getElementById('headertext').style.color = $('#app_font_color').val();;
			// document.getElementById('myframe').contentWindow.document.getElementById('mybutton').style.backgroundColor = $('#app_button_color').val();;
			// document.getElementById('myframe').contentWindow.document.getElementById('buytext').style.color = $('#app_button_text_color').val();;

			$('#myframe #mybutton').hover(function()
			{ 
				$(this).find('b').css('color',$('#selected_button_text_color').val());
			},function()
			{ 
				$(this).find('b').css('color',$('#app_button_text_color').val()); 
			});
			
			$('#myframe #mybutton').hover(function()
			{ 
				$(this).css('background',$('#selected_button_color').val()); 
				$(this).css('border-color',$('#app_button_color').val()); 
			},function()
			{ 
				$(this).css('background',$('#app_button_color').val()); 
			});


		},1500);
      
   });
