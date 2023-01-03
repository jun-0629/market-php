function Postcode() {
	new daum.Postcode({
		oncomplete: function(data) {
			let addr = '';
			let extraAddr = '';

			if (data.userSelectedType === 'R') {
				addr = data.roadAddress;
			} else {
				addr = data.jibunAddress;
			}

			if(data.userSelectedType === 'R'){
				if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
					extraAddr += data.bname;
				}
				if(data.buildingName !== '' && data.apartment === 'Y'){
					extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
				}
				if(extraAddr !== ''){
					extraAddr = ' (' + extraAddr + ')';
				}
				document.getElementById("addr1").value = extraAddr;
			
			} else {
				document.getElementById("addr1").value = '';
			}

			document.getElementById('zip_code').value = data.zonecode;
			document.getElementById("addr").value = addr;
			document.getElementById("addr1").focus();
		}
	}).open();
}