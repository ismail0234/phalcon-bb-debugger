window.onload = () => {

	var getClickedItem = (e) => {

		for (var i = 0; i < e.length; i++) {
			
			if (e[i].localName == 'a') {
				return e[i];
			}
	
		}

		return null;
	};
		
	var BBMenuClick = (e) => {

		var element = getClickedItem(e.path);
		if (element !== null) {
			
			var divList = document.querySelectorAll(".bb-container:not(#" + element.dataset.bb + ")");
			for (var i = 0; i < divList.length; i++) {
				divList[i].classList.add('bb-d-none');
			}

			document.getElementById(element.dataset.bb).classList.toggle('bb-d-none');			
		
		}
	
	};

	var divList = document.querySelectorAll("a[data-bb]");
	for (var i = 0; i < divList.length; i++) {
		divList[i].addEventListener('click' , BBMenuClick);
	}

};