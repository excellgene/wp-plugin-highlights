(function ($) {
	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$.ajax({
		url: url,
		type: "POST",
		global: false,
		data: {
			'action': 'get_latest_post',
		}
	})
		.done(function (results) {
			let data = JSON.parse(results);
			console.log(data.json);


			if (data.json && data.json.length > 0) {
				data.json.forEach(category => {
					let latestPostTitle = category.latest_post;
					let postDate = category.date;
					let categoryName = category.category;
					let Content = category.content;
					let URLguid = category.url_post
					let element;

					function addZero(n) {
						return n < 10 ? '0' + n : n;
					}

					let formattedDate = new Date(postDate);
					let day = addZero(formattedDate.getDate());
					let month = addZero(formattedDate.getMonth() + 1);
					let year = formattedDate.getFullYear();



					if (categoryName === "Events") {
						element = $('<div class="events"></div>').html(
							`	<div class="postHeader"> 
								<p class="date"> ${year}/${month}/${day}</p>
								<p class="label">${categoryName}</p>
								</div>
								<h2 class="title">${latestPostTitle}</h2>
								<p class="text">${Content}</p>
								<a href=${URLguid} class="button-35"> Read more </a>
							`

						);
					} else {
						element = $('<div class="content"></div>').html(
							` <div class="postHeader"> 
							<p class="date"> ${year}/${month}/${day}</p>
							<p class="label">${categoryName}</p>
							</div>
          					 <h2 class="title">${latestPostTitle}</h2>
							   <a href=${URLguid} class="button-35"> Read more </a>
						   `
						);
					}

					$(document).ready(function () {
						let events = $('.events');
						let content = $('.content');

						events.each(function (index) {
							if (index === 0) {
								$(this).css('grid-area', 'area1');
							}
						});

						content.each(function (index) {
							$(this).css('grid-area', 'area' + (index + 2));
						});
					});



					// Ajoutez l'élément à la page
					$('#blogsHighlight').append(element);
				});
			}
		})



})(jQuery);
