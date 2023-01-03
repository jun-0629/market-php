function selectDateCheck(){
	var nowDate = new Date(),
		nowYear = nowDate.getFullYear(),
		nowMonth = nowDate.getMonth() + 1,
		nowDay = nowDate.getDay(),
		_wrap = document.querySelectorAll('.ui-check-date'),
		_select = document.querySelectorAll('.ui-check-date select'),
		_year = document.querySelectorAll('.ui-check-date select[data-unit=y]'),
		_month = document.querySelectorAll('.ui-check-date select[data-unit=m]'),
		_day = document.querySelectorAll('.ui-check-date select[data-unit=d]'),
		yearTerm = 100;

	for(var i=0; i < _wrap.length; i++){
		var startYear,
			endYear,
			setTerm = _wrap[i].getAttribute('data-term') *1,
			setPoint = _wrap[i].getAttribute('data-point'),
			num = 0;
			
		_year[i].options[0] = new Option(_year[i].getAttribute('data-default-option'), 'default');	// 'default' || ''
		
		if(setTerm != null && setTerm != ''){ yearTerm = setTerm; }
		
		if(setPoint =='up'){
			startYear = nowYear + yearTerm;
			endYear = nowYear;
		}else if(setPoint =='down' || setPoint =='' || setPoint == null) {
			startYear = nowYear;
			endYear = nowYear - yearTerm;
		}
		
		for(var j=startYear; j>=endYear; j--){
			num++;
			_year[i].options[num] = new Option(j, j);
		}
	}
		
	for(var i=0; i<_wrap.length; i++){
		_month[i].options[0] = new Option(_month[i].getAttribute('data-default-option'), 'default');
		for(var j=1; j<=12; j++){
			_month[i].options[j] = new Option(j, j);
		}
	}
	
	for(var i=0; i<_wrap.length; i++){
		_day[i].options[0] = new Option(_day[i].getAttribute('data-default-option'), 'default');
		for(var j=1; j<=31; j++){
			_day[i].options[j] = new Option(j, j);
		}
	}
	
	for(var i=0; i<_wrap.length; i++){
		_year[i].addEventListener('change', selectSetDay, false);
	}
	
	for(var i=0; i<_wrap.length; i++){
		_month[i].addEventListener('change', selectSetDay, false);
	}
	
	function selectSetDay(){
		var arrDay=[31,28,31,30,31,30,31,31,30,31,30,31],
			lastDay,
			wrap = this.parentNode,
			yearVal = wrap.querySelector('select[data-unit=y]').value,
			monthVal = wrap.querySelector('select[data-unit=m]').value,
			selectedDay = wrap.querySelector('select[data-unit=d]'),
			dayVal = selectedDay.value,
			defaultTxt = selectedDay.getAttribute('data-default-option'),
			defaultVal = 'default';
			
		if(yearVal%4 == 0 && yearVal%100 !=0 || yearVal%400 == 0){ arrDay[1]=29; }
		lastDay = (monthVal != defaultVal) ? arrDay[monthVal-1] : 31;
		
		selectedDay.options.length = 0;
		selectedDay.options[0] = new Option(defaultTxt, defaultVal);
		for(var i=1; i<=lastDay; i++){
			selectedDay.options[i] = new Option(i, i);
		}
		selectedDay.value = (dayVal != defaultVal && dayVal > lastDay) ? lastDay : dayVal;
	}
}

window.onload=function(){
	selectDateCheck();
}