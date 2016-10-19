$(document).ready(function(){

//Menu
$('ul#menu').superfish();


//Client Logo Image Hover
$('a').css({opacity: 0.7});

$(".clients li").hover(function(){
	$(this).find("a").stop(true, true).animate({ opacity: 1 }, 500);
	}, function() {
	$(this).find("a").stop(true, true).animate({ opacity: 0.7 }, 500);
});


//Image Hover
$(".image, .social a").hover(function () {
$(this).stop().animate({opacity: 0.6}, 800);
	}, function() {
		$(this).stop().animate({opacity: 1 }, 800);
	});


//prettyPhoto
$("a[rel^='pretty']").prettyPhoto();


//Tooltip
$("a[rel^='tipsy']").tipsy({gravity: 's'});


//Flickr Footer
$('ul.flickr').jflickrfeed({
	limit: 9,
	qstrings: {
		id: '99771506@N00'
	},
	itemTemplate:
	'<li>' +
		'<a href="{{image_b}}" rel="pretty"><img src="{{image_s}}" alt="{{title}}" class="" /></a>' +
	'</li>'
});

//Flickr Sidebar
$('ul.flickr-sidebar').jflickrfeed({
	limit: 9,
	qstrings: {
		id: '99771506@N00'
	},
	itemTemplate:
	'<li>' +
		'<a href="{{image_b}}" rel="pretty"><img src="{{image_s}}" alt="{{title}}" class="image" /></a>' +
	'</li>'
});




//Latest Twitter
$("#twitter").getTwitter({
		userName: "bingumd",
		numTweets: 2,
		loaderText: "Loading tweets...",
		slideIn: true,
		showHeading: true,
		headingText: "",
		showProfileLink: true
	});

//Tab sidebar
$('ul.tabs').each(function() {
    $(this).find('li').each(function(i) {
      $(this).click(function(){
        $(this).addClass('active').siblings().removeClass('active')
          .parents('div.tab_block').find('div.tab').hide().end().find('div.tab:eq('+i+')').fadeIn(2000);
      });
    });
});


//Tab sidebar
$('ul.tab-page').each(function() {
    $(this).find('li').each(function(i) {
      $(this).click(function(){
        $(this).addClass('active').siblings().removeClass('active')
          .parents('div.tabs-page').find('div.tabpage').hide().end().find('div.tabpage:eq('+i+')').fadeIn(2000);
      });
    });
});



//Toggle
$(".close").click(function(){$("#seting").toggle("fast");
$(this).toggleClass("openpanel");return false});
$(".toggle-block").hide();

$("p.toggle").click(function(){
		$(this).toggleClass("active").next().slideToggle(500);
		return false;
	});

//Accordion
$('.acc-block').hide();
$('.acc-header:first').addClass('active').next().show();
$('.acc-header').click(function(){
	if( $(this).next().is(':hidden') ) {
		$('.acc-header').removeClass('active').next().slideUp();
		$(this).toggleClass('active').next().slideDown();
	}
	return false;
});

});



$(window).load(function() {
        //Image Hover Efect
		$(".flickr img, ul.flickr-sidebar img").hover(function () {
		$(this).stop().animate({opacity: 0.6}, 800);
		}, function() {
		$(this).stop().animate({opacity: 1 }, 800);
	});

});
