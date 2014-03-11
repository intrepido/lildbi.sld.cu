$(document).ready(function() {
	
			
			$('#loading').html('<img src="/lildbi/img/loader.gif">');
			$.post('/lildbi/bases/getTotalDocsBases').done(function(data){
				$('#loading').fadeOut(100);
				var result = $.parseJSON(data);
				var chart;
				var basesName = new Array();	
				var basesTotal = new Array();
								
				$.each(result, function(key, base) { 
					basesName.unshift(base['name']);
					basesTotal.unshift(base['total']);
				});
				
				/*alert(basesName[0]);
				
				var basesNameTotal = new Array( new Array(basesName.length));
				
				$.each(result, function(key, base) { 
					basesTotal[key].unshift(base['total']);
				});*/
				
				chart = new Highcharts.Chart({
					chart : {
						renderTo : 'report',
						type : 'column',
						backgroundColor : '#FAFAFA',
					},
					title : {
						text : 'Total de Documentos en Bases'
					},
					subtitle : {
						text : 'Fuente: INFOMED'
					},
					xAxis: {
						title: {
			                text: 'Bases'
			            },
		                categories: basesName
		            },
					yAxis : {
						min : 0,
						title : {
							text : 'Total de Documentos'
						}
					},
					legend : {
						layout : 'vertical',
						backgroundColor : '#FFFFFF',
						align : 'left',
						verticalAlign : 'top',
						x : 100,
						y : 70,
						floating : true,
						shadow : true
					},
					tooltip : {
						formatter : function() {
							return '' + this.x + ': ' + this.y ;
						}
					},
					plotOptions : {
						column : {
							pointPadding : 0.2,
							borderWidth : 0,
							colorByPoint: true
						}	
					},					
					series: [{						
			            data: basesTotal,
			            showInLegend: false
			        }]					
				});
			});
			
		});
