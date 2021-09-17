$(document).ready(function(){

	$('#infinite-news-area').infiniteScroll({
		// options
		// path: '.pagination__next',
		append: '.news_block',
		history: false,
		path: '/front/news?page={{#}}&limit=6'
	});

});
