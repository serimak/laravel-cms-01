function isThaichar(str,obj){
	var orgi_text="ๅภถุึคตจขชๆไำพะัีรนยบลฃฟหกดเ้่าสวงผปแอิืทมใฝ๑๒๓๔ู฿๕๖๗๘๙๐ฎฑธํ๊ณฯญฐฅฤฆฏโฌ็๋ษศซฉฮฺ์ฒฬฦ";
	var str_length=str.length;
	var str_length_end=str_length-1;
	var isThai=true;
	var Char_At="";
	for(i=0;i<str_length;i++){
		Char_At=str.charAt(i);
		if(orgi_text.indexOf(Char_At)==-1){
			isThai=false;
		}   
	}
	if(str_length>=1){
		if(isThai==false){
			obj.value=str.substr(0,str_length_end);
		}
	}
	return isThai; // if true is Thai only
}

function isEngchar(str,obj){
	var orgi_text="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!\"#$%&\'()*+,/;<=>?_-.@^+|\\~`";
	var str_length=str.length;
	var str_length_end=str_length-1;
	var isEng=true;
	var Char_At="";
	
	for(i=0;i<str_length;i++){
		Char_At=str.charAt(i);
		if(orgi_text.indexOf(Char_At)==-1){
			isEng=false;
		}   
	}
	if(str_length>=1){
		if(isEng==false){
			obj.value=str.substr(0,str_length_end);
		}
	}
	return isEng; // if true is Eng only
}

function isNumeric(str,obj){
	var orgi_text="0123456789";
	var str_length=str.length;
	var str_length_end=str_length-1;
	var isNumeric=true;
	var Char_At="";
	for(i=0;i<str_length;i++){
		Char_At=str.charAt(i);
		if(orgi_text.indexOf(Char_At)==-1){
			isNumeric=false;
		}   
	}
	if(str_length>=1){
		if(isNumeric==false){
			obj.value=str.substr(0,str_length_end);
		}
	}
	return isNumeric; // if true is Num only
}
