;(function($){
	$(document).ready(function (){
		
	});
})(jQuery);
(function(d, t) { 
	var g = d.createElement(t), s = d.getElementsByTagName(t)[0]; 
	g.src = '//api.reftagger.com/v2/RefTagger.js'; 
	s.parentNode.insertBefore(g, s); 
}(document, 'script')); 

var refTagger = {
	settings: { 
		bibleVersion: reftagger_settings.bible_verse
	}  
}; 


console.log(reftagger_settings);
console.log(reftagger_settings.bible_verse);