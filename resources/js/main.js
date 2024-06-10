// main.js
window.runMenuControls = function() {
	$(document).ready(function() {
	  ////////////////////////////////////////////////////
	  // 04. Menu Controls JS
	  if($('.tp-category-menu-content').length && $('.tp-category-mobile-menu').length){
		let navContent = document.querySelector(".tp-category-menu-content").outerHTML;
		let mobileNavContainer = document.querySelector(".tp-category-mobile-menu");
		mobileNavContainer.innerHTML = navContent;
	  
		$('.tp-offcanvas-category-toggle').on('click', function(){
		  $(this).siblings().find('nav').slideToggle();
		});
		
	  
		let arrow = $(".tp-category-mobile-menu .has-dropdown > a");
	  
		arrow.each(function () {
		  let self = $(this);
		  let arrowBtn = document.createElement("BUTTON");
		  arrowBtn.classList.add("dropdown-toggle-btn");
		  arrowBtn.innerHTML = "<i class='fa-regular fa-angle-right'></i>";
	  
		  self.append(function () {
			return arrowBtn;
		  });
	  
		  self.find("button").on("click", function (e) {
			e.preventDefault();
			let self = $(this);
			self.toggleClass("dropdown-opened");
			self.parent().toggleClass("expanded");
			self.parent().parent().addClass("dropdown-opened").siblings().removeClass("dropdown-opened");
			self.parent().parent().children(".tp-submenu").slideToggle();
			
		  });
	  
		});
	  }
	  
	  if($('.tp-main-menu-content').length && $('.tp-main-menu-mobile').length){
		let navContent = document.querySelector(".tp-main-menu-content").outerHTML;
		let mobileNavContainer = document.querySelector(".tp-main-menu-mobile");
		mobileNavContainer.innerHTML = navContent;
	  
		let arrow = $(".tp-main-menu-mobile .has-dropdown > a");
	  
		arrow.each(function () {
		  let self = $(this);
		  let arrowBtn = document.createElement("BUTTON");
		  arrowBtn.classList.add("dropdown-toggle-btn");
		  arrowBtn.innerHTML = "<i class='fa-regular fa-angle-right'></i>";
	  
		  self.append(function () {
			return arrowBtn;
		  });
	  
		  self.find("button").on("click", function (e) {
			e.preventDefault();
			let self = $(this);
			self.toggleClass("dropdown-opened");
			self.parent().toggleClass("expanded");
			self.parent().parent().addClass("dropdown-opened").siblings().removeClass("dropdown-opened");
			self.parent().parent().children(".tp-submenu").slideToggle();
		  });
	  
		});
	  }
	  
	  $(".tp-category-menu-toggle").on("click", function () {
		$(".tp-category-menu > nav > ul").slideToggle();
	  });
	  
	  
	  ////////////////////////////////////////////////////
	  // 05. Offcanvas Js
	  $(".tp-offcanvas-open-btn").on("click", function () {
		$(".offcanvas__area").addClass("offcanvas-opened");
		$(".body-overlay").addClass("opened");
	  });
	  $(".offcanvas-close-btn").on("click", function () {
		$(".offcanvas__area").removeClass("offcanvas-opened");
		$(".body-overlay").removeClass("opened");
	  });
	  
	  ////////////////////////////////////////////////////
	  // 06. Search Js
	  $(".tp-search-open-btn").on("click", function () {
		$(".tp-search-area").addClass("opened");
		$(".body-overlay").addClass("opened");
	  });
	  $(".tp-search-close-btn").on("click", function () {
		$(".tp-search-area").removeClass("opened");
		$(".body-overlay").removeClass("opened");
	  });
	  
	  ////////////////////////////////////////////////////
	  // 07. cartmini Js
	  $(".cartmini-open-btn").on("click", function () {
		$(".cartmini__area").addClass("cartmini-opened");
		$(".body-overlay").addClass("opened");
	  });
	  
	  
	  $(".cartmini-close-btn").on("click", function () {
		$(".cartmini__area").removeClass("cartmini-opened");
		$(".body-overlay").removeClass("opened");
	  });
	});
  };
  
  // Ejecutar la función inmediatamente si es necesario
  window.runMenuControls();