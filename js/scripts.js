//--------------------------
// Ready                   |
//--------------------------

$(document).ready(function() {

	$(document).on('click', 'a[href="#"]', function(e){ e.preventDefault(); });

	// WOW Animate
	new WOW().init();

	// Rocket Flight Point
	var roadmapPoint = 'to-point-11'; // 01 - 14

	// Active tab if link with hash
	if (window.location.hash == '#airDrop') {
			$('.main__tab-links ul li a').removeClass('active');
			$('.main__tab').removeClass('active');

			$('.main__tab-links ul li a[href="#airDrop"]').addClass('active');
			$('#airDrop').addClass('active');
	} else if (window.location.hash == '#roadmap') {
			var	top = $('#roadmap').offset().top;
			$('html, body').animate({scrollTop: top + 1}, 100);
	}

	// Table col hover
	$(".a-table").delegate('td','mouseover mouseleave', function(e) {
		if (e.type == 'mouseover') {
			$(this).parent().addClass("hover");
			$("colgroup").eq($(this).index()).addClass("hover");
		}
		else {
			$(this).parent().removeClass("hover");
			$("colgroup").eq($(this).index()).removeClass("hover");
		}
	});

	//Fixed elements
	var urlLastSegment = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
	
	$(document).scroll(function () {

		var bodyScroll = $(this).scrollTop();

		if (bodyScroll > 0) {
			$('#header').addClass('header-fixed');
		} else {
			$('#header').removeClass('header-fixed');
		}

		if (window.location.pathname == '/' || window.location.pathname == '') {

			var	advPos           = $('#advantages').offset().top,
					tablePos         = $('.a-table').offset().top,
					tradingPos       = $('#trading').offset().top,
					tradingPosOffset = tradingPos - 137,
					roadmapPos       = $('#roadmap').offset().top;

			if ($(window).width() > 999) {

				if (bodyScroll >= advPos && bodyScroll < tradingPos) {
					$('#header').hide();
				} else $('#header').show();
		
				if (bodyScroll >= tablePos && bodyScroll < tradingPos) {
					$('.a-table-fixed').show();
				} else $('.a-table-fixed').hide();

			} else {

				if (bodyScroll >= advPos && bodyScroll < tradingPosOffset) {
					$('#header').hide();
				} else $('#header').show();
		
				if (bodyScroll >= tablePos && bodyScroll < tradingPosOffset) {
					$('.a-table-fixed').show();
				} else $('.a-table-fixed').hide();

			}

			// Rocket Fly
			if (bodyScroll >= roadmapPos - $(window).height() / 2) {
				$('.rocket').addClass(roadmapPoint);
			}

		}

	});

	if (typeof $().stick_in_parent !== "undefined") {

		$('.a-table-fixed').stick_in_parent({
			parent: '.advantages__table-inner'
		});

	}



	// Popup-modal
	var scrollWidth = window.innerWidth - document.body.clientWidth;

	$('#buy_coin_header, #buy_coin_footer, #coin_hover_btn').on('click', function(e) {
		e.preventDefault();

		$('.popup-modal').fadeIn('fast');

		$('body').css({
			'overflow' : 'hidden',
			'margin-right' : scrollWidth + 'px'
		});
		$('.header-fixed').css('right', scrollWidth + 'px');

		return false;
	});

	$('.p-modal__close').on('click', function() {
		$('.popup-modal').hide();
		$('body').attr('style', '');
		$('.header-fixed').css('right', 0);
	});

	$(document).on('click touchstart', function(e) {
		var container = $('.p-modal');
		if (container.length && !$(e.target).closest(container).length) {
			$('.popup-modal').hide();
			$('body').attr('style', '');
			$('.header-fixed').css('right', 0);
		}
	});

	$(document).keyup(function(e) {
		if (e.keyCode == 27) {
			$('.popup-modal').hide();
			$('body').attr('style', '');
			$('.header-fixed').css('right', 0);
		}
	});



	// Custom select
	$('.select').each(function(){
		var self = $(this);
		self.find('.select_hidden').val(self.find('.select_list li:first').attr('data-value'));
	});
	
	$('.select_in').on('click', function() {
		var self = $(this),
			select = self.closest('.select'),
			option_list = select.find('.select_list');
	
		if (option_list.is(':visible')){
			option_list.slideUp(200);
			select.removeClass('is-opened');
			self.find('.select_arrow').removeClass('is-active');
		} else {
			if ($('.select .select_list:visible').length){
				$('.select .select_list:visible').hide();
				$('.select .select_arrow').removeClass('is-active');
			}
			option_list.slideDown(200);
			select.addClass('is-opened');
			self.find('.arrow').addClass('is-active');
		}
	});
	
	$('.select_list li').on('click', function() {
		var self =  $(this),
				title = self.closest('.select').find('.select_in .select_title'),
				option = self.html();
	
		title.html(option);
		self.closest('.select').find('input[type=hidden]').val(self.attr('data-value'));
		self.closest('.select_list').find('li').removeClass('is-active');
		self.addClass('is-active');
		self.closest('.select_list').slideUp(200);
		self.closest('.select').removeClass('is-opened');
		self.closest('.select').find('.select_arrow').removeClass('is-active');
	});
	
	$(document).on('click', function(e) {
		if ($('.select .select_list:visible').length && !$(e.target).closest('.select').length){
			$('.select').removeClass('is-opened');
			$('.select .select_list').slideUp(200);
			$('.select .select_arrow').removeClass('is-active');
		}
	});
	
	$(document).keyup(function(e) {
		if (e.keyCode == 27) {
			$('.select').removeClass('is-opened');
			$('.select .select_list').slideUp(200);

			$('.header__nav').slideUp();
			$('.hamburger').removeClass('is-active');

			$('.ps-circuit__item').removeClass('active');
		}
	});



	// Hamburger
	$('.hamburger').on('click', function() {
		$(this).toggleClass('is-active');
		$('.header__nav').slideToggle();

		return false;
	});

	$(document).on('click', function(e) {
		var container = $(".header__nav");
		if (container.length && !$(e.target).closest(container).length) {
			$('.header__nav').slideUp();
			$('.hamburger').removeClass('is-active');
		}
	});



	// Smooth scrolling

		$('.header__nav ul li a[href^= "#"]').on('click', function (e) {
			e.preventDefault();

			var _id  = $(this).attr('href'),
					headerHeight = $('.header').outerHeight(),
					decoded_id = decodeURIComponent(_id);

			if (window.location.pathname !== '/' && window.location.pathname !== '') {
				window.location = '/' + decoded_id;
			} else {

				var	top = $(_id).offset().top - headerHeight;

				$('html, body').animate({scrollTop: top}, 1000);

				$('.header__nav').slideUp();
				$('.hamburger').removeClass('is-active');
			}
		});


		$('.footer__nav li a[href^= "#"]').on('click', function(e) {
			e.preventDefault();

			var _id  = $(this).attr('href'),
					decoded_id = decodeURIComponent(_id);

			if (window.location.pathname !== '/' && window.location.pathname !== '') {
				window.location = '/' + decoded_id;
			} else {

				var top = $(_id).offset().top;

				if (_id == '#airDrop') {
					$('html, body').animate({scrollTop: top}, 1000);
					
					$('.main__tab-links ul li a').removeClass('active');
					$('.main__tab').removeClass('active');

					$('.main__tab-links ul li a[href="#airDrop"]').addClass('active');
					$(_id).addClass('active');
					
				} else $('html, body').animate({scrollTop: top}, 1000);

			}
		});


	//Random Background
	var bgArr = $('.main__bg video').toArray(),
			rand  = Math.round(Math.random() * bgArr.length);

			if(rand == bgArr.length) rand -= 1;

	$(bgArr[rand]).addClass('visible');	




	
	if (window.location.pathname == '/' || window.location.pathname == '') {

		// Pre-sale form
		coinChange({
			arrPrev: '.prev-coin',
			arrNext: '.next-coin',
			input: '.input-coin'
		});


		// Main Tabs
		tabThis({
			tabsLinks: '.main__tab-links ul li a',
			tabsConts: '.main__tab'
		});

		// Token info Tabs
		tabThis({
			tabsLinks: '.tokeninfo__tab-links ul li a',
			tabsConts: '.tokeninfo__tab'
		});


		// Token info charts
		// Allocation of shares
		tokenInfoChart({
			chartId: 'sharesChart',
			chartIdSelector: '#sharesChart',
			legendId: 'sharesChartLegend',
			legendItems: '#sharesChartLegend ul li',
			data: [10, 10, 80],
			bgColor: ['#46a6ff', '#57c2ff', '#5447eb']
		});

		// Use of funds
		tokenInfoChart({
			chartId: 'useOfFundsChart',
			chartIdSelector: '#useOfFundsChart',
			legendId: 'useOfFundsChartLegend',
			legendItems: '#useOfFundsChartLegend ul li',
			data: [90, 10],
			bgColor: ['#46a6ff', '#57c2ff']
		});

	}


//FORM AJAX SUBMIT

	$('form.white-label__form.wl-form').on('submit', function(){
		var form = $(this);
		var error = false;
		form.find('input').each(function(){
			if($(this).prop('required') && $(this).val().trim() == ''){
				$(this).parent().addClass('error');				
				error = true;
			}else if($(this).prop('required') && $(this).val().trim() != '') {
				$(this).parent().removeClass('error');	
			}
		});
		if(error == true){
			return false;
		}
		var data = $(this).serializeArray();
		data.push({name: "url", value: location.href});
		data.push({name: "AJAX", value: "Y"});
		$.ajax({
			type: 'POST',
			url: '/whitelabel/ajax.php',
			data: $.param(data),
			dataType: 'json',
			success: function(json) {			
				if(json.status == 'success'){
					form[0].reset();
					grecaptcha.reset();
					form.find('p.messege').text('Your email has been sent.');
				}else {
					form.find('p.messege').text(json.messege);
				}
				
			},
			error:  function(xhr, str){
				form.find('p.messege').text('An error has occurred.');
				console.log('An error has occurred: ' + xhr.responseCode);
			}
				});
		return false;
	});


}); // End Ready









//--------------------------
// Resize trigger          |
//--------------------------


$(window).resize(function() {

	if (window.location.pathname == '/' || window.location.pathname == '') {

		if($(this).width() <= 999) {

			if (typeof $().mCustomScrollbar !== "undefined") {
				$('.advantages__table').mCustomScrollbar({
					axis: "x",
					autoDraggerLength: false,
					mouseWheel:{ enable: false },
					advanced:{ autoExpandHorizontalScroll:true },
					callbacks: {
						whileScrolling:function() {
							var l = this.mcs.left + 20;
							$('.a-table-fixed').css({ left: l });
						}
					}
				});
			}

			$('.ps-circuit__item').removeClass('item-hover');

			if (typeof $().slick !== "undefined" && !$('.pre-sale__slider').hasClass('slick-initialized')) {
				$('.pre-sale__slider').slick({
					mobileFirst: true,
					dots: true,
					adaptiveHeight: true,
					responsive: [
						{
							breakpoint: 999,
							settings: "unslick"
						}
					]
				});
			}

			$('.download__item').removeClass('wow flipInY');

		} else {

			if (typeof $().mCustomScrollbar !== "undefined")
				$('.advantages__table').mCustomScrollbar("destroy");

			$('.a-table-fixed').css({ left: 'auto' });

			$('.ps-circuit__item').addClass('item-hover');

			$('.download__item').addClass('wow flipInY');
		}

	}

}).trigger("resize");






//--------------------------
// Functions               |
//--------------------------


// Coin Change
function coinChange(e) {
	var arrPrev         = $(e.arrPrev),
			arrNext         = $(e.arrNext),
			input           = $(e.input),
			selectHidden    = input.find('.select_hidden'),
			selectListItems = input.find('.select-coin_list li'),
			title = input.find('.select-coin_in .select-coin_title'),
			currentVal;

	arrPrev.on('click', coinPrev);
	arrNext.on('click', coinNext);

	function coinPrev() {
		currentVal = selectHidden.val();

		if(currentVal > 1) {
			$(selectListItems[currentVal-1]).removeClass('is-active');
			currentVal -= 1;
			selectHidden.val(currentVal);
			$(selectListItems[currentVal-1]).addClass('is-active');
			$(selectListItems[currentVal-1]).html();
			title.html($(selectListItems[currentVal-1]).html());
		}
	}

	function coinNext() {
		currentVal = selectHidden.val();

		if(currentVal < selectListItems.length) {
			$(selectListItems[currentVal-1]).removeClass('is-active');
			currentVal = +currentVal + 1;
			selectHidden.val(currentVal);
			$(selectListItems[currentVal-1]).addClass('is-active');
			$(selectListItems[currentVal-1]).html();
			title.html($(selectListItems[currentVal-1]).html());
		}
	}
}



// Universal Tabs
function tabThis(t){
	$(t.tabsLinks).on('click', function(e){
		e.preventDefault();
		e.stopPropagation();

		var _id = $(this).attr('href');

		//if(_id == '#airDrop') mainChartInit();
		//if(_id == '#shares') tokenInfoChart({ chartId: 'sharesChart' });
		//if(_id == '#useOfFunds') tokenInfoChart({ chartId: 'useOfFundsChart' });

		$(t.tabsLinks).removeClass('active');
		$(t.tabsConts).removeClass('active');

		$(this).addClass('active');
		$(_id).addClass('active');

		if(_id == '#preSale' && $(window).width() <= 999 && $('.pre-sale__slider').hasClass('slick-initialized'))
			$('.pre-sale__slider').slick('setPosition');
	});
}

// ============================================
// As of Chart.js v2.5.0
// http://www.chartjs.org/docs
// ============================================

if ($("#chart").length) {

	var chart    = document.getElementById('chart').getContext('2d'),
			gradient = chart.createLinearGradient(0, 0, 0, 250);

	gradient.addColorStop(0, 'rgba(255, 222, 37, 1)');
	gradient.addColorStop(0.5, 'rgba(255, 222, 37, 1)');
	gradient.addColorStop(1, 'rgba(255, 222, 37, 0.5)');


	var amountArr = [],
			dateArr = [],
			dataLastAmount,
			dataLastAmountStr;

	$.getJSON('scripts/amount.json', function(data) {

		var dataUnique = mergeDuplicates(data, 'amount'),
				dataLast = dataUnique.slice(-15);
				

				dataLastAmount = Math.round(dataLast[dataLast.length - 1].amount);
				dataLastAmountStr = String(dataLastAmount).replace(/(\d)(?=(\d{3})+(\D|$))/g, '$1 ');

		for (var i=0; i<dataLast.length; i++) {

			var	_a = Math.round(dataLast[i].amount),
					_d = dataLast[i].timestamp,
					_date = new Date(_d*1000),
					_monthlist = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ],
					_monthIndex = _date.getMonth(),
					_dateString = _date.getDate().toString() + ' ' + _monthlist[_monthIndex],
					_amountString = String(_a).replace(/(\d)(?=(\d{3})+(\D|$))/g, '$1 ');
					
					amountArr.push(_a);
					dateArr.push(_dateString);
		}

		airDropProgress();

	});

	function mergeDuplicates(array, property) { 
		if (!array || array.length === 0) {
			return array;
		}

		return array.filter(function (item, index) {
			var value = item[property];
			var nextItem = array[index + 1];

			if (nextItem && value === nextItem[property] ) {
				return false;
			}

			return true;
		});
	}

	// AirDropped progress bar
	function airDropProgress() {
		var airDropped = 10000000 - dataLastAmount,
				airDroppedStr = String(airDropped).replace(/(\d)(?=(\d{3})+(\D|$))/g, '$1 '),
				progressBarWidth = airDropped / 10000000 * 100;

		$('.air-drop__chart-label span').html(airDroppedStr + ' ');
		$('.air-drop__progress .s-left, .air-drop__progress .s-black').html(airDroppedStr + ' LLC AirDropped');
		$('.air-drop__progress .s-right').html(dataLastAmountStr + ' LLC left');
		$('.air-drop__progress-bar').width(progressBarWidth + '%');

	}


	var chartInstance = new Chart(chart, {
		type: 'line',
		data: {
			labels: dateArr,
			datasets: [{
				data: amountArr,
				backgroundColor: gradient,
				pointBackgroundColor: '#fff',
				borderWidth: 2,
				borderColor: '#fff'
			}],
		},
		options: {
			responsive: true,
			maintainAspectRatio: true,
			animation: {
				easing: 'easeInOutQuad',
				duration: 520
			},
			tooltips: {
				displayColors: false,
				titleFontFamily: 'Open Sans',
				backgroundColor: 'rgba(0,0,0,0.3)',
				titleFontColor: '#ffde25',
				caretSize: 5,
				cornerRadius: 2,
				xPadding: 10,
				yPadding: 10,
				callbacks: {
					label: function(tooltipItem, data) {
						var value = data.datasets[0].data[tooltipItem.index];
						value = value.toString();
						value = value.split(/(?=(?:...)*$)/);
						value = value.join(' ');
						return value;
					}
				} // end callbacks:
			}, //end tooltips
			scales: {
				yAxes: [{
					ticks: {
						userCallback: function(value, index, values) {
							// Convert the number to a string and splite the string every 3 charaters from the end
							value = value.toString();
							value = value.split(/(?=(?:...)*$)/);
							value = value.join(' ');
							return value;
						}
					},
					gridLines: {
						color: 'rgba(200, 200, 200, 0.05)',
						lineWidth: 1
					}
				}],
				xAxes: [{
					gridLines: {
						color: 'rgba(200, 200, 200, 0.05)',
						lineWidth: 1
					}
				}]
			},
			elements: {
				line: {
					tension: 0.3
				}
			},
			point: {
				backgroundColor: '#fff'
			},
			legend: {
				display: false
			}
		}
	});

}



// Token info chart
function tokenInfoChart(c) {

	var ctx = document.getElementById(c.chartId);
	var myChart = new Chart(ctx, {
			type: 'doughnut',
			data: {
					datasets: [{
							label: '# of Votes',
							data: c.data,
							backgroundColor: c.bgColor,
							hoverBackgroundColor: [
								'#ffffff',
								'#ffffff',
								'#ffffff',
								'#ffffff'
							],
							borderWidth: 0,
							shadowColor: 'rgba(0, 0, 0, 1)',
							shadowOffsetX: 0,
							shadowOffsetY: 15,
							shadowBlur: 30
					}]
			},
			options: {
					cutoutPercentage: 68,
					layout: {
							padding: {
									left: 20,
									right: 20,
									top: 20,
									bottom: 40
							}
					},
					scales: {
							yAxes: [{
									ticks: {
										display: false
									},
									gridLines: {
										display:false,
										drawTicks: false,
										drawBorder:false
									}
							}],
							xAxes: [{
								ticks: {
									display: false
								},
								gridLines: {
									display:false,
									drawTicks: false,
									drawBorder:false
								}
						}]
					},
					legend: {
							display: false
					},
					tooltips: {
						enabled: false
					},
					onHover: function(e) {
						var point = this.getElementAtEvent(e);
						//console.log(point);
						if (point.length) e.target.style.cursor = 'pointer';
						else e.target.style.cursor = 'default';
					}
			}
	});

	// Highlight Doughnut Segment on Legend Hover
	var legendItems = $(c.legendItems);

	$(legendItems).each(function(index, item) {
		$(item).on('mouseenter', function() {
			var itemVal = $(this).find('a').data('value');

			highlightSegment(myChart, index, true);
			$(c.legendItems).removeClass('active');
			$(this).addClass('active');
			$('.chart-item-value').html(itemVal);
		});
		$(item).on('mouseleave', function() {
			highlightSegment(myChart, index, false);
			$(c.legendItems).removeClass('active');
			$('.chart-item-value').html('');
		});
	});

	function highlightSegment(chart, index, isHighlight) {
		var activeSegment = chart.getDatasetMeta(0).data[index];

		if (isHighlight) {
			chart.updateHoverStyle([activeSegment], null, true);
		} else {
			chart.updateHoverStyle([activeSegment], null, false);
		}
		chart.draw();
	}

	// Highlight Legend Hover on Doughnut Segment
	$(c.chartIdSelector).on('mousemove mouseout',function(e){
		var activeSegment = myChart.getElementAtEvent(e);
		pieChartHoverBreakout(this, activeSegment, e);
	});

	var currentBreakoutIndex = null;
	function pieChartHoverBreakout(chart, activeSegment, eventType) {		

		var legendItems = $(chart).closest('.tokeninfo__tab').find('.tokeninfo__chart-legend ul li');
		var segmentIndex = (activeSegment.length && (typeof activeSegment[0]._index != 'undefined' && activeSegment[0]._index !== null)) ? activeSegment[0]._index : -1;
		var breakout = (eventType.type === 'mousemove') ? true : false;
		if (currentBreakoutIndex != segmentIndex) {
				if (breakout && segmentIndex >= 0) {
					currentBreakoutIndex = segmentIndex;
					var targetSegment = legendItems.get(segmentIndex);
					var targetSegmentValue = $(targetSegment).find('a').data('value');
					$(legendItems).removeClass('active');
					$(targetSegment).addClass('active');
					$('.chart-item-value').html(targetSegmentValue);
				} else {
					currentBreakoutIndex = null;
					legendItems.removeClass('active');
					$('.chart-item-value').html('');
				}
			}

	}


}